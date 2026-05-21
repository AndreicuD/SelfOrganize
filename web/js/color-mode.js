/*!
 * Color mode toggler for Bootstrap 5.3+
 * Based on https://getbootstrap.com/docs/5.3/customize/color-modes/
 */
(() => {
    'use strict'

    const getStoredTheme = () => localStorage.getItem('theme')
    const setStoredTheme = theme => localStorage.setItem('theme', theme)

    const getPreferredTheme = () => {
        const stored = getStoredTheme()
        if (stored) return stored
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
        document.documentElement.setAttribute('data-bs-theme', theme)
    }

    const updateToggle = theme => {
        const toggle = document.getElementById('theme-toggle')
        if (!toggle) return
        //toggle.textContent = theme === 'dark' ? '\u2600' : '\uD83C\uDF19'
        toggle.innerHTML = theme === 'dark'
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--bs-light)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-sun"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8 12a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--bs-light)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-moon-stars"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454l0 .008" /><path d="M17 4a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2" /><path d="M19 11h2m-1 -1v2" /></svg>'
        toggle.setAttribute(
            'aria-label',
            theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
        )
    }

    setTheme(getPreferredTheme())

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (!getStoredTheme()) {
            const theme = getPreferredTheme()
            setTheme(theme)
            updateToggle(theme)
        }
    })

    document.addEventListener('DOMContentLoaded', () => {
        updateToggle(getPreferredTheme())

        const toggle = document.getElementById('theme-toggle')
        if (toggle) {
            toggle.addEventListener('click', () => {
                const newTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark'
                    ? 'light'
                    : 'dark'
                setStoredTheme(newTheme)
                setTheme(newTheme)
                updateToggle(newTheme)
            })
        }
    })
})()
