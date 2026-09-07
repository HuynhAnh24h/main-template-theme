<?php
/**
 * Forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_template_part('template-parts/sections/menu/layout-3-columns', null, isset($args) ? $args : array());
