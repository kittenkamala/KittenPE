<?php
/*
* @package kittenPE
*/
/**
 * Plugin Name:       KittenPE Kitten Python Embedder 
 * Plugin URI:        https://kittenkamala.com/kittenpe
 * Description:       Embed Python scripts into WordPress blog posts.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Amy Kamala
 * Author URI:        https://kittenkamala.com
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kittenpe
 **/



defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class kittenPE {

    function __construct() {
        add_action( 'init', array($this, 'register_style'));
        add_action( 'init', array($this, 'enqueue_style'));
    } #todo
  
  //register stylesheet on plugin initialization
  function register_style(){
      wp_register_style( 'test_style', plugins_url('/css/test_style.css', __FILE__), false, '1.0.0', 'all'); 
  }
  //enqueue stylesheet on initialization 
  function enqueue_style(){
      wp_enqueue_style( 'test_style' ); #todo, make this for plugin admin and posts only 
  }


  //activation #todo
  function activate() {
      //include plugin stylesheet
      //flush rewrite rules 
  }

  //deactivation #todo
  function deactivate() {
      //flush rewrite rules 
  }

  //uninstall #todo
  function uninstall()
  {
      // #todo delete plugin data from db (not specified as part of this test so leaving it out for now)
    }

   public static function pythonEmbed( $attributes )
{
    $data = shortcode_atts(
        [
            'file' => 'hello.py'
        ],
        $attributes
    );

    $handle = popen( __DIR__ . '/' . $data['file'] . ' 2>&1', 'r' );
    $read = '';

    while ( ! feof( $handle ) )
    {
        $read .= fread( $handle, 2096 );
    }

    pclose( $handle );

    return $read;
}

}

if ( class_exists( 'kittenPE' )) {
  $kittenPE = new kittenPE();
}

register_activation_hook( __FILE__, array( $kittenPE, 'activate'));
register_deactivation_hook( __FILE__, array( $kittenPE, 'deactivate'));
add_shortcode( 'python', array( $kittenPE , 'pythonEmbed' ) );



