<?php
/**
 * Template Part: Section Blog Detail (Chi Tiết Bài Viết Chuẩn On The Rock)
 * Description: Khớp 100% bản thiết kế trang chi tiết bài viết với Hero Image, Header Meta Bar,
 * Typography cao cấp, Hộp Voucher Event, Mục bài viết liên quan và dải Marquee Ticker.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Lấy thông tin bài viết hiện tại
$post_id    = get_the_ID();
$categories = get_the_category( $post_id );
$main_cat   = ! empty( $categories ) ? $categories[0] : null;
$cat_name   = $main_cat ? $main_cat->name : 'Event';
$cat_slug   = $main_cat ? $main_cat->slug : 'event';
$cat_link   = $main_cat ? get_category_link( $main_cat->term_id ) : '#';

// Lấy ảnh bài viết (Ưu tiên: Ảnh đại diện WP -> ACF/Meta _otr_custom_image -> Fallback Bar photo)
$post_image = '';
if ( has_post_thumbnail( $post_id ) ) {
    $post_image = get_the_post_thumbnail_url( $post_id, 'full' );
}
if ( empty( $post_image ) ) {
    $custom_img = get_post_meta( $post_id, '_otr_custom_image', true );
    if ( ! empty( $custom_img ) ) {
        $post_image = $custom_img;
    }
}
if ( empty( $post_image ) ) {
    $post_image = 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=1400&auto=format&fit=crop';
}

$author_name = get_the_author();
if ( empty( $author_name ) || $author_name === 'admin' ) {
    $author_name = 'Admin Supper';
}
$post_date_formatted = get_the_date( 'F j, Y' );
?>

<!-- 1. Thanh Tiến Trình Đọc Bài Viết (Reading Progress Bar) -->
<div class="fixed top-0 left-0 w-full h-[3px] z-[100] bg-transparent pointer-events-none">
    <div id="reading-progress" class="h-full bg-[#caa875] w-0 transition-all duration-75 shadow-[0_0_10px_#caa875]"></div>
</div>

<!-- 2. Khu Vực Bài Viết Chính (Single Article) -->
<article class="w-full bg-[#080604] text-[#f4efe8] pt-28 md:pt-36 pb-16 relative overflow-hidden">
    
    <!-- Hiệu ứng quầng sáng nền huyền ảo -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-[#caa875]/5 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl relative z-10">

        <!-- 2.1 Ảnh Bìa Lớn (Hero Featured Image) Bo Góc Chuẩn Thiết Kế -->
        <div class="w-full rounded-2xl md:rounded-[28px] overflow-hidden shadow-2xl border border-white/5 relative bg-[#120d09] aspect-[16/10] sm:aspect-[16/9] md:aspect-[21/10] max-h-[540px] group">
            <img src="<?php echo esc_url( $post_image ); ?>" 
                 alt="<?php echo esc_attr( get_the_title() ); ?>" 
                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/10 pointer-events-none"></div>
        </div>

        <!-- 2.2 Tiêu Đề Bài Viết (Article Title) -->
        <h1 class="font-mrch text-3xl sm:text-4xl md:text-5xl lg:text-[52px] text-[#d8c19d] font-normal leading-[1.22] tracking-wide mt-8 md:mt-12 mb-6">
            <?php the_title(); ?>
        </h1>

        <!-- 2.3 Thanh Thông Tin Meta & Cụm Nút Chia Sẻ Mạng Xã Hội -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4 border-b border-[#caa875]/20 mb-10 text-stone-400">
            
            <!-- Bên trái: Huy hiệu chuyên mục (Category Pill Badge) -->
            <div class="flex items-center">
                <a href="<?php echo esc_url( $cat_link ); ?>" 
                   class="inline-flex items-center px-4 py-1.5 rounded-full text-xs uppercase tracking-widest font-medium border border-[#caa875]/40 text-[#caa875] bg-[#caa875]/5 hover:bg-[#caa875]/15 hover:border-[#caa875]/70 transition-all duration-300">
                    <?php echo esc_html( $cat_name ); ?>
                </a>
            </div>

            <!-- Ở giữa: Tác giả & Ngày đăng (Author & Date) -->
            <div class="text-xs text-stone-400 font-light flex flex-col sm:text-center leading-relaxed">
                <span class="text-stone-300 font-medium">By <?php echo esc_html( $author_name ); ?></span>
                <span class="text-stone-500 text-[11px]"><?php echo esc_html( $post_date_formatted ); ?></span>
            </div>

            <!-- Bên phải: 4 Nút Chia Sẻ Tròn (Share Action Buttons) -->
            <div class="flex items-center gap-2.5">
                <!-- Nút 1: Sao chép liên kết -->
                <button type="button" 
                        data-share="copy" 
                        class="btn-liquid-glass w-9 h-9 rounded-full flex items-center justify-center text-stone-300 hover:text-[#caa875] transition-all duration-300 cursor-pointer" 
                        title="Sao chép liên kết bài viết">
                    <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </button>

                <!-- Nút 2: Facebook -->
                <button type="button" 
                        data-share="facebook" 
                        class="btn-liquid-glass w-9 h-9 rounded-full flex items-center justify-center text-stone-300 hover:text-[#caa875] transition-all duration-300 cursor-pointer" 
                        title="Chia sẻ lên Facebook">
                    <svg class="w-4 h-4 text-current" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </button>

                <!-- Nút 3: X (Twitter) -->
                <button type="button" 
                        data-share="twitter" 
                        class="btn-liquid-glass w-9 h-9 rounded-full flex items-center justify-center text-stone-300 hover:text-[#caa875] transition-all duration-300 cursor-pointer" 
                        title="Chia sẻ lên X (Twitter)">
                    <svg class="w-3.5 h-3.5 text-current" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </button>

                <!-- Nút 4: Telegram / Chia sẻ trực tiếp -->
                <button type="button" 
                        data-share="telegram" 
                        class="btn-liquid-glass w-9 h-9 rounded-full flex items-center justify-center text-stone-300 hover:text-[#caa875] transition-all duration-300 cursor-pointer" 
                        title="Chia sẻ lên Telegram">
                    <svg class="w-4 h-4 text-current" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/>
                    </svg>
                </button>
            </div>

        </div>

        <!-- 2.4 Nội Dung Bài Viết Chính (Article Content Area) -->
        <div class="otr-article-content max-w-4xl mx-auto">
            <?php the_content(); ?>
        </div>

        <!-- 2.5 Thẻ Tags (Nếu có) -->
        <?php if ( has_tag() ) : ?>
            <div class="mt-12 pt-6 border-t border-[#caa875]/20 flex flex-wrap items-center gap-2 text-xs">
                <span class="text-stone-400 font-medium mr-2">Tags:</span>
                <?php
                $tags = get_the_tags();
                if ( $tags ) {
                    foreach ( $tags as $tag ) {
                        echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="px-3 py-1 rounded-full border border-white/10 text-stone-300 hover:text-[#caa875] hover:border-[#caa875]/40 transition-colors">' . esc_html( $tag->name ) . '</a>';
                    }
                }
                ?>
            </div>
        <?php endif; ?>

    </div>
</article>

<!-- 3. Mục Bài Viết & Sự Kiện Khác ("EVENT VÀ BÀI VIẾT KHÁC") -->
<section class="w-full bg-[#080604] border-t border-[#caa875]/15 pt-16 md:pt-20 pb-20 relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

        <!-- Tiêu đề mục -->
        <h3 class="font-mrch text-xl sm:text-2xl text-[#caa875] uppercase tracking-wider mb-8 md:mb-10 text-left">
            EVENT VÀ BÀI VIẾT KHÁC
        </h3>

        <!-- Lưới 3 cột bài viết liên quan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <?php
            $related_query = new WP_Query( array(
                'post_type'           => 'post',
                'posts_per_page'      => 3,
                'post__not_in'        => array( $post_id ),
                'ignore_sticky_posts' => 1,
                'orderby'             => 'date',
                'order'               => 'DESC',
            ) );

            if ( $related_query->have_posts() ) :
                while ( $related_query->have_posts() ) : $related_query->the_post();
                    $rel_id      = get_the_ID();
                    $rel_cats    = get_the_category( $rel_id );
                    $rel_cat_name= ! empty( $rel_cats ) ? $rel_cats[0]->name : 'Event';
                    $rel_img     = '';
                    if ( has_post_thumbnail( $rel_id ) ) {
                        $rel_img = get_the_post_thumbnail_url( $rel_id, 'medium_large' );
                    }
                    if ( empty( $rel_img ) ) {
                        $rel_img = get_post_meta( $rel_id, '_otr_custom_image', true );
                    }
                    if ( empty( $rel_img ) ) {
                        $rel_img = 'https://images.unsplash.com/photo-1543007630-9710e4a00a20?q=80&w=800&auto=format&fit=crop';
                    }
                    $rel_author = get_the_author();
                    if ( empty( $rel_author ) || $rel_author === 'admin' ) {
                        $rel_author = 'Admin Supper';
                    }
            ?>
                    <article class="group flex flex-col">
                        <!-- Khung ảnh bài viết -->
                        <a href="<?php the_permalink(); ?>" class="block rounded-2xl overflow-hidden aspect-[16/10] bg-[#14100c] border border-white/5 relative mb-3 group-hover:border-[#caa875]/40 transition-all duration-300">
                            <img src="<?php echo esc_url( $rel_img ); ?>" 
                                 alt="<?php echo esc_attr( get_the_title() ); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-300"></div>
                        </a>

                        <!-- Meta: Category badge & Author | Date -->
                        <div class="flex items-center justify-between text-xs mb-2.5">
                            <span class="inline-block border border-white/20 text-[#caa875] text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-white/5 font-medium">
                                <?php echo esc_html( $rel_cat_name ); ?>
                            </span>
                            <span class="text-[11px] text-stone-400 font-light">
                                By <?php echo esc_html( $rel_author ); ?> | <?php echo get_the_date( 'M j, Y' ); ?>
                            </span>
                        </div>

                        <!-- Tiêu đề bài viết -->
                        <h4 class="font-mrch text-base sm:text-lg text-[#d8c19d] group-hover:text-white transition-colors duration-300 font-normal leading-snug line-clamp-2">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h4>
                    </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

    </div>
</section>

<!-- 4. Dải Marquee Chạy Chữ Vô Tận Trước Footer ("MEET THE ON THE ROCK TEAM") -->
<?php get_template_part( 'template-parts/components/marquee-team-ticker' ); ?>
