<?php
/**
 * Template Part: Section Blog & Event List
 * Description: Danh sách bài viết & sự kiện phong cách On The Rock.
 * Bố cục so le Zig-Zag (Ảnh trái - Chữ phải & Chữ trái - Ảnh phải),
 * tích hợp bộ lọc Chuyên mục Tab (Tất cả, Event, Bài viết) và nút Xem Thêm.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Lấy danh sách chuyên mục cho thanh Tab
$categories = get_categories( array(
    'hide_empty' => true,
    'exclude'    => array( get_cat_ID( 'Uncategorized' ) ),
) );

// Sắp xếp chuyên mục chuẩn theo thiết kế: Event trước, Bài viết sau
if ( ! empty( $categories ) && is_array( $categories ) ) {
    usort( $categories, function( $a, $b ) {
        if ( $a->slug === 'event' ) return -1;
        if ( $b->slug === 'event' ) return 1;
        return strcmp( $a->name, $b->name );
    } );
}

// Chuyên mục đang chọn (nếu có tham số URL hoặc truy cập trang category)
$current_cat_slug = 'all';
if ( is_category() ) {
    $current_term = get_queried_object();
    if ( $current_term && ! empty( $current_term->slug ) ) {
        $current_cat_slug = $current_term->slug;
    }
} elseif ( ! empty( $_GET['cat'] ) ) {
    $current_cat_slug = sanitize_text_field( $_GET['cat'] );
}

// 2. Query danh sách bài viết
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

if ( $current_cat_slug !== 'all' ) {
    $query_args['category_name'] = $current_cat_slug;
}

$blog_query = new WP_Query( $query_args );

// Danh sách ảnh chất lượng cao mặc định nếu bài viết chưa có Featured Image
$fallback_images = array(
    'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1543007630-9710e4a00a20?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1572116469696-31de0f17cc34?q=80&w=1200&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop',
);
?>

<section class="w-full bg-[#080604] text-[#caa875] pt-28 sm:pt-36 md:pt-40 pb-24 md:pb-32 font-serif min-h-screen relative overflow-hidden">
    
    <!-- TIÊU ĐỀ LỚN: BLOG & EVENT (FONT MRCH-NewYork) -->
    <div class="w-full max-w-[1536px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 text-center mb-8 md:mb-12">
        <h1 class="font-mrch text-[#caa875] text-4xl sm:text-5xl md:text-6xl lg:text-[72px] font-normal uppercase tracking-[0.06em] leading-tight select-none">
            BLOG &amp; EVENT
        </h1>
    </div>

    <!-- THANH BỘ LỌC CHUYÊN MỤC (PILL FILTER TABS) -->
    <div class="w-full max-w-[1536px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 mb-12 sm:mb-16 md:mb-20">
        <div class="blog-filter-tabs flex items-center justify-center gap-2.5 sm:gap-4 select-none flex-wrap">
            
            <!-- Tab Tất Cả -->
            <button type="button" 
                    class="blog-tab-btn btn-liquid-glass <?php echo ($current_cat_slug === 'all') ? 'is-active' : ''; ?>"
                    data-cat-slug="all">
                <span class="btn-roll-wrap">
                    <span class="btn-roll-text">
                        <span>Tất cả</span>
                        <span aria-hidden="true">Tất cả</span>
                    </span>
                </span>
            </button>

            <!-- Các Tab Chuyên mục thực tế từ WordPress -->
            <?php if ( ! empty( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : 
                    $isActive = ($current_cat_slug === $cat->slug);
                ?>
                    <button type="button" 
                            class="blog-tab-btn btn-liquid-glass <?php echo $isActive ? 'is-active' : ''; ?>"
                            data-cat-slug="<?php echo esc_attr( $cat->slug ); ?>">
                        <span class="btn-roll-wrap">
                            <span class="btn-roll-text">
                                <span><?php echo esc_html( $cat->name ); ?></span>
                                <span aria-hidden="true"><?php echo esc_html( $cat->name ); ?></span>
                            </span>
                        </span>
                    </button>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Fallback Tabs mặc định chuẩn Mockup nếu chưa có Category trong DB -->
                <button type="button" class="blog-tab-btn btn-liquid-glass" data-cat-slug="event">
                    <span class="btn-roll-wrap">
                        <span class="btn-roll-text">
                            <span>Event</span>
                            <span aria-hidden="true">Event</span>
                        </span>
                    </span>
                </button>
                <button type="button" class="blog-tab-btn btn-liquid-glass" data-cat-slug="bai-viet">
                    <span class="btn-roll-wrap">
                        <span class="btn-roll-text">
                            <span>Bài viết</span>
                            <span aria-hidden="true">Bài viết</span>
                        </span>
                    </span>
                </button>
            <?php endif; ?>

        </div>
    </div>

    <!-- DANH SÁCH BÀI VIẾT (CONTAINER RỘNG BẰNG HEADER CONTAINER) -->
    <div class="w-full max-w-[1536px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16">
        <div id="blog-posts-container" class="space-y-8 sm:space-y-12 md:space-y-16">
            
            <?php 
            if ( $blog_query->have_posts() ) :
                $item_index = 0;
                while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    $post_id   = get_the_ID();
                    
                    // Ảnh đại diện
                    $img_url = get_the_post_thumbnail_url( $post_id, 'large' );
                    if ( empty( $img_url ) ) {
                        $custom_img = get_post_meta( $post_id, '_otr_custom_image', true );
                        $img_url = ! empty( $custom_img ) ? $custom_img : $fallback_images[$item_index % count($fallback_images)];
                    }

                    // Chuyên mục bài viết
                    $post_cats = get_the_category( $post_id );
                    $cat_obj   = ! empty( $post_cats ) ? $post_cats[0] : null;
                    $cat_name  = $cat_obj ? $cat_obj->name : 'Event';
                    $cat_slug  = $cat_obj ? $cat_obj->slug : 'event';

                    // Tác giả & Ngày đăng
                    $author_name = get_the_author();
                    $author_name = (!empty($author_name) && $author_name !== 'admin') ? $author_name : 'Admin Supper';
                    $date_str    = get_the_time( 'M d, Y' );

                    // Đoạn trích dẫn ngắn
                    $excerpt = get_the_excerpt();
                    if ( empty( $excerpt ) ) {
                        $excerpt = wp_trim_words( get_the_content(), 35, '...' );
                    }
            ?>
                <!-- Khung Thẻ Bài Viết Chuẩn Mockup On The Rock -->
                <article class="blog-post-card group relative w-full flex flex-col lg:flex-row cursor-pointer"
                         data-post-cat="<?php echo esc_attr( $cat_slug ); ?>">
                    
                    <!-- Link bọc toàn bộ thẻ để click mở chi tiết -->
                    <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10" aria-label="<?php the_title_attribute(); ?>"></a>

                    <!-- CỘT ẢNH NGHỆ THUẬT (50% WIDTH) -->
                    <div class="w-full lg:w-1/2 relative overflow-hidden shrink-0 aspect-[16/10] sm:aspect-[16/9] lg:aspect-auto lg:min-h-[380px] bg-[#0c0805]">
                        <img src="<?php echo esc_url( $img_url ); ?>" 
                             alt="<?php the_title_attribute(); ?>" 
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover brightness-[0.92] group-hover:brightness-100 group-hover:scale-105 transition-all duration-700 ease-out select-none">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                    </div>

                    <!-- CỘT NỘI DUNG CHI TIẾT (50% WIDTH, NỀN ĐỔI SANG #472b08 KHI HOVER) -->
                    <div class="blog-card-content w-full lg:w-1/2 flex flex-col justify-center p-6 sm:p-8 md:p-10 lg:p-14">
                        
                        <!-- Dòng Meta: Tag chuyên mục & Tác giả / Ngày đăng -->
                        <div class="flex items-center justify-between gap-4 mb-4 sm:mb-6 select-none relative z-20">
                            <span class="blog-card-tag">
                                <?php echo esc_html( $cat_name ); ?>
                            </span>
                            <span class="text-xs sm:text-[13px] font-sans font-light tracking-wide text-[#caa875]/70 group-hover:text-[#f4efe8]/80 transition-colors">
                                By <?php echo esc_html( $author_name ); ?> &nbsp;|&nbsp; <?php echo esc_html( $date_str ); ?>
                            </span>
                        </div>

                        <!-- Tiêu đề bài viết (Font MRCH-NewYork) -->
                        <h2 class="font-mrch text-2xl sm:text-3xl md:text-4xl lg:text-[40px] font-normal text-[#caa875] group-hover:text-[#fdf8f0] transition-colors duration-400 leading-[1.22] mb-3 sm:mb-4 tracking-[0.02em]">
                            <?php the_title(); ?>
                        </h2>

                        <!-- Đoạn trích tóm tắt (Font SVN-Gilroy Light) -->
                        <p class="text-xs sm:text-sm md:text-[14.5px] font-gilroy-light text-[#caa875]/75 group-hover:text-[#f4efe8]/90 transition-colors duration-400 leading-relaxed line-clamp-3 md:line-clamp-4">
                            <?php echo esc_html( $excerpt ); ?>
                        </p>

                    </div>

                </article>

            <?php 
                    $item_index++;
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="text-center py-16 text-[#caa875]/60 font-sans italic">
                    Chưa có bài viết hoặc sự kiện nào trong danh mục này.
                </div>
            <?php endif; ?>

        </div>

        <!-- NÚT XEM THÊM Ở ĐÁY TRANG -->
        <div class="text-center mt-16 sm:mt-20 md:mt-24">
            <button type="button" 
                    id="blog-load-more-btn" 
                    class="btn-liquid-glass inline-flex items-center justify-center px-8 sm:px-10 py-3.5 rounded-full text-xs sm:text-[13px] tracking-[0.2em] uppercase font-sans font-medium transition-all duration-300 cursor-pointer shadow-lg select-none">
                <span class="btn-roll-wrap">
                    <span class="btn-roll-text">
                        <span>XEM THÊM</span>
                        <span aria-hidden="true">XEM THÊM</span>
                    </span>
                </span>
            </button>
        </div>

    </div>

</section>
