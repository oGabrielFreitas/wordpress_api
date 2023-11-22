<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\routes;

use src\services\reports\PdfGenerator;
use src\endpoints\ReportsEndpoint;

class ReportsRoutes
{

    public static function register()
    {


        // GERAR RELATÓRIO EM PDF
        add_action('rest_api_init', function () {
            register_rest_route('api', '/pdf', array(
                'methods' => 'GET',
                'callback' => [new PdfGenerator(), 'handle']
            ));
        });

        // INSERE RELATÓRIO
        add_action('rest_api_init', function () {
            register_rest_route('api', '/reports/create', array(
                'methods' => 'POST',
                'callback' => [new ReportsEndpoint(), 'create']
            ));
        });

        // BUSCA 1 RELATÓRIO
        add_action('rest_api_init', function () {
            register_rest_route('api', '/reports/read', array(
                'methods' => 'GET',
                'callback' => [new ReportsEndpoint(), 'read']
            ));
        });

        // LISTA TODOS RELATÓRIO
        add_action('rest_api_init', function () {
            register_rest_route('api', '/reports/list', array(
                'methods' => 'GET',
                'callback' => [new ReportsEndpoint(), 'list']
            ));
        });
    }
}
