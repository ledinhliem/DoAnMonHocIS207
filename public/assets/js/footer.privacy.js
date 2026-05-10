

document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Sticky TOC active highlight ────────────────────────────────────
    const tocLinks = document.querySelectorAll('aside a[href^="#"]');
    const sections = [...tocLinks].map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);

    const setActive = id => {
        tocLinks.forEach(a => {
            const isActive = a.getAttribute('href') === `#${id}`;
            a.classList.toggle('text-primary',      isActive);
            a.classList.toggle('font-bold',         isActive);
            a.classList.toggle('border-b-2',        isActive);
            a.classList.toggle('border-primary',    isActive);
            a.classList.toggle('pb-1',              isActive);
            a.classList.toggle('text-on-surface-variant', !isActive);
        });
    };

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

    // ── 2. Scroll reveal cho security cards ───────────────────────────────
    if ('IntersectionObserver' in window) {
        const cards = document.querySelectorAll(
            '#bao-mat [class*="flex items-start gap-6"]'
        );
        const observer = new IntersectionObserver(entries => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity   = '1';
                        entry.target.style.transform = 'translateX(0)';
                    }, i * 150);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        cards.forEach(card => {
            card.style.opacity   = '0';
            card.style.transform = 'translateX(-20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    }

    // ── 3. "Tải bản PDF" button ───────────────────────────────────────────
    const pdfBtn = document.querySelector('[data-pdf-download]');
    if (pdfBtn) {
        pdfBtn.addEventListener('click', () => {
            // Thay bằng URL thật khi có file PDF
            alert('Tính năng tải PDF sẽ sớm ra mắt.');
        });
    }

});