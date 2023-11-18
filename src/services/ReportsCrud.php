<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\services;

use src\models\Reports;


class ReportsCrud{

  function __construct(){
    // echo '_PDF INICIADO';
  }

  function create($nome, $idade, $respostas) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . Reports::$table_name;

    $wpdb->insert(
        $tabela_nome,
        array(
            'nome' => $nome,
            'idade' => $idade,
            'respostas' => $respostas
        ),
        array('%s', '%d', '%s')
    );
  }


  function read($id) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . Reports::$table_name;

    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $tabela_nome WHERE id = %d", $id), ARRAY_A);
}


  function update($id, $nome, $idade, $respostas) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . Reports::$table_name;

    $wpdb->update(
        $tabela_nome,
        array(
            'nome' => $nome,
            'idade' => $idade,
            'respostas' => $respostas
        ),
        array('id' => $id),
        array('%s', '%d', '%s'),
        array('%d')
    );
  }


  function delete($id) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . Reports::$table_name;

    $wpdb->delete($tabela_nome, array('id' => $id), array('%d'));
  }


  function list_all() {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . Reports::$table_name;

    return $wpdb->get_results("SELECT * FROM $tabela_nome", ARRAY_A);
  }


}

