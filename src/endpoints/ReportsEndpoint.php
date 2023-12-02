<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\endpoints;

use src\models\ReportsModel;
use src\helpers\ScoreCalculator;
use src\models\QuestionsModel;


class ReportsEndpoint
{

    //NOME DA TABELA
    public static $table_name = 'ilsapi_reports';


    public function create($request)
    {

        $pontuacao = 10;

        // Os sanitize é uma função do Wordpress que evita entradas maliciosas
        $nome = sanitize_text_field($request['nome']);
        $idade = sanitize_text_field($request['idade']);
        $respostas = sanitize_text_field($request['respostas']);


        // $pontuacao = ScoreCalculator::calculate($respostas);


        // -------------------------------------------------------------------------------------


        // Busca toda a lista de questões
        $question_list = QuestionsModel::list_all();
        // return rest_ensure_response($question_list);

        // Terminar isso depois
        $pontuacao = array();

        $resposta_id_index = array();


        foreach ($question_list as $index => $question) {

            // Verifica se a resposta com id_interno está na requisição, se não pula o laço e vai para a próxima iteração.
            if (!isset($request[$question_list[$index]['id_interno']])) {
                continue;
            }

            // Compara a diferença entre a resposta que veio pela requisição, com a resposta do banco de dados
            $difereca_resposta[0] = levenshtein($request[$question_list[$index]['id_interno']], $question_list[$index]['resposta_a']);
            $difereca_resposta[1] = levenshtein($request[$question_list[$index]['id_interno']], $question_list[$index]['resposta_b']);
            $difereca_resposta[2] = levenshtein($request[$question_list[$index]['id_interno']], $question_list[$index]['resposta_c']);

            // Encontrar o menor valor (menor diferença)
            $menor_valor = min($difereca_resposta);

            // Encontrar o índice do menor valor
            $indice_menor_valor = array_search($menor_valor, $difereca_resposta);

            // Soma a pontuação da resposta, dentro da array de pontuações, de acordo com a categoria.
            if ($indice_menor_valor == 0) {
                $pontuacao[$question_list[$index]['categoria']] += $question_list[$index]['pontuacao_a'];
                $resposta_id_index[$question_list[$index]['id_interno']] = 0;
            } elseif ($indice_menor_valor == 1) {
                $pontuacao[$question_list[$index]['categoria']] += $question_list[$index]['pontuacao_b'];
                $resposta_id_index[$question_list[$index]['id_interno']] = 1;
            } elseif ($indice_menor_valor == 2) {
                $pontuacao[$question_list[$index]['categoria']] += $question_list[$index]['pontuacao_c'];
                $resposta_id_index[$question_list[$index]['id_interno']] = 2;
            }
        }

        // -------------------------------------------------------------------------------------

        // return rest_ensure_response($resposta_id_index);



        // Salva o report no banco de dados. As respostas, pontuações e um backup da requisição vão em formato JSON.

        // RESPOSTAS JSON
        $respostas_json = json_encode($resposta_id_index);

        // PONTUAÇÃO JSON
        $pontuacao_json = json_encode($pontuacao);

        // REQUEST BODY
        $request_body = $request->get_body();

        // SALVA NO BANCO DE DADOS
        (new ReportsModel())->create($nome, $idade, $respostas_json, $pontuacao_json, $request_body);

        return rest_ensure_response($pontuacao);
    }

    public function read($request)
    {

        $id = sanitize_text_field($request['id']);

        $response = (new ReportsModel())->read($id);

        return rest_ensure_response($response);
    }


    public function list($request)
    {

        $response = (new ReportsModel())->list_all();

        return rest_ensure_response($response);
    }
}
