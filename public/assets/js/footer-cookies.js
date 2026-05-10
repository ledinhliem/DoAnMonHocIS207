
document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Highlight card khi hover (pulse ring) ───────────────────────────
    const bentoCards = document.querySelectorAll('[data-cookie-card]');
    bentoCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('ring-2', 'ring-primary/20');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('ring-2', 'ring-primary/20');
        });
    });

    // ── 2. Smooth scroll cho các anchor link (nếu có thêm sau) ───────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', e => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // ── 3. Trust chip entrance animation ──────────────────────────────────
    const chips = document.querySelectorAll('[data-trust-chip]');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity  = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, i * 120);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        chips.forEach(chip => {
            chip.style.opacity  = '0';
            chip.style.transform = 'translateY(16px)';
            chip.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            observer.observe(chip);
        });
    }

});