<?php if ( ! is_front_page() ) : ?>
</main> <!-- Đóng main-content -->
<?php endif; ?>

<?php
// Gọi dải chữ chạy Marquee ("MEET THE ON THE ROCK TEAM") trước Footer nếu trang chưa có
get_template_part( 'template-parts/components/marquee-team-ticker' );

// Gọi component chân trang On The Rock
get_template_part( 'template-parts/footer/site-footer' );
?>

<!-- Nút Cuộn Lên Đầu Trang (Back to Top) -->
<button id="back-to-top" class="btn-liquid-glass fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full text-[#caa875] flex items-center justify-center transition-all duration-300 opacity-0 pointer-events-none" title="Cuộn lên đầu trang">
    <svg class="w-4 h-4 -rotate-90 text-current" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
</button>

<?php wp_footer(); ?> <!-- BẮT BUỘC: Để WP nhúng JS và Admin Bar -->
</body>
</html>