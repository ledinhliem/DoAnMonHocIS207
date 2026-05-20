
<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-16">

    <!-- ── Breadcrumb ── -->   
    <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-8">
        <a href="?url=" class="hover:text-primary transition-colors">Trang chủ</a>
        <span>/</span>
        <span class="text-primary font-semibold"><?= htmlspecialchars($meta['breadcrumb']) ?></span>
    </nav>

     <!-- ── Hero Section ── -->
    <header class="mb-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-7">
                <span class="inline-block px-1 py-1 rounded-full bg-primary-fixed text-on-surface font-medium mb-6 uppercase tracking-widest text-xs">
                    Báo cáo bền vững 2024
                </span>
                <h1 class="text-6xl md:text-8xl font-black font-headline text-primary leading-none tracking-tighter mb-8">
                    Kiến tạo từ <br/><span class="italic font-normal">Tự nhiên.</span>
                </h1>
                <p class="text-xl md:text-2xl text-on-surface-variant max-w-xl leading-relaxed">
                    Tại Zentro, chúng tôi tin rằng sự sang trọng thực sự không chỉ nằm ở vẻ ngoài, mà còn ở
                    cách sản phẩm được tạo ra và tác động của nó đối với hành tinh này.
                </p>
            </div>
            <div class="lg:col-span-5">
                <div class="aspect-[4/5] overflow-hidden rounded-xl">
                    <img
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBunBSBEYPqIpPtyDOvREvwQH8JaZ7nrh81o7_Y-DSLLrywPOhWDMKm8geMbr_m8fZCzJtKNkJo1ReKoVo56poN1MlyBqAsRdiGP2vzx-xDiby6WKeJLyejMgb-YatzawA433kmC3OojadbxBL0F_4gdS4FEJcIrCbjf4vEfjsdvDt7DWuWF15oZfAkYKq08bPU5eu2meMbgtyVWCluqltta7mRs8r8xO8MgvyTKlSQ-TPdDUAxifHRrmautOtkLZIXwQHwDtIrwUc"
                        alt="Sustainability visual"
                        class="w-full h-full object-cover"
                    >
                </div>
            </div>
        </div>
    </header>

    <!-- ── Impact Metrics ── -->
    <section class="mb-32">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-10 bg-surface-container-high rounded-xl flex flex-col justify-between" style="min-height:20rem;">
                <div>
                    <span class="material-symbols-outlined text-4xl text-primary mb-4 block">eco</span>
                    <h3 class="text-lg font-bold text-primary">Carbon Trung Tính</h3>
                </div>
                <div>
                <div data-metric="94%" class="text-5xl font-black font-headline text-primary mb-2">94%</div>
                    <p class="text-sm text-on-surface-variant">
                        Quy trình sản xuất của chúng tôi hiện đã đạt mức phát thải carbon thấp kỷ lục.
                    </p>
                </div>
            </div>
            <div class="p-10 bg-surface-container-high rounded-xl flex flex-col justify-between" style="min-height:20rem;">
                <div>
                    <span class="material-symbols-outlined text-4xl text-primary mb-4 block">water_drop</span>
                    <h3 class="text-lg font-bold text-primary">Tiết Kiệm Nước</h3>
                </div>
                <div>
                <div data-metric="12M L" class="text-5xl font-black font-headline text-primary mb-2">12M L</div>
                    <p class="text-sm text-on-surface-variant">
                        Lượng nước sạch được tiết kiệm thông qua hệ thống lọc tuần hoàn khép kín.
                    </p>
                </div>
            </div>
            <div class="p-10 bg-surface-container-high rounded-xl flex flex-col justify-between" style="min-height:20rem;">
                <div>
                    <span class="material-symbols-outlined text-4xl text-primary mb-4 block">recycling</span>
                    <h3 class="text-lg font-bold text-primary">Tái Chế Triệt Để</h3>
                </div>
                <div>
                <div data-metric="100%" class="text-5xl font-black font-headline text-primary mb-2">100%</div>
                    <p class="text-sm text-on-surface-variant">
                        Bao bì được làm hoàn toàn từ vật liệu phân hủy sinh học hoặc tái chế.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Materials Focus ── -->
    <section class="mb-32 py-24 border-y border-outline-variant/20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="space-y-12">
                <h2 class="text-5xl font-bold font-headline text-primary leading-tight">
                    Vật liệu tinh tuyển <br/>từ lòng đất mẹ.
                </h2>

                <div>
                    <div class="flex items-center gap-6 mb-4">
                        <span class="w-12 h-12 flex items-center justify-center rounded-full bg-primary text-white text-sm font-bold shrink-0">01</span>
                        <h4 class="text-2xl font-bold font-headline">Bông Hữu Cơ (Organic Cotton)</h4>
                    </div>
                    <p class="text-on-surface-variant leading-relaxed border-l-2 border-outline-variant pl-6 ml-[18px]">
                        Được trồng không sử dụng thuốc trừ sâu hóa học, bảo vệ hệ sinh thái đất và sức khỏe
                        người nông dân. Mỗi sợi vải mang hơi thở của vùng cao nguyên đầy nắng.
                    </p>
                </div>

                <div>
                    <div class="flex items-center gap-6 mb-4">
                        <span class="w-12 h-12 flex items-center justify-center rounded-full bg-primary text-white text-sm font-bold shrink-0">02</span>
                        <h4 class="text-2xl font-bold font-headline">Thủy Tinh Tái Chế</h4>
                    </div>
                    <p class="text-on-surface-variant leading-relaxed border-l-2 border-outline-variant pl-6 ml-[18px]">
                        Biến những mảnh vỡ thành tác phẩm nghệ thuật. Quy trình nung chảy nhiệt độ thấp giúp
                        giảm 40% năng lượng tiêu thụ so với thủy tinh nguyên bản.
                    </p>
                </div>
            </div>

            <div class="relative">
                <div class="aspect-square rounded-xl overflow-hidden shadow-2xl">
                    <img
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVULm9cARIoF51ufJ-dFQmOJIu_rZcV5w_YXKJsVIJ5YCEWhOp5BRSxuFvWv7L4RbcxfBZH1hwtCdsZ_Bbngtr2lSfPtJkERqdEvZN5p8gOnzZM5qlzGsh1ei-xrpCZqbx5twnw4IfQhsXQiltLv4xxigCAwzcVneEmzpaUZWTR6av8-wcRWykPhtpQ-u7xizJZ80IjrcE7uGGXmRasOMJNy36rtE2pzCKtjKWw6mpy2XugSp7aBMKqVqJN95RLqVqH3cZMiNmEik"
                        alt="Organic textures"
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="absolute -bottom-10 -left-10 w-64 p-6 bg-white rounded-xl shadow-xl hidden md:block">
                    <div class="text-primary font-bold text-sm mb-2">Chứng nhận GOTS</div>
                    <p class="text-xs text-on-surface-variant">
                        Toàn bộ quy trình từ nông trại đến thành phẩm đều tuân thủ tiêu chuẩn dệt may hữu cơ toàn cầu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Ethics & Transparency ── -->
    <section class="mb-32">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-4xl font-bold font-headline text-primary mb-6">Đạo đức &amp; Minh bạch</h2>
            <p class="text-on-surface-variant">
                Chúng tôi không giấu giếm. Mỗi mắt xích trong chuỗi cung ứng của Zentro đều được kiểm định
                độc lập để đảm bảo công bằng cho con người và môi trường.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php
            $ethics = [
                ['icon' => 'handshake',  'title' => 'Lương Công Bằng',      'desc' => 'Đảm bảo thu nhập cao hơn 30% so với mức sàn quy định.'],
                ['icon' => 'factory',    'title' => 'Xưởng May Xanh',       'desc' => 'Sử dụng 100% năng lượng mặt trời tại các cơ sở sản xuất.'],
                ['icon' => 'visibility', 'title' => 'Truy Xuất Nguồn Gốc',  'desc' => 'Mỗi sản phẩm đi kèm mã QR để bạn biết ai đã làm ra nó.'],
                ['icon' => 'diversity_3','title' => 'Cộng Đồng',            'desc' => 'Trích 2% doanh thu cho các dự án tái tạo rừng ngập mặn.'],
            ];
            foreach ($ethics as $item): ?>
                <div data-ethics-card class="p-8 bg-surface-container-high rounded-xl text-center hover:bg-primary-fixed transition-colors">
                    <span class="material-symbols-outlined text-3xl mb-4 block text-primary">
                        <?= $item['icon'] ?>
                    </span>
                    <h5 class="font-bold mb-2"><?= $item['title'] ?></h5>
                    <p class="text-xs text-on-surface-variant"><?= $item['desc'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ── CTA Banner ── -->
    <section data-newsletter class="rounded-xl overflow-hidden bg-primary p-12 md:p-24 text-center text-white relative">
        <div class="relative z-10 max-w-2xl mx-auto">
            <h2 class="text-4xl md:text-6xl font-bold font-headline mb-8">
                Cùng Zentro thay đổi tương lai.
            </h2>
            <p class="text-primary-fixed/80 text-lg mb-12 font-light">
                Đăng ký nhận bản tin Journal để tìm hiểu thêm về lối sống bền vững và các bộ sưu tập mới nhất.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <input
                    type="email"
                    placeholder="Email của bạn..."
                    class="bg-white/10 border border-white/20 text-white placeholder-white/50 rounded-xl px-8 py-4
                           focus:ring-2 focus:ring-primary-fixed focus:outline-none w-full md:w-80"
                >
                <button class="bg-secondary-container text-on-secondary-container font-bold px-10 py-4 rounded-xl
                               hover:scale-105 transition-transform">
                    Tham Gia Ngay
                </button>
            </div>
        </div>
        <!-- decorative blobs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-container rounded-full blur-[100px]
                    -mr-32 -mt-32 opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary-fixed rounded-full blur-[100px]
                    -ml-32 -mb-32 opacity-30 pointer-events-none"></div>
    </section>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script src="<?= BASE_URL ?>public/assets/js/footer-sustainability.js" defer></script>