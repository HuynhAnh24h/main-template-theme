<?php
/**
 * Header forwarder for backward compatibility
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_template_part( 'template-parts/components/site-header', null, isset( $args ) ? $args : array() );
