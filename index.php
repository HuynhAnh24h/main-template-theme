<?php
/**
 * The main template file
 * Description: Mẫu trang dự phòng chính (Fallback Index).
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => get_the_title() ? get_the_title() : 'Nội dung'
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            
            <?php if (have_posts()) : ?>
                <div class="space-y-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="pb-6 border-b border-gray-100 last:border-b-0 last:pb-0">
                            <h2 class="text-xl md:text-2xl font-black text-gray-800 mb-2 hover:text-lc-blue transition">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="text-xs text-gray-400 mb-4"><?php echo get_the_date(); ?></div>
                            <div class="text-sm text-gray-500 leading-relaxed mb-4"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="text-xs font-bold text-lc-blue hover:text-lc-darkblue inline-flex items-center gap-1 transition">
                                Đọc tiếp &rarr;
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <div class="mt-8 flex justify-center">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <div class="text-center py-16">
                    <div class="text-4xl mb-4">🔍</div>
                    <h2 class="text-xl font-black text-gray-800 mb-2">Không tìm thấy nội dung</h2>
                    <p class="text-xs text-gray-400">Rất tiếc, nội dung bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
get_footer();