<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\routes;

// TODAS AS ROTAS DEVEM SER INSTANCIADAS AQUI

class InitRoutes{

  public static function register(){

    ReportsRoutes::register();

  }

}
