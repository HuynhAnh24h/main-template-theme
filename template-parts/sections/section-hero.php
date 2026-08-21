<?php
/**
 * Section: Hero Section
 * Bố cục: Main Banner Slider (Trái 2/3) + Benefit Cards (Phải 1/3)
 * Custom Fields: home_slider (ACF Repeater)
 */

$slides = function_exists('get_field') ? get_field('home_slider') : null; // Cụm slide từ ACF nếu có cài plugin
?>
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Main Banner Slider (Trái 2/3) -->
    <div class="lg:col-span-2 rounded-3xl overflow-hidden shadow-md relative group h-80 md:h-96 bg-slate-900">
        
        <?php if ($slides && is_array($slides)) : ?>
            <!-- Container chính của Slider -->
            <div id="home-main-slider" class="relative w-full h-full overflow-hidden">
                <!-- Wrapper chứa toàn bộ slide đặt ngang -->
                <div class="slider-wrapper flex transition-transform duration-500 ease-out h-full w-full">
                    <?php foreach ($slides as $index => $slide) : 
                        $image = $slide['slide_image'];
                        $title = $slide['slide_title'];
                        $subtitle = $slide['slide_subtitle'];
                        $button_text = $slide['slide_button_text'];
                        $link = $slide['slide_link'];
                        
                        // Xử lý linh hoạt định dạng trả về của ảnh (Array / ID / URL)
                        $image_url = '';
                        if (is_array($image) && isset($image['url'])) {
                            $image_url = $image['url'];
                        } elseif (is_numeric($image)) {
                            $image_url = wp_get_attachment_url($image);
                        } else {
                            $image_url = $image;
                        }
                    ?>
                        <!-- Một slide đơn lẻ -->
                        <div class="slide shrink-0 w-full h-full relative flex items-center justify-start text-white p-8 md:p-12 bg-cover bg-center" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                            <!-- Lớp phủ tối (Overlay) làm rõ chữ -->
                            <div class="absolute inset-0 bg-slate-950/40 z-0"></div>
                            
                            <!-- Hiệu ứng radial nhẹ làm tăng chiều sâu -->
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.08),transparent_50%)] z-0"></div>
                            
                            <div class="relative z-10 max-w-lg">
                                <?php if (!empty($slide['slide_badge'])) : ?>
                                    <span class="inline-flex items-center gap-1.5 bg-lc-orange text-white text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm mb-4">
                                        <?php echo get_svg_icon('shield', 'w-3.5 h-3.5'); ?> <?php echo esc_html($slide['slide_badge']); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <h2 class="text-3xl md:text-5xl font-black mb-4 leading-tight drop-shadow-sm">
                                    <?php echo wp_kses_post($title); ?>
                                </h2>
                                
                                <p class="text-sm md:text-base text-slate-100 mb-6 leading-relaxed drop-shadow-sm">
                                    <?php echo esc_html($subtitle); ?>
                                </p>
                                
                                <?php if (!empty($button_text) && !empty($link)) : ?>
                                    <div class="flex">
                                        <a href="<?php echo esc_url($link); ?>" class="bg-lc-orange hover:bg-orange-600 text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-lg shadow-orange-500/20 transform hover:-translate-y-0.5">
                                            <?php echo esc_html($button_text); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Nút điều khiển Arrow (Chỉ hiện khi có từ 2 slide trở lên) -->
                <?php if (count($slides) > 1) : ?>
                    <!-- Arrow trái -->
                    <button id="slider-prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-slate-900/30 hover:bg-slate-900/55 border border-white/10 flex items-center justify-center text-white cursor-pointer z-20 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition duration-300">
                        <?php echo get_svg_icon('chevron-left', 'w-5 h-5'); ?>
                    </button>
                    <!-- Arrow phải -->
                    <button id="slider-next" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-slate-900/30 hover:bg-slate-900/55 border border-white/10 flex items-center justify-center text-white cursor-pointer z-20 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition duration-300">
                        <?php echo get_svg_icon('chevron-right', 'w-5 h-5'); ?>
                    </button>

                    <!-- Chỉ số chấm (Dots) -->
                    <div id="slider-dots" class="absolute bottom-5 left-0 right-0 flex justify-center gap-2.5 z-20">
                        <?php foreach ($slides as $index => $slide) : ?>
                            <button class="slider-dot w-2.5 h-2.5 rounded-full bg-white/35 hover:bg-white/60 transition-all duration-300 cursor-pointer" data-slide="<?php echo $index; ?>"></button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- Giao diện mặc định (Fallback) nếu chưa cấu hình slide nào trong WordPress Admin -->
            <div class="w-full h-full bg-gradient-to-r from-lc-blue via-blue-600 to-lc-darkblue flex items-center justify-start text-white p-8 md:p-12 relative">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.1),transparent_50%)]"></div>
                <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition duration-1000"></div>
                
                <div class="relative z-10 max-w-lg">
                    <span class="inline-flex items-center gap-1.5 bg-lc-orange text-white text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm mb-4">
                        <?php echo get_svg_icon('shield', 'w-3.5 h-3.5'); ?> Hệ Thống Đạt Chuẩn GPP
                    </span>
                    <h2 class="text-3xl md:text-5xl font-black mb-4 leading-tight">
                        Chăm Sóc Sức Khỏe<br><span class="text-lc-orange">Cho Cả Gia Đình</span>
                    </h2>
                    <p class="text-sm md:text-base text-blue-100 mb-6 leading-relaxed">
                        Hệ thống nhà thuốc đạt chuẩn GPP. Hỗ trợ giao hàng nhanh trong 1 giờ. Hãy kích hoạt plugin ACF và điền dữ liệu động để hiển thị các banner của riêng bạn!
                    </p>
                    <div class="flex">
                        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="bg-lc-orange hover:bg-orange-600 text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-lg shadow-orange-500/20 transform hover:-translate-y-0.5">
                            Mua hàng ngay
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Side Benefits (Phải 1/3) -->
    <div class="flex flex-col justify-between gap-4">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-50 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-lc-blue flex items-center justify-center shrink-0 group-hover:bg-lc-blue group-hover:text-white transition duration-300">
                <?php echo get_svg_icon('phone', 'w-6 h-6'); ?>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Thuốc Theo Đơn</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Chụp ảnh đơn thuốc gửi qua Zalo, nhận tư vấn và báo giá trong 5 phút.</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-50 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-lc-orange flex items-center justify-center shrink-0 group-hover:bg-lc-orange group-hover:text-white transition duration-300">
                <?php echo get_svg_icon('truck', 'w-6 h-6'); ?>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Freeship Siêu Tốc</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Miễn phí vận chuyển cho các đơn hàng từ 150k trong phạm vi 5km.</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-50 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shrink-0 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                <?php echo get_svg_icon('shield', 'w-6 h-6'); ?>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Đổi Trả Dễ Dàng</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Đổi trả thuốc trong vòng 30 ngày nếu còn nguyên bao bì nhãn mác.</p>
            </div>
        </div>
    </div>
    
</section>