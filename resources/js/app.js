const themeStorageKey = 'work-tracker-theme';
const privacyStorageKey = 'work-tracker-privacy-mode';
const root = document.documentElement;

let storedTheme = null;
let storedPrivacyMode = null;

try {
    storedTheme = localStorage.getItem(themeStorageKey);
    storedPrivacyMode = localStorage.getItem(privacyStorageKey);
} catch (error) {
    storedTheme = null;
    storedPrivacyMode = null;
}

if (storedTheme === 'dark') {
    root.classList.add('dark');
}

if (storedPrivacyMode === 'enabled') {
    root.classList.add('privacy-mode');
}

const updateThemeToggle = () => {
    const isDark = root.classList.contains('dark');
    const label = isDark ? 'Switch to light mode' : 'Switch to dark mode';

    document.querySelectorAll('[data-theme-toggle]').forEach((toggle) => {
        toggle.setAttribute('aria-pressed', String(isDark));
        toggle.setAttribute('aria-label', label);
    });

    document.querySelectorAll('[data-theme-toggle-label]').forEach((toggleLabel) => {
        toggleLabel.textContent = label;
    });
};

const updatePrivacyToggle = () => {
    const isPrivate = root.classList.contains('privacy-mode');
    const label = isPrivate ? 'Turn privacy mode off' : 'Turn privacy mode on';

    document.querySelectorAll('[data-privacy-toggle]').forEach((toggle) => {
        toggle.setAttribute('aria-pressed', String(isPrivate));
        toggle.setAttribute('aria-label', label);
    });

    document.querySelectorAll('[data-privacy-toggle-label]').forEach((toggleLabel) => {
        toggleLabel.textContent = isPrivate ? 'Privacy on' : 'Privacy off';
    });
};

document.querySelectorAll('[data-theme-toggle]').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        root.classList.toggle('dark');

        try {
            localStorage.setItem(themeStorageKey, root.classList.contains('dark') ? 'dark' : 'light');
        } catch (error) {}

        updateThemeToggle();
    });
});

document.querySelectorAll('[data-privacy-toggle]').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        root.classList.toggle('privacy-mode');

        try {
            localStorage.setItem(privacyStorageKey, root.classList.contains('privacy-mode') ? 'enabled' : 'disabled');
        } catch (error) {}

        updatePrivacyToggle();
    });
});

updateThemeToggle();
updatePrivacyToggle();
