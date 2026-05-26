<?php include __DIR__ . '/../layouts/header.php';?>

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
                    <li><a class="toc-link block transition-colors hover:text-primary" href="#intro">1. Chấp nhận Điều khoản</a></li>
                    <li><a class="toc-link block transition-colors hover:text-primary" href="#usage">2. Giấy phép Sử dụng</a></li>
                    <li><a class="toc-link block transition-colors hover:text-primary" href="#purchase">3. Thanh toán &amp; Giao dịch</a></li>
                    <li><a class="toc-link block transition-colors hover:text-primary" href="#ip">4. Sở hữu Trí tuệ</a></li>
                </ul>

                <!-- Support card -->
                <div class="mt-8 p-6 rounded-xl bg-surface-container border border-outline-variant/10">
                    <p class="text-sm font-semibold text-on-surface mb-2">Cần hỗ trợ?</p>
                    <p class="text-xs text-on-surface-variant leading-relaxed mb-4">
                        Mọi thắc mắc về Điều khoản Dịch vụ, vui lòng liên hệ đội ngũ pháp lý của chúng tôi.
                    </p>
                    <a class="text-sm font-bold text-primary underline hover:text-primary-container transition-colors"
                       href="mailto:legal@zentro.vn">legal@zentro.vn</a>
                </div>
            </div>
        </aside>

        <!-- ── MAIN ARTICLE ────────────────────────────────────────────────── -->
        <article class="lg:col-span-9 max-w-3xl">

            <!-- Page header -->
            <header class="mb-16">
                <h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tighter text-primary leading-tight mb-8">
                    Điều khoản<br/>Dịch vụ
                </h1>
                <p class="text-xl md:text-2xl font-light text-on-surface-variant leading-relaxed">
                    Chào mừng bạn đến với Zentro. Việc bạn truy cập và sử dụng hệ thống bền vững của chúng tôi đồng nghĩa với việc bạn chấp nhận các cam kết sau đây.
                </p>
            </header>

            <div class="space-y-24">

                <!-- Section 1 -->
                <section class="scroll-mt-32" id="intro">
                    <h2 class="text-3xl font-headline font-bold text-primary mb-8 flex items-center gap-4">
                        <span class="w-12 h-12 rounded-full bg-primary-container text-white flex items-center justify-center text-sm font-black">01</span>
                        Chấp nhận Điều khoản
                    </h2>
                    <div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
                        <p>Bằng cách sử dụng trang web zentro.vn ("Trang web"), bạn đồng ý bị ràng buộc bởi các Điều khoản Dịch vụ này, tất cả các luật và quy định hiện hành, và đồng ý rằng bạn chịu trách nhiệm tuân thủ mọi luật pháp địa phương có hiệu lực.</p>
                        <p>Nếu bạn không đồng ý với bất kỳ điều khoản nào trong số này, bạn sẽ bị cấm sử dụng hoặc truy cập trang web này. Các tài liệu có trên trang web này được bảo vệ bởi luật bản quyền và thương hiệu hiện hành.</p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section class="scroll-mt-32" id="usage">
                    <h2 class="text-3xl font-headline font-bold text-primary mb-8 flex items-center gap-4">
                        <span class="w-12 h-12 rounded-full bg-primary-container text-white flex items-center justify-center text-sm font-black">02</span>
                        Giấy phép Sử dụng
                    </h2>
                    <div class="space-y-6 text-lg text-on-surface-variant leading-relaxed">
                        <p>Zentro cấp phép tạm thời để tải xuống một bản sao của các tài liệu (thông tin hoặc phần mềm) trên trang web của Zentro chỉ nhằm mục đích xem cá nhân, không thương mại.</p>
                        <ul class="space-y-4">
                            <li class="flex gap-4">
                                <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                                <span>Không sửa đổi hoặc sao chép các tài liệu vì mục đích thương mại.</span>
                            </li>
                            <li class="flex gap-4">
                                <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                                <span>Không cố gắng biên dịch ngược hoặc đảo ngược kỹ thuật bất kỳ phần mềm nào có trên trang web của Zentro.</span>
                            </li>
                            <li class="flex gap-4">
                                <span class="material-symbols-outlined text-primary mt-1">check_circle</span>
                                <span>Không xóa bất kỳ ghi chú bản quyền hoặc ký hiệu sở hữu nào khác khỏi tài liệu.</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Visual break -->
                <div class="relative w-full aspect-[16/9] rounded-2xl overflow-hidden group">
                    <img alt="Zentro Workspace"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuCXLGz8On7S865mHmmgwnfm3Y7QXoSWysXqASFo2fg5XRTvshQZeq96nSnry0wVbhgyo8vuuYUiP84bn_wN80Vo1xkpWJDDDQeCZB5BebGdKLPtcvwbwAvIcv1ohOXQ1175RdcDQB3CdmwfjGotrRyocSMw_yqkGiLiA0k13a-eHW_p_nqx0s5G-xjS6UJZelCfLbNBitRzsQ5VytejHPoCXuGnVFXSgRYxOKAQmiOUo2BFQ331_eZQQFusrO8ET05CXdsZoqBQvgk"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/50 to-transparent"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <p class="text-xs uppercase tracking-widest font-bold mb-2">Cam kết của chúng tôi</p>
                        <h4 class="text-2xl font-headline font-bold">Minh bạch trong từng sợi vải.</h4>
                    </div>
                </div>

                <!-- Section 3 -->
                <section class="scroll-mt-32" id="purchase">
                    <h2 class="text-3xl font-headline font-bold text-primary mb-8 flex items-center gap-4">
                        <span class="w-12 h-12 rounded-full bg-primary-container text-white flex items-center justify-center text-sm font-black">03</span>
                        Thanh toán &amp; Giao dịch
                    </h2>
                    <div class="bg-surface-container rounded-2xl p-10 space-y-6">
                        <p class="text-lg text-on-surface-variant">Mọi giao dịch mua hàng thông qua Zentro đều được xử lý bảo mật. Chúng tôi cam kết cung cấp thông tin giá cả chính xác, tuy nhiên, sai sót có thể xảy ra.</p>
                        <div class="grid md:grid-cols-2 gap-6 mt-4">
                            <div class="p-6 bg-surface rounded-xl border border-outline-variant/10">
                                <h4 class="font-bold text-primary mb-3">Xác nhận đơn hàng</h4>
                                <p class="text-sm text-on-surface-variant">Chúng tôi có quyền từ chối hoặc hủy đơn hàng của bạn vì bất kỳ lý do gì, bao gồm sự sẵn có của sản phẩm hoặc lỗi trong đơn hàng.</p>
                            </div>
                            <div class="p-6 bg-surface rounded-xl border border-outline-variant/10">
                                <h4 class="font-bold text-primary mb-3">Chính sách Hoàn trả</h4>
                                <p class="text-sm text-on-surface-variant">Việc hoàn trả được thực hiện dựa trên các tiêu chuẩn bền vững, ưu tiên tái chế thay vì tiêu hủy sản phẩm lỗi.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 4 -->
                <section class="scroll-mt-32" id="ip">
                    <h2 class="text-3xl font-headline font-bold text-primary mb-8 flex items-center gap-4">
                        <span class="w-12 h-12 rounded-full bg-primary-container text-white flex items-center justify-center text-sm font-black">04</span>
                        Sở hữu Trí tuệ
                    </h2>
                    <div class="space-y-6 text-lg text-on-surface-variant leading-relaxed border-l-2 border-primary-fixed pl-8 py-2">
                        <p>Tất cả nội dung trên Zentro, bao gồm nhưng không giới hạn ở văn bản, đồ họa, biểu trưng, hình ảnh, clip âm thanh và phần mềm, là tài sản của Zentro hoặc các nhà cung cấp nội dung của Zentro và được bảo vệ bởi luật pháp Việt Nam và quốc tế.</p>
                        <p class="font-bold italic">Việc sử dụng trái phép nhãn hiệu Zentro và các thiết kế đi kèm sẽ bị xử lý theo pháp luật.</p>
                    </div>
                </section>

                <!-- Eco chips -->
                <div class="flex flex-wrap gap-4 py-8 border-y border-outline-variant/20">
                    <div class="inline-flex items-center gap-2 bg-surface-container text-primary px-5 py-2.5 rounded-full">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">eco</span>
                        <span class="text-sm font-semibold font-label">100% Nguyên liệu bền vững</span>
                    </div>
                    <div class="inline-flex items-center gap-2 bg-surface-container text-primary px-5 py-2.5 rounded-full">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">security</span>
                        <span class="text-sm font-semibold font-label">Bảo mật dữ liệu 256-bit</span>
                    </div>
                </div>

            </div><!-- /space-y-24 -->

            <!-- Article footer -->
            <footer class="mt-20 pt-10 border-t border-outline-variant/20 text-on-surface-variant italic text-sm">
                <p>Mọi thắc mắc về Điều khoản Dịch vụ vui lòng liên hệ:
                    <a class="text-primary underline font-bold hover:text-primary-container transition-colors"
                       href="mailto:legal@zentro.vn">legal@zentro.vn</a>
                </p>
            </footer>

        </article>
    </div><!-- /grid -->

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script src="<?= BASE_URL ?>public/assets/js/footer-tems.js" defer></script>