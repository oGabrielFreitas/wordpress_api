<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\models;

use src\helpers\InitiateData;


class QuestionsModel
{

    //NOME DA TABELA
    public static string $table_name = 'lance_api_questions';

    // ESTRUTURA DA TABELA DENTRO DO BANCO DE DADOS
    private static function create_table()
    {

        global $wpdb;

        $wp_table_name = $wpdb->prefix . self::$table_name;

        $charset_collate = $wpdb->get_charset_collate();

        // Verifica se a tabela já existe
        // if ($wpdb->get_var("SHOW TABLES LIKE '{$wp_table_name}'") != $wp_table_name) {
        $sql = "CREATE TABLE $wp_table_name (

            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            id_interno TEXT,
            categoria TEXT,
            pergunta TEXT,
            resposta_a TEXT,
            pontuacao_a DECIMAL(5,2),
            resposta_b TEXT,
            pontuacao_b DECIMAL(5,2),
            resposta_c TEXT,
            pontuacao_c DECIMAL(5,2),
            PRIMARY KEY  (id)

    ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        // }


    }

    // CHAMADA PARA CRIAR A TABELA
    public static function register()
    {

        // Cria a tabela
        self::create_table();

        // Chama a função para importar dados após a criação da tabela
        InitiateData::register(self::$table_name);
    }

    // ---------------------------------------------------------------------------


    // CRUD - CREATE (INSERT)
    public static function create($data)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        $wpdb->insert(
            $tabela_nome,
            array(
                'id_interno' => $data['id_interno'],
                'categoria' => $data['categoria'],
                'pergunta' => $data['pergunta'],
                'resposta_a' => $data['resposta_a'],
                'pontuacao_a' => $data['pontuacao_a'],
                'resposta_b' => $data['resposta_b'],
                'pontuacao_b' => $data['pontuacao_b'],
                'resposta_c' => $data['resposta_c'],
                'pontuacao_c' => $data['pontuacao_c']
            ),
            array('%s', '%s', '%s', '%f', '%s', '%f', '%s', '%f')
        );
    }



    // CRUD - UPDATE
    public static function update($id, $data)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        $wpdb->update(
            $tabela_nome,
            array(
                'categoria' => $data['categoria'],
                'pergunta' => $data['pergunta'],
                'resposta_a' => $data['resposta_a'],
                'pontuacao_a' => $data['pontuacao_a'],
                'resposta_b' => $data['resposta_b'],
                'pontuacao_b' => $data['pontuacao_b'],
                'resposta_c' => $data['resposta_c'],
                'pontuacao_c' => $data['pontuacao_c']
            ),
            array('id' => $id),
            array('%s', '%s', '%s', '%f', '%s', '%f', '%s', '%f'),
            array('%d')
        );
    }



    // ---------------------------------------------------------------------------
    // PADRÃO PARA TODOS QUE USAM ID COMO PRIMARY KEY


    // CRUD - READ
    public static function read($id)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $tabela_nome WHERE id = %d", $id), ARRAY_A);
    }


    // CRUD - DELETE
    public static function delete($id)
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        $wpdb->delete($tabela_nome, array('id' => $id), array('%d'));
    }


    public static function list_all()
    {
        global $wpdb;

        $tabela_nome = $wpdb->prefix . self::$table_name;

        return $wpdb->get_results("SELECT * FROM $tabela_nome", ARRAY_A);
    }
}
