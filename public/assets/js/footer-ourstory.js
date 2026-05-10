

document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Scroll reveal — tất cả section con ─────────────────────────────
    if ('IntersectionObserver' in window) {
        const revealEls = document.querySelectorAll(
            'section, header .grid > *, [data-reveal]'
        );

        const observer = new IntersectionObserver(entries => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity   = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        revealEls.forEach(el => {
            el.style.opacity   = '0';
            el.style.transform = 'translateY(24px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    // ── 2. Bento grid: hover lift effect ──────────────────────────────────
    document.querySelectorAll('[data-bento]').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-4px)';
            card.style.transition = 'transform 0.3s ease';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

    // ── 3. Newsletter form — basic UX ─────────────────────────────────────
    const form = document.querySelector('[data-newsletter]');
    if (form) {
        const input  = form.querySelector('input[type="email"]');
        const button = form.querySelector('button');

        button.addEventListener('click', () => {
            if (!input || !input.value.trim()) {
                input?.classList.add('ring-2', 'ring-red-400');
                setTimeout(() => input?.classList.remove('ring-2', 'ring-red-400'), 1500);
                return;
            }
            button.textContent = 'Đã đăng ký ✓';
            button.disabled = true;
            button.style.opacity = '0.7';
        });
    }

});