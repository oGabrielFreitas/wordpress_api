<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\helpers;

use src\models\QuestionsModel;


class InitiateData
{

    // CHAMADA PARA PREENCHER A TABELA
    static public function register($table_name)
    {
        self::import_csv_respostas_pontuacoes($table_name);
    }

    // TABELA DE PERGUNTAS, RESPOSTAS E PONTUAÇÕES
    private static function import_csv_respostas_pontuacoes($table_name)
    {

        global $wpdb;

        $wp_table_name = $wpdb->prefix . $table_name;

        // Verifica se a tabela já contém dados
        $existing_data = $wpdb->get_var("SELECT COUNT(*) FROM $wp_table_name");
        if ($existing_data > 0) {
            // A tabela já contém dados, então pula a importação
            return;
        }

        // Caminho para o arquivo CSV - ajuste para o caminho correto do seu arquivo
        $csv_file_path = LANCE_API_PLUGIN_DIR . '/src/data/respostas_pontuacoes.csv';

        // Abre o arquivo CSV para leitura
        if (($handle = fopen($csv_file_path, 'r')) !== FALSE) {
            // Pula a primeira linha (cabeçalhos)
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== FALSE) {
                // Prepara os dados para inserção
                $wpdb->insert(
                    $wp_table_name,
                    array(
                        'id_interno' => $data[0],
                        'categoria' => $data[1],
                        'pergunta' => $data[2],
                        'resposta_a' => $data[3],
                        'pontuacao_a' => $data[4],
                        'resposta_b' => $data[5],
                        'pontuacao_b' => $data[6],
                        'resposta_c' => $data[7],
                        'pontuacao_c' => $data[8]
                    ),
                    array('%s', '%s', '%s', '%s', '%f', '%s', '%f', '%s', '%f')
                );
            }

            fclose($handle);
        }
    }
}
