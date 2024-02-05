<?php
/**
 * Plugin Name: Media File Size WP
 * Plugin URI: https://github.com/thisisalamin/media-file-size-wp
 * Description: Media File Size WP is a WordPress plugin that allows you see the file size of media files in the media library.
 * Version: 1.0.0
 * Author: Mohamed Alamin
 * Author URI: https://www.linkedin.com/in/thisismdalamin/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: media-file-size-wp
 * Domain Path: /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define the plugin path
define( 'MFSW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

class Media_File_Size_WP {
    /**
     * Constructor method for the Media_File_Size_WP class.
     * Initializes the plugin by adding an action hook to the 'init' event.
     */
    public function __construct(){
        add_action( 'init', array( $this, 'init' ) );
    }
    
    /**
     * Initialization method for the plugin.
     * Requires the necessary files and initializes the required classes.
     */
    public function init() {
        add_filter( 'manage_media_columns', array( $this, 'add_media_columns' ) );
        add_action( 'manage_media_custom_column', array( $this, 'manage_media_custom_column' ), 10, 2 );
        add_filter( 'manage_upload_sortable_columns', array( $this, 'add_media_columns' ) );
        add_filter( 'views_upload', array( $this, 'remove_grid_view' ) );

    }

    /**
     * Add new column to media library
     */
    public function add_media_columns( $columns ) {
        $columns['file_size'] = __( 'File Size', 'media-file-size-wp' );
        return $columns;
    }

    /**
     * Add file size to new column
     */
    public function manage_media_custom_column( $column_name, $id ) {
        if ( $column_name === 'file_size' ) {
            $file = get_attached_file( $id );
            echo size_format( filesize( $file ) );
        }
    }

    public function manage_media_custom_column_content( $column_name, $id ) {
        if ( $column_name === 'file_size' ) {
            $file = get_attached_file( $id );
            echo size_format( filesize( $file ) );
        }
    }


    /**
     * Remove grid view in media library
     */
    public function remove_grid_view( $views ) {
        unset( $views['grid'] );
        return $views;
    }

}

new Media_File_Size_WP();