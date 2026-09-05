<?php
/**
 * Template Name: Front Page (Wander Reveal & Cocktail Bar)
 * Description: Trang chủ với hiệu ứng Loading Reveal & Khối Hero Cocktail Bar.
 */

get_header();

// Lấy ID của trang chủ tĩnh
$front_page_id = get_option('page_on_front');

// 1. Cấu hình Câu nói mở đầu (Intro Quote) nổi trên hình ảnh từ ACF
$raw_intro = get_field('home_intro_quote', $front_page_id);
if (empty($raw_intro)) {
    $raw_intro = get_field('home_reveal_title', $front_page_id);
}
if (!empty($raw_intro) && strpos($raw_intro, 'Ánh sáng') === false) {
    $clean_intro = preg_replace('/<br\s*\/?>/i', "\n", $raw_intro);
    $intro_quote = trim(strip_tags($clean_intro));
} else {
    $intro_quote = "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.";
}

// 2. Lấy 10 hình ảnh từ ACF (cho Loading & Moodboard), fallback sang ảnh không gian thực tế của quán
$theme_uri = get_template_directory_uri();
$fallback_images = array(
    $theme_uri . '/assets/images/atmosphere-1.jpg',
    $theme_uri . '/assets/images/atmosphere-2.jpg',
    $theme_uri . '/assets/images/atmosphere-3.jpg',
    $theme_uri . '/assets/images/atmosphere-4.jpg',
    $theme_uri . '/assets/images/atmosphere-5.jpg',
    $theme_uri . '/assets/images/atmosphere-6.jpg',
    $theme_uri . '/assets/images/atmosphere-7.jpg',
    $theme_uri . '/assets/images/atmosphere-8.jpg',
    $theme_uri . '/assets/images/atmosphere-9.jpg',
    'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop'
);

$images = array();
for ($i = 1; $i <= 10; $i++) {
    $img_arr = get_field('home_reveal_image_' . $i, $front_page_id);
    if (!empty($img_arr) && is_array($img_arr)) {
        $images[] = $img_arr['url'];
    } elseif (!empty($img_arr) && is_string($img_arr)) {
        $images[] = $img_arr;
    } else {
        $images[] = $fallback_images[$i - 1];
    }
}

// 3. Cấu hình Fixed Header từ ACF
$header_fb       = get_field('header_facebook_url', $front_page_id) ?: 'https://facebook.com/ontherock.dalat';
$header_insta    = get_field('header_instagram_url', $front_page_id) ?: 'https://instagram.com/ontherock.dalat';
$header_logo     = get_field('header_logo', $front_page_id);
$header_menu     = get_field('header_menu_text', $front_page_id) ?: 'MENU';
$raw_menu_url    = get_field('header_menu_url', $front_page_id);
$header_menu_url = (empty($raw_menu_url) || in_array($raw_menu_url, array('#menu', '#', ''))) ? home_url('/menu/') : (function_exists('otr_url') ? otr_url($raw_menu_url) : home_url('/' . ltrim($raw_menu_url, '/')));
$header_contact  = get_field('header_contact_text', $front_page_id) ?: 'CONTACT';
$raw_contact_url = get_field('header_contact_url', $front_page_id);
$header_contact_url = (empty($raw_contact_url) || in_array($raw_contact_url, array('#contact', '#', ''))) ? home_url('/contact/') : (function_exists('otr_url') ? otr_url($raw_contact_url) : home_url('/' . ltrim($raw_contact_url, '/')));
$header_booking  = get_field('header_booking_text', $front_page_id) ?: 'ĐẶT BÀN TRƯỚC';
$raw_booking_url = get_field('header_booking_url', $front_page_id);
$header_booking_url = (empty($raw_booking_url) || in_array($raw_booking_url, array('#book', '#booking', '#', ''))) ? home_url('/booking/') : (function_exists('otr_url') ? otr_url($raw_booking_url) : home_url('/' . ltrim($raw_booking_url, '/')));

// 4. Cấu hình Hero Section từ ACF
$hero_bg_image   = get_field('hero_bg_image', $front_page_id);
$hero_title      = get_field('hero_title', $front_page_id) ?: "BESPEAK YOUR\nBESPOKE COCKTAIL";
$hero_btn_text   = get_field('hero_btn_text', $front_page_id) ?: 'XEM MENU';
$raw_hero_btn    = get_field('hero_btn_link', $front_page_id);
$hero_btn_link   = (empty($raw_hero_btn) || in_array($raw_hero_btn, array('#menu', '#', ''))) ? home_url('/menu/') : $raw_hero_btn;
$hero_btn_style  = get_field('hero_btn_style', $front_page_id) ?: 'solid-dark';

// 5. Cấu hình Thẻ Đánh giá Google từ ACF
$hero_review_score = get_field('hero_review_score', $front_page_id) ?: '4.7';
$hero_review_max   = get_field('hero_review_max', $front_page_id) ?: '/5';
$hero_review_title = get_field('hero_review_title', $front_page_id) ?: 'Excellent';
$hero_review_sub   = get_field('hero_review_subtitle', $front_page_id) ?: 'Based on 3 576 reviews';
$hero_review_link  = get_field('hero_review_link', $front_page_id) ?: '#';

// 6. Cấu hình Dải chữ Marquee từ ACF
$hero_marquee_text = get_field('hero_marquee_text', $front_page_id) ?: 'ON THE ROCKS COCKTAIL BAR';

// 7. Cấu hình Thực đơn Menu từ ACF
$menu_title = get_field('menu_section_title', $front_page_id) ?: 'MENU';
$menu_items = array();
$fallback_menu_images = array(
    1 => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
    2 => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
    3 => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
    4 => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop',
    5 => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop',
    6 => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?q=80&w=1000&auto=format&fit=crop',
    7 => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?q=80&w=1000&auto=format&fit=crop',
    8 => 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1000&auto=format&fit=crop',
);

for ($m = 1; $m <= 8; $m++) {
    $num_str   = sprintf('%02d', $m);
    $title_val = get_field('menu_item_title_' . $m, $front_page_id);
    $desc_val  = get_field('menu_item_desc_' . $m, $front_page_id);
    $img_val   = get_field('menu_item_image_' . $m, $front_page_id);
    $img_url   = (!empty($img_val) && is_array($img_val)) ? $img_val['url'] : (is_string($img_val) && !empty($img_val) ? $img_val : (isset($fallback_menu_images[$m]) ? $fallback_menu_images[$m] : ''));

    if (!empty($title_val)) {
        $menu_items[] = array(
            'num'   => $num_str,
            'title' => $title_val,
            'desc'  => $desc_val,
            'image' => $img_url,
        );
    }
}

// 8. Cấu hình Cảm nhận khách hàng từ ACF
$testimonials_title = get_field('testimonials_title', $front_page_id) ?: 'CẢM NHẬN TỪ KHÁCH HÀNG';

// ================= NHÚNG CÁC SECTION ĐỘC LẬP VÀO TRANG CHỦ ================= //

// Section A: Header cố định (Fixed Header)
get_template_part('template-parts/header/site-header', null, array(
    'facebook_url'  => $header_fb,
    'instagram_url' => $header_insta,
    'logo'          => $header_logo,
    'menu_text'     => $header_menu,
    'menu_url'      => $header_menu_url,
    'contact_text'  => $header_contact,
    'contact_url'   => $header_contact_url,
    'booking_text'  => $header_booking,
    'booking_url'   => $header_booking_url,
));

// Section B: Màn hình Intro Moodboard & Loading Reveal (Ảnh nằm dưới, Chữ nổi ở trên)
get_template_part('template-parts/sections/home/section-loading', null, array(
    'quote_text' => $intro_quote,
    'images'     => $images,
));

// Section C: Khối Hero Quầy Bar Cocktail & Google Reviews & Marquee Ticker
get_template_part('template-parts/sections/home/section-hero', null, array(
    'hero_bg_image'        => $hero_bg_image,
    'hero_title'           => $hero_title,
    'hero_btn_text'        => $hero_btn_text,
    'hero_btn_link'        => $hero_btn_link,
    'hero_btn_style'       => $hero_btn_style,
    'hero_review_score'    => $hero_review_score,
    'hero_review_max'      => $hero_review_max,
    'hero_review_title'    => $hero_review_title,
    'hero_review_subtitle' => $hero_review_sub,
    'hero_review_link'     => $hero_review_link,
    'hero_marquee_text'    => $hero_marquee_text,
));

// Section D: Khối Cảm nhận từ khách hàng (Testimonials Slider)
get_template_part('template-parts/sections/home/section-testimonials', null, array(
    'title' => $testimonials_title,
));

// Section E: Khối Thực đơn Menu Cocktail tương tác (8 Món)
get_template_part('template-parts/sections/home/section-menu', null, array(
    'title' => $menu_title,
    'items' => $menu_items,
));

// 9. Cấu hình Khoảnh khắc @OnTheRock từ ACF (Hỗ trợ Ảnh & Video dọc tràn viền)
$moments_title_1 = get_field('moments_title_1', $front_page_id) ?: 'THƯỞNG THỨC, LƯU LẠI KHOẢNH KHẮC';
$moments_title_2 = get_field('moments_title_2', $front_page_id) ?: 'VÀ GẮN THẺ @ONTHEROCK.';
$moments_ig_url  = get_field('moments_instagram_url', $front_page_id) ?: 'https://instagram.com';
$moments_fb_url  = get_field('moments_facebook_url', $front_page_id) ?: 'https://facebook.com';

$fallback_moments_media = array(
    1 => array('image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop', 'badge' => ''),
    2 => array('image' => 'https://images.unsplash.com/photo-1543007630-9710e4a00a20?q=80&w=1000&auto=format&fit=crop', 'badge' => ''),
    3 => array('image' => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop', 'badge' => 'THE BAR is where STORIES BEGIN'),
    4 => array('image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1000&auto=format&fit=crop', 'badge' => ''),
);

$moments_items = array();
for ($i = 1; $i <= 4; $i++) {
    $m_type  = get_field('moments_media_type_' . $i, $front_page_id) ?: 'image';
    $m_img   = get_field('moments_image_' . $i, $front_page_id);
    $m_vid   = get_field('moments_video_' . $i, $front_page_id);
    $m_badge = get_field('moments_badge_' . $i, $front_page_id);
    if ($m_badge === null || $m_badge === '') {
        $m_badge = isset($fallback_moments_media[$i]['badge']) ? $fallback_moments_media[$i]['badge'] : '';
    }

    $img_url = (!empty($m_img) && is_array($m_img)) ? $m_img['url'] : (is_string($m_img) && !empty($m_img) ? $m_img : $fallback_moments_media[$i]['image']);

    $moments_items[] = array(
        'type'  => $m_type,
        'image' => $img_url,
        'video' => $m_vid ?: '',
        'badge' => $m_badge,
    );
}

// Section F: Khối Khoảnh khắc & Mạng xã hội tràn viền (@ONTHEROCK Moments Gallery)
get_template_part('template-parts/sections/home/section-moments', null, array(
    'title_1'       => $moments_title_1,
    'title_2'       => $moments_title_2,
    'instagram_url' => $moments_ig_url,
    'facebook_url'  => $moments_fb_url,
    'items'         => $moments_items,
));

// 10. Cấu hình Đội ngũ (Meet The On The Rock Team) từ ACF
$team_marquee_text = get_field('team_marquee_text', $front_page_id) ?: 'MEET THE ON THE ROCK TEAM';

$fallback_team_photos = array(
    1 => array('name' => 'QUỲNH VÂN', 'role' => 'STORE MANAGER', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop'),
    2 => array('name' => 'TUẤN KIỆT', 'role' => 'BAR MANAGER', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop'),
    3 => array('name' => 'VĂN BẢO', 'role' => 'BAR CAPTAIN', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&auto=format&fit=crop'),
    4 => array('name' => 'THÀNH ĐỨC', 'role' => 'BAR CAPTAIN', 'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=800&auto=format&fit=crop'),
    5 => array('name' => 'HỒNG PHÚ', 'role' => 'BARTENDER', 'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&auto=format&fit=crop'),
);

$team_members = array();
for ($t = 1; $t <= 5; $t++) {
    $t_name  = get_field('team_member_name_' . $t, $front_page_id);
    $t_role  = get_field('team_member_role_' . $t, $front_page_id);
    $t_photo = get_field('team_member_photo_' . $t, $front_page_id);

    $photo_url = (!empty($t_photo) && is_array($t_photo)) ? $t_photo['url'] : (is_string($t_photo) && !empty($t_photo) ? $t_photo : $fallback_team_photos[$t]['photo']);

    $team_members[] = array(
        'name'  => !empty($t_name) ? $t_name : $fallback_team_photos[$t]['name'],
        'role'  => !empty($t_role) ? $t_role : $fallback_team_photos[$t]['role'],
        'photo' => $photo_url,
    );
}

// Section G: Khối Đội ngũ (Meet The On The Rock Team)
get_template_part('template-parts/sections/home/section-team', null, array(
    'marquee_text' => $team_marquee_text,
    'members'      => $team_members,
));

get_footer();