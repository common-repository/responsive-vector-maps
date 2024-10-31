<?php
/**
 * GLOBAL SETTINGS ( OPTIONS PAGE )
 * ----------------------------------------------------------------------------
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Add settings link on plugin page
add_filter( 'plugin_action_links_' . RVM_PLUGIN_FILE, 'rvm_settings_link' );
function rvm_settings_link( $links )
{
    $settings_link = '<a href="options-general.php?page=rvm_options_page.php">' . esc_html__( 'Settings', 'responsive-vector-maps' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
// Add a menu for our option page
add_action( 'admin_menu', 'rvm_options_add_page' );
function rvm_options_add_page()
{
    add_options_page( esc_html__( 'RVM settings', 'responsive-vector-maps' ), // Page title on browser bar 
        esc_html__( 'RVM global settings', 'responsive-vector-maps' ), // menu item text
        'manage_options', // only administartors can open this
        'rvm_options_page', // unique name of settings page
        'rvm_options_form' //call to fucntion which creates the form
        );
}
// Register and define the settings
add_action( 'admin_init', 'rvm_admin_init' );
function rvm_admin_init()
{
    register_setting( 'rvm_settings', 'rvm_options', '' 
    //,'rvm_validate_options' non need of validation at the moment
        );
    add_settings_section( //Main settings 
        'rvm_main_settings', //id
        esc_html__( 'Main settings', 'responsive-vector-maps' ), //title
        'rvm_section_main', //callback
        'rvm_options_page' //page
        );
    add_settings_field( 'rvm_option_dequeue_wp_emoji', //id
        esc_html__( 'Disable wp_emoji', 'responsive-vector-maps' ), //title
        'rvm_settings_field', //callback
        'rvm_options_page', //page
        'rvm_main_settings', //section
        array( // The $args
         'rvm_option_dequeue_wp_emoji', // Should match Option ID
        'checkbox' 
    ) );
}
// Add forms to options page
function rvm_section_main()
{
}
// Add fields to options page
function rvm_settings_field( $args )
{
    $output = '';
    // Retrieve options
    $rvm_options = rvm_retrieve_options();
    if ( $args[ 1 ] == 'checkbox' ) {
        $rvm_option_dequeue_wp_emoji = !empty( $rvm_options[ $args[ 0 ] ] ) ? 'checked="checked"' : '';
        $output .= '<input  ' . $rvm_option_dequeue_wp_emoji . ' type="' . $args[ 1 ] . '" name="rvm_options[' . $args[ 0 ] . ']" id="' . $args[ 0 ] . '" /><span>' . __( 'In case you may notice issues related to wp_emoji enable following checkbox. It\'s well documented this script has problems with svg ( vector images ) on which RVM relies on.', 'responsive-vector-maps' ) . '</span>';
    }
    // All options need to be declared here, otherwise WP will get rid in DB of non declared value 
    $rvm_version = !empty( $rvm_options[ 'ver' ] ) ? $rvm_options[ 'ver' ] : RVM_VERSION;
    $output .= '<input type="hidden" value="' . $rvm_version . '" id="rvm_version" name="rvm_options[ver]"/>';
    echo wp_kses( $output, rvm_allowed_tags('core') );
}
// Add forms to options page
function rvm_options_form()
{
?>    
    <div class="wrap">
        <h2><?php esc_html( esc_html_e( 'RVM global settings', 'responsive-vector-maps' ) ); ?></h2>
        <form action="options.php" method="post" id="rvm_options_form">
        <?php settings_fields( 'rvm_settings' );?>
        <?php do_settings_sections( 'rvm_options_page' );?>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'responsive-vector-maps' );?>" />
        </p>
        </form>
    </div>
    
<?php
}
?>