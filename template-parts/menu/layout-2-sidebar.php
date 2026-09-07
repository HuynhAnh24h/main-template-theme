<?php
/**
 * Forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_template_part('template-parts/sections/menu/layout-2-sidebar', null, isset($args) ? $args : array());
