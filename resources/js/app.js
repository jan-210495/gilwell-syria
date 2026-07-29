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

    const updateHeaderState = () => {
        const readableFromFirstPaint = siteHeader.classList.contains('site-header--readable');

        siteHeader.classList.toggle('is-scrolled', readableFromFirstPaint || window.scrollY > 24);
    };

    setMenuOpen(false);
    updateHeaderState();
    window.addEventListener('scroll', updateHeaderState, { passive: true });
}

const heroCorners = document.querySelector('.home-hero--corners');

if (heroCorners) {
    const cornerPanels = [...heroCorners.querySelectorAll('.hero-corner-panel')];
    const hoverZones = [...heroCorners.querySelectorAll('.hero-corner-panel__hover-zone')];

    const clearExpandedPanel = () => {
        heroCorners.classList.remove('is-exploring-panels');
        cornerPanels.forEach((panel) => panel.classList.remove('is-expanded'));
    };

    const expandPanel = (panel, className = 'is-exploring-panels') => {
        if (!panel) {
            clearExpandedPanel();
            return;
        }

        heroCorners.classList.add(className);
        cornerPanels.forEach((candidate) => {
            candidate.classList.toggle('is-expanded', candidate === panel);
        });
    };

    hoverZones.forEach((zone) => {
        const panel = zone.closest('.hero-corner-panel');

        zone.addEventListener('pointerenter', () => expandPanel(panel));
        zone.addEventListener('pointerleave', () => {
            if (!heroCorners.classList.contains('has-panel-focus')) {
                clearExpandedPanel();
            }
        });
    });

    cornerPanels.forEach((panel) => {
        panel.addEventListener('focusin', () => {
            heroCorners.classList.add('has-panel-focus');
            expandPanel(panel, 'has-panel-focus');
        });

        panel.addEventListener('focusout', () => {
            window.setTimeout(() => {
                const panelStillFocused = cornerPanels.some((candidate) => candidate.contains(document.activeElement));

                if (!panelStillFocused) {
                    heroCorners.classList.remove('has-panel-focus');

                    if (!heroCorners.matches(':hover')) {
                        clearExpandedPanel();
                    }
                }
            }, 0);
        });
    });
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
