# Work Tracker

Work Tracker is a personal work administration app for recording leave, tracking overtime hours, and keeping a history of earnings. It brings those records together in an authenticated dashboard, with a running paid leave balance and optional two-factor authentication.

Records belong to individual users. The current installation workflow is geared toward a provisioned account: public registration is disabled, and the default database seeder initializes a specific account and its leave types.

## Contents

- [Features](#features)
- [Technology and code map](#technology-and-code-map)
- [Local setup](#local-setup)
- [Request lifecycle and dashboard](#request-lifecycle-and-dashboard)
- [Database and relationships](#database-and-relationships)
- [Leave calculations and balances](#leave-calculations-and-balances)
- [Overtime calculations](#overtime-calculations)
- [Earnings and totals](#earnings-and-totals)
- [Authentication and security](#authentication-and-security)
- [Frontend behavior](#frontend-behavior)
- [Routes and JSON responses](#routes-and-json-responses)
- [Backups and operations](#backups-and-operations)
- [Tests and development checks](#tests-and-development-checks)
- [TODO: future improvements](#todo-future-improvements)

## Features

| Area | Current capabilities |
| --- | --- |
| Dashboard | Paid leave balance, total overtime hours, total earnings, and record histories. |
| Leave | Type, inclusive date range, optional reason, weekday calculation, paid balance deductions, and refunds on deletion. |
| Balance | Manual adjustments and automatic catch-up of monthly accrual. |
| Overtime | Work date, start/end times, optional notes, and calculated duration including overnight shifts. |
| Earnings | Pay date, base pay, bonus, overtime pay, and currency code. |
| Account security | Email or username login, logout, and authenticator-based two-factor authentication. |
| Display | Light/dark themes and privacy mode for selected dashboard values. |
| Backups | File and database archive configuration using local storage. |

Leave is recorded directly; there is no approval workflow. Overtime hours and overtime pay are entered separately. The application does not currently integrate with payroll or calculate taxes.

## Technology and code map

Versions below describe the installed dependencies when this README was rewritten. Lockfiles remain the source of truth for exact versions.

| Layer | Implementation |
| --- | --- |
| PHP | Project target: PHP 8.4; `composer.json` declares `^8.3`. Check the locked dependencies against the CLI and web-server runtime. |
| Backend | Laravel 13, currently 13.25.0. |
| Authentication | Laravel Fortify 1, currently 1.38.0, with session-based authentication. |
| Database | MySQL in `.env.example`; SQLite in memory for automated tests. |
| UI | Server-rendered Blade templates, Tailwind CSS 4, and plain JavaScript. |
| Assets | Vite 8 and Laravel Vite Plugin 3. |
| Backups | Spatie Laravel Backup 10, currently 10.3.1. |
| Tests and formatting | Pest 4, Pest Laravel plugin, and Laravel Pint. |

| Location | Responsibility |
| --- | --- |
| [`routes/web.php`](routes/web.php) | Root redirect and authenticated tracker routes. |
| [`bootstrap/app.php`](bootstrap/app.php) | Bootstrap, routing, health endpoint, and JSON exception rendering rules. |
| [`app/Http/Controllers`](app/Http/Controllers) | Input validation, ownership checks, persistence, and responses. |
| [`app/Services`](app/Services) | Monthly accrual, weekday counting, and overtime duration calculations. |
| [`app/Models`](app/Models) | Eloquent relationships, assignable attributes, and casts. |
| [`app/Actions/Fortify`](app/Actions/Fortify) | Profile/password update logic and authentication scaffolding actions. |
| [`app/Providers/FortifyServiceProvider.php`](app/Providers/FortifyServiceProvider.php) | Login lookup, authentication views, and rate limiters. |
| [`database/migrations`](database/migrations) | Schema, constraints, and dashboard indexes. |
| [`database/seeders`](database/seeders) | Initial account, balance settings, and leave types. |
| [`resources/views`](resources/views) | Pages, layouts, and shared Blade components. |
| [`resources/js/app.js`](resources/js/app.js) | Theme/privacy initialization and toggle handlers. |
| [`resources/css/app.css`](resources/css/app.css) | Tailwind, typography, dark variant, and privacy blur. |
| [`config/backup.php`](config/backup.php) | Backup sources, destination, notifications, monitoring, and retention. |
| [`tests`](tests) | Domain unit tests and HTTP feature tests. |

## Local setup

### Prerequisites

- PHP and the extensions required by `composer.lock`, including the database driver for your connection. SQLite support is needed for tests.
- Composer.
- Node.js and npm compatible with Vite. The currently installed Vite 8 package requires Node `^20.19.0 || >=22.12.0`.
- A running MySQL server and an empty `work_tracker` database when using the example environment configuration.
- PHP ZIP support and an accessible database dump executable such as `mysqldump` for MySQL backups.

On WAMP, check that the terminal and Apache use the intended PHP version and extensions; they can use different installations.

### Install and configure

Run these commands from the project root in PowerShell:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate --no-interaction
```

Copy the environment file only for a new checkout without an existing `.env`. Set the application URL and database connection before migrating:

```dotenv
APP_NAME="Work Tracker"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=work_tracker
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

Use credentials appropriate to your local database. The timezone is currently hardcoded to `UTC` in [`config/app.php`](config/app.php); accrual and default dates use that application clock.

```powershell
php artisan migrate --no-interaction
npm ci --ignore-scripts
npm run build
```

Use `composer check-platform-reqs` to check PHP/runtime compatibility.

### Initial account

There is no public sign-up page. For a disposable local installation, the existing seeders initialize the bundled account and leave configuration:

```powershell
php artisan db:seed --no-interaction
```

Review [`database/seeders/JustinUserSeeder.php`](database/seeders/JustinUserSeeder.php) first. It contains a fixed identity/password, and its `updateOrCreate` resets that account's password on subsequent runs. Change the password after initial access; this is not a production account provisioning process. Credentials are intentionally not repeated here.

The seeder initializes a zero paid balance with the current accrual month and creates:

| Leave type | Reduces paid balance? |
| --- | --- |
| `paid_leave` | Yes |
| `vacation` | Yes |
| `emergency` | No |

### Start development

```powershell
composer run dev
```

This starts Laravel's development server, a queue listener with `--tries=1`, and Vite through `concurrently`. It does not start a scheduler.

When serving through WAMP/Apache, point the document root at the project's `public` directory and run `npm run dev` separately for asset development. Use `npm run build` for compiled assets when Vite is not running.

The `composer run setup` shortcut installs dependencies, creates `.env` if absent, generates an application key, migrates with `--force`, installs JavaScript dependencies, and builds assets. Configure the database first. Treat it as a fresh-install shortcut: generating a new application key on an existing installation can make previously encrypted data unreadable.

## Request lifecycle and dashboard

1. Laravel boots through `bootstrap/app.php` and loads providers and web routes.
2. `/` redirects guests to login and signed-in users to the dashboard.
3. Tracker routes use the `auth` middleware. Browser forms use session authentication and CSRF protection; PUT/DELETE forms use Blade method spoofing.
4. Controllers validate input and derive ownership from the authenticated user rather than a submitted `user_id`.
5. Services perform calculations, and Eloquent persists records. Leave operations group record and balance changes in database transactions.
6. Browser writes redirect back with flash status messages. Requests expecting JSON receive structured objects and HTTP status codes.

### Dashboard loading

[`DashboardController`](app/Http/Controllers/DashboardController.php) first brings leave accrual up to date. It then calculates user-scoped database aggregates: leave count, summed overtime hours, and summed earnings components.

For JSON, it returns those summaries immediately. For HTML, it additionally loads all leave records with their leave types, all overtime entries, all earnings, and available leave types. Leave history is ordered by creation time; overtime and earnings use their work/pay dates, newest first.

Leave types are eager-loaded to avoid a separate relationship query per leave row. Composite indexes support filtering by user and ordering by date. History currently has no pagination, so dashboard HTML and memory usage grow with the record count.

## Database and relationships

A `User` has one `LeaveSetting` and many `LeaveType`, `Leave`, `OvertimeEntry`, and `Earning` records. Each leave belongs to both a user and a leave type.

| Table | Important fields and constraints |
| --- | --- |
| `users` | Name, unique email, nullable unique username, hashed password, and optional two-factor secret/recovery data and confirmation timestamp. |
| `leave_settings` | Unique user, decimal balance `(8,2)`, and last accrued year/month. |
| `leave_types` | User, name, boolean `affects_balance`; names are unique per user. |
| `leaves` | User/type, start/end dates, integer `days_used`, optional reason; indexed by user/creation time. |
| `overtime_entries` | User, work date, start/end times, decimal hours `(5,2)`, optional notes; indexed by user/work date. |
| `earnings` | User, pay date, three decimal amounts `(10,2)`, currency; indexed by user/pay date. |
| `passkeys` | Credential storage migration exists, but passkey authentication is disabled. |
| Infrastructure | Sessions, password reset tokens, cache/locks, jobs, job batches, and failed jobs. |

Domain foreign keys cascade on user deletion. Deleting a leave type also cascades to its leaves at the database level; there is currently no leave-type deletion UI. These cascades do not execute the controller's balance-restoration workflow.

Dates are cast to date objects. Balances, money, and overtime hours have two-decimal Eloquent casts and can appear in JSON as strings such as `"4.00"`. Day counts are integers and balance flags are booleans.

## Leave calculations and balances

### Monthly accrual

[`LeaveAccrualService`](app/Services/LeaveAccrualService.php) grants **one paid leave day per elapsed calendar month** since the last recorded accrual month:

```text
months missed = max(0, (current year - last year) * 12 + current month - last month)
new balance   = previous balance + months missed
```

A balance of 2 days last accrued in March becomes 5 when accessed in June. Reopening in June does not grant another day because the marker has advanced to June.

The service uses a transaction and `lockForUpdate` on an existing settings row. If settings do not exist, it creates a zero balance with the current year/month. It does not infer an employment start date or grant historical entitlement.

Accrual is triggered by `/dashboard` or `GET /leave-settings`. It is not scheduled. Leave create/edit/delete and manual balance updates do not themselves call the accrual service, which matters for clients writing directly to those endpoints.

### Day counting

[`LeaveCalculator`](app/Services/LeaveCalculator.php) iterates over the inclusive range using Carbon and counts Monday through Friday. Weekends do not count; public holidays and individual work schedules are not considered.

Monday through Sunday consumes 5 days. A weekend-only period consumes 0. Leave records use whole weekdays even though balances can store fractional days.

### Create, edit, and delete

- **Create:** Validate dates and type, retrieve the type within the current user's records, and calculate weekdays. For a type with `affects_balance = true`, require at least one weekday and sufficient balance, deduct the days, and create the record in one transaction.
- **Edit:** Verify ownership, temporarily restore the original deduction if applicable, calculate/validate the replacement, deduct its new cost, and update the record. Failed validation rolls back the transaction, including that temporary restoration.
- **Delete:** Verify ownership, restore the stored day count for a balance-affecting type, and delete the record in one transaction.
- **Non-balance leave:** Store calculated weekdays without changing the balance. Weekend-only emergency leave is allowed with zero days used.

Reasons are optional and limited to 1,000 characters. End dates must be on or after start dates. The controller supports updates, although the dashboard currently exposes add/delete controls only.

### Manual balance adjustments

The dashboard replaces the balance with a nonnegative numeric value. The input suggests increments of `0.25`, but server validation does not enforce quarter-day increments. A manual adjustment does not reset an existing accrual marker or create an audit record.

## Overtime calculations

[`OvertimeEntryController`](app/Http/Controllers/OvertimeEntryController.php) validates a work date and times in `H:i` format. [`OvertimeCalculator`](app/Services/OvertimeCalculator.php) uses a fixed reference date to calculate duration:

1. Parse start and end times.
2. Reject identical times rather than interpreting them as 24 hours.
3. Move the end to the next day if it precedes the start.
4. Divide the minute difference by 60 and round to two decimals.

Thus `17:00` to `19:30` stores `2.50` hours, and `22:00` to `02:00` stores `4.00`. Overnight entries remain associated with the submitted work date.

Notes are optional and limited to 1,000 characters. Hours are calculated server-side. Breaks, multiple-day shifts, hourly rates, and multipliers are not represented. Current routes support creation without overtime edit/delete endpoints.

## Earnings and totals

Each earnings record stores a pay date, required nonnegative base amount, optional nonnegative bonus/overtime pay, and optional three-character currency. Missing bonus and overtime amounts default to zero; currency defaults to `USD` and is uppercased.

A record's total is `base_amount + bonus_amount + overtime_pay_amount`. The dashboard uses SQL `SUM` across those components and returns zero when there are no records.

Overtime pay is entered independently of overtime hours. Payments are not linked to individual overtime entries. Currency validation checks length rather than a supported-currency list.

**Current limitation:** The summary adds records together regardless of currency and prefixes the result with `$`. History entries display their own currency code. Mixed-currency summaries are not converted monetary totals.

Earnings routes currently support creation only; editing and deletion are future work.

## Authentication and security

[`FortifyServiceProvider`](app/Providers/FortifyServiceProvider.php) authenticates the `login` field against email or username and checks passwords using Laravel's hashing service. The session-based `web` guard is used, with successful login redirecting to `/dashboard`.

Login allows 5 attempts per minute per normalized login/IP combination. Two-factor challenges allow 5 per minute using the pending login ID. A passkey limiter is defined, but passkeys are disabled.

### Two-factor flow

Settings enables an authenticator secret, shows a QR code/manual key while setup is pending, and requires a valid code to confirm enrollment. Password login then redirects to the two-factor challenge, which also accepts recovery codes.

`User` uses Fortify's `TwoFactorAuthenticatable` trait. Fortify handles encrypted secret/recovery-code storage. The custom QR URL uses the application name as issuer and email as the account label.

Setup confirmation is required, but `confirmPassword` is false: 2FA management does not require the additional password-confirmation step. Recovery-code viewing/regeneration endpoints exist, but the settings UI does not currently expose those controls.

### Feature boundaries

- Profile/password update endpoints are enabled. Profile updates handle name/email; password updates check the current password and a confirmed replacement. Settings currently provides 2FA controls rather than profile/password forms.
- Public registration, email password reset, email verification, and passkeys are disabled in [`config/fortify.php`](config/fortify.php).
- Registration/reset actions and the passkey migration remain as scaffolding; they do not mean those features are active.
- Tracker queries are scoped to the signed-in user. Editing/deleting another user's leave or selecting another user's leave type returns 404.

## Frontend behavior

Blade provides guest/authenticated layouts, regular HTML forms, and shared status/validation alerts. No SPA framework is used.

JavaScript stores preferences in browser `localStorage`:

| Key | Values | Effect |
| --- | --- | --- |
| `work-tracker-theme` | `dark` / `light` | Toggles the root `dark` class. |
| `work-tracker-privacy-mode` | `enabled` / `disabled` | Toggles the root `privacy-mode` class. |

A layout script applies saved dark mode before the main bundle initializes. Toggle handlers update accessible labels and `aria-pressed`. Storage access is guarded with `try/catch` so unavailable storage does not break controls.

Privacy mode blurs elements marked `data-private`, including the email and earnings values, and disables pointer interaction/selection on them. **Values remain in page markup and responses.** This is screen concealment, not access control or encryption. Preferences are browser-local rather than synchronized with the account.

Vite compiles the CSS/JavaScript entry points and refreshes Blade during development. CSS imports Geist from Google Fonts, while Vite also configures Instrument Sans through Bunny; consolidating typography is in the backlog.

## Routes and JSON responses

These are session-authenticated web routes with CSRF protection where applicable, not a separate token API. Send `Accept: application/json` for JSON responses from the tracker controllers.

| Method | Path | Route name | Behavior |
| --- | --- | --- | --- |
| GET | `/` | Unnamed | Redirect to login/dashboard. |
| GET | `/dashboard` | `dashboard` | HTML dashboard or summary JSON. |
| GET | `/settings` | `settings.edit` | 2FA settings page. |
| GET | `/leave-settings` | `leave-settings.show` | Accrue and return settings JSON. |
| PUT | `/leave-settings` | `leave-settings.update` | Replace balance. |
| POST | `/leaves` | `leaves.store` | Record leave and balance impact. |
| PUT | `/leaves/{leave}` | `leaves.update` | Update leave and balance impact. |
| DELETE | `/leaves/{leave}` | `leaves.destroy` | Delete and restore applicable days. |
| POST | `/overtime-entries` | `overtime-entries.store` | Calculate and store overtime. |
| POST | `/earnings` | `earnings.store` | Store earnings. |
| GET | `/up` | Framework health route | Application health endpoint. |

Fortify registers login/logout, two-factor challenges, profile/password updates, and 2FA management. Inspect active routes with:

```powershell
php artisan route:list --no-interaction
```

Dashboard JSON contains `leave_setting`, `leave_count`, `overtime_hours`, and `earnings_total`, without history collections. Creates return 201 with a `leave`, `overtime_entry`, or `earning` object. Leave updates return `leave`; settings responses return `leave_setting`. Deletion returns 204 and validation failures return 422. Browser writes redirect back with flash messages.

The bootstrap requests JSON exception rendering for `api/*`, but it does not currently register an application API route file.

## Backups and operations

### Contents and destination

[`config/backup.php`](config/backup.php) includes the project directory and the database named by `DB_CONNECTION`. It excludes `vendor`, `node_modules`, and `storage/framework`; backup process directories are excluded by the package. Symlinks are not followed.

Archives use the `local` disk, rooted at `storage/app/private` in [`config/filesystems.php`](config/filesystems.php). The backup name comes from `APP_NAME`, falling back to `laravel-backup` when absent:

```text
storage/app/private/<backup-name>/
```

For the original WAMP path, if the backup name is `backup`, archives are stored at:

```text
C:\wamp64\www\work-tracker\storage\app\private\backup\
```

With `APP_NAME="Work Tracker"`, expect a `Work Tracker` subdirectory instead. Temporary files use `storage/app/backup-temp`. Recheck the disk root and backup name after configuration changes.

### Manual commands

```powershell
php artisan backup:run --no-interaction
php artisan backup:list --no-interaction
php artisan backup:monitor --no-interaction
php artisan backup:clean --no-interaction
```

Use `php artisan backup:run --only-db --no-interaction` for database-only archives. MySQL dumping requires an accessible executable; configure connection dump options if WAMP binaries are not on the PHP process's PATH.

Retention keeps all backups for 7 days, then daily backups for 16 days, weekly backups for 8 weeks, monthly backups for 4 months, and yearly backups for 2 years. Cleanup also has a 5,000 MB threshold. These are cleanup rules, not automatic scheduling.

No scheduled tasks are defined in `routes/console.php`. Package installation and `composer run dev` do not schedule backups, cleanup, or monitoring. Invoke commands manually or arrange recurring execution separately.

### Operational details

- Example sessions, cache, and queues use the database, so their migrations must exist.
- The example mailer is `log`; configure a real transport and backup recipients before relying on email alerts.
- File backups can include `.env` because the project root is included. Protect archives and retain a secure copy of the original `APP_KEY` for encrypted-data recovery, including 2FA secrets.
- The destination is currently the same machine's local disk. Off-machine copies and restore drills remain future work.
- [`AppServiceProvider`](app/Providers/AppServiceProvider.php) overrides the `files` service: its `replace` method writes directly using `LOCK_EX` and optionally applies permissions. This differs from the framework's temporary-file replacement behavior and matters when investigating filesystem issues.

## Tests and development checks

The Pest suite uses in-memory SQLite, array cache/session/mail drivers, and synchronous queues through [`phpunit.xml`](phpunit.xml). Tracker feature tests use `RefreshDatabase` to isolate their schema.

Run focused domain/tracker tests:

```powershell
php artisan test --compact tests/Unit/LeaveDomainTest.php tests/Feature/TrackerFeatureTest.php
```

Run the entire suite when needed:

```powershell
php artisan test --compact
```

Current tests cover accrual catch-up/idempotency, inclusive weekdays, paid/emergency leave, balance validation/refunds, overnight overtime, dashboard summaries, login/logout, the 2FA challenge, privacy markup, and ownership restrictions.

Theme/privacy tests check markup rather than executing JavaScript. Concurrent balance writes, leave-edit rollback cases, and full earnings validation need additional coverage.

After PHP edits, follow the project's formatter requirement:

```powershell
vendor/bin/pint --dirty --format agent
```

After frontend edits, run `npm run build`. If UI changes are missing, check whether Vite is running or compiled assets need rebuilding.

## TODO: future improvements

This is a planning backlog, not an immediate implementation commitment. The order puts correctness and recovery ahead of feature expansion. Every item describes proposed work.

### Data correctness and account safety

- [ ] **Replace fixed seeded credentials.** Add deliberate account provisioning without a committed password; prevent repeat seeding from resetting existing passwords. Update feature tests that depend on those credentials.
- [ ] **Serialize all balance changes.** Leave creation checks then decrements without explicitly locking the settings row. Apply consistent locking to accrual, create/edit/delete, and manual adjustments; test simultaneous requests against MySQL to prevent overspending/lost updates.
- [ ] **Accrue consistently before writes.** Bring accrual up to date before balance-sensitive operations instead of depending on an earlier dashboard read. Define manual corrections when monthly accrual is pending.
- [ ] **Handle currencies correctly.** Group totals by currency or enforce one currency per account. Validate supported codes, render the correct currency, and add mixed-currency regression coverage.
- [ ] **Add a balance audit trail.** Record accrual credits, leave deductions/refunds, and manual adjustment reasons so balances can be explained and reconciled.
- [ ] **Complete 2FA management.** Expose recovery-code viewing/regeneration, consider password confirmation for security-sensitive changes, and review hidden user attributes so future JSON serialization cannot expose two-factor fields.
- [ ] **Define duplicate/overlap rules.** Decide whether overlapping leave, overlapping overtime, and duplicate earnings should be rejected or flagged, including overtime crossing midnight.
- [ ] **Protect historical leave semantics.** Define how leave-type flag changes/deletion affect existing records and balances; avoid losing history through cascades without reconciliation.

### Reliability and operations

- [ ] **Schedule backups, cleanup, and monitoring.** Add recurring execution, overlap protection, working alert recipients, and mail configuration.
- [ ] **Keep off-machine backups and test restoration.** Add another destination, decide archive encryption/access requirements, and document a restore drill for files, database, and the original application key.
- [ ] **Expand regression coverage.** Test paid/non-paid leave edits, rollback on rejected edits, year-boundary accrual, settings initialization races, earnings validation/defaults, and full 2FA enrollment/challenge/recovery.
- [ ] **Test browser interactions.** Configure browser testing for theme/privacy persistence, keyboard access, validation feedback, and mobile forms; current tests only inspect markup.
- [ ] **Add continuous integration.** Automate PHP checks and asset builds, including database-specific tests where SQLite cannot reproduce production behavior.
- [ ] **Review the filesystem override.** Establish the Windows issue it addresses, test interrupted writes, and document why direct locked writes are necessary before retaining/replacing it.
- [ ] **Make setup more deliberate.** Align the declared PHP requirement with the supported runtime, configure the business timezone, and avoid regenerating an existing key through the setup shortcut.

### Usability and reporting

- [ ] **Add correction controls.** Provide leave editing in the UI and authorized overtime/earnings update/delete operations with tests.
- [ ] **Paginate/filter histories.** Add independent pagination, date ranges, type filters, and search to avoid loading every record into the dashboard.
- [ ] **Add exports and period summaries.** Provide CSV export and monthly/yearly views of leave, overtime, and earnings grouped by currency.
- [ ] **Make leave policy configurable.** Consider employment dates, accrual rates, caps/carryover, holidays, part-time schedules, and fractional-day leave after agreeing the required policies.
- [ ] **Add account maintenance forms.** Expose profile/password updates and decide whether self-service password reset or additional account provisioning is needed.
- [ ] **Improve deletion feedback.** Add appropriate confirmation and accessible feedback; decide whether important records need recoverable deletion.
- [ ] **Consolidate fonts/preferences.** Choose one font-loading approach and apply saved privacy mode earlier to reduce sensitive-value flashes before bundle initialization.
- [ ] **Improve onboarding.** Explain the opening balance, accrual policy, emergency leave behavior, and independent overtime/pay records near the relevant forms.
