<?php
/**
 * DONATION
 * ----------------------------------------------------------------------------
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$output .= '<div id="rvm_donation" class="rvm_hidden_when_custom_map"><p>' . esc_html__( 'Do you like RVM? Please consider making a donation now' , 'responsive-vector-maps' )   . '<a class="rvm_donate_link" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40responsivemapsplugin%2ecom&lc=IT&item_name=responsive%20Vector%20Maps%20Plugin&item_number=rvm%2dplugin%2dwordpress%2dadmin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" target="_blank">
<img style="vertical-align:middle;margin-left:5px;" src="' . RVM_IMG_PLUGIN_DIR . '/donate_button.png" /></a></p></div>' ;
?>