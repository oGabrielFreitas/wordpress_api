<?php
/**
 * @package GabrielPlugin
 */

/*
 * Plugin Name:       PDF PLUGIN CERTO
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Lance no Digital
 * Author URI:        https://lancenodigital.com.br/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


if ( ! defined('ABSPATH')){
  echo 'There is some ABSPATH problem in your Wordpress';
  die;
}


class PdfApi{

  function __construct(){





  }

  function activate(){

    $this->custom_post_type(); // Não necessário, mas evita bugs
    // flush rewrite rules
    flush_rewrite_rules();

  }

  function deactivate(){

  }

  function uninstall(){


  }

  function start(){
    $this->create_post_type();
    require_once plugin_dir_path( __FILE__ ) . '/custom-post-type/produto.php';

    require_once plugin_dir_path( __FILE__ ) . '/endpoints/pdf_generator.php';


  }



  function create_post_type(){
    add_action( 'init', array( $this, 'custom_post_type') );

  }


  // Funções potencialmente úteis, que aprendi no curso

  function custom_post_type(){
    register_post_type( 'book', ['public' => true, 'label' => 'Books', 'show_ui' => true] );


  }

  function register() {
    add_action ('admin_enqueue_scripts', array($this, 'enqueue'));

  }

  function enqueue() {
    // Enfileirar todos meus scripts.
    wp_enqueue_style( 'mypluginstyle', plugins_url( '/src/scripts/mystyle.css', __FILE__ ) );
    wp_enqueue_script( 'mypluginscript', plugins_url( '/src/scripts/myscript.js', __FILE__ ) );

  }

}

if (class_exists('PdfApi')) {
  $PdfApi = new PdfApi();
  // $PdfApi->register();
  $PdfApi->start();
}

register_activation_hook( __FILE__, array( $PdfApi , 'activate') );
register_deactivation_hook( __FILE__, array( $PdfApi , 'deactivate') );

// Function to JWT Token expire time
function api_expire_token(){
  return time() + (60*60*24); // 1d
}

add_action('jwt_auth_expire', 'api_expire_token');











$plugin_dir = WP_PLUGIN_DIR . '/pdf-api';


require_once($plugin_dir . "/custom-post-type/produto.php");
require_once($plugin_dir . "/custom-post-type/transacao.php");

require_once($plugin_dir . "/endpoints/usuario_post.php");
require_once($plugin_dir . "/endpoints/usuario_get.php");
// require_once($plugin_dir . "/endpoints/pdf_generator.php");
require_once($plugin_dir . "/endpoints/forms-test.php");




?>
