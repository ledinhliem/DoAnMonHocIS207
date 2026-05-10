
document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Reading progress bar ────────────────────────────────────────────
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed; top: 0; left: 0; height: 3px; width: 0%;
        background-color: var(--primary); z-index: 9999;
        transition: width 0.1s linear; pointer-events: none;
    `;
    document.body.prepend(progressBar);

    window.addEventListener('scroll', () => {
        const scrollTop  = window.scrollY;
        const docHeight  = document.documentElement.scrollHeight - window.innerHeight;
        const pct        = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        progressBar.style.width = `${Math.min(pct, 100)}%`;
    }, { passive: true });

    // ── 2. Sticky TOC active highlight ────────────────────────────────────
    const tocLinks = document.querySelectorAll('aside a[href^="#"]');
    const sections = [...tocLinks]
        .map(a => document.querySelector(a.getAttribute('href')))
        .filter(Boolean);

    const updateTOC = activeId => {
        tocLinks.forEach(a => {
            const isActive = a.getAttribute('href') === `#${activeId}`;

            // Active state: pill filled
            a.classList.toggle('bg-primary',        isActive);
            a.classList.toggle('text-white',        isActive);
            a.classList.toggle('font-medium',       isActive);
            a.classList.toggle('translate-x-0',     isActive);

            // Inactive state
            a.classList.toggle('text-on-surface-variant', !isActive);
            a.classList.toggle('text-on-surface/60',      false); // remove old class
        });
    };

    if (sections.length) {
        const io = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) updateTOC(entry.target.id);
            });
        }, { rootMargin: '-25% 0px -65% 0px' });

        sections.forEach(sec => io.observe(sec));

        // Smooth scroll
        tocLinks.forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (!target) return;
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    // ── 3. Scroll reveal — các section chính ──────────────────────────────
    if ('IntersectionObserver' in window) {
        const revealSections = document.querySelectorAll('article section');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity   = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });

        revealSections.forEach(sec => {
            sec.style.opacity   = '0';
            sec.style.transform = 'translateY(20px)';
            sec.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(sec);
        });
    }

});