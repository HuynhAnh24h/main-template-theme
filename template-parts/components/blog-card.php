<?php
/**
 * Component: Blog Card
 * Hiển thị tóm tắt bài viết blog/tin tức.
 */
$post_id = isset($args['post_id']) ? $args['post_id'] : get_the_ID();
$class_custom = isset($args['class']) ? $args['class'] : '';

$title = get_the_title($post_id);
$permalink = get_permalink($post_id);
$excerpt = get_the_excerpt($post_id);
$date = get_the_date('', $post_id);
$image_html = has_post_thumbnail($post_id) 
    ? get_the_post_thumbnail($post_id, 'medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-500']) 
    : '<div class="w-full h-full bg-orange-50 flex items-center justify-center text-lc-orange text-3xl font-bold">📰</div>';
?>

<article class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 group flex flex-col justify-between <?php echo esc_attr($class_custom); ?>">
    <div>
        <!-- Link ảnh -->
        <a href="<?php echo esc_url($permalink); ?>" class="h-48 overflow-hidden block relative bg-gray-100">
            <?php echo $image_html; ?>
        </a>
        
        <!-- Nội dung tin tức -->
        <div class="p-5">
            <!-- Ngày đăng -->
            <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block mb-2"><?php echo esc_html($date); ?></span>
            
            <!-- Tiêu đề -->
            <h3 class="font-bold text-sm md:text-base text-gray-800 group-hover:text-lc-blue transition duration-200 line-clamp-2 mb-2">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>
            
            <!-- Tóm tắt ngắn -->
            <p class="text-xs text-gray-500 line-clamp-3 mb-4 leading-relaxed"><?php echo esc_html($excerpt); ?></p>
        </div>
    </div>
    
    <!-- Link Xem thêm -->
    <div class="px-5 pb-5 pt-0">
        <a href="<?php echo esc_url($permalink); ?>" class="inline-flex items-center text-xs font-bold text-lc-blue hover:text-lc-darkblue gap-1 transition">
            Xem thêm <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
        </a>
    </div>
</article>
