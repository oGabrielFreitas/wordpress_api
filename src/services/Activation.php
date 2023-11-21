<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\services;

use src\models\ReportsModel;
use src\models\QuestionsModel;




class Activation{

  public static function register(){

    self::create_app_tables(); // Criar todas as tabelas

    flush_rewrite_rules(); // Limpa as regras (importante, nunca desativar)

  }

  private static function create_app_tables() {

    ReportsModel::register(); // Cria a tabela de Reports
    QuestionsModel::register(); // Cria a tabela de Perguntas



}

}
