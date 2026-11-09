# Backups

BACKUPS (Spatie Laravel Backup) - Location on Windows (WAMP)

1) Backup configuration
- In `config/backup.php`:
  - `destination.disks` is set to: `['local']`

2) Where the `local` disk points
- In `config/filesystems.php`:
  - `disks.local.root` is set to:
    - `storage_path('app/private')`

3) Final absolute backup folder
So your backup zip files are stored at:

- `C:\wamp64\www\work-tracker\storage\app\private\backup\`

Notes
- Zips should appear in `.../storage/app/private/backup/`.
- Temporary files are stored in:
  - `storage/app/backup-temp` (from `config/backup.php` → `temporary_directory`)

If you ever update `config/filesystems.php`, re-check the `local.root` value, because that’s what determines the final folder.
