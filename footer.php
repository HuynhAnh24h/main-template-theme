</main> <!-- Đóng main-content -->

<!-- Premium Footer -->
<footer class="site-footer bg-gray-900 text-gray-400 mt-16 border-t border-gray-800">
    <!-- Top Footer Links -->
    <div class="container mx-auto px-4 py-12 md:py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <!-- Col 1: Brand / Slogan -->
        <div class="space-y-4">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                <span class="w-9 h-9 rounded-xl bg-lc-blue text-white flex items-center justify-center font-black text-lg">LC</span>
                <span class="text-lg font-black text-white tracking-tight"><?php bloginfo('name'); ?></span>
            </a>
            <p class="text-xs text-gray-500 leading-relaxed">
                Hệ thống bán lẻ dược phẩm, thực phẩm chức năng và mỹ phẩm chăm sóc sắc đẹp hàng đầu Việt Nam. Cam kết tận tâm, uy tín và chất lượng 100%.
            </p>
            <div class="text-xs text-gray-500 font-bold">
                Hotline hỗ trợ: <span class="text-white">1800 6928</span> (Miễn phí)
            </div>
        </div>

        <!-- Col 2: Quick Navigation -->
        <div>
            <h3 class="text-white font-extrabold text-sm uppercase tracking-wider mb-4 border-l-2 border-lc-blue pl-3">Liên kết chính</h3>
            <nav class="flex flex-col gap-2.5 text-xs [&>ul]:flex [&>ul]:flex-col [&>ul]:gap-2.5 [&>ul>li>a]:hover:text-white [&>ul>li>a]:transition [&>ul>li>a]:inline-block">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_menu',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col gap-2.5',
                    'fallback_cb'    => 'theme_footer_menu_fallback'
                ));
                ?>
            </nav>
        </div>

        <!-- Col 3: Customer Policy -->
        <div>
            <h3 class="text-white font-extrabold text-sm uppercase tracking-wider mb-4 border-l-2 border-lc-blue pl-3">Chính sách mua hàng</h3>
            <ul class="flex flex-col gap-2.5 text-xs">
                <li><a href="#" class="hover:text-white transition block">Chính sách giao nhận hàng</a></li>
                <li><a href="#" class="hover:text-white transition block">Chính sách đổi trả thuốc</a></li>
                <li><a href="#" class="hover:text-white transition block">Chính sách bảo mật thông tin</a></li>
                <li><a href="#" class="hover:text-white transition block">Chính sách giải quyết khiếu nại</a></li>
            </ul>
        </div>

        <!-- Col 4: Contact & Socials -->
        <div class="space-y-4">
            <h3 class="text-white font-extrabold text-sm uppercase tracking-wider mb-4 border-l-2 border-lc-blue pl-3">Kết nối với chúng tôi</h3>
            <p class="text-xs leading-relaxed text-gray-500">
                Email hỗ trợ khách hàng:<br>
                <a href="mailto:support@ecommerce-theme.com" class="text-white hover:underline">support@ecommerce-theme.com</a>
            </p>
            
            <div class="flex items-center gap-2 pt-2">
                <a href="#" class="w-8 h-8 rounded-xl bg-gray-800 text-gray-400 hover:bg-lc-blue hover:text-white flex items-center justify-center transition" title="Facebook">
                    <i data-lucide="facebook" class="w-4 h-4"></i>
                </a>
                <a href="#" class="w-8 h-8 rounded-xl bg-gray-800 text-gray-400 hover:bg-lc-blue hover:text-white flex items-center justify-center transition" title="Youtube">
                    <i data-lucide="youtube" class="w-4 h-4"></i>
                </a>
                <a href="#" class="w-8 h-8 rounded-xl bg-gray-800 text-gray-400 hover:bg-lc-blue hover:text-white flex items-center justify-center transition" title="Instagram">
                    <i data-lucide="instagram" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Bottom Copyright -->
    <div class="border-t border-gray-800 py-6 text-center text-xs text-gray-600">
        <div class="container mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>&copy; <?php echo date('Y'); ?> - <?php bloginfo('name'); ?>. Phát triển trên nền tảng WordPress & Tailwind CSS.</p>
            <p class="text-[10px]">Made with passion by Antigravity AI.</p>
        </div>
    </div>
</footer>

<!-- Back to top button (Điều khiển bởi main.js) -->
<button id="back-to-top" class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-2xl bg-lc-blue hover:bg-lc-darkblue text-white shadow-lg flex items-center justify-center transition-all duration-300 opacity-0 pointer-events-none hover:scale-105" title="Cuộn lên đầu trang">
    <?php echo get_svg_icon('chevron-right', 'w-5 h-5 -rotate-90'); ?>
</button>

<?php wp_footer(); ?> <!-- BẮT BUỘC: Để WP nhúng JS và Admin Bar -->
</body>
</html>