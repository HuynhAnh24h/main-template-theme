<?php
/**
 * Description: Mẫu trang chi tiết bài viết Blog (Single Post).
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => get_the_title()
]);
?>

<!-- Reading Progress Bar (Điều khiển bởi blog-detail.js) -->
<div class="fixed top-0 left-0 w-full h-1 z-50 bg-gray-100">
    <div id="reading-progress" class="h-full bg-lc-blue w-0 transition-all duration-75"></div>
</div>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Article Content (Trái 2/3) -->
            <article class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <!-- Post Meta Header -->
                    <header class="mb-6 pb-6 border-b border-gray-100">
                        <!-- Chuyên mục -->
                        <span class="bg-orange-50 text-lc-orange text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">
                            <?php the_category(', '); ?>
                        </span>
                        
                        <h1 class="text-xl md:text-3xl font-black text-gray-800 mb-4 leading-snug"><?php the_title(); ?></h1>
                        
                        <div class="flex items-center gap-4 text-xs text-gray-400 font-medium">
                            <span class="flex items-center gap-1">
                                <?php echo get_svg_icon('user', 'w-3.5 h-3.5 text-gray-300'); ?> Đăng bởi: <?php the_author(); ?>
                            </span>
                            <span>|</span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-300"></i> Ngày: <?php the_date(); ?>
                            </span>
                        </div>
                    </header>

                    <!-- Feature Image -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="rounded-2xl overflow-hidden mb-8 shadow-sm max-h-[400px]">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Content -->
                    <div class="prose prose-blue max-w-none text-gray-600 text-sm md:text-base leading-relaxed space-y-4">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php if (has_tag()) : ?>
                        <footer class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400">Thẻ:</span>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <?php the_tags('', ' ', ''); ?>
                            </div>
                        </footer>
                    <?php endif; ?>

                <?php endwhile; else : ?>
                    <!-- Fallback Dummy Post nếu chưa có bài viết thực tế -->
                    <header class="mb-6 pb-6 border-b border-gray-100">
                        <span class="bg-orange-50 text-lc-orange text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Cẩm Nang Sức Khỏe</span>
                        <h1 class="text-xl md:text-3xl font-black text-gray-800 mb-4 leading-snug">Vitamin C có tác dụng gì? Hướng dẫn bổ sung Vitamin C đúng cách cho cả nhà</h1>
                        <div class="flex items-center gap-4 text-xs text-gray-400 font-medium">
                            <span class="flex items-center gap-1"><?php echo get_svg_icon('user', 'w-3.5 h-3.5 text-gray-300'); ?> Dược sĩ Long Châu</span>
                            <span>|</span>
                            <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-300"></i> 07/08/2026</span>
                        </div>
                    </header>
                    
                    <div class="rounded-2xl overflow-hidden mb-8 shadow-sm h-64 md:h-80 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover">
                    </div>

                    <div class="prose prose-blue max-w-none text-gray-600 text-sm md:text-base leading-relaxed space-y-4">
                        <p class="font-bold">Vitamin C (axit ascorbic) là một chất dinh dưỡng thiết yếu giúp duy trì hoạt động bình thường của cơ thể. Nó đóng vai trò đặc biệt quan trọng trong việc hỗ trợ miễn dịch và bảo vệ tế bào khỏi tác hại của các gốc tự do.</p>
                        <p>Tuy nhiên, vì cơ thể con người không thể tự tổng hợp hay lưu trữ Vitamin C, chúng ta bắt buộc phải cung cấp nó hàng ngày qua thực phẩm ăn uống hoặc các chế phẩm bổ sung như viên nén sủi, viên nang uống.</p>
                        <h3 class="font-bold text-gray-800 text-lg mt-6 mb-2">1. Những tác dụng vàng của Vitamin C</h3>
                        <p>Bổ sung đầy đủ Vitamin C mang lại nhiều giá trị tuyệt vời:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li><strong>Tăng cường hệ miễn dịch:</strong> Kích thích sản sinh và bảo vệ tế bào bạch cầu, giúp cơ thể chống lại các bệnh nhiễm trùng, cảm cúm thông thường.</li>
                            <li><strong>Sản sinh Collagen:</strong> Vitamin C cần thiết cho quá trình tổng hợp collagen, giúp da săn chắc, các vết thương nhanh lành hơn.</li>
                            <li><strong>Chống oxy hóa:</strong> Bảo vệ tế bào khỏi tổn thương do các gốc tự do, giảm thiểu nguy cơ mắc bệnh mãn tính.</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </article>

            <!-- Related Articles Sidebar (Phải 1/3) -->
            <aside class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50">
                    <h3 class="font-extrabold text-gray-800 text-base pb-3 border-b border-gray-100 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-lc-blue rounded-full inline-block"></span> Bài viết liên quan
                    </h3>
                    
                    <div class="space-y-4">
                        <?php
                        $related_query = new WP_Query([
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'post__not_in' => [get_the_ID()]
                        ]);

                        if ($related_query->have_posts()) :
                            while ($related_query->have_posts()) : $related_query->the_post();
                        ?>
                                <a href="<?php the_permalink(); ?>" class="group flex gap-3 items-start">
                                    <div class="w-16 h-16 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                                        <?php if(has_post_thumbnail()): the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition']); endif; ?>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs text-gray-800 group-hover:text-lc-blue line-clamp-2 transition leading-tight mb-1"><?php the_title(); ?></h4>
                                        <span class="text-[9px] text-gray-400"><?php echo get_the_date(); ?></span>
                                    </div>
                                </a>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            // Dummy links
                            $mocks = [
                                ['title' => 'Chế độ ăn tốt cho người cao huyết áp', 'img' => 'https://images.unsplash.com/photo-1505576399279-565b52d4ac71?auto=format&fit=crop&q=80&w=200'],
                                ['title' => 'Dinh dưỡng bổ sung cho trẻ biếng ăn', 'img' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&q=80&w=200']
                            ];
                            foreach($mocks as $m):
                        ?>
                                <a href="#" class="group flex gap-3 items-start">
                                    <div class="w-16 h-16 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                                        <img src="<?php echo esc_url($m['img']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs text-gray-800 group-hover:text-lc-blue line-clamp-2 transition leading-tight mb-1"><?php echo esc_html($m['title']); ?></h4>
                                        <span class="text-[9px] text-gray-400">07/08/2026</span>
                                    </div>
                                </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

<?php
get_footer();
