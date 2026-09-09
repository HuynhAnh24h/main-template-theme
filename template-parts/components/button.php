<?php
/**
 * Component: Button
 * Description: Reusable button component with multiple style choices.
 *
 * Arguments ($args):
 * - text (string): Text content of the button.
 * - link (string): Custom URL link (default: '#').
 * - style (string): Button style style: 'outline', 'arrow', 'text-link', 'solid-dark', 'solid-light', 'solid-gold', 'solid-black' (default: 'solid-gold').
 * - target (string): Anchor target, e.g. '_self', '_blank' (default: '_self').
 * - addon (string): Optional text addon for the 'text-link' style, e.g. '20' for '[20]'.
 * - extra_class (string): Extra CSS classes to append.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

// Thiết lập các giá trị mặc định cho tham số truyền vào
$text        = isset($args['text']) ? $args['text'] : '';
$link        = isset($args['link']) ? $args['link'] : '#';
$style       = isset($args['style']) ? $args['style'] : 'solid-gold';
$target      = isset($args['target']) ? $args['target'] : '_self';
$addon       = isset($args['addon']) ? $args['addon'] : '';
$extra_class = isset($args['extra_class']) ? $args['extra_class'] : '';

// 1. Ánh xạ class Tailwind CSS dựa trên Kiểu nút bấm (Style)
$is_text_link = ($style === 'text-link');
$base_class   = $is_text_link 
    ? 'inline-flex items-center justify-center transition-all duration-300 ' 
    : 'btn-liquid-glass inline-flex items-center justify-center rounded-full text-xs font-medium tracking-[0.14em] uppercase select-none cursor-pointer ';

$style_classes = array(
    'outline'     => 'px-6 py-2.5',
    'arrow'       => 'w-10 h-10',
    'text-link'   => 'gap-1 text-[#caa875] hover:text-[#f7ebd8] border-b border-transparent hover:border-current pb-0.5 normal-case font-normal',
    'solid-dark'  => 'px-8 py-3.5',
    'solid-light' => 'px-8 py-3.5',
    'solid-gold'  => 'px-8 py-3.5',
    'solid-black' => 'px-8 py-3.5',
);

$chosen_style_class = isset($style_classes[$style]) ? $style_classes[$style] : $style_classes['solid-gold'];
$final_class = $base_class . $chosen_style_class . ' ' . $extra_class;

// 2. Render Nút bấm dựa trên kiểu
if ($style === 'arrow') :
    if (!empty($text)) :
        // Hiển thị cả cụm: Nút chữ Outline + Nút tròn mũi tên bên cạnh
        ?>
        <div class="inline-flex items-center gap-3 <?php echo esc_attr($extra_class); ?>">
            <!-- Nút chữ Outline -->
            <a href="<?php echo esc_url($link); ?>" class="btn-liquid-glass inline-flex items-center justify-center px-6 py-2.5 rounded-full text-xs font-medium uppercase tracking-[0.14em] transition-all duration-300" target="<?php echo esc_attr($target); ?>">
                <span class="btn-roll-wrap">
                    <span class="btn-roll-text">
                        <span><?php echo esc_html($text); ?></span>
                        <span aria-hidden="true"><?php echo esc_html($text); ?></span>
                    </span>
                </span>
            </a>
            <!-- Nút tròn mũi tên -->
            <a href="<?php echo esc_url($link); ?>" class="btn-liquid-glass inline-flex items-center justify-center w-10 h-10 rounded-full transition-all duration-300" target="<?php echo esc_attr($target); ?>" title="<?php echo esc_attr($text); ?>">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <?php
    else :
        // Chỉ hiển thị duy nhất nút tròn mũi tên
        ?>
        <a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($final_class); ?>" target="<?php echo esc_attr($target); ?>">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
        <?php
    endif;
elseif ($style === 'text-link') :
?>
    <a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($final_class); ?>" target="<?php echo esc_attr($target); ?>">
        <?php echo esc_html($text); ?>
        <?php if (!empty($addon)) : ?>
            <span class="text-[10px] text-gray-400 font-mono ml-0.5">[<?php echo esc_html($addon); ?>]</span>
        <?php endif; ?>
    </a>
<?php
else :
?>
    <a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($final_class); ?>" target="<?php echo esc_attr($target); ?>">
        <span class="btn-roll-wrap">
            <span class="btn-roll-text">
                <span><?php echo esc_html($text); ?></span>
                <span aria-hidden="true"><?php echo esc_html($text); ?></span>
            </span>
        </span>
    </a>
<?php
endif;
