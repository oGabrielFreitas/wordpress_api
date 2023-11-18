<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\endpoints;

use src\models\ReportsModel;


class ReportsEndpoint{

  //NOME DA TABELA
  public static $table_name = 'ilsapi_reports';


  public function create($request){

    // Os sanitize é uma função do Wordpress que evita entradas maliciosas
    $nome = sanitize_text_field( $request['nome'] );
    $idade = sanitize_text_field( $request['idade'] );
    $respostas = sanitize_text_field( $request['respostas'] );

    // $rr = new ReportsModel();
    // $rr->create( $nome, $idade, $respostas);

    (new ReportsModel())->create( $nome, $idade, $respostas);


    return rest_ensure_response('Chegou aqui pai');

  }

}


