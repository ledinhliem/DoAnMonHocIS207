<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="pt-20">
    <!-- Banner tiêu đề -->
    <header class="relative w-full h-[921px] flex items-end overflow-hidden">
        <h1 style="display:none">
            <?= $blog['title'] ?? 'Blog detail' ?>
        </h1>
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover"
                data-alt="Modern sustainable architecture with floor-to-ceiling windows overlooking a misty forest, natural wood interior and soft morning light"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0vqyPMTsy0I7PGgFM7BZ9WICkOTJn4lrJU83JjKMtwtD9TST2PkeWQBw2JfGo9v15SxXSMkAYVr8SKk_17upQARw0usZYzlQs03avnezzPKV-42rcsmpxG8kU1vuC95A0wjSeRU1Xkk60hVv6LGcdBKEko9pGj0eVEmuS6ISp1y2XlQZHIZUVDi9cZI9tMWOgPdJnLpSbnIafZkY_jAokP2Gp-IL-JCz-ao8uo1LSYbfc5QpQvjWBvuJ9C94MYwBCCGzXFPgSUfU" />
            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 via-transparent to-transparent"></div>
        </div>
        <div class="relative z-10 w-full max-w-7xl mx-auto px-8 pb-16 md:pb-24">
            <div class="max-w-3xl">
                <span
                    class="inline-block px-4 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-sm font-bold uppercase tracking-widest mb-6">Sustainable
                    Architecture</span>
                <h1
                    class="text-5xl md:text-7xl lg:text-8xl font-black font-headline text-surface leading-[1.1] tracking-tight mb-8">
                    The Architecture of Conscious Living
                </h1>
                <p class="text-xl md:text-2xl text-surface-container-highest font-light leading-relaxed max-w-2xl">
                    Exploring how the spaces we inhabit shape our relationship with the planet and our well-being.
                </p>
            </div>
        </div>
    </header>
    <!-- Content -->
    <article class="editorial-grid gap-y-12 md:gap-y-20 py-16 md:py-32">
        <!-- Thông tin: tác giả, ngày đăng, thời gian đọc -->
        <div class="flex flex-col md:flex-row md:items-center gap-8 py-8 border-y border-outline-variant/20 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container-high">
                    <img class="w-full h-full object-cover"
                        data-alt="Portrait of a female architect in a minimalist white studio, soft professional lighting"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBcXeBmO4Ce7cKbqu2KDa-c3VQTc3r05bocbD9LUlkap_f7-1G0MKT-hE9RktEOltY6iEohZeWId-jUj4FHecZOLV3UjiJ7QwfmddHpTnk35eAORgySPge5_WoTAbYKNwlaYNh9oZ7OxPhkQxNYn5jErmodp-8NzedlmzCpahU-IRhLv2CRLEfXdYLEeEay8XIfUGI3G4jJORyYTHqfggSO8fHv-3xL-JYXTl18sKvmcufbhmBY3_q_7MVsL-dUt7qaxtU67OiOM6k" />
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant font-medium">Written by</p>
                    <p class="text-base font-bold text-primary font-headline">Elena Thorne</p>
                </div>
            </div>
            <div class="hidden md:block w-px h-10 bg-outline-variant/30"></div>
            <div>
                <p class="text-sm text-on-surface-variant font-medium">Published on</p>
                <p class="text-base font-bold text-on-surface">October 24, 2024</p>
            </div>
            <div class="hidden md:block w-px h-10 bg-outline-variant/30"></div>
            <div>
                <p class="text-sm text-on-surface-variant font-medium">Read time</p>
                <p class="text-base font-bold text-on-surface">12 min read</p>
            </div>
        </div>
        <!-- Nội dung bài viết -->
        <div class="space-y-8">
            <p
                class="text-xl md:text-2xl leading-relaxed text-on-surface-variant first-letter:text-7xl first-letter:font-black first-letter:font-headline first-letter:mr-4 first-letter:float-left first-letter:text-primary">
                In the quiet corners of the Pacific Northwest, a new philosophy of habitation is taking root. It's
                not just about building houses; it's about crafting ecosystems that breathe, adapt, and eventually
                return to the earth. This is the architecture of conscious living—a movement that prioritizes
                tactile sustainability over industrial efficiency.
            </p>
            <p class="text-lg leading-relaxed text-on-surface-variant">
                For decades, modern design has been synonymous with the conquest of nature. We built glass towers
                that fought the sun and concrete fortresses that ignored the soil. Today, architects like the ones
                behind Zentro's latest projects are flipping the script. They're asking: What if our homes could
                regenerate the land instead of depleting it?
            </p>
        </div>
        <!-- Quote -->
        <div
            class="wide py-12 px-8 bg-surface-container-low rounded-[2.5rem] my-8 flex flex-col items-center text-center">
            <span class="material-symbols-outlined text-6xl text-primary-container mb-6"
                data-icon="format_quote">format_quote</span>
            <blockquote class="text-3xl md:text-4xl font-headline font-bold text-primary leading-tight max-w-3xl">
                "Sustainability is no longer a feature we add to a building; it is the very soul of the space we
                occupy."
            </blockquote>
            <cite class="mt-8 not-italic text-on-surface-variant font-medium uppercase tracking-widest">— Julian
                Vane, Lead Designer</cite>
        </div>
        <!-- Embedded Image -->
        <div class="wide space-y-4">
            <div class="rounded-[2rem] overflow-hidden aspect-[16/9] bg-surface-container">
                <img class="w-full h-full object-cover"
                    data-alt="Interior of a home featuring reclaimed timber beams, lime-plastered walls, and a large window overlooking a meadow"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSuwwvvFnyqZ780JQPv5kWS5OujBJVvDMMj6OO5XH7HgoOTMT0sgk0qqnhRb066Nf2VHDvPjTXk4cT07c3W-sY-EfvObiBj0hWkYSlLaH0JiGSw0nCIX_QhYZs_p53a6GIaoUqEEIlIXAQFsAe3pjFi7af5Va6xZhcc2y5A7WlPanBFsKPomit4hKChMUI7jB858avedlLMZIkhvUFyN40Z1WbF20cJFzxFUHrV7NyxmCgYwN0cQZk-orfekt-80PX4GYXdOuQlYk" />
            </div>
            <p class="text-sm text-on-surface-variant italic text-center font-medium">Fig 1.1: The integration of
                reclaimed Douglas Fir beams provides structural integrity with a 70% lower carbon footprint than
                steel.</p>
        </div>
        <!-- Long body text continues -->
        <div class="space-y-8">
            <h2 class="text-3xl md:text-4xl font-black font-headline text-primary mt-12 mb-6">The Materiality of
                Tomorrow</h2>
            <p class="text-lg leading-relaxed text-on-surface-variant">
                The shift toward conscious living begins with tactile honesty. We are seeing a return to lime
                plasters, hempcrete, and cross-laminated timber. These materials don't just look natural; they
                behave naturally. They regulate humidity, filter toxins from the air, and provide a thermal mass
                that works with the seasons.
            </p>
            <p class="text-lg leading-relaxed text-on-surface-variant">
                In our Zentro projects, we've focused on "Low-Exergy" systems—designs that use high-quality energy
                for high-quality tasks and low-quality energy (like ambient ground heat) for heating our floors.
                It’s a sophisticated dance of thermodynamics and traditional craftsmanship.
            </p>
        </div>
        <!-- Eco-Stats Chip Section -->
        <div class="wide grid grid-cols-1 md:grid-cols-3 gap-6 my-12">
            <div class="p-8 rounded-[2rem] bg-surface-container-high flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl" data-icon="co2">co2</span>
                </div>
                <p class="text-4xl font-black font-headline text-primary mb-2">42%</p>
                <p class="text-sm font-bold uppercase tracking-widest text-on-surface-variant">CO2 Reduction</p>
                <p class="mt-4 text-sm text-on-surface-variant/80">Compared to traditional concrete and steel
                    residential builds.</p>
            </div>
            <div class="p-8 rounded-[2rem] bg-surface-container-high flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl"
                        data-icon="water_drop">water_drop</span>
                </div>
                <p class="text-4xl font-black font-headline text-primary mb-2">12k L</p>
                <p class="text-sm font-bold uppercase tracking-widest text-on-surface-variant">Water Saved</p>
                <p class="mt-4 text-sm text-on-surface-variant/80">Through greywater recycling systems integrated
                    into the foundation.</p>
            </div>
            <div class="p-8 rounded-[2rem] bg-surface-container-high flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary text-3xl"
                        data-icon="energy_savings_leaf">energy_savings_leaf</span>
                </div>
                <p class="text-4xl font-black font-headline text-primary mb-2">0.0</p>
                <p class="text-sm font-bold uppercase tracking-widest text-on-surface-variant">Net Energy</p>
                <p class="mt-4 text-sm text-on-surface-variant/80">Achieved through passive solar design and
                    integrated roof tiles.</p>
            </div>
        </div>
        <!-- Giới thiệu sản phẩm -->
        <div class="wide mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-primary font-bold uppercase tracking-widest text-sm">Curated Living</span>
                    <h3 class="text-4xl md:text-5xl font-black font-headline mt-2">Shop the Look</h3>
                </div>
                <a class="inline-flex items-center gap-2 text-primary font-bold hover:gap-4 transition-all"
                    href="<?= BASE_URL ?>?url=product">
                    View Collection <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- 1 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container relative mb-4">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            data-alt="Minimalist solid oak chair with organic curved backrest on a concrete floor"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXE1Twi1EaF8qvzq4QRG2GB2gGcPRCKyEpfmGLj50QKpnlSaPOV20U-0xqlsn9R4IA5XIPw4Tw0xJR2JFAC0ey9RPU_MvYA_Vay9OAXrJ9YqIyGmSNYN-B3Mvo6n6fK8ResM4a2Tl8wIoS48TwY5FUjkyZhrJeMB_6wEhYRClnTto0Zc7zRMNgQfHr2gBjVt1f6FOl8sFPPMNablSm5Ss5qKN_t6Tfk-8pzPTTVLDXM9aQ12RSZSOoUAgdzX574r8pebGb7KStJ84" />
                        <button
                            class="absolute bottom-4 right-4 w-12 h-12 rounded-full bg-surface/90 backdrop-blur shadow-xl flex items-center justify-center text-primary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>
                    <h4 class="text-lg font-bold font-headline group-hover:text-primary transition-colors">Honed Oak
                        Lounge Chair</h4>
                    <p class="text-on-surface-variant">$1,240</p>
                </div>
                <!-- 2 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container relative mb-4">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            data-alt="Modern pendant lamp made from recycled ocean plastic with a warm ambient glow"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-Qa2OrwtAXy8qZnVTeGD9ySgdVo7EAuBF-vMSm-kHbPLW2APnFu0wqxnA0JatfkeKMeGXlokGDoHTDonh_TaYla1KHFEvVlQvGLc7vAMzSi8hlUQVl1te2k-PDBbzefUoNOPnq-U6T4zmc86XMUPYIv5mHqLG67t4RXWtTU3ctj1qCEL3lxuHFTLoq_P-AutR4PDl-aGfTJkB-qGPCKWnH9uRD3Zo4gWsGWQHoyxGsHBgPdY_SzpIlMhJ16c9v1kayOY8FOLMrEE" />
                        <button
                            class="absolute bottom-4 right-4 w-12 h-12 rounded-full bg-surface/90 backdrop-blur shadow-xl flex items-center justify-center text-primary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>
                    <h4 class="text-lg font-bold font-headline group-hover:text-primary transition-colors">Aegean
                        Pendant Light</h4>
                    <p class="text-on-surface-variant">$480</p>
                </div>
                <!-- 3 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container relative mb-4">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            data-alt="Handcrafted ceramic vase with a textured stone-like finish and a single dried branch"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuATFwe4_GcA8D9HK9AjVUdlc7R6-1HWwTiPCYLHcOTLL_gwl5mTfK-741ACcDb-fm182oVCfoEmIMb43aJhdkTlTOAaytYFPD2zk-DiubVLbDuOtiq5FI-jsjjIvtUwP4GW8NKJe7vEaZ_i2noLz3TOjM_FaxBL4eFi4UzBJnV_r1TKJ5CtOw5xVJdQu_-zluEueD-_VBgowQBclLAfFGLzae3DSu3A9nMpg-sKAjjiKHRJzB2HekUFBpFeOCeGa_BJ3r1gULTwIUw" />
                        <button
                            class="absolute bottom-4 right-4 w-12 h-12 rounded-full bg-surface/90 backdrop-blur shadow-xl flex items-center justify-center text-primary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>
                    <h4 class="text-lg font-bold font-headline group-hover:text-primary transition-colors">Terra
                        Ceramic Vessel</h4>
                    <p class="text-on-surface-variant">$185</p>
                </div>
                <!-- 4 -->
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container relative mb-4">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            data-alt="Sustainable cork flooring sample with a warm natural grain and rich texture"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDG6Cp4izujZlix9Pl3DYYVWci0d1dcX_g0lJmZj2GiwwynkuXPQLQ3KYf7ZiwdOeQGjN6iHH9XFN_23BKduK2Q7uy2J4Zj46NC05fNWijE29sdyataKMmwXTGoVzbdtMBLJIETf17tm5YFycuhjtg6nfjFNUqJDPp7mCi8qKDe0qMgyLMxXc5rp7O08Cdt-BWnodqhF-C9ZX2fWemjTHAV4dpQHtGuG-NfkrQyaOFyrLnT5N7SX0CGM3-OuAwiLL3GDvcXvvhvxA" />
                        <button
                            class="absolute bottom-4 right-4 w-12 h-12 rounded-full bg-surface/90 backdrop-blur shadow-xl flex items-center justify-center text-primary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>
                    <h4 class="text-lg font-bold font-headline group-hover:text-primary transition-colors">Floating
                        Cork Plank</h4>
                    <p class="text-on-surface-variant">$12/sqft</p>
                </div>
            </div>
        </div>
        <!-- Xem thêm -->
        <div class="wide mt-32 pt-24 border-t border-outline-variant/30">
            <h3 class="text-4xl font-black font-headline mb-16">More from our Journal</h3>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                <div class="md:col-span-7 group cursor-pointer">
                    <div class="aspect-[16/9] rounded-3xl overflow-hidden mb-6">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            data-alt="Close-up of human hands planting a small green seedling into rich dark earth"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBp27mVnrZtkcWaIKcDjW6FtH0jP27xaAfHgGB0go7mvzswEoabcbTcKD9Xwb0PWFn1yjYAz8vFD8OmLI6dgX5ePXZkxvskXyDWwbgvZBik-o0ZHpUnMfPXk9Li3PH1c2tvSjSjbhZDpy8d3m6ovWpHxujGDS0yhuKYa-RtgrU3tnKSyc8oT6yZihg3p1lK9YR6YLMPYbKDl7WaIa2PqOZFOZfpd04MaF2_X0msDR72eYmWYbooROLBQHAj74OYN7mik3FjrSl6Kbc" />
                    </div>
                    <span class="text-secondary font-bold text-sm uppercase tracking-widest">Reforestation</span>
                    <h4 class="text-3xl font-black font-headline mt-3 group-hover:text-primary transition-colors">
                        How We Planted 100,000 Trees in 2024</h4>
                    <p class="mt-4 text-on-surface-variant leading-relaxed line-clamp-2">A look back at our
                        partnership with Eden Reforestation Projects and the communities we've touched.</p>
                </div>
                <div class="md:col-span-5 flex flex-col gap-12">
                    <div class="flex gap-6 group cursor-pointer">
                        <div class="w-32 h-32 flex-shrink-0 rounded-2xl overflow-hidden">
                            <img class="w-full h-full object-cover"
                                data-alt="Collection of sustainable textile samples in earth tones like olive, sand, and clay"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUBHlTKYX7lyZOl4sKGfJsLLGduQLXQkaYF2iV_T83xufHPAAjfMkVeufBKlDqPG85cCZ7iyEn3vX1NY8cFsmZZ5K1UjWLevbhZFOfQGVJ4TM6OKqpjKhe5XoK6Ty9HfNKWQBkDLCnKbR1aYfz8YQQtzJdkVT_VsQrtyhNEeduf57n8_KybfktzyA45_2vd6hI2ujIbDBgRgTrK_iddTu4gFuPW34hO5NiW5rjqk-kh5glrUAAgg8F-GJIMj4llmMNzgOoCejOiao" />
                        </div>
                        <div>
                            <span class="text-secondary font-bold text-xs uppercase tracking-widest">Materials</span>
                            <h5
                                class="text-xl font-bold font-headline mt-1 leading-tight group-hover:text-primary transition-colors">
                                The Future of Textiles: Mycelium Leather</h5>
                        </div>
                    </div>
                    <div class="flex gap-6 group cursor-pointer">
                        <div class="w-32 h-32 flex-shrink-0 rounded-2xl overflow-hidden">
                            <img class="w-full h-full object-cover"
                                data-alt="Aerial view of a circular community garden with paths radiating from a central point"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5WkP0S3fW4BlpB-aiZv3tQqWNfjU7esMj8KQskqsZZiiDpihh5SvrXScSVBNpX8p3T_4oFNJiuiT2uiC6udQLKdwpRBNuL-p_2wU3csX3I4vnbJEDNlITPgUjVNQTMG0IPifw3DWd_UIK0whBTTmMh5Ee-hvJNCa7KB3ovBQHtVyGYCx51jXcjL84PIVUptn-qlaxkT-yJwuMTk-4PECa2zh9fhUFD0XAXpYjOowPC0Icvfqbj56S4wDYq8UALtcO0S_-sLHrwEA" />
                        </div>
                        <div>
                            <span class="text-secondary font-bold text-xs uppercase tracking-widest">Community</span>
                            <h5
                                class="text-xl font-bold font-headline mt-1 leading-tight group-hover:text-primary transition-colors">
                                Circular Design in Urban Planning</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CTA đăng ký -->
        <div class="wide mt-32">
            <div
                class="bg-primary-container rounded-[3rem] p-8 md:p-20 relative overflow-hidden flex flex-col md:flex-row items-center gap-12">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-primary rounded-full blur-[100px] -mr-32 -mt-32 opacity-50">
                </div>
                <div class="relative z-10 md:w-1/2">
                    <h3 class="text-4xl md:text-5xl font-black font-headline text-surface leading-tight mb-6">Join
                        the Movement.</h3>
                    <p class="text-primary-fixed-dim text-lg leading-relaxed">
                        Receive our monthly journal on sustainable design, architectural innovations, and conscious
                        living delivered to your inbox.
                    </p>
                </div>
                <div class="relative z-10 md:w-1/2 w-full">
                    <form class="flex flex-col sm:flex-row gap-4">
                        <input
                            class="flex-1 px-8 py-5 rounded-2xl bg-surface/10 border-none text-surface placeholder:text-surface/50 focus:ring-2 focus:ring-surface/30 transition-all text-lg"
                            placeholder="Enter your email" type="email" />
                        <button
                            class="px-10 py-5 rounded-2xl bg-surface text-primary font-black font-headline hover:bg-primary-fixed transition-colors text-lg whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                    <p class="text-xs text-primary-fixed-dim/60 mt-4 px-2">No spam. Only inspiration. Unsubscribe
                        anytime.</p>
                </div>
            </div>
        </div>
    </article>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>