<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\routes;

use src\endpoints\UsersEndpoint;
use src\helpers\ValidateJWT;

class UsersRoutes
{

    public static function register()
    {


        // LOGA USUÁRIO
        add_action('rest_api_init', function () {
            register_rest_route('api', '/users', array(
                'methods' => 'POST',
                'callback' => [new UsersEndpoint(), 'login'],
                // 'permission_callback' => function () {
                //   return current_user_can( 'edit_others_posts' );
                // }
            ));
        });

        // VALIDA USUÁRIO ( DESATIVAR DEPOIS ) - MODELO PARA PERMISSION_CALLBACK
        add_action('rest_api_init', function () {
            register_rest_route('api', '/users/validate', array(
                'methods' => 'POST',
                'callback' => function () {
                    return rest_ensure_response('Autenticado'); // FUNÇÃO AUTORIZADA
                },
                'permission_callback' => [new ValidateJWT(), 'is_validated'],
            ));
        });

        // ( MANTER DESATIVADA )
        // TESTE DA PERMISSION CALL_BACK VALIDAÇÃO DE USUÁRIO
        add_action('rest_api_init', function () {
            register_rest_route('api', '/users/validate_test', array(
                'methods' => 'POST',
                'callback' => [new ValidateJWT(), 'is_validated'],
                // 'permission_callback' => function () {
                //   return current_user_can( 'edit_others_posts' );
                // }
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
