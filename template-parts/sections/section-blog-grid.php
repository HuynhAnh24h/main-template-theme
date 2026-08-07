<?php
/**
 * Section: Blog Posts Grid
 * Bố cục: Header tin tức + Lưới bài viết nổi bật
 */
$post_count = isset($args['posts_per_page']) ? $args['posts_per_page'] : 3;
?>
<section class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
        <h2 class="text-lg font-black text-gray-800 flex items-center gap-2">
            <span class="w-2 h-5 bg-lc-orange rounded-full inline-block"></span> Góc Sức Khỏe & Bệnh Học
        </h2>
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-xs md:text-sm font-bold text-lc-blue hover:text-lc-darkblue flex items-center gap-1 transition">
            Xem tất cả bài viết <?php echo get_svg_icon('chevron-right', 'w-3.5 h-3.5'); ?>
        </a>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $blog_query = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => $post_count
        ]);
        
        if ($blog_query->have_posts()) :
            while ($blog_query->have_posts()) : $blog_query->the_post();
                get_template_part('template-parts/components/blog-card', null, [
                    'post_id' => get_the_ID()
                ]);
            endwhile;
            wp_reset_postdata();
        else :
            // Dữ liệu mẫu bài viết nếu chưa có bài viết WordPress
            for ($i = 1; $i <= $post_count; $i++) :
                get_template_part('template-parts/components/blog-card', null, [
                    'post_id' => $i
                ]);
            endfor;
        endif;
        ?>
    </div>
</section>
