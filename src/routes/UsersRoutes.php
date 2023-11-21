<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\routes;

use src\endpoints\UsersEndpoint;


class UsersRoutes{

  public static function register(){



    // LOGA USUÁRIO
    add_action('rest_api_init', function () {
      register_rest_route('api', '/users', array(
          'methods' => 'POST',
          'callback' => [new UsersEndpoint(), 'login']
      ));
    });

    // // BUSCA 1 RELATÓRIO
    // add_action('rest_api_init', function () {
    //   register_rest_route('api', '/reports/read', array(
    //       'methods' => 'GET',
    //       'callback' => [new ReportsEndpoint(), 'read']
    //   ));
    // });

    // // LISTA TODOS RELATÓRIO
    // add_action('rest_api_init', function () {
    //   register_rest_route('api', '/reports/list', array(
    //       'methods' => 'GET',
    //       'callback' => [new ReportsEndpoint(), 'list']
    //   ));
    // });

  }

}
