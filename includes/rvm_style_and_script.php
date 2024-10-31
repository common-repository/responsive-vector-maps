<?php
// Initialize css for plugin initialization
/**
 * STYLE & SCRIPT SECTION
 * ----------------------------------------------------------------------------
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'init', 'rvm_add_styles' );
function rvm_add_styles()
{
    wp_register_style( 'rvm_jvectormap_css', RVM_CSS_PLUGIN_DIR . '/jquery-jvectormap-2.0.4.css', '2.0.4' );
    wp_register_style( 'rvm_settings_css', RVM_CSS_PLUGIN_DIR . '/rvm_settings.css', '', '1.8' );
    wp_register_style( 'rvm_general_css', RVM_CSS_PLUGIN_DIR . '/rvm_general.css', '', '1.1' );
}
// Make the style available for public pages after main theme style
add_action( 'wp_enqueue_scripts', 'rvm_add_style', 11 );
function rvm_add_style()
{
    wp_enqueue_style( 'rvm_jvectormap_css' );
    wp_enqueue_style( 'rvm_general_css' );
}
//Register script to WP
add_action( 'init', 'rvm_add_scripts' );
function rvm_add_scripts()
{
    wp_register_script( 'rvm_jquery-jvectormap-js', RVM_JS_JVECTORMAP_PLUGIN_DIR . '/jquery-jvectormap-2.0.3.min.js', array(
         'jquery' 
    ), '2.0.3' ); //dependency from jquery
    //setting the dependency of following script to the above, means it will be loaded JUST if the parent is loaded
    wp_register_script( 'rvm_jquery-jvectormap-world_merc_js', RVM_JS_JVECTORMAP_PLUGIN_DIR . '/jquery-jvectormap-world_merc_en.js', array(
         'rvm_jquery-jvectormap-js' 
    ), '' );
    wp_register_script( 'rvm_jquery-jvectormap-it_merc_js', RVM_JS_JVECTORMAP_PLUGIN_DIR . '/jquery-jvectormap-it_merc_en.js', array(
         'rvm_jquery-jvectormap-js' 
    ), '' );
    //Get custom maps if exist on DB
    $rvm_custom_maps_options = rvm_retrieve_custom_maps_options();
    //Here $key is the javascript name and $value the path to javascript itself
    if ( !empty( $rvm_custom_maps_options ) ) {
        // get last value entered temporally
        $rvm_custom_maps_options = array_reverse( $rvm_custom_maps_options );
        foreach ( $rvm_custom_maps_options as $key => $value ) {
            $rvm_retrieve_custom_map_dir_and_url_path = rvm_retrieve_custom_map_dir_and_url_path( $value );
            // Check if custom map is still in original upload subdir: if not do not show it in drop down
            $rvm_is_map_in_download_dir_yet = rvm_is_map_in_download_dir_yet( $rvm_retrieve_custom_map_dir_and_url_path[ 0 ], $key );
            if ( $rvm_is_map_in_download_dir_yet ) {
                //@include $rvm_retrieve_custom_map_dir_and_url_path[ 0 ] . $key . '/rvm-cm-settings.php';
                //wp_register_script( 'rvm_jquery-jvectormap-' . $key , rvm_retrieve_custom_map_destination_url( $value ) .'/jquery-jvectormap-' . $key  . '.js', array( 'rvm_jquery-jvectormap-js' ), '' );
                wp_register_script( 'rvm_jquery-jvectormap-' . $key, $rvm_retrieve_custom_map_dir_and_url_path[ 1 ] . $key . '/jquery-jvectormap-' . $key . '.js', array(
                     'rvm_jquery-jvectormap-js' 
                ), '' );
            } //if ( $rvm_is_map_in_download_dir_yet )
        } //$rvm_custom_maps_options as $key => $value
    } //!empty( $rvm_custom_maps_options )
    //Get custom maps with new plugin installation system ( since dec 2019 ) if exist on DB
    //We're keeping old system too to allow previous doenloaded map to work anyway
    $rvm_custom_maps_options_for_plugin_path_system = rvm_retrieve_custom_maps_options_for_plugin_path_system();
    //Check if option exist in DB
    if ( !empty( $rvm_custom_maps_options_for_plugin_path_system ) ) {
        // get last value entered temporally
        $rvm_custom_maps_options_for_plugin_path_system = array_reverse( $rvm_custom_maps_options_for_plugin_path_system );
        // Sort regions alphabetically
        ksort( $rvm_custom_maps_options_for_plugin_path_system );
        foreach ( $rvm_custom_maps_options_for_plugin_path_system as $key => $value ) {
            //@include RVM_GENERAL_PLUGIN_DIR_PATH . $key . '/rvm-cm-settings.php';
            wp_register_script( 'rvm_jquery-jvectormap-' . $key, RVM_GENERAL_PLUGIN_DIR_URL . $key . '/jquery-jvectormap-' . $key . '.js', array(
                 'rvm_jquery-jvectormap-js' 
            ), '' );
        } // foreach ( $rvm_custom_maps_options_for_plugin_path_system as $key => $value
    } //if ( !empty( $rvm_custom_maps_options_for_plugin_path_system ) 
    wp_register_script( 'rvm_general_js', RVM_JS_PLUGIN_DIR . '/rvm_general.js', array(
         'jquery' 
    ), '', true );
    wp_register_script( 'rvm_custom_posts_js', RVM_JS_PLUGIN_DIR . '/rvm_custom_posts.js', array(
         'jquery' 
    ), '', true );
    //Load classList.js polyfill just in case Browser is Microsoft <=9
    //$browser = preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version);
    global $is_IE;
    if ( $is_IE ) {
        wp_register_script( 'class_list_js', RVM_JS_PLUGIN_DIR . '/classList.js', array(), '', false );
    }
    wp_register_script( 'rvm_toggle_default_cards_js', RVM_JS_PLUGIN_DIR . '/rvm_toggle_default_cards.js', array(
        'rvm_jquery-jvectormap-js' 
    ), '', true );
    
    //Localize in javascript rvm_general_js
    wp_localize_script( 'rvm_custom_posts_js', 'objectL10n', array(
         'loading' => esc_html__( 'Loading...', 'responsive-vector-maps' ),
        'marker_name' => esc_html__( 'Name', 'responsive-vector-maps' ),
        'marker_lat' => esc_html__( 'Latitude', 'responsive-vector-maps' ),
        'marker_long' => esc_html__( 'Longitude', 'responsive-vector-maps' ),
        'marker_link' => esc_html__( 'Link', 'responsive-vector-maps' ),
        'marker_dim' => esc_html__( 'Dimension', 'responsive-vector-maps' ),
        'marker_popup' => esc_html__( 'Popup label', 'responsive-vector-maps' ),
        'marker_remove' => esc_html__( 'Remove', 'responsive-vector-maps' ),
        'marker_dim_expl' => esc_html__( 'Use only integer or decimal', 'responsive-vector-maps' ),
        'marker_dim_placeholder' => esc_html__( 'e.g. 591.20', 'responsive-vector-maps' ),
        'marker_popup_placeholder' => esc_html__( 'e.g. Rome precipitation (mm) long term averages', 'responsive-vector-maps' ),
        'unzip_custom_map' => esc_html__( 'Unzip custom map', 'responsive-vector-maps' ),
        'unzipping' => esc_html__( 'Installing Map...', 'responsive-vector-maps' ),
        'registering' => esc_html__( 'Registering...', 'responsive-vector-maps' ),
        'no_map_selected' => esc_html__( 'Oops, seems someone needs to select a map first, correct?', 'responsive-vector-maps' ),
        //set the path for javascript files
        'images_js_path' => RVM_IMG_PLUGIN_DIR, //path for images to be called from javascript  
        'markers_correctly_imported' => wp_kses_post( __( 'Markers correctly imported. Remember <strong>to update this post</strong> in order to save imported markers into database.', 'responsive-vector-maps' ) ),
        'regions_correctly_imported' => wp_kses_post( __( 'Subdivisions correctly imported. Remember <strong>to update this post</strong> in order to save imported subdivisions into database', 'responsive-vector-maps' ) ),
        'show_custom_tag_label' => esc_html__( 'Show following tag (use ID selector without "#")', 'responsive-vector-maps' ),
        'load_correct_file' => esc_html__( 'Please import the correct file with this exact name:', 'responsive-vector-maps' ),
        'close_preview' => esc_html__( 'Close preview', 'responsive-vector-maps' )
    ) );
    //Localize in javascript rvm_admin_js
    wp_localize_script( 'rvm_admin_js', 'objectL10n', array(
         'unzipping' => esc_html__( 'Installing Marker Module...', 'responsive-vector-maps' ),
        'registering' => esc_html__( 'Registering...', 'responsive-vector-maps' ),
        'no_marker_module_selected' => esc_html__( 'Oops, seems someone needs to select a marker module first, correct?', 'responsive-vector-maps' ),
        //set the path for javascript files
        'images_js_path' => RVM_IMG_PLUGIN_DIR //path for images to be called from javascript  
    ) );
}
// Make the style available just for plugin settings page
add_action( 'admin_enqueue_scripts', 'rvm_add_settings_styles' );
function rvm_add_settings_styles( $hook )
{
    if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
        wp_enqueue_style( 'wp-color-picker' ); // default WP colour picker
        wp_enqueue_style( 'rvm_settings_css' );
        wp_enqueue_style( 'rvm_general_css' );
        wp_enqueue_style( 'rvm_jvectormap_css' );
    } //'post.php' == $hook || 'post-new.php' == $hook
}
// Make the script available just for plugin post pages
add_action( 'admin_enqueue_scripts', 'rvm_add_settings_scripts' );
function rvm_add_settings_scripts( $hook )
{
    if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'rvm_general_js' );
        wp_enqueue_script( 'rvm_custom_posts_js' );
        wp_enqueue_script( 'rvm_jquery-jvectormap-js' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_media(); //for media uploader
        wp_enqueue_script( 'rvm_jquery-jvectormap-it_merc_js' );
        wp_enqueue_script( 'rvm_jquery-jvectormap-world_merc_js' );
        // Retrieve options
        $rvm_options = rvm_retrieve_options();
        //Remove emoji error in console
        if ( !empty( $rvm_options[ 'rvm_option_dequeue_wp_emoji' ] ) ) {
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        }
        //Get custom maps if exist on DB
        $rvm_custom_maps_options = rvm_retrieve_custom_maps_options();
        //Here $key is the javascript name and $value the path to javascript itself
        if ( !empty( $rvm_custom_maps_options ) ) {
            // get last value entered temporally
            $rvm_custom_maps_options = array_reverse( $rvm_custom_maps_options );
            foreach ( $rvm_custom_maps_options as $key => $value ) {
                $rvm_retrieve_custom_map_dir_and_url_path = rvm_retrieve_custom_map_dir_and_url_path( $value );
                // Check if custom map is still in original upload subdir: if not do not show it in drop down
                $rvm_is_map_in_download_dir_yet = rvm_is_map_in_download_dir_yet( $rvm_retrieve_custom_map_dir_and_url_path[ 0 ], $key );
                if ( $rvm_is_map_in_download_dir_yet ) {
                    wp_enqueue_script( 'rvm_jquery-jvectormap-' . $key, $rvm_retrieve_custom_map_dir_and_url_path[ 1 ] . $key . '/jquery-jvectormap-' . $key . '.js', array(
                        'rvm_jquery-jvectormap-js' 
                   ), '', true );
                } //if ( $rvm_is_map_in_download_dir_yet )
            } //$rvm_custom_maps_options as $key => $value
        } //!empty( $rvm_custom_maps_options )
        //Get custom maps with new plugin installation system ( since dec 2019 ) if exist on DB
        //We're keeping old system too to allow previous doenloaded map to work anyway
        $rvm_custom_maps_options_for_plugin_path_system = rvm_retrieve_custom_maps_options_for_plugin_path_system();
        //Check if option exist in DB
        if ( !empty( $rvm_custom_maps_options_for_plugin_path_system ) ) {
            // get last value entered temporally
            $rvm_custom_maps_options_for_plugin_path_system = array_reverse( $rvm_custom_maps_options_for_plugin_path_system );
            // Sort regions alphabetically
            ksort( $rvm_custom_maps_options_for_plugin_path_system );
            foreach ( $rvm_custom_maps_options_for_plugin_path_system as $key => $value ) {
                wp_enqueue_script( 'rvm_jquery-jvectormap-' . $key, RVM_GENERAL_PLUGIN_DIR_URL . $key . '/jquery-jvectormap-' . $key . '.js', array(
                    'rvm_jquery-jvectormap-js' 
               ), '', true );
            } // foreach ( $rvm_custom_maps_options_for_plugin_path_system as $key => $value
        } //if ( !empty( $rvm_custom_maps_options_for_plugin_path_system ) 
        wp_enqueue_script( 'rvm_toggle_default_cards_js', RVM_JS_PLUGIN_DIR . '/rvm_toggle_default_cards.js', array(
            'jquery' 
        ), '', true );
    } //'post.php' == $hook || 'post-new.php' == $hook
}
// Add scripts just for admin settings page
add_action( 'admin_print_scripts-settings_page_rvm_options_page', 'rvm_add_admin_settings_scripts' );
function rvm_add_admin_settings_scripts()
{
    wp_enqueue_media(); //for media uploader
    wp_enqueue_script( 'rvm_general_js' );        
    wp_enqueue_style( 'rvm_settings_css' );
}
// Make the scripts available for public pages
add_action( 'wp_enqueue_scripts', 'rvm_add_pub_scripts' );
function rvm_add_pub_scripts()
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'rvm_jquery-jvectormap-js' );
    global $is_IE;
    if ( $is_IE ) {
        wp_enqueue_script( 'class_list_js' );
    }
    // Retrieve options
    $rvm_options = rvm_retrieve_options();
    //Remove emoji error in console
    if ( !empty( $rvm_options[ 'rvm_option_dequeue_wp_emoji' ] ) ) {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }
}
?>