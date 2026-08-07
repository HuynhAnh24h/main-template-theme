<?php
/**
 * Description: Mẫu trang danh sách bài viết Blog (News Index).
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Góc sức khỏe & Tin tức'
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            <div class="mb-8 pb-4 border-b border-gray-100">
                <h1 class="text-2xl font-black text-gray-800">Tin tức & Kinh nghiệm hay</h1>
                <p class="text-xs text-gray-400 mt-1">Cập nhật kiến thức y khoa phòng bệnh, tư vấn dinh dưỡng và chăm sóc sức khỏe lành mạnh.</p>
            </div>

            <!-- Danh sách Bài viết dạng lưới -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/components/blog-card', null, [
                            'post_id' => get_the_ID()
                        ]);
                    endwhile;
                else :
                    // Dummy posts nếu không có bài viết thực tế
                    for ($i = 1; $i <= 6; $i++) :
                        get_template_part('template-parts/components/blog-card', null, [
                            'post_id' => $i
                        ]);
                    endfor;
                endif;
                ?>
            </div>

            <!-- Nút Xem thêm Ajax hoặc Phân trang -->
            <div class="mt-12 text-center">
                <?php if (have_posts()) : ?>
                    <div class="flex justify-center gap-2">
                        <?php
                        echo paginate_links([
                            'type'      => 'list',
                            'prev_text' => '&larr;',
                            'next_text' => '&rarr;'
                        ]);
                        ?>
                    </div>
                <?php else : ?>
                    <button id="blog-load-more-btn" class="bg-blue-50 hover:bg-lc-blue text-lc-blue hover:text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-sm border border-transparent">
                        Xem thêm bài viết
                    </button>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<?php
get_footer();
