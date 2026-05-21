

document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Counter animation ───────────────────────────────────────────────
    /**
     * Phân tích chuỗi như "94%", "12M L", "100%" thành
     * { prefix: '', value: 94, suffix: '%' }
     */
    const parseMetric = raw => {
        const str = raw.trim();
        const match = str.match(/^(\D*?)([\d.]+)(\D*)$/);
        if (!match) return null;
        return { prefix: match[1], value: parseFloat(match[2]), suffix: match[3] };
    };

    const animateCounter = (el, from, to, suffix, prefix, duration = 1800) => {
        const start = performance.now();
        const isFloat = !Number.isInteger(to);

        const tick = now => {
            const elapsed  = now - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease-out cubic
            const ease = 1 - Math.pow(1 - progress, 3);
            const current = from + (to - from) * ease;
            el.textContent = prefix + (isFloat ? current.toFixed(1) : Math.round(current)) + suffix;
            if (progress < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    };

    const metricEls = document.querySelectorAll('[data-metric]');

    if ('IntersectionObserver' in window && metricEls.length) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el     = entry.target;
                const parsed = parseMetric(el.dataset.metric);
                if (!parsed) return;
                animateCounter(el, 0, parsed.value, parsed.suffix, parsed.prefix);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        metricEls.forEach(el => observer.observe(el));
    }

    // ── 2. Scroll reveal — ethics cards ───────────────────────────────────
    const ethicsCards = document.querySelectorAll('[data-ethics-card]');

    if ('IntersectionObserver' in window && ethicsCards.length) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity   = '1';
                        entry.target.style.transform = 'translateY(0) scale(1)';
                    }, i * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        ethicsCards.forEach(card => {
            card.style.opacity   = '0';
            card.style.transform = 'translateY(20px) scale(0.97)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    }

    // ── 3. Newsletter form UX ─────────────────────────────────────────────
    const ctaSection = document.querySelector('[data-newsletter]');
    if (ctaSection) {
        const input  = ctaSection.querySelector('input[type="email"]');
        const button = ctaSection.querySelector('button');

        button?.addEventListener('click', () => {
            if (!input?.value.trim()) {
                input?.classList.add('ring-2', 'ring-white/60');
                input?.focus();
                setTimeout(() => input?.classList.remove('ring-2', 'ring-white/60'), 1500);
                return;
            }
            button.textContent = 'Đã đăng ký ✓';
            button.disabled    = true;
            button.style.opacity = '0.8';
        });
    }

});