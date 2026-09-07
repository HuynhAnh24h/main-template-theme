<?php
/**
 * Forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_template_part('template-parts/sections/booking/section-booking-atmosphere', null, isset($args) ? $args : array());
