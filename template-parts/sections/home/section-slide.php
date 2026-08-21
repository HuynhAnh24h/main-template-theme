<?php

/**
 * Section: Slide
 * Bố cục: Hiển thị Slide toàn màn hình về sản phẩm nổi bật cho website
 */
?>
<section class="home w-full min-h-screen flex flex-col justify-between">
    <div class="home__backdrop"></div>
    <svg class="home__grain w-full h-full">
        <filter id="home-noise">
            <feTurbulence type="fractalNoise" baseFrequency="0.9" numOctaves="2" stitchTiles="stitch"></feTurbulence>
            <feColorMatrix type="saturate" values="0"></feColorMatrix>
        </filter>
        <rect width="100%" height="100%" filter="url(#home-noise)" opacity="0.06"></rect>
    </svg>
    <div class="home__watermark">AERO</div>
    <!-- hero -->
    <div class="home__hero relative z-20 flex-1 grid grid-cols-1 lg:grid-cols-[1.05fr_0.95fr] items-center gap-10 px-6 md:px-14 py-10">

        <div class="home__copy max-w-xl">
            <div class="home__eyebrow home__reveal flex items-center gap-3 mb-6" style="animation-delay:.15s">
                <span class="home__eyebrow-line w-8 h-px bg-white"></span>
                <span class="home__eyebrow-text home__font-mono text-[11px] uppercase tracking-[0.25em] text-gray-300">Bộ sưu tập Xuân · Hè</span>
            </div>

            <h1 class="home__title home__font-display uppercase leading-[0.88] text-[15vw] sm:text-[9vw] md:text-[6.4vw] lg:text-[5.2vw]">
                <div class="home__title-row"><span style="animation-delay:.25s">BƯỚC ĐI</span></div>
                <div class="home__title-row"><span style="animation-delay:.38s">RIÊNG,</span></div>
                <div class="home__title-row home__title-row--outline"><span style="animation-delay:.51s">SẢI CHÂN</span></div>
                <div class="home__title-row"><span style="animation-delay:.64s">CHẤT.</span></div>
            </h1>

            <p class="home__subtitle home__reveal mt-7 text-[15px] md:text-base text-gray-400 leading-relaxed max-w-md" style="animation-delay:.8s">
                Đế êm, form dáng gọn, chất liệu tái chế cao cấp. AERO Runner được thiết kế cho những người
                không thích đi theo lối mòn — chỉ 300 đôi cho mỗi phối màu.
            </p>

            <div class="home__actions home__reveal mt-9 flex flex-wrap items-center gap-6" style="animation-delay:.95s">
                <button onclick="document.getElementById('home-product').scrollIntoView({behavior:'smooth'})"
                    class="home__btn font-bold text-sm md:text-base px-7 py-4 rounded-full inline-flex items-center gap-2">
                    Mua ngay
                    <span class="home__btn-arrow">→</span>
                </button>
                <div class="home__price home__font-mono flex items-baseline gap-2">
                    <span class="home__price-current text-xl text-white">2.190.000₫</span>
                    <span class="home__price-old text-sm text-gray-500 line-through">2.890.000₫</span>
                </div>
            </div>

            <div class="home__stats home__reveal home__font-mono mt-11 flex" style="animation-delay:1.05s">
                <div class="home__stat pl-0 pr-7">
                    <div class="home__stat-value text-xl text-white">4.9<span class="text-white">★</span></div>
                    <div class="home__stat-label text-[10px] uppercase tracking-[0.18em] text-gray-500 mt-1">2.4k đánh giá</div>
                </div>
                <div class="home__stat border-l border-white/15 px-7">
                    <div class="home__stat-value text-xl text-white">180g</div>
                    <div class="home__stat-label text-[10px] uppercase tracking-[0.18em] text-gray-500 mt-1">Siêu nhẹ</div>
                </div>
                <div class="home__stat border-l border-white/15 px-7">
                    <div class="home__stat-value text-xl text-white">Freeship</div>
                    <div class="home__stat-label text-[10px] uppercase tracking-[0.18em] text-gray-500 mt-1">Toàn quốc</div>
                </div>
            </div>
        </div>

        <div id="home-product" class="home__visual home__reveal relative flex items-center justify-center h-[380px] sm:h-[440px] lg:h-[560px]" style="animation-delay:.5s">
            <div class="home__visual-glow absolute w-[340px] h-[340px] sm:w-[440px] sm:h-[440px] rounded-full"></div>
            <div class="home__visual-ring absolute w-[420px] h-[420px] sm:w-[520px] sm:h-[520px] rounded-full"></div>

            <div class="home__product relative w-full h-full flex items-center justify-center" id="home-product-stage">
                <svg class="home__product-image w-[86%] max-w-[440px]" viewBox="0 0 400 220" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="home-body-grad" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#3a3a3a" />
                            <stop offset="55%" stop-color="#1c1c1c" />
                            <stop offset="100%" stop-color="#050505" />
                        </linearGradient>
                        <linearGradient id="home-sole-grad" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#ffffff" />
                            <stop offset="100%" stop-color="#c9c9c9" />
                        </linearGradient>
                        <linearGradient id="home-swoosh-grad" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#ffffff" />
                            <stop offset="100%" stop-color="#8f8f8f" />
                        </linearGradient>
                    </defs>

                    <path d="M15 165 Q10 195 55 200 L330 208 Q378 206 386 178 Q392 158 360 152 L60 148 Q28 148 15 165 Z" fill="url(#home-sole-grad)" />
                    <g stroke="#000000" stroke-opacity="0.2" stroke-width="3">
                        <line x1="70" y1="178" x2="70" y2="196" />
                        <line x1="110" y1="182" x2="110" y2="200" />
                        <line x1="150" y1="184" x2="150" y2="202" />
                        <line x1="190" y1="185" x2="190" y2="203" />
                        <line x1="230" y1="184" x2="230" y2="202" />
                        <line x1="270" y1="182" x2="270" y2="200" />
                        <line x1="310" y1="178" x2="310" y2="195" />
                    </g>

                    <path d="M30 150 C20 110 45 70 95 55 C140 41 175 40 210 48 C255 58 300 66 345 92 C372 108 380 128 365 150 C330 158 60 158 30 150 Z" fill="url(#home-body-grad)" />
                    <path d="M30 150 C24 122 38 92 68 74 C58 100 58 128 66 150 Z" fill="#000000" opacity="0.55" />
                    <path d="M75 128 C130 96 210 84 320 108 C260 108 165 118 105 146 Z" fill="url(#home-swoosh-grad)" />

                    <g stroke="#ffffff" stroke-width="4" stroke-linecap="round" opacity="0.9">
                        <line x1="150" y1="62" x2="185" y2="86" />
                        <line x1="175" y1="56" x2="210" y2="82" />
                        <line x1="200" y1="54" x2="235" y2="80" />
                        <line x1="225" y1="56" x2="258" y2="84" />
                    </g>

                    <path d="M300 62 C325 72 348 88 360 106" stroke="#ffffff" stroke-width="3" fill="none" opacity="0.5" />
                </svg>
            </div>

            <div class="home__badge home__badge--limited absolute top-4 right-2 sm:right-8 bg-neutral-900 border border-white/20 rounded-2xl px-4 py-3 shadow-xl">
                <div class="home__badge-label home__font-mono text-[10px] uppercase tracking-[0.15em] text-gray-500">Giới hạn</div>
                <div class="home__badge-value text-sm font-bold text-white mt-0.5">300 đôi / màu</div>
            </div>

            <div class="home__badge home__badge--sale absolute bottom-6 left-0 sm:left-4 bg-neutral-900 border border-white/20 rounded-2xl px-4 py-3 shadow-xl">
                <div class="home__badge-label home__font-mono text-[10px] uppercase tracking-[0.15em] text-gray-500">Đang giảm</div>
                <div class="home__badge-value text-sm font-bold text-white mt-0.5">-24% hôm nay</div>
            </div>
        </div>
    </div>

    <!-- ticker -->
    <div class="home__ticker relative z-20 border-t border-white/10 py-3 overflow-hidden">
        <div class="home__ticker-track home__font-mono text-[11px] uppercase tracking-[0.3em] text-gray-500">
            <span class="home__ticker-item px-6">Miễn phí vận chuyển</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Hàng mới về mỗi tuần</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Đổi trả trong 30 ngày</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Số lượng giới hạn</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Miễn phí vận chuyển</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Hàng mới về mỗi tuần</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Đổi trả trong 30 ngày</span><span class="home__ticker-dot px-6 text-white">•</span>
            <span class="home__ticker-item px-6">Số lượng giới hạn</span><span class="home__ticker-dot px-6 text-white">•</span>
        </div>
    </div>
</section>