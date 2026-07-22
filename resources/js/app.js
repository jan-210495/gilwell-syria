const siteHeader = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const menuPanel = document.querySelector('[data-menu-panel]');
const menuCloseTargets = document.querySelectorAll('[data-menu-close]');

function setMenuOpen(open) {
    if (!siteHeader || !menuToggle || !menuPanel) {
        return;
    }

    siteHeader.classList.toggle('is-menu-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuPanel.toggleAttribute('data-open', open);
    document.documentElement.classList.toggle('has-open-menu', open);
}

if (siteHeader && menuToggle && menuPanel) {
    menuToggle.addEventListener('click', () => {
        setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
    });

    menuCloseTargets.forEach((target) => {
        target.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });

    const updateHeaderState = () => {
        siteHeader.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    updateHeaderState();
    window.addEventListener('scroll', updateHeaderState, { passive: true });
}
