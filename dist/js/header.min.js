window.addEventListener('DOMContentLoaded', function () {
    let navToggle = document.querySelector('.js-nav-toggle');
    let menu = document.getElementById('menu-header');
    let header = document.getElementById('header');
    let dropdownToggles = Array.from(document.querySelectorAll('.menu-chevron'));
    let mobileMedia = window.matchMedia('(max-width: 991px)');
    let resizeTimer = null;
    let historyBackButton = document.querySelector('.js-history-back');

    function isMobileMenu() {
        return mobileMedia.matches;
    }

    function getSubmenu(toggle) {
        let parentItem = toggle.closest('li');

        return parentItem ? parentItem.querySelector(':scope > .sub-menu') : null;
    }

    function setHeaderMenuHeight() {
        if (!menu || !header || !isMobileMenu()) {
            return;
        }

        let headerHeight = header.offsetHeight;
        let availableHeight = Math.max(0, window.innerHeight - headerHeight);

        menu.style.top = headerHeight + 'px';
        menu.style.maxHeight = availableHeight + 'px';
        menu.style.overflowY = 'auto';
    }

    function closeSubmenus() {
        dropdownToggles.forEach(function (toggle) {
            let submenu = getSubmenu(toggle);

            toggle.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');

            if (submenu) {
                submenu.hidden = isMobileMenu();
                submenu.setAttribute('aria-hidden', isMobileMenu() ? 'true' : 'false');
            }
        });
    }

    function setMobileMenu(open, returnFocus) {
        if (!navToggle || !menu) {
            return;
        }

        navToggle.classList.toggle('active', open);
        navToggle.setAttribute('aria-expanded', String(open));
        menu.hidden = !open;
        menu.setAttribute('aria-hidden', String(!open));
        document.documentElement.classList.toggle('lock-scroll', open);
        document.body.classList.toggle('lock-scroll', open);

        if (open) {
            setHeaderMenuHeight();
            let firstFocusable = menu.querySelector('a, button');

            if (firstFocusable) {
                firstFocusable.focus();
            }
        } else {
            closeSubmenus();

            if (returnFocus) {
                navToggle.focus();
            }
        }
    }

    function prepareSubmenus() {
        dropdownToggles.forEach(function (toggle, index) {
            let submenu = getSubmenu(toggle);

            if (!submenu) {
                return;
            }

            let submenuId = submenu.id || 'primary-submenu-' + index;
            submenu.id = submenuId;
            toggle.setAttribute('aria-controls', submenuId);
            toggle.setAttribute('aria-expanded', 'false');
            submenu.hidden = isMobileMenu();
            submenu.setAttribute('aria-hidden', isMobileMenu() ? 'true' : 'false');
        });
    }

    function resetForViewport() {
        if (!navToggle || !menu) {
            return;
        }

        document.documentElement.classList.remove('lock-scroll');
        document.body.classList.remove('lock-scroll');
        navToggle.classList.remove('active');
        navToggle.setAttribute('aria-expanded', 'false');
        menu.removeAttribute('style');

        if (isMobileMenu()) {
            menu.hidden = true;
            menu.setAttribute('aria-hidden', 'true');
            closeSubmenus();
            setHeaderMenuHeight();
        } else {
            menu.hidden = false;
            menu.removeAttribute('aria-hidden');

            dropdownToggles.forEach(function (toggle) {
                let submenu = getSubmenu(toggle);
                toggle.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');

                if (submenu) {
                    submenu.hidden = false;
                    submenu.removeAttribute('aria-hidden');
                }
            });
        }
    }

    if (navToggle && menu) {
        navToggle.addEventListener('click', function () {
            let isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
            setMobileMenu(!isExpanded, false);
        });

        dropdownToggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (event) {
                if (!isMobileMenu()) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                let submenu = getSubmenu(toggle);

                if (!submenu) {
                    return;
                }

                let isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.classList.toggle('active', !isExpanded);
                toggle.setAttribute('aria-expanded', String(!isExpanded));
                submenu.hidden = isExpanded;
                submenu.setAttribute('aria-hidden', String(isExpanded));
            });
        });

        document.addEventListener('click', function (event) {
            if (!isMobileMenu() || navToggle.getAttribute('aria-expanded') !== 'true') {
                return;
            }

            if (!header.contains(event.target)) {
                setMobileMenu(false, false);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isMobileMenu() && navToggle.getAttribute('aria-expanded') === 'true') {
                setMobileMenu(false, true);
            }
        });

        window.addEventListener('resize', function () {
            window.clearTimeout(resizeTimer);
            resizeTimer = window.setTimeout(resetForViewport, 120);
        });

        prepareSubmenus();
        resetForViewport();
    }

    if (historyBackButton) {
        historyBackButton.addEventListener('click', function () {
            if (window.history.length > 1) {
                window.history.back();
                return;
            }

            window.location.href = historyBackButton.dataset.homeUrl || '/';
        });
    }
});
