<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\models;


class ReportsModel{

  //NOME DA TABELA
  public static $table_name = 'ilsapi_reports';

  // ESTRUTURA DA TABELA DENTRO DO BANCO DE DADOS
  private static function create_table() {

    global $wpdb;

    $wp_table_name = $wpdb->prefix . self::$table_name;

    $charset_collate = $wpdb->get_charset_collate();

    // Verifica se a tabela já existe
    // if ($wpdb->get_var("SHOW TABLES LIKE '{$wp_table_name}'") != $wp_table_name) {
    $sql = "CREATE TABLE $wp_table_name (

        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        nome tinytext NOT NULL,
        idade int NOT NULL,
        respostas LONGTEXT NOT NULL,
        PRIMARY KEY  (id)

    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    // }

  }

  // CHAMADA PARA CRIAR A TABELA
  static public function register(){
    self::create_table();
  }

  // ---------------------------------------------------------------------------


  // CRUD - CREATE (INSERT)
  function create($nome, $idade, $respostas) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . self::$table_name;

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


  // CRUD - UPDATE
  function update($id, $nome, $idade, $respostas) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . self::$table_name;

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


  // ---------------------------------------------------------------------------
  // PADRÃO PARA TODOS QUE USAM ID COMO PRIMARY KEY


  // CRUD - READ
  function read($id) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . self::$table_name;

    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $tabela_nome WHERE id = %d", $id), ARRAY_A);
  }


  // CRUD - DELETE
  function delete($id) {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . self::$table_name;

    $wpdb->delete($tabela_nome, array('id' => $id), array('%d'));
  }


  function list_all() {
    global $wpdb;

    $tabela_nome = $wpdb->prefix . self::$table_name;

    return $wpdb->get_results("SELECT * FROM $tabela_nome", ARRAY_A);
  }


}

