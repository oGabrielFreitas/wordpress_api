<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

/*
 * Plugin Name:       ILS API
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           2
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


defined ('ABSPATH') or die ('Hey, what are you trying to do here?');

if (file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' )){
  require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

class IlsApi{

  function __construct(){

  }

  function activate(){

    src\services\Activation::register();

  }

  function deactivate(){

  }

  function uninstall(){

  }

  function register(){

    src\routes\InitRoutes::register();

  }

}


if (class_exists('IlsApi')) {
  $IlsApi = new IlsApi();
  $IlsApi->register();
}

register_activation_hook( __FILE__, array( $IlsApi , 'activate') );
register_deactivation_hook( __FILE__, array( $IlsApi , 'deactivate') );



// Function to JWT Token expire time
function api_expire_token(){
  return time() + (60*60*24); // 1d
}

add_action('jwt_auth_expire', 'api_expire_token');


$plugin_dir = WP_PLUGIN_DIR . '/pdf-api';
require_once($plugin_dir . "/endpoints/usuario_post.php");

require_once($plugin_dir . "/custom-post-type/produto.php");




?>
