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
    const tocLinks = document.querySelectorAll('aside a.toc-link');
    const sections = [...tocLinks]
        .map(a => document.querySelector(a.getAttribute('href')))
        .filter(Boolean);

    const setActive = id => {
        tocLinks.forEach(a => {
            const isActive = a.getAttribute('href') === `#${id}`;
            if (isActive) {
                a.style.color       = 'var(--primary)';
                a.style.fontWeight  = '700';
                a.style.borderBottom = '2px solid var(--primary)';
                a.style.paddingBottom = '4px';
                a.style.width       = 'fit-content';
            } else {
                a.style.color       = 'rgba(var(--on-surface-variant), 0.7)';
                a.style.fontWeight  = '';
                a.style.borderBottom = '';
                a.style.paddingBottom = '';
                a.style.width       = '';
            }
        });
    };

    // Khởi tạo active link đầu tiên
    if (tocLinks.length) setActive(tocLinks[0].getAttribute('href').slice(1));

    if (sections.length) {
        const io = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) setActive(entry.target.id);
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

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