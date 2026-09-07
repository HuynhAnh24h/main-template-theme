<?php
/**
 * Forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_template_part('template-parts/sections/contact/section-contact-info', null, isset($args) ? $args : array());
