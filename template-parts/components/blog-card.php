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
    ? get_the_post_thumbnail($post_id, 'medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-500', 'loading' => 'lazy', 'decoding' => 'async']) 
    : '<div class="w-full h-full bg-[#1e1711] flex items-center justify-center text-[#caa875] text-3xl font-serif">🍸</div>';
?>

<article class="bg-[#140f0a] rounded-2xl overflow-hidden border border-white/10 hover:border-[#caa875]/40 hover:shadow-2xl transition-all duration-300 group flex flex-col justify-between <?php echo esc_attr($class_custom); ?>">
    <div>
        <!-- Link ảnh -->
        <a href="<?php echo esc_url($permalink); ?>" class="h-48 overflow-hidden block relative bg-black/40">
            <?php echo $image_html; ?>
        </a>
        
        <!-- Nội dung tin tức -->
        <div class="p-5">
            <!-- Ngày đăng -->
            <span class="text-[10px] text-stone-500 font-medium uppercase tracking-widest block mb-2"><?php echo esc_html($date); ?></span>
            
            <!-- Tiêu đề -->
            <h3 class="font-serif text-base text-stone-100 group-hover:text-[#caa875] transition duration-200 line-clamp-2 mb-2">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>
            
            <!-- Tóm tắt ngắn -->
            <p class="text-xs text-stone-400 line-clamp-3 mb-4 leading-relaxed font-light"><?php echo esc_html($excerpt); ?></p>
        </div>
    </div>
    
    <!-- Link Xem thêm -->
    <div class="px-5 pb-5 pt-0">
        <a href="<?php echo esc_url($permalink); ?>" class="btn-liquid-glass inline-flex items-center px-4 py-2 rounded-full text-[11px] tracking-wider uppercase font-medium text-[#caa875] gap-1.5 transition">
            <span class="btn-roll-wrap">
                <span class="btn-roll-text">
                    <span>Xem thêm &rarr;</span>
                    <span aria-hidden="true">Xem thêm &rarr;</span>
                </span>
            </span>
        </a>
    </div>
</article>
