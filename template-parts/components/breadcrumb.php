<?php
/**
 * Component: Breadcrumb
 * Hiển thị thanh điều hướng bài viết/trang.
 */
$title = isset($args['title']) ? $args['title'] : get_the_title();
?>
<div class="bg-[#0e0b08] border-b border-white/10 py-3.5 mb-6">
    <div class="container mx-auto px-4 flex items-center gap-2 text-xs md:text-sm text-stone-400">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-[#caa875] flex items-center gap-1.5 font-medium transition duration-200">
            <?php echo get_svg_icon('home', 'w-4 h-4 text-stone-500 hover:text-[#caa875]'); ?> Trang chủ
        </a>
        
        <?php echo get_svg_icon('chevron-right', 'w-3.5 h-3.5 text-stone-600'); ?>
        
        <span class="text-[#caa875] font-medium truncate max-w-xs md:max-w-md"><?php echo esc_html($title); ?></span>
    </div>
</div>
