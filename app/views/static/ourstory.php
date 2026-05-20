
<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-16 md:py-24">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-16">
        <a href="?url=" class="hover:text-primary transition-colors">Trang chủ</a>
        <span>/</span>
        <span class="text-primary font-semibold"><?= htmlspecialchars($meta['breadcrumb']) ?></span>
    </nav>

    <!-- ── Hero Section ── -->
    <header class="mb-24">
        <h1 class="text-5xl md:text-8xl font-bold font-headline tracking-tighter text-primary mb-8 leading-[1.1]">
            Kiến tạo sự bền vững <br/> qua từng điểm chạm.
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-end">
            <p class="text-xl md:text-2xl font-light text-on-surface-variant leading-relaxed">
                Zentro không chỉ là một thương hiệu; đó là một hành trình tìm về bản ngã của vật liệu tự nhiên,
                nơi tính thẩm mỹ hiện đại gặp gỡ trách nhiệm sinh thái.
            </p>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center gap-4 py-2 border-b border-outline-variant/30">
                    <span class="text-xs font-bold uppercase tracking-widest text-primary">Thành lập</span>
                    <span class="text-lg">2021 — Đà Lạt, Việt Nam</span>
                </div>
                <div class="flex items-center gap-4 py-2 border-b border-outline-variant/30">
                    <span class="text-xs font-bold uppercase tracking-widest text-primary">Sứ mệnh</span>
                    <span class="text-lg">Tactile Sustainability</span>
                </div>
            </div>
        </div>
    </header>

    <!-- ── Story: 2-Column Editorial ── -->
    <section class="grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-24 mb-32">

        <!-- Column 1: Image & Quote -->    
        <div class="md:col-span-5 flex flex-col space-y-12">
            <div class="relative group">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAbVGS9mcLMSkd-Jmc-2mOY330_8LyPBsBDzOqdURcOUdRKWfaU7M07WdLWBnbYF1nedfjZye5yBOKyRqf6fkW62gLdhZghomEHzTU_ky_0UpOTlqfvkGuoRtyAzvB38Hpdqcwx-PmZimnhX_ebkrCsApaeVcl0PjFh3TbkpRoNqpBH6mAaddZhs_GjtJKP-KzzH4ormgH-uS1b0hEkc9XHebsV39CYDtGbN8UKs_JeJX7vUjXI4JtZ9cSOlAk-WdZxVZVTeUGV2d4"
                    alt="Craftsmanship and sustainable materials"
                    class="w-full rounded-xl aspect-[3/4] object-cover"
                    style="box-shadow: 0 40px 40px -20px rgba(25,28,24,.04);"
                >
                <div class="absolute -bottom-6 -right-6 bg-secondary-container p-8 rounded-xl max-w-xs hidden lg:block"
                     style="box-shadow: 0 40px 40px -20px rgba(25,28,24,.04);">
                    <p class="text-on-secondary-container font-medium italic">
                        "Sự bền vững không nên là một sự hy sinh về phong cách, mà là sự nâng tầm của nó."
                    </p>
                </div>
            </div>

            <div class="pt-12">
                <h3 class="text-3xl font-bold font-headline text-primary mb-6">Di sản &amp; Tầm nhìn</h3>
                <p class="text-on-surface-variant leading-relaxed mb-6">
                    Bắt nguồn từ những cánh rừng cao nguyên và những xưởng thủ công truyền thống, Zentro ra đời với
                    khát khao định nghĩa lại khái niệm 'sang trọng'. Chúng tôi tin rằng sự sang trọng thực sự nằm
                    ở sự tĩnh lặng của thiên nhiên và độ bền của thời gian.
                </p>
                <p class="text-on-surface-variant leading-relaxed">
                    Mỗi sản phẩm là một câu chuyện về sự kết nối giữa con người và trái đất, được tinh tuyển từ
                    những nguồn nguyên liệu tái sinh và quy trình sản xuất không phát thải.
                </p>
            </div>
        </div>

        <!-- Column 2: Detailed Story -->
        <div class="md:col-span-7 flex flex-col justify-center">
            <div class="mb-16">
                <span class="inline-block px-4 py-1 rounded-full bg-primary-fixed text-on-surface text-sm font-bold mb-6 tracking-widest uppercase">
                    CHƯƠNG I
                </span>
                <h2 class="text-4xl md:text-6xl font-bold font-headline mb-8 leading-tight">
                    Cảm thức về <br/>
                    <span class="text-primary italic font-light">Sự Bền Vững Xúc Giác</span>
                </h2>
                <p class="text-xl text-on-surface-variant leading-relaxed mb-8">
                    Chúng tôi gọi triết lý của mình là 'Tactile Sustainability' — Sự bền vững có thể chạm thấy.
                    Đó là cảm giác mát lạnh của mặt đá được mài thủ công, sự mềm mại của vải sợi dứa,
                    hay mùi hương gỗ mộc lan tỏa trong không gian.
                </p>

                <div class="grid grid-cols-2 gap-8 mb-12">
                    <div class="bg-surface-container-high p-8 rounded-xl">
                        <span class="material-symbols-outlined text-primary mb-4 text-4xl block">eco</span>
                        <h4 class="font-bold text-lg mb-2 text-primary">Nguồn gốc</h4>
                        <p class="text-sm text-on-surface-variant">
                            100% nguyên liệu từ nguồn cung ứng minh bạch và có thể tái tạo.
                        </p>
                    </div>
                    <div class="bg-surface-container-high p-8 rounded-xl">
                        <span class="material-symbols-outlined text-primary mb-4 text-4xl block">water_drop</span>
                        <h4 class="font-bold text-lg mb-2 text-primary">Tiết tấu</h4>
                        <p class="text-sm text-on-surface-variant">
                            Tôn vinh lối sống chậm và quy trình chế tác không vội vã.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0ikrueHpLDgq2zwNtwEBkD_WzXKyk7TpnkW78XmaasDnYNA5_hvEBEfuvx0TrWjktUgiI-7M7blSFJ39BbUs4XArmXq8Yu5MBEeGD4gGkMVrk8EVjAW561aqdI3sUgDWXrZOPmGuJIgfjxCoCJ2UEGiAqw48M3RDQhfe_1b0CHl5THmejEcRiuZ4CwZp3FcJ86Uy5lKLWa6-sil0dDJXvUqWUOGqd7InMS6IeKiMKZZ4J0iNzNVEW7I7krmiFIs8O9iXxbEWpDUQ"
                    alt="Sustainable textures and brand aesthetic"
                    class="w-full rounded-xl aspect-video object-cover"
                >
                <div class="bg-surface-container-high p-10 rounded-xl border-l-4 border-primary">
                    <p class="text-lg leading-relaxed text-on-surface italic">
                        "Zentro không chỉ bán sản phẩm, chúng tôi cung cấp một hệ sinh thái của sự tỉnh thức.
                        Nơi mỗi lựa chọn tiêu dùng đều góp phần nuôi dưỡng hành tinh xanh."
                    </p>
                    <p class="mt-4 font-bold text-primary">— Founder, Zentro Systems</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Process Bento Grid ── -->
    <section class="mb-32">
        <h2 class="text-4xl font-bold font-headline mb-16 text-center">Quy trình Độc bản</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div data-bento class="md:col-span-2 md:row-span-2 bg-surface-container-high p-12 rounded-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-3xl font-bold font-headline mb-6">Nghiên cứu Vật liệu</h3>
                    <p class="text-on-surface-variant">
                        Phòng thí nghiệm của chúng tôi dành hàng nghìn giờ để thử nghiệm các sợi tự nhiên
                        và polyme sinh học từ phế phẩm nông nghiệp.
                    </p>
                </div>
                <div class="mt-12 flex flex-wrap gap-3">
                    <span class="px-4 py-2 bg-white rounded-full text-xs font-bold tracking-widest uppercase">Bio-Tech</span>
                    <span class="px-4 py-2 bg-white rounded-full text-xs font-bold tracking-widest uppercase">Upcycled</span>
                    <span class="px-4 py-2 bg-white rounded-full text-xs font-bold tracking-widest uppercase">Vegan</span>
                </div>
            </div>

            <div data-bento class="md:col-span-2 bg-primary p-12 rounded-xl text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold font-headline mb-4">Cam kết 0% Nhựa</h3>
                    <p class="opacity-80">
                        Chúng tôi đã loại bỏ hoàn toàn nhựa nguyên sinh khỏi toàn bộ chuỗi cung ứng và bao bì đóng gói.
                    </p>
                </div>
                <span class="material-symbols-outlined absolute -bottom-10 -right-10 opacity-10 rotate-12"
                      style="font-size:180px;">recycling</span>
            </div>

            <div data-bento class="bg-secondary-container p-8 rounded-xl flex flex-col items-center text-center justify-center">
                <span class="material-symbols-outlined text-4xl mb-4 text-on-secondary-container">local_shipping</span>
                <h4 class="font-bold text-on-secondary-container">Vận chuyển Xanh</h4>
            </div>

            <div data-bento class="bg-surface-container-high p-8 rounded-xl flex flex-col items-center text-center justify-center">
                <span class="material-symbols-outlined text-4xl mb-4 text-primary">diversity_3</span>
                <h4 class="font-bold text-primary">Cộng đồng Artisans</h4>
            </div>
        </div>
    </section>

    <!-- ── CTA Section ── -->
    <?php include __DIR__ . '/../components/newsletter_cta.php'; ?>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script src="<?= BASE_URL ?>public/assets/js/footer-ourstory.js" defer></script>
