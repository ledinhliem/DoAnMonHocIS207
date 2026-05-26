document.addEventListener('DOMContentLoaded', () => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealEls = document.querySelectorAll('[data-home-reveal]');

    if (!revealEls.length) {
        return;
    }

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealEls.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                return;
            }

            const delay = Number(entry.target.dataset.homeDelay || 0);
            setTimeout(() => {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translate3d(0, 0, 0)';
            }, delay);

            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px'
    });

    revealEls.forEach(el => {
        const direction = el.dataset.homeReveal;
        const offset = direction === 'left'
            ? 'translate3d(-28px, 0, 0)'
            : direction === 'right'
                ? 'translate3d(28px, 0, 0)'
                : 'translate3d(0, 24px, 0)';

        el.style.opacity = '0';
        el.style.transform = offset;
        el.style.transition = 'opacity 0.65s ease, transform 0.65s cubic-bezier(0.22, 1, 0.36, 1)';
        el.style.willChange = 'opacity, transform';

        observer.observe(el);
    });
});
