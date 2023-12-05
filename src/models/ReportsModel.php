<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\models;


class ReportsModel
{

    //NOME DA TABELA
    public static $table_name = 'lance_api_reports';

    // ESTRUTURA DA TABELA DENTRO DO BANCO DE DADOS
    private static function create_table()
    {
        global $wpdb;

        $wp_table_name = $wpdb->prefix . self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $wp_table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            nome tinytext,
            idade int,
            email VARCHAR(255),
            respostas LONGTEXT,
            pontuacao LONGTEXT,
            request_backup LONGTEXT,
            data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
            data_edicao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


    // CHAMADA PARA CRIAR A TABELA
    static public function register()
    {
        self::create_table();
    }

    // ---------------------------------------------------------------------------


    // CRUD - CREATE (INSERT)
    function create($nome, $email, $idade, $respostas, $pontuacao, $request_backup)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        $wpdb->insert(
            $tabela_nome,
            array(
                'nome' => $nome,
                'email' => $email,
                'idade' => $idade,
                'respostas' => $respostas,
                'pontuacao' => $pontuacao,
                'request_backup' => $request_backup
            ),
            array('%s', '%s', '%d', '%s', '%s', '%s')
        );
    }


    // CRUD - UPDATE
    function update($id, $nome, $email, $idade, $respostas, $pontuacao, $request_backup)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        $wpdb->update(
            $tabela_nome,
            array(
                'nome' => $nome,
                'email' => $email,
                'idade' => $idade,
                'respostas' => $respostas,
                'pontuacao' => $pontuacao,
            ),
            array('id' => $id),
            array('%s', '%s', '%d', '%s', '%s', '%s'),
            array('%d')
        );
    }


    // ---------------------------------------------------------------------------
    // PADRÃO PARA TODOS QUE USAM ID COMO PRIMARY KEY

    // Nesta implementação em específico, não estou retornando o request_backup em READ e LIST


    // CRUD - READ
    function read($id)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        return $wpdb->get_row($wpdb->prepare("SELECT id, nome, email, idade, respostas, pontuacao, data_criacao, data_edicao FROM $tabela_nome WHERE id = %d", $id), ARRAY_A);
    }


    // CRUD - DELETE
    function delete($id)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        $wpdb->delete($tabela_nome, array('id' => $id), array('%d'));
    }


    function list_all()
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        // Especificando as colunas que você deseja retornar
        $sql = "SELECT id, nome, email, idade, respostas, pontuacao, data_criacao, data_edicao FROM $tabela_nome";

        return $wpdb->get_results($sql, ARRAY_A);
    }
}
