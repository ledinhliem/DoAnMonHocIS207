<?php

include __DIR__ . '/../layouts/header.php';
?>

<main class="max-w-7xl mx-auto px-6 lg:px-12 py-12 md:py-20">

    <!-- BREADCRUMB -->
    <nav class="flex flex-wrap gap-2 text-xs font-label uppercase tracking-widest text-outline mb-10 items-center">
        <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>">Trang chủ</a>
        <span>/</span>
        <span class="text-on-surface font-semibold"><?= htmlspecialchars($meta['breadcrumb']) ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

        <!-- ── STICKY SIDEBAR TOC ──────────────────────────────────────────── -->
        <aside class="hidden lg:block lg:col-span-3">
            <div class="sticky top-32 space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-primary/50">Nội dung chính</p>
                <ul class="space-y-3">
                    <li><a class="text-primary font-bold border-b-2 border-primary pb-1 block w-fit hover:text-primary-container transition-colors" href="#thu-thap">1. Thu thập dữ liệu</a></li>
                    <li><a class="text-on-surface-variant/70 hover:text-primary transition-colors block" href="#su-dung">2. Mục đích sử dụng</a></li>
                    <li><a class="text-on-surface-variant/70 hover:text-primary transition-colors block" href="#bao-mat">3. Bảo mật thông tin</a></li>
                    <li><a class="text-on-surface-variant/70 hover:text-primary transition-colors block" href="#quyen-loi">4. Quyền của người dùng</a></li>
                    <li><a class="text-on-surface-variant/70 hover:text-primary transition-colors block" href="<?= BASE_URL ?>?url=cookies">5. Chính sách Cookie ↗</a></li>
                </ul>

                <!-- Support card -->
                <div class="mt-8 p-6 rounded-xl bg-surface-container border border-outline-variant/10">
                    <p class="text-sm font-semibold text-on-surface mb-2">Cần hỗ trợ?</p>
                    <p class="text-xs text-on-surface-variant leading-relaxed mb-4">
                        Mọi thắc mắc về quyền riêng tư, vui lòng liên hệ đội ngũ pháp lý của chúng tôi.
                    </p>
                    <a class="text-sm font-bold text-primary underline hover:text-primary-container transition-colors"
                       href="mailto:privacy@zentro.vn">privacy@zentro.vn</a>
                </div>
            </div>
        </aside>

        <!-- ── MAIN ARTICLE ────────────────────────────────────────────────── -->
        <article class="lg:col-span-9 max-w-3xl">

            <!-- Page header -->
            <header class="mb-16">
                <h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tight text-primary leading-tight mb-6">
                    Chính sách Bảo mật.
                </h1>
                <p class="text-xl text-on-surface-variant/80 leading-relaxed font-light">
                    Tại Zentro, sự minh bạch là nền tảng của bền vững. Chúng tôi cam kết bảo vệ dữ liệu cá nhân của bạn như cách chúng tôi bảo vệ hành tinh xanh.
                    Tài liệu này giải thích cách chúng tôi thu thập, xử lý và tôn trọng quyền riêng tư của bạn.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <span class="px-4 py-1.5 rounded-full bg-surface-container text-primary text-xs font-bold">Cập nhật lần cuối: 24/05/2024</span>
                    <span class="px-4 py-1.5 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold italic">Bản dịch chính thức</span>
                </div>
            </header>

            <!-- Section 1 -->
            <section class="mb-20" id="thu-thap">
                <h2 class="text-3xl font-headline font-bold text-primary mb-8 tracking-tight">01. Thu thập dữ liệu cá nhân</h2>
                <div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
                    <p>Chúng tôi chỉ thu thập những thông tin thực sự cần thiết để nâng cao trải nghiệm sống bền vững của bạn. Điều này bao gồm:</p>
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                            <span><strong class="text-on-surface">Thông tin định danh:</strong> Tên, địa chỉ email, và số điện thoại khi bạn đăng ký tài khoản hoặc bản tin Journal.</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                            <span><strong class="text-on-surface">Dữ liệu giao dịch:</strong> Lịch sử mua hàng và thông tin thanh toán (được mã hóa theo tiêu chuẩn quốc tế).</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                            <span><strong class="text-on-surface">Dữ liệu hành vi:</strong> Cách bạn tương tác với các nội dung về lối sống xanh trên nền tảng Zentro.</span>
                        </li>
                    </ul>
                    <blockquote class="p-8 bg-surface-container rounded-xl italic font-light border-l-4 border-primary text-on-surface-variant">
                        "Zentro không bao giờ bán hoặc trao đổi dữ liệu cá nhân của bạn cho bên thứ ba vì mục đích tiếp thị thuần túy."
                    </blockquote>
                </div>
            </section>

            <!-- Visual break -->
            <div class="my-16 overflow-hidden rounded-2xl h-80 md:h-96 relative">
                <img alt="Zentro Privacy"
                     class="w-full h-full object-cover"
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2toW3_ygN1QBiC7aNxlB6MIbXsdsuttij5p_jYV_QoBysbJ_zXTPQX6NU-Hscr3HUTur5r2h0pJO9BsU7mwpMWXKuuMbY1ud68o9jOyBIWTSPrgbhffbdg5lpEQNq-L4kfxZBub6uGlD5ofPfL0y1rivLFu8ZHkn3H6aoWVcxfU-b95_bT36-NxacYeAP_DOWuy1uLecAtvLT4la6AeTc8xqujzY_Wf71A09AYrEmqzb_rFEvwxT8MyolOZMZhw3wXq1yHi_7knc"/>
            </div>

            <!-- Section 2 -->
            <section class="mb-20" id="su-dung">
                <h2 class="text-3xl font-headline font-bold text-primary mb-8 tracking-tight">02. Cách chúng tôi sử dụng thông tin</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="p-8 rounded-xl bg-surface-container border border-outline-variant/10">
                        <span class="material-symbols-outlined text-3xl mb-4 text-primary block" style="font-variation-settings:'FILL' 1">eco</span>
                        <h3 class="text-xl font-headline font-bold mb-3">Cá nhân hóa trải nghiệm</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">Gợi ý các vật liệu và bài viết phù hợp với hành trình sống bền vững của riêng bạn.</p>
                    </div>
                    <div class="p-8 rounded-xl bg-surface-container border border-outline-variant/10">
                        <span class="material-symbols-outlined text-3xl mb-4 text-primary block" style="font-variation-settings:'FILL' 1">shield_person</span>
                        <h3 class="text-xl font-headline font-bold mb-3">Nâng cao an toàn</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">Xác minh tài khoản và ngăn chặn các hoạt động giả mạo hoặc trái pháp luật.</p>
                    </div>
                </div>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    Mọi thông tin được xử lý tự động thông qua hệ thống AI của chúng tôi để đảm bảo tính bảo mật tuyệt đối trước khi nhân viên hỗ trợ có thể tiếp cận (nếu cần thiết).
                </p>
            </section>

            <!-- Section 3 -->
            <section class="mb-20" id="bao-mat">
                <h2 class="text-3xl font-headline font-bold text-primary mb-8 tracking-tight">03. Cam kết bảo mật kỹ thuật</h2>
                <div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
                    <p>Zentro áp dụng các biện pháp bảo mật đa tầng để bảo vệ tài sản số của bạn:</p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-6 p-6 rounded-xl bg-surface-container border border-outline-variant/10">
                            <div class="bg-primary text-white px-3 py-2 rounded-lg font-bold font-label text-sm shrink-0">AES</div>
                            <div>
                                <h4 class="font-bold text-on-surface mb-1">Mã hóa 256-bit</h4>
                                <p class="text-sm">Toàn bộ dữ liệu nhạy cảm được mã hóa ở trạng thái nghỉ và trong quá trình truyền tải.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-6 p-6 rounded-xl bg-surface-container border border-outline-variant/10">
                            <div class="bg-primary text-white px-3 py-2 rounded-lg font-bold font-label text-sm shrink-0">SOC</div>
                            <div>
                                <h4 class="font-bold text-on-surface mb-1">Kiểm tra định kỳ</h4>
                                <p class="text-sm">Chúng tôi thực hiện kiểm tra thâm nhập hàng tháng bởi các chuyên gia bảo mật độc lập.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4 -->
            <section class="mb-20" id="quyen-loi">
                <h2 class="text-3xl font-headline font-bold text-primary mb-8 tracking-tight">04. Quyền lợi của bạn</h2>
                <p class="text-lg text-on-surface-variant leading-relaxed mb-8">
                    Bạn có toàn quyền kiểm soát dữ liệu của mình. Theo quy định của pháp luật Việt Nam và chuẩn GDPR, bạn có quyền:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border border-outline-variant/20 p-6 rounded-xl hover:bg-surface-container transition-colors group">
                        <h4 class="font-bold mb-2 group-hover:text-primary transition-colors">Truy cập</h4>
                        <p class="text-sm text-on-surface-variant">Yêu cầu bản sao tất cả dữ liệu chúng tôi lưu trữ về bạn.</p>
                    </div>
                    <div class="border border-outline-variant/20 p-6 rounded-xl hover:bg-surface-container transition-colors group">
                        <h4 class="font-bold mb-2 group-hover:text-primary transition-colors">Chỉnh sửa</h4>
                        <p class="text-sm text-on-surface-variant">Cập nhật thông tin không chính xác bất cứ lúc nào qua cài đặt.</p>
                    </div>
                    <div class="border border-outline-variant/20 p-6 rounded-xl hover:bg-surface-container transition-colors group">
                        <h4 class="font-bold mb-2 group-hover:text-primary transition-colors">Xóa bỏ</h4>
                        <p class="text-sm text-on-surface-variant">Yêu cầu "được lãng quên" và xóa vĩnh viễn tài khoản của bạn.</p>
                    </div>
                </div>
            </section>

            <!-- Section 5 -->
            <section class="mb-20" id="cookies">
                <h2 class="text-3xl font-headline font-bold text-primary mb-8 tracking-tight">05. Chính sách Cookie</h2>
                <div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
                    <p>
                        Zentro sử dụng cookie để cải thiện trải nghiệm duyệt web của bạn, phân tích lưu lượng truy cập và cá nhân hóa nội dung. Các cookie này không bao giờ được dùng để nhận dạng cá nhân bạn ngoài phạm vi nền tảng Zentro.
                    </p>
                    <p>
                        Bạn có toàn quyền kiểm soát việc chấp nhận hoặc từ chối cookie không thiết yếu thông qua cài đặt trình duyệt hoặc banner đồng ý cookie của chúng tôi.
                    </p>
                </div>
                <a href="<?= BASE_URL ?>?url=cookies"
                   class="inline-flex items-center gap-3 mt-8 px-8 py-4 bg-surface-container rounded-xl border border-outline-variant/20
                          text-primary font-bold hover:bg-primary hover:text-white transition-all duration-300 group">
                    <span class="material-symbols-outlined text-xl transition-transform group-hover:rotate-12"
                          style="font-variation-settings:'FILL' 1">cookie</span>
                    Xem toàn bộ Chính sách Cookie
                    <span class="material-symbols-outlined text-base transition-transform group-hover:translate-x-1">arrow_forward</span>
                </a>
            </section>

            <!-- CTA banner -->
            <div class="mt-20 p-10 md:p-12 rounded-2xl bg-primary text-white flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-md text-center md:text-left">
                    <h3 class="text-2xl font-headline font-bold mb-4">Mọi thứ bắt đầu từ sự tin tưởng.</h3>
                    <p class="opacity-80 text-sm leading-relaxed">Nếu bạn đồng ý với các điều khoản trên, hãy cùng chúng tôi kiến tạo một tương lai bền vững.</p>
                </div>
                <div class="flex flex-col gap-3 w-full md:w-auto shrink-0">
                    <a href="<?= BASE_URL ?>"
                       class="zentro-button text-center px-8 py-4 rounded-xl bg-white !text-primary font-bold hover:bg-primary-fixed transition-colors">
                        Đồng ý &amp; Tiếp tục
                    </a>
                    <button data-pdf-download class="border border-white/30 text-white px-8 py-3 rounded-xl font-bold hover:bg-white/10 transition-colors text-sm">
                        Tải bản PDF
                    </button>
                </div>
            </div>

        </article>
    </div><!-- /grid -->

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script src="<?= BASE_URL ?>public/assets/js/footer.privacy.js" defer></script>