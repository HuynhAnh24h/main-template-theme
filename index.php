<?php
/**
 * The main template file
 * Description: Mẫu trang dự phòng chính (Fallback Index).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="bg-[#080604] min-h-[70vh] py-20 px-4">
    <div class="max-w-4xl mx-auto text-center font-serif text-[#caa875]">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-light uppercase tracking-wider mb-6">
            <?php single_post_title(); ?>
        </h1>
        <div class="w-24 h-px bg-[#caa875]/30 mx-auto mb-10"></div>

        <?php if ( have_posts() ) : ?>
            <div class="space-y-12 text-left">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'border-b border-[#caa875]/20 pb-8' ); ?>>
                        <h2 class="text-2xl md:text-3xl font-normal mb-3">
                            <a href="<?php the_permalink(); ?>" class="hover:text-white transition-colors duration-200">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <div class="text-[#caa875]/70 text-sm font-sans mb-4">
                            <?php the_time( get_option( 'date_format' ) ); ?>
                        </div>
                        <div class="text-[#f4efe8]/80 text-sm md:text-base font-sans leading-relaxed">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="mt-12">
                <?php the_posts_pagination( array( 'class' => 'pagination text-[#caa875]' ) ); ?>
            </div>
        <?php else : ?>
            <p class="text-[#caa875]/70 font-sans italic text-base">
                Chưa có nội dung nào được đăng tải.
            </p>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();