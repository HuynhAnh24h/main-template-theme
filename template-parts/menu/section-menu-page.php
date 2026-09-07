<?php
/**
 * Forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_template_part('template-parts/sections/menu/section-menu-page', null, isset($args) ? $args : array());
