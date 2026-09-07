<?php
/**
 * Footer forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_template_part( 'template-parts/components/site-footer', null, isset( $args ) ? $args : array() );
