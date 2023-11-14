<?php

/*
 * Plugin Name:       PDF PLUGIN
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


$plugin_dir = WP_PLUGIN_DIR . '/pdf-api';


require_once($plugin_dir . "/custom-post-type/produto.php");
require_once($plugin_dir . "/custom-post-type/transacao.php");

require_once($plugin_dir . "/endpoints/usuario_post.php");
require_once($plugin_dir . "/endpoints/usuario_get.php");
require_once($plugin_dir . "/endpoints/pdf_generator.php");
require_once($plugin_dir . "/endpoints/forms-test.php");




// Function to JWT Token expire time
function api_expire_token(){
  return time() + (60*60*24); // 1d
}

add_action('jwt_auth_expire', 'api_expire_token');

?>
