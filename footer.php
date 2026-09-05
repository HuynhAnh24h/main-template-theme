<?php if ( ! is_front_page() ) : ?>
</main> <!-- Đóng main-content -->
<?php endif; ?>

<?php
// Gọi component chân trang On The Rock
get_template_part( 'template-parts/footer/site-footer' );
?>

<!-- Nút Cuộn Lên Đầu Trang (Back to Top) -->
<button id="back-to-top" class="fixed bottom-6 right-6 z-40 w-10 h-10 rounded-full bg-[#caa875] hover:bg-[#b89563] text-[#171009] shadow-xl flex items-center justify-center transition-all duration-300 opacity-0 pointer-events-none hover:scale-105" title="Cuộn lên đầu trang">
    <svg class="w-4 h-4 -rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
</button>

<?php wp_footer(); ?> <!-- BẮT BUỘC: Để WP nhúng JS và Admin Bar -->
</body>
</html>