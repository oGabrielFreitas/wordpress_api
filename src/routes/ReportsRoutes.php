<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\routes;

use src\services\reports\PdfGenerator;


// require_once WP_PLUGIN_DIR . '/pdf-api/src/services/Reports/PdfGenerator.php';




class ReportsRoutes{

  public static function register(){


    // GERAR RELATÓRIO EM PDF
    add_action('rest_api_init', function () {
      register_rest_route('api', '/pdf', array(
          'methods' => 'GET',
          'callback' => [new PdfGenerator(), 'handle']
      ));
    });

  }

}
