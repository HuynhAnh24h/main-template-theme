<?php
/**
 * Template Part: Section Testimonials (Cảm nhận từ khách hàng)
 * Description: Khối đánh giá khách hàng dạng Slider với đường viền đứt nét ngăn cách sang trọng.
 * 
 * Arguments ($args):
 * - title (string)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = ! empty( $args['title'] ) ? $args['title'] : (function_exists('get_field') ? (get_field('testimonials_title', get_option('page_on_front')) ?: 'CẢM NHẬN TỪ KHÁCH HÀNG') : 'CẢM NHẬN TỪ KHÁCH HÀNG');

// 1. Lấy danh sách cảm nhận từ Custom Post Type "testimonial"
$testimonials = array();
$query = new WP_Query(array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC',
));

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        $stars = get_field('testimonial_stars', get_the_ID()) ?: 5;
        $testimonials[] = array(
            'author' => get_the_title(),
            'quote'  => get_the_content(),
            'stars'  => intval($stars),
        );
    }
    wp_reset_postdata();
}

// Fallback 5 đánh giá chuẩn từ ảnh thiết kế nếu chưa có bài viết nào trong CPT
if ( empty( $testimonials ) ) {
    $testimonials = array(
        array(
            'author' => 'Ognium',
            'quote'  => "Quán nằm ở ngay trung tâm và khá là dễ tìm. Đồ uống ngon, hợp gu mình Các bạn nhân viên siêu dễ thương 🍕",
            'stars'  => 5,
        ),
        array(
            'author' => 'Roger Ramjet',
            'quote'  => "Spectacular. Been to a cocktail bar or seven in my time and this place nails everything. My standard test case of dry martini passed with special honours and a commendation.",
            'stars'  => 5,
        ),
        array(
            'author' => 'Cường 0140 Nguyễn',
            'quote'  => "Quán decor quá là ok luôn, nhạc thi chắc k phải gu mình nhưng bạn bè thi lại thích ( chắc do gu mình lạ), giá đồ uống thì cũng rất hợp lý so với chất lượng và dịch vụ quá là cute của quán. Nhất định sẽ còn quay lại",
            'stars'  => 5,
        ),
        array(
            'author' => 'Anh Kim',
            'quote'  => "Đêm tối Đà Lạt trở lạnh, On The Rocks là một sự lựa chọn mang đến trải nghiệm khá chill với mình. Nước ngon, không gian ấm cúng, nhân viên ở đây chu đáo và cực vui, siu mê❤️✨",
            'stars'  => 5,
        ),
        array(
            'author' => 'Dang Khoa',
            'quote'  => "Quán cocktail xịn xò, không gian chill, đồ uống cân vị cực đã 🍸✨ Đã uống một tỷ lần rùi.",
            'stars'  => 5,
        ),
    );
}
?>

<section id="section-testimonials" class="relative w-full py-20 md:py-28 px-4 sm:px-8 md:px-14 bg-[#0d0905] overflow-hidden text-[#f4efe8]">
    
    <!-- Hiệu ứng ánh sáng tỏa ấm trung tâm -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_75%_55%_at_50%_0%,rgba(70,45,22,0.42)_0%,rgba(13,9,5,0.95)_75%,rgba(7,5,3,1)_100%)] pointer-events-none"></div>

    <div class="max-w-[1520px] mx-auto relative z-10">
        
        <!-- Tiêu đề Section & Nút điều hướng Slider -->
        <div class="flex items-center justify-between mb-12 md:mb-16">
            
            <!-- Khoảng đệm cân xứng bên trái -->
            <div class="w-16 hidden md:block"></div>

            <!-- Tiêu đề chính căn giữa -->
            <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl lg:text-[38px] font-normal tracking-[0.22em] text-[#caa875] uppercase text-center flex-1">
                <?php echo esc_html( $section_title ); ?>
            </h2>

            <!-- Nút Prev / Next Slider -->
            <div class="flex items-center gap-2.5 shrink-0">
                <button id="testi-prev-btn" class="btn-liquid-glass w-8 h-8 md:w-9 md:h-9 rounded-full border border-[#caa875]/40 text-[#caa875] flex items-center justify-center cursor-pointer shadow-md" aria-label="Trước">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button id="testi-next-btn" class="btn-liquid-glass w-8 h-8 md:w-9 md:h-9 rounded-full border border-[#caa875]/40 text-[#caa875] flex items-center justify-center cursor-pointer shadow-md" aria-label="Sau">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

        </div>

        <!-- Khung Slider Track với thanh cuộn mượt và viền đứt nét -->
        <div class="relative">
            
            <!-- Đường viền đứt nét ngoài cùng bên trái -->
            <div class="hidden xl:block absolute left-0 top-0 bottom-0 border-l border-dashed border-[#caa875]/25 pointer-events-none z-10"></div>

            <div id="testimonials-track" class="flex overflow-x-auto scroll-smooth scrollbar-none snap-x snap-mandatory cursor-grab active:cursor-grabbing select-none py-2">
                <?php foreach ( $testimonials as $index => $item ) : ?>
                    <div class="testi-slide shrink-0 w-[84%] sm:w-[48%] md:w-[33.333%] xl:w-[20%] snap-start border-r border-dashed border-[#caa875]/25 px-5 sm:px-6 md:px-7 flex flex-col justify-between min-h-[300px] md:min-h-[340px]">
                        
                        <!-- Lời nhận xét -->
                        <div class="text-xs sm:text-[13px] leading-[1.72] text-[#c7beb2] font-light tracking-wide pr-1 select-text">
                            <?php echo wp_kses_post( nl2br( $item['quote'] ) ); ?>
                        </div>

                        <!-- Tên khách hàng & Số sao -->
                        <div class="mt-8 pt-4">
                            <div class="font-medium text-sm text-[#f4efe8] tracking-wide select-text">
                                <?php echo esc_html( $item['author'] ); ?>
                            </div>
                            <div class="flex items-center gap-1 text-[#caa875] text-xs mt-1.5 select-none" title="<?php echo esc_attr( $item['stars'] ); ?> sao">
                                <?php for ( $s = 0; $s < 5; $s++ ) : ?>
                                    <span><?php echo $s < $item['stars'] ? '★' : '☆'; ?></span>
                                <?php endfor; ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</section>
