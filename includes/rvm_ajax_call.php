<?php
/**
 * AJAX CALLS
 * ----------------------------------------------------------------------------
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* Map Preview */
add_action( 'wp_ajax_rvm_preview', 'rvm_ajax_preview' );
function rvm_ajax_preview()
{
    if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'map' ] ) && sanitize_text_field( $_REQUEST[ 'map' ] ) != 'select_country' ) {
        // Verify that the incoming request is coming with the security nonce
        if ( wp_verify_nonce( sanitize_key( $_REQUEST[ 'nonce' ] ), 'rvm_ajax_nonce' ) ) {
            $output = do_shortcode('[rvm_map mapid="' . sanitize_text_field( $_REQUEST[ 'rvm_mbe_post_id' ] ) . '"]');
            wp_die( $output );
        } //wp_verify_nonce( $_REQUEST[ 'nonce' ], 'rvm_ajax_nonce' )
        else {
            wp_die( '<div class="rvm_messages rvm_error_messages">' . esc_html__( 'There was an issue with the preview generation tool', 'responsive-vector-maps' ) . '</div>' );
        }
    } //isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'map' ] ) && $_REQUEST[ 'map' ] != 'select_country'
    else {
        wp_die( '<div class="rvm_messages rvm_error_messages">' . esc_html__( 'Choose a valid map from the drop down menu', 'responsive-vector-maps' ) . '</div>' );
    }
} // add_action( 'wp_ajax_rvm_preview', 'rvm_ajax_preview' );
// Export Subdivisions to csv
add_action( 'wp_ajax_rvm_export_regions', 'rvm_ajax_export_regions' );
function rvm_ajax_export_regions()
{
    if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_mbe_select_map' ] ) && wp_verify_nonce( sanitize_key( $_REQUEST[ 'nonce' ] ), 'rvm_ajax_nonce' ) && current_user_can( 'edit_others_posts' ) ) {
        $array_regions = rvm_include_custom_map_settings( sanitize_text_field( $_REQUEST[ 'rvm_mbe_post_id' ] ), sanitize_text_field( $_REQUEST[ 'rvm_mbe_select_map' ] ) );
        // Sort regiosn alphabetically
        ksort( $array_regions );
        $data = array();
        foreach ( $array_regions as $region ) {
            // function regionsparams() can be found in rvm_core.php
            $regionsparams_array = regionsparams( sanitize_text_field( $_REQUEST[ 'rvm_mbe_post_id' ] ), $region[ 1 ] ); // get regions/
            $data[] = implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, array(
                 $region[ 1 ],
                $region[ 2 ],
                $regionsparams_array[ 'field_region_link' ],
                $regionsparams_array[ 'field_region_bg' ],
                $regionsparams_array[ 'field_region_popup' ],
                $regionsparams_array[ 'field_region_mouse_hover_over_colour' ],
                $regionsparams_array[ 'field_region_onclick_action' ] 
            ) );
        }
        $fp = fopen( 'php://output', 'w' );
        foreach ( $data as $line ) {
            $val = explode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $line );
            fputcsv( $fp, $val, ',', '"' );
        }
        fclose( $fp );
    } //isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_mbe_select_map' ] )
    wp_die();
}
// Import Subdivisions from csv file
add_action( 'wp_ajax_rvm_import_regions', 'rvm_ajax_import_regions' );
function rvm_ajax_import_regions()
{
    $output = '';
    if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_upload_regions_file_id' ] ) && wp_verify_nonce( sanitize_key( $_REQUEST[ 'nonce' ] ), 'rvm_ajax_nonce' ) && current_user_can( 'edit_others_posts' ) ) {
        //Validate file uploaded
        if ( rvm_is_valid_upload( sanitize_text_field( $_REQUEST[ 'rvm_upload_regions_file_id' ] ), sanitize_text_field( $_REQUEST[ 'rvm_mbe_select_map' ] ), 'regions', 'csv' ) ) {
            $rvm_imported_regions_array = array();
            $handle = fopen( get_attached_file( sanitize_text_field( $_REQUEST[ 'rvm_upload_regions_file_id' ] ) ), "r" );
            if ( empty( $handle ) === false ) {
                while ( ( $data = fgetcsv( $handle ) ) !== FALSE ) {
                    $rvm_imported_regions_array[] = $data;
                }
                fclose( $handle );
                for ( $i = 0; $i < count( $rvm_imported_regions_array ); $i++ ) {
                    $output .= '<div class="rvm_region_name rvm_region_hide"><h4><b>' . $rvm_imported_regions_array[ $i ][ 1 ] . '</b><span class="rvm_arrow"></span></h4></div>';
                    //If id structure name changes, please update accordingly on rvm_general.js row 56
                    $output .= '<div id="rvm_region_' . $rvm_imported_regions_array[ $i ][ 0 ] . '"   class="rvm_regions_flex_wrapper">';
                    $output .= '<div class="rvm_regions_flex">';
                    if ( isset( $rvm_imported_regions_array[ $i ][ 6 ] ) ) {
                        //In case user choose to open a link in the action we escape the db entry with esc_url WP built-in feature
                        if ( $rvm_imported_regions_array[ $i ][ 6 ] == 'open_link' || empty( $rvm_imported_regions_array[ $i ][ 6 ] ) ) {
                            $output .= '<div id="rvm_region_input_link_' . $rvm_imported_regions_array[ $i ][ 0 ] . '" class="rvm_regions_input rvm_regions_wrapper_link"><label for="' . __( 'Subdivisions name', 'responsive-vector-maps' ) . '" ' . RVM_LABEL_CLASS . ' >' . __( 'Link', 'responsive-vector-maps' ) . '</label><input ' . RVM_REGION_LINK_CLASS . ' type="text" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]" value="' . $rvm_imported_regions_array[ $i ][ 2 ] . '"></div>'; //.rvm_regions_input
                        }
                        //case user selected to open onto custom tag
                        else if ( $rvm_imported_regions_array[ $i ][ 6 ] == 'show_custom_selector' ) {
                            $output .= '<div id="rvm_region_input_link_' . $rvm_imported_regions_array[ $i ][ 0 ] . '" class="rvm_regions_input rvm_regions_wrapper_link"><label for="' . __( 'Subdivisions name', 'responsive-vector-maps' ) . '" ' . RVM_LABEL_CLASS . ' >' . __( 'Show following tag (use ID selector without "#")', 'responsive-vector-maps' ) . '</label><input ' . RVM_REGION_LINK_CLASS . ' type="text" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]" value="' . rvm_delete_first_character( $rvm_imported_regions_array[ $i ][ 2 ], '#' ) . '"></div>'; //.rvm_regions_input
                        } else {
                            $output .= '<div id="rvm_region_input_link_' . $rvm_imported_regions_array[ $i ][ 0 ] . '" class="rvm_regions_input rvm_regions_wrapper_link rvm_hide"><label for="' . __( 'Fake input field just for serializing consistency', 'responsive-vector-maps' ) . '" ' . RVM_LABEL_CLASS . ' >' . __( 'Open label on default', 'responsive-vector-maps' ) . '</label><input ' . RVM_REGION_LINK_CLASS . ' type="text" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]" value="' . $rvm_imported_regions_array[ $i ][ 2 ] . '"></div>'; //.rvm_regions_input
                        }
                    } else {
                        $output .= '<div id="rvm_region_input_link_' . $rvm_imported_regions_array[ $i ][ 0 ] . '" class="rvm_regions_input rvm_regions_wrapper_link"><label for="' . __( 'Subdivisions name', 'responsive-vector-maps' ) . '" ' . RVM_LABEL_CLASS . ' >' . __( 'Link', 'responsive-vector-maps' ) . '</label><input ' . RVM_REGION_LINK_CLASS . ' type="text" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]" value=""></div>'; //.rvm_regions_input
                    }
                    //$output .= '</div>';//.rvm_regions_labelinput_wrapper
                    $output .= '<div class="rvm_regions_input rvm_regions_wrapper_bgcolor"><label for="' . __( 'Background color', 'responsive-vector-maps' ) . '" ' . RVM_LABEL_CLASS . ' >' . __( 'Background', 'responsive-vector-maps' ) . '</label><input class="rvm_color_picker" type="text" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]" value="' . $rvm_imported_regions_array[ $i ][ 3 ] . '"></div>'; //.rvm_regions_input
                    //$output .= '</div>';//.rvm_flex_regions
                    //$output .= '<div class="rvm_regions_flex">';
                    $output .= '<div class="rvm_regions_input rvm_regions_wrapper_popup"><label for="rvm_region_label_popup" ' . RVM_LABEL_CLASS . ' >' . __( 'Label popup', 'responsive-vector-maps' ) . '</label><textarea id="rvm_region_label_popup_' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '" rows="5" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]" >' . wp_unslash( $rvm_imported_regions_array[ $i ][ 4 ] ) . '</textarea></div>';
                    $output .= '<div class="rvm_regions_input rvm_regions_wrapper_hover_color"><label for="rvm_region_activate_on_mouse_over" ' . RVM_LABEL_CLASS . ' >' . __( 'Activate Mouse Over Background <br> <span class="rvm_small_text">hold  [SHIFT] key for multiple select</span>', 'responsive-vector-maps' ) . '</label><input  type="checkbox" class="rvm_region_checkbox rvm_region_checkbox_bg" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]"    ' . checked( 'checked', $rvm_imported_regions_array[ $i ][ 5 ], false ) . ' ></div>';
                    if ( isset( $rvm_imported_regions_array[ $i ][ 6 ] ) ) {
                        $output .= '<div class="rvm_regions_input rvm_regions_onclick_action"><label for="rvm_region_onclick_action" ' . RVM_LABEL_CLASS . ' >' . __( 'When click onto this subdivision: ', 'responsive-vector-maps' ) . '</label><select class="rvm_region_label_action" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]"><option ' . selected( 'open_link', $rvm_imported_regions_array[ $i ][ 6 ], false ) . ' value="open_link">' . __( 'Open link', 'responsive-vector-maps' ) . '</option><option ' . selected( 'open_label_onto_default_card', $rvm_imported_regions_array[ $i ][ 6 ], false ) . ' value="open_label_onto_default_card">' . __( 'Open label content onto default card', 'responsive-vector-maps' ) . '</option><option ' . selected( 'show_custom_selector', $rvm_imported_regions_array[ $i ][ 6 ], false ) . ' value="show_custom_selector">' . __( 'Show custom selector', 'responsive-vector-maps' ) . '</option></select>';
                    } else {
                        $output .= '<div class="rvm_regions_input rvm_regions_onclick_action"><label for="rvm_region_onclick_action" ' . RVM_LABEL_CLASS . ' >' . __( 'When click onto this subdivision: ', 'responsive-vector-maps' ) . '</label><select class="rvm_region_label_action" name="' . strval( $rvm_imported_regions_array[ $i ][ 0 ] ) . '[]"><option selcted="selected" value="open_link">' . __( 'Open link', 'responsive-vector-maps' ) . '</option><option value="open_label_onto_default_card">' . __( 'Open label content onto default card', 'responsive-vector-maps' ) . '</option><option value="show_custom_selector">' . __( 'Show custom selector', 'responsive-vector-maps' ) . '</option></select>';
                    }
                    $output .= '<input type="hidden" class="rvm_regions_sub_block" value="' . $rvm_imported_regions_array[ $i ][ 0 ] . '"></div>'; // this is needed in conjunction with the select .rvm_region_label_action to target correct link input field and change the label
                    $output .= '</div>'; //.rvm_flex_regions
                    $output .= '</div>'; //.rvm_regions_flex_wrapper
                } //for( $i=0; $i < count( $rvm_imported_regions_array[ 0 ] ); $i++ ) {
                $output .= '</div>'; // close id="rvm_regions_from_db"  
            }
     
        } //if rvm_is_valid_upload()  
        wp_die( wp_kses( $output, rvm_allowed_tags('regions-import') ) );
    } //if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_upload_regions_file_id' ] ) && wp_verify_nonce( $_REQUEST[ 'nonce' ], 'rvm_ajax_nonce' )) {  
}
// Export Markers to csv
add_action( 'wp_ajax_rvm_export_markers', 'rvm_ajax_export_markers' );
function rvm_ajax_export_markers()
{
    if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_mbe_select_map' ] ) && wp_verify_nonce( sanitize_key( $_REQUEST[ 'nonce' ] ), 'rvm_ajax_nonce' ) && current_user_can( 'edit_others_posts' ) ) {
        // function markers() can be found in rvm_core.php
        $marker_array_serialized = markers( sanitize_text_field( $_REQUEST[ 'rvm_mbe_post_id' ] ), 'retrieve', 'serialized' );
        $marker_array_unserialized = markers( sanitize_text_field( $_REQUEST[ 'rvm_mbe_post_id' ] ), 'retrieve', 'unserialized' );
        $rvm_marker_array_count = count( $marker_array_unserialized[ 'rvm_marker_name_array' ] ); // count element of the array starting from 1
        if ( is_array( $marker_array_unserialized[ 'rvm_marker_name_array' ] ) && $rvm_marker_array_count > 0 ) {
            //Export the csv file
            //header('Content-Type: text/csv');
            //header('Content-Disposition: attachment; filename="test.csv"');
            $data = array(
                //"'" . $rvm_marker_name_array_TEMP . "'",
                implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $marker_array_unserialized[ 'rvm_marker_name_array' ] ),
                implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $marker_array_unserialized[ 'rvm_marker_lat_array' ] ),
                implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $marker_array_unserialized[ 'rvm_marker_long_array' ] ),
                implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $marker_array_unserialized[ 'rvm_marker_link_array' ] ),
                implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $marker_array_unserialized[ 'rvm_marker_dim_array' ] ),
                implode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $marker_array_unserialized[ 'rvm_marker_popup_array' ] ) 
            );
            $fp = fopen( 'php://output', 'w' );
            foreach ( $data as $line ) {
                $val = explode( RVM_CUSTOM_MAPS_PATHS_DELIMITER, $line );
                fputcsv( $fp, $val, ',', '"' );
            }
            fclose( $fp );
        } //if( is_array( $marker_array_unserialized[ 'rvm_marker_name_array' ] ) && $rvm_marker_array_count > 0  )
    } //if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) )
    wp_die();
}
// Import Markers from csv file
add_action( 'wp_ajax_rvm_import_markers', 'rvm_ajax_import_markers' );
function rvm_ajax_import_markers()
{
    $output = '';
    if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_upload_markers_file_id' ] ) && wp_verify_nonce( sanitize_key( $_REQUEST[ 'nonce' ] ), 'rvm_ajax_nonce' ) && current_user_can( 'edit_others_posts' ) ) {
        //Validate file uploaded
        if ( rvm_is_valid_upload( sanitize_text_field( $_REQUEST[ 'rvm_upload_markers_file_id' ] ), sanitize_text_field( $_REQUEST[ 'rvm_mbe_select_map' ] ), 'markers', 'csv' ) ) {
            $rvm_imported_markers_array = array();
            $handle = fopen( get_attached_file( sanitize_text_field( $_REQUEST[ 'rvm_upload_markers_file_id' ] ) ), "r" );
            if ( empty( $handle ) === false ) {
                while ( ( $data = fgetcsv( $handle ) ) !== FALSE ) {
                    $rvm_imported_markers_array[] = $data;
                }
                fclose( $handle );
                //Now create the markers blocks to be saved into db
                $output .= '<h4 class="rvm_title rvm_added_markers_title">' . __( 'Added Markers', 'responsive-vector-maps' ) . '</h4>';
                for ( $i = 0; $i < count( $rvm_imported_markers_array[ 0 ] ); $i++ ) {
                    $output .= '<div class="rvm_markers">';
                    $output .= '<p><label for="marker_name" class="rvm_label rvm_label_markers">' . __( 'Name', 'responsive-vector-maps' ) . '*</label><input type="text" name="rvm_marker_name[]" value="' . strip_tags( wp_unslash( $rvm_imported_markers_array[ 0 ][ $i ] ) ) . '" /></p>';
                    $output .= '<p><label for="marker_lat" class="rvm_label rvm_label_markers">' . __( 'Latitude', 'responsive-vector-maps' ) . '*</label><input type="text" name="rvm_marker_lat[]" value="' . strip_tags( $rvm_imported_markers_array[ 1 ][ $i ] ) . '" placeholder="e.g. 48.921537" /></p>';
                    $output .= '<p><label for="marker_long" class="rvm_label rvm_label_markers">' . __( 'Longitude', 'responsive-vector-maps' ) . '*</label><input type="text" name="rvm_marker_long[]" value="' . strip_tags( $rvm_imported_markers_array[ 2 ][ $i ] ) . '" placeholder="e.g. -66.829834" /></p>';
                    $output .= '<p><label for="marker_link" class="rvm_label rvm_label_markers">' . __( 'Link', 'responsive-vector-maps' ) . '</label><input type="text" name="rvm_marker_link[]" value="' . $rvm_imported_markers_array[ 3 ][ $i ] . '" /></p>';
                    $output .= '<p><label for="marker_dim" class="rvm_label rvm_label_markers">' . __( 'Dimension', 'responsive-vector-maps' ) . '<br><span class="rvm_small_text">' . __( 'Use only integer or decimal', 'responsive-vector-maps' ) . '</span></label><input type="text" name="rvm_marker_dim[]" value="' . strip_tags( $rvm_imported_markers_array[ 4 ][ $i ] ) . '" placeholder="' . __( 'e.g. 591.20', 'responsive-vector-maps' ) . '" /></p>';
                    $output .= '<p><label for="marker_popup" class="rvm_label rvm_label_markers" style="vertical-align:top;">' . __( 'Popup label', 'responsive-vector-maps' ) . '</label><textarea name="rvm_marker_popup[]" placeholder="' . __( 'e.g. Rome precipitation (mm) long term averages', 'responsive-vector-maps' ) . '" >' . wp_unslash( $rvm_imported_markers_array[ 5 ][ $i ] ) . '</textarea></p>';
                    $output .= '<input type="submit" class="rvm_remove_field button-secondary" value="' . __( 'Remove', 'responsive-vector-maps' ) . '">';
                    $output .= '</div>';
                }
            }
        } //if ( rvm_is_valid_upload() )   
        wp_die( wp_kses( $output, rvm_allowed_tags('markers-import') ) );
    } //if ( isset( $_REQUEST[ 'nonce' ] ) && isset( $_REQUEST[ 'rvm_mbe_post_id' ] ) && isset( $_REQUEST[ 'rvm_upload_markers_file_path' ] ) )
}
?>