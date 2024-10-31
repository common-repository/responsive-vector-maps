<?php
/**
 * WIDGET SECTION
 * ----------------------------------------------------------------------------
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// use widgets_init action hook to execute custom function
add_action( 'widgets_init', 'rvm_register_widgets' );
//register our widget
function rvm_register_widgets( ) {
                register_widget( 'rvm_widget' );
}
//Since WP version 4.3 use construct for widget
    class rvm_widget extends WP_Widget {
                    //process the new widget
                    function __construct( ) {
                                    parent::__construct( 'rvm_widget', // Base ID
                                                    RVM_PLUGIN_NAME, // Name
                                                    array(
                                                        'description' => RVM_PLUGIN_WIDGET_DESCR,
                                                    'classname' => 'rvm_widget'
                                    ) // Args
                                                    );
                    }
                    function form( $instance ) {
                                    //here we need just the post/map aid and we're done, we can create the shortcode
                                    //Create da loop through the maps post type
                                    $loop = new WP_Query( array(
                                                        'post_type' => 'rvm'
                                    ) );
                                    if ( $loop->have_posts() ) {
?>

                                                    <select name="<?php
                                                                    echo esc_html( $this->get_field_name( 'rvm_map_id' ) ); ?>">
                                                                    <option value="no_choice" <?php
                                                                    if ( isset( $instance[ 'rvm_map_id' ] ) ) {
                                                                                    selected( $instance[ 'rvm_map_id' ], 'no_choice' );
                                                                    } //isset( $instance[ 'rvm_map_id' ] )
                                                                    ?>>Select one map...</option>

                                                    <?php
                                                                    while ( $loop->have_posts() ) {
                                                                                    $loop->the_post();
                                                    ?>
                                                                                    <option value="<?php echo esc_attr( get_the_ID() ); ?>" <?php
                                                                                    if ( isset( $instance[ 'rvm_map_id' ] ) ) {
                                                                                                    selected( $instance[ 'rvm_map_id' ], get_the_ID() );
                                                                                    } //isset( $instance[ 'rvm_map_id' ] )
                                                                                    ?>> <?php echo esc_html( get_the_title() ); ?> </option>

                                                    <?php
                                                                    } //while ( $loop->have_posts() )
                                                    ?>

                                                    </select>

                    <?php
                                    } //if ( $loop->have_posts() )
                    } //function form ( $instance )
                    function update( $new_instance, $old_instance ) {
                                    $instance                 = $old_instance;
                                    $instance[ 'rvm_map_id' ] = $new_instance[ 'rvm_map_id' ];
                                    return $instance;
                    }
                    //display the widget only if a map was selected
                    function widget( $args, $instance ) {
                                    if ( $instance[ 'rvm_map_id' ] != 'no_choice' ) {
                                                    extract( $args );
                                                    echo wp_kses_post( $before_widget );
                                                    $rvm_mbe_width = get_post_meta( $instance[ 'rvm_map_id' ], '_rvm_mbe_width', true );
                                                    $rvm_mbe_width = !empty( $rvm_mbe_width ) ? ' width="' . $rvm_mbe_width . '"' : '';
                                                    // Use the shortcode to generate the map
                                                    echo do_shortcode( '[rvm_map mapid="' . esc_html( $instance[ 'rvm_map_id' ] ) . '" ' . esc_html( $rvm_mbe_width ) . ' ]' );
                                                    echo wp_kses_post( $after_widget );
                                    } //$instance[ 'rvm_map_id' ] != 'no_choice'
                    }
    }
?>