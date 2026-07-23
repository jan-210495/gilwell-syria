const siteHeader = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const menuPanel = document.querySelector('[data-menu-panel]');
const menuCloseTargets = document.querySelectorAll('[data-menu-close]');
const mobileMenuQuery = window.matchMedia('(max-width: 820px)');

function setMenuOpen(open) {
    if (!siteHeader || !menuToggle || !menuPanel) {
        return;
    }

    const isMobile = mobileMenuQuery.matches;
    const shouldOpen = isMobile && open;

    siteHeader.classList.toggle('is-menu-open', shouldOpen);
    menuToggle.setAttribute('aria-expanded', String(shouldOpen));
    menuPanel.toggleAttribute('data-open', shouldOpen);
    menuPanel.hidden = isMobile && !shouldOpen;
    menuPanel.inert = isMobile && !shouldOpen;
    document.documentElement.classList.toggle('has-open-menu', shouldOpen);
}

if (siteHeader && menuToggle && menuPanel) {
    menuToggle.addEventListener('click', () => {
        setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
    });

    mobileMenuQuery.addEventListener('change', () => setMenuOpen(false));

    menuCloseTargets.forEach((target) => {
        target.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });

    const hasDarkHero = document.body.classList.contains('has-dark-hero');

    const updateHeaderState = () => {
        if (hasDarkHero) {
            siteHeader.classList.toggle('is-scrolled', window.scrollY > 24);
        }
    };

    setMenuOpen(false);
    updateHeaderState();
    window.addEventListener('scroll', updateHeaderState, { passive: true });
}

const revealTargets = document.querySelectorAll('[data-reveal]');

if (revealTargets.length > 0) {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
        revealTargets.forEach((target) => target.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.14,
        });

        revealTargets.forEach((target) => revealObserver.observe(target));
    }
}

/* Hero corner panel expansion via hover zones (desktop only) */
const hoverZones = document.querySelectorAll('.hero-corner-panel__hover-zone');
const heroSection = document.querySelector('.home-hero--corners');

if (hoverZones.length > 0 && !window.matchMedia('(max-width: 820px)').matches) {
    hoverZones.forEach((zone) => {
        const panel = zone.closest('.hero-corner-panel');

        zone.addEventListener('mouseenter', () => {
            panel.classList.add('is-expanded');
            if (heroSection) heroSection.classList.add('has-panel-focus');
        });

        zone.addEventListener('mouseleave', () => {
            panel.classList.remove('is-expanded');
            if (heroSection) heroSection.classList.remove('has-panel-focus');
        });
    });

    /* Keyboard focus also toggles expansion */
    const heroPanels = document.querySelectorAll('.hero-corner-panel');

    heroPanels.forEach((panel) => {
        panel.addEventListener('focusin', () => {
            panel.classList.add('is-expanded');
            if (heroSection) heroSection.classList.add('has-panel-focus');
        });

        panel.addEventListener('focusout', () => {
            panel.classList.remove('is-expanded');
            if (heroSection) heroSection.classList.remove('has-panel-focus');
        });
    });
}

/* Mobile: toggle has-panel-focus on panel hover/touch */
if (heroSection && window.matchMedia('(max-width: 820px)').matches) {
    const mobilePanels = document.querySelectorAll('.hero-corner-panel');

    mobilePanels.forEach((panel) => {
        panel.addEventListener('mouseenter', () => {
            heroSection.classList.add('has-panel-focus');
        });

        panel.addEventListener('mouseleave', () => {
            heroSection.classList.remove('has-panel-focus');
        });

        /* Touch: toggle on tap */
        panel.addEventListener('touchstart', () => {
            heroSection.classList.toggle('has-panel-focus');
        }, { passive: true });
    });
}
