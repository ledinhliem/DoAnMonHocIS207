<?php include __DIR__ . '/../layouts/header.php';?>

<main class="max-w-7xl mx-auto px-6 lg:px-12 py-12 md:py-20">

    <!-- BREADCRUMB -->
    <nav class="flex flex-wrap gap-2 text-xs font-label uppercase tracking-widest text-outline mb-10 items-center">
        <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>">Trang chủ</a>
        <span>/</span>
        <span class="text-on-surface font-semibold"><?= htmlspecialchars($meta['breadcrumb']) ?></span>
    </nav>

    <!-- ── PAGE HERO ─────────────────────────────────────────────────────── -->
    <header class="mb-20 flex flex-col md:flex-row items-end justify-between gap-12">
        <div class="max-w-2xl">
            <div class="mb-6">
                <span class="bg-primary-fixed text-primary px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase">Transparency</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-headline font-extrabold text-primary tracking-tight leading-none mb-8">
                Chính sách Cookie.
            </h1>
            <p class="text-xl text-on-surface-variant leading-relaxed max-w-lg">
                Tại Zentro, chúng tôi tin rằng sự minh bạch là nền tảng của sự bền vững. Tìm hiểu cách chúng tôi sử dụng công nghệ để cải thiện trải nghiệm của bạn mà không làm ảnh hưởng đến quyền riêng tư.
            </p>
        </div>
        <div class="w-full md:w-64 lg:w-72 aspect-[4/5] rounded-2xl overflow-hidden bg-surface-container shrink-0">
            <img class="w-full h-full object-cover"
                 alt="Cookie Policy Hero"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuCShXy0S5OYol9P7GAqAC0Kkb5RzpKFjPpD-jZ4W0NqxDg27UcAHqLqjo2WWlTQ4XmDZhksgfoHCBp-clqVtsrKHfIXapDBy6uuWVMjey5ZhRcQEvtFxAdZdG6rXkNEvnPGUKgHgNnuxLL3eodmPADklGMoiVWXsvdrxtAaR7WvkOYl_PV79gs7wHw7FnWSYL0obE5ZryNTLn1JmCueIimQP4pEcTG7WxLMYjfQPCtbdw0BuRrnT-j1KDdnAXwvLqYwpNhJKB1kyAw"/>
        </div>
    </header>

    <!-- ── BENTO: COOKIE TYPES ────────────────────────────────────────────── -->
    <section class="mb-24">
        <div class="mb-10">
            <h2 class="text-3xl font-headline font-bold text-primary mb-4">Các loại Cookie chúng tôi sử dụng</h2>
            <div class="h-1 w-16 bg-primary rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            <!-- Necessary (tall card) -->
            <div data-cookie-card class="md:col-span-5 bg-surface-container rounded-2xl p-10 flex flex-col justify-between border border-outline-variant/10">
                <div>
                    <span class="material-symbols-outlined text-4xl text-primary mb-6 block"
                          style="font-variation-settings:'FILL' 1">verified_user</span>
                    <h3 class="text-2xl font-headline font-bold mb-4">Cookie Thiết yếu</h3>
                    <p class="text-on-surface-variant leading-relaxed">
                        Đây là những cookie bắt buộc để trang web hoạt động bình thường. Chúng bao gồm các chức năng cơ bản như điều hướng trang và truy cập vào các khu vực an toàn của website. Trang web không thể hoạt động ổn định nếu thiếu các cookie này.
                    </p>
                </div>
                <div class="mt-8 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    <span class="text-xs font-bold text-primary uppercase tracking-tighter">Luôn kích hoạt</span>
                </div>
            </div>

            <!-- Performance -->
            <div data-cookie-card class="md:col-span-7 bg-surface-container-high rounded-2xl p-10 relative overflow-hidden group border border-outline-variant/10">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl text-primary mb-6 block">insights</span>
                    <h3 class="text-2xl font-headline font-bold mb-4">Phân tích &amp; Hiệu suất</h3>
                    <p class="text-on-surface-variant leading-relaxed max-w-md">
                        Chúng tôi sử dụng những cookie này để hiểu cách khách truy cập tương tác với trang web. Thông tin này giúp chúng tôi đo lường và cải thiện hiệu suất của nền tảng, đảm bảo trải nghiệm người dùng luôn mượt mà nhất.
                    </p>
                </div>
                <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-500"></div>
            </div>

            <!-- Preference -->
            <div data-cookie-card class="md:col-span-7 bg-surface-container rounded-2xl p-10 border border-outline-variant/10">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="flex-1">
                        <span class="material-symbols-outlined text-4xl text-primary mb-6 block">tune</span>
                        <h3 class="text-2xl font-headline font-bold mb-4">Tùy chọn Cá nhân</h3>
                        <p class="text-on-surface-variant leading-relaxed">
                            Cho phép trang web ghi nhớ thông tin thay đổi cách trang web hành xử hoặc hiển thị, như ngôn ngữ ưa thích của bạn hoặc khu vực bạn đang sinh sống.
                        </p>
                    </div>
                    <div class="w-full md:w-40 aspect-square rounded-xl overflow-hidden shrink-0">
                        <img class="w-full h-full object-cover"
                             alt="Preference cookie visual"
                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuDV8vLg-jqrRuheRAo3Bz99ixq1pEySbs0crvuGFp13nhhrxAbLlU4ZDovzqKMmxQZy8g-p9TAXy-GP7t1TnsGfX6uwG_rr4J6v529DvKx3nIkpR90S09qt5VCUJvTIFYFnZJIZhuHRETef588r-Od_zg11OFfUK5tuYi8vAo3iQvEMbZLVkijCGSWNmLyGxwqJxEa-D-e6shh3vs5DV03bkH2MUVkApsNuda8jPI306l0msyvq13AhkysZtFoTPEuK1IHQqU4rLbU"/>
                    </div>
                </div>
            </div>

            <!-- Marketing -->
            <div data-cookie-card class="md:col-span-5 bg-secondary-container rounded-2xl p-10 text-on-secondary-container border border-outline-variant/10">
                <span class="material-symbols-outlined text-4xl mb-6 block">campaign</span>
                <h3 class="text-2xl font-headline font-bold mb-4">Marketing &amp; Quảng cáo</h3>
                <p class="leading-relaxed opacity-90">
                    Được sử dụng để theo dõi khách truy cập qua các trang web. Mục đích là hiển thị quảng cáo có liên quan và hấp dẫn đối với người dùng cá nhân, có giá trị hơn cho các nhà xuất bản và bên thứ ba.
                </p>
            </div>

        </div>
    </section>

    <!-- ── DETAILED Q&A SECTION ───────────────────────────────────────────── -->
    <section class="max-w-4xl mx-auto space-y-20">

        <!-- What are cookies? -->
        <div class="flex flex-col md:flex-row gap-12">
            <div class="md:w-1/3">
                <h2 class="text-2xl font-headline font-bold text-primary md:sticky md:top-32">Cookie là gì?</h2>
            </div>
            <div class="md:w-2/3 space-y-4">
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    Cookie là các tệp văn bản nhỏ được trang web bạn truy cập lưu trên máy tính của bạn. Chúng được sử dụng rộng rãi để làm cho trang web hoạt động hoặc hoạt động hiệu quả hơn, cũng như cung cấp thông tin cho chủ sở hữu trang web.
                </p>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    Tại Zentro, chúng tôi coi cookie như những "hạt mầm" dữ liệu giúp nuôi dưỡng trải nghiệm của bạn, đảm bảo rằng mỗi lần bạn quay lại, môi trường số của chúng tôi sẽ thích ứng hoàn hảo với nhu cầu của bạn.
                </p>
            </div>
        </div>

        <!-- Manage cookies -->
        <div class="flex flex-col md:flex-row gap-12">
            <div class="md:w-1/3">
                <h2 class="text-2xl font-headline font-bold text-primary md:sticky md:top-32">Quản lý Cookie</h2>
            </div>
            <div class="md:w-2/3">
                <p class="text-lg text-on-surface-variant leading-relaxed mb-8">
                    Bạn có quyền kiểm soát hoàn toàn các cookie không thiết yếu. Hầu hết các trình duyệt web cho phép kiểm soát hầu hết các cookie thông qua cài đặt trình duyệt. Để tìm hiểu thêm về cookie, bao gồm cách xem cookie nào đã được thiết lập, hãy truy cập
                    <a class="text-primary font-bold underline hover:text-primary-container transition-colors" href="https://www.aboutcookies.org" target="_blank" rel="noopener">www.aboutcookies.org</a>.
                </p>
                <div class="p-8 bg-surface-container rounded-xl border border-outline-variant/10">
                    <h4 class="font-bold text-primary mb-6">Cách thay đổi cài đặt trình duyệt:</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">check_circle</span>
                            <span class="text-on-surface-variant text-sm">
                                <strong>Google Chrome:</strong> Cài đặt › Quyền riêng tư và bảo mật › Cookie và các dữ liệu khác của trang web.
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">check_circle</span>
                            <span class="text-on-surface-variant text-sm">
                                <strong>Safari:</strong> Tùy chọn › Quyền riêng tư › Chặn tất cả cookie.
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">check_circle</span>
                            <span class="text-on-surface-variant text-sm">
                                <strong>Firefox:</strong> Tùy chọn › Quyền riêng tư &amp; Bảo mật › Cookie và Dữ liệu trang web.
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Trust chips -->
        <div class="flex flex-wrap gap-4 pt-12 border-t border-outline-variant/20">
            <div data-trust-chip class="inline-flex items-center gap-2 bg-surface-container text-primary px-5 py-3 rounded-full">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">eco</span>
                <span class="text-sm font-semibold font-label">Dữ liệu được lưu trữ sạch</span>
            </div>
            <div data-trust-chip class="inline-flex items-center gap-2 bg-surface-container text-primary px-5 py-3 rounded-full">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">security</span>
                <span class="text-sm font-semibold font-label">Mã hóa 256-bit chuẩn quân đội</span>
            </div>
            <div data-trust-chip class="inline-flex items-center gap-2 bg-surface-container text-primary px-5 py-3 rounded-full">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">visibility_off</span>
                <span class="text-sm font-semibold font-label">Không bán dữ liệu cho bên thứ 3</span>
            </div>
        </div>

    </section>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script src="<?= BASE_URL ?>public/assets/js/footer-cookies.js" defer></script>