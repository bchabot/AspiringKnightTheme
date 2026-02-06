/**
 * Navigation.js
 * 
 * Handles toggling the navigation menu for small screens.
 */

(function() {
    const siteNavigation = document.getElementById('site-navigation');
    if (!siteNavigation) return;

    const button = siteNavigation.getElementsByTagName('button')[0];
    if ('undefined' === typeof button) return;

    const menu = siteNavigation.getElementsByTagName('ul')[0];

    // Hide menu toggle button if menu is empty and return early.
    if ('undefined' === typeof menu) {
        button.style.display = 'none';
        return;
    }

    if (!menu.classList.contains('nav-menu')) {
        menu.classList.add('nav-menu');
    }

    button.addEventListener('click', function() {
        siteNavigation.classList.toggle('toggled');

        if (siteNavigation.classList.contains('toggled')) {
            button.setAttribute('aria-expanded', 'true');
            menu.setAttribute('aria-expanded', 'true');
        } else {
            button.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-expanded', 'false');
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInside = siteNavigation.contains(event.target);
        if (!isClickInside && siteNavigation.classList.contains('toggled')) {
            siteNavigation.classList.remove('toggled');
            button.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-expanded', 'false');
        }
    });
})();
