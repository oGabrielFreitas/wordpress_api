<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\routes;

use src\services\reports\PdfGenerator;
use src\endpoints\ReportsEndpoint;

use src\helpers\ValidateJWT;

class ReportsRoutes
{

    public static function register()
    {

        add_action('rest_api_init', function () {

            // GERAR RELATÓRIO EM PDF
            register_rest_route('api', '/pdf', array(
                'methods' => 'GET',
                'callback' => [new PdfGenerator(), 'handle']
            ));

            // INSERE RELATÓRIO
            register_rest_route('api', '/reports/create', array(
                'methods' => 'POST',
                'callback' => [new ReportsEndpoint(), 'create']
            ));

            // BUSCA 1 RELATÓRIO
            register_rest_route('api', '/reports/read/(?P<id>\d+)', array(
                'methods' => 'GET',
                'callback' => [new ReportsEndpoint(), 'read'],
                // 'permission_callback' => [new ValidateJWT(), 'is_validated'], // Apenas usuários logados
            ));

            // LISTA TODOS RELATÓRIO
            register_rest_route('api', '/reports/list', array(
                'methods' => 'GET',
                'callback' => [new ReportsEndpoint(), 'list'],
                // 'permission_callback' => [new ValidateJWT(), 'is_validated'], // Apenas usuários logados

            ));
        });
    }
}
