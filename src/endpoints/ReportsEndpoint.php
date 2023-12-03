<?php

/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\endpoints;

use src\models\ReportsModel;
use src\helpers\ScoreCalculator;
use src\models\QuestionsModel;

use WP_REST_Request, WP_REST_Response, WP_Error;


class ReportsEndpoint
{

    //NOME DA TABELA
    public static $table_name = 'ilsapi_reports';


    // A FUNÇÃO MÁGICA QUE CRIA OS REPORTS
    public function create($request)
    {

        $pontuacao = 10;

        // Os sanitize é uma função do Wordpress que evita entradas maliciosas
        $nome = sanitize_text_field($request['nome']);
        $idade = sanitize_text_field($request['idade']);


        // -------------------------------------------------------------------------------------


        // Busca toda a lista de questões
        $question_list = QuestionsModel::list_all();

        // Inicia arrays que serão preenchidas
        $pontuacao = array();
        $respostas = array();

        // Laço que verifica respostas
        foreach ($question_list as $index => $question) {


            // Verifica se a resposta com id_interno está na requisição, se não pula o laço e vai para a próxima iteração.
            if (!isset($request[$question['id_interno']])) {
                continue;
            }

            // // Define variáveis do loop atual
            // $pergunta_atual = $question_list[$index]['pergunta'];

            // $id_interno_atual = $question_list[$index]['id_interno'];
            // $categoria_atual = $question_list[$index]['categoria'];

            // $resposta_requisicao = sanitize_text_field($request[$id_interno_atual]);

            // $resposta_A_atual = $question_list[$index]['resposta_a'];
            // $resposta_B_atual = $question_list[$index]['resposta_b'];
            // $resposta_C_atual = $question_list[$index]['resposta_c'];

            // Define variáveis do loop atual
            $pergunta_atual = $question['pergunta'];

            $id_interno_atual = $question['id_interno'];
            $categoria_atual = $question['categoria'];

            $resposta_requisicao = sanitize_text_field($request[$id_interno_atual]);

            $resposta_A_atual = $question['resposta_a'];
            $resposta_B_atual = $question['resposta_b'];
            $resposta_C_atual = $question['resposta_c'];



            // Compara a diferença entre a resposta que veio pela requisição, com a resposta do banco de dados
            $difereca_resposta[0] = levenshtein($resposta_requisicao, $resposta_A_atual);
            $difereca_resposta[1] = levenshtein($resposta_requisicao, $resposta_B_atual);
            $difereca_resposta[2] = levenshtein($resposta_requisicao, $resposta_C_atual);

            // Encontrar o menor valor (menor diferença)
            $menor_valor = min($difereca_resposta);

            // Encontrar o índice do menor valor
            $indice_menor_valor = array_search($menor_valor, $difereca_resposta);



            // Soma a pontuação da resposta, dentro da array de pontuações, de acordo com a categoria. Salva array de respostas
            if ($indice_menor_valor == 0) {
                $pontuacao[$categoria_atual] += $question['pontuacao_a'];
                array_push(
                    $respostas,
                    array(
                        'id_interno' => $id_interno_atual,
                        'categoria' => $categoria_atual,
                        'pergunta' => $pergunta_atual,
                        'resposta' => $resposta_A_atual,
                        'pontuacao' => $question['pontuacao_a'],
                        'index_reposta' => $indice_menor_valor
                    )
                );
            } elseif ($indice_menor_valor == 1) {
                $pontuacao[$categoria_atual] += $question['pontuacao_b'];
                array_push(
                    $respostas,
                    array(
                        'id_interno' => $id_interno_atual,
                        'categoria' => $categoria_atual,
                        'pergunta' => $pergunta_atual,
                        'resposta' => $resposta_A_atual,
                        'pontuacao' => $question['pontuacao_a'],
                        'index_reposta' => $indice_menor_valor
                    )
                );
            } elseif ($indice_menor_valor == 2) {
                $pontuacao[$categoria_atual] += $question['pontuacao_c'];
                array_push(
                    $respostas,
                    array(
                        'id_interno' => $id_interno_atual,
                        'categoria' => $categoria_atual,
                        'pergunta' => $pergunta_atual,
                        'resposta' => $resposta_A_atual,
                        'pontuacao' => $question['pontuacao_a'],
                        'index_reposta' => $indice_menor_valor
                    )
                );
            }
        }

        // -------------------------------------------------------------------------------------


        // Salva o report no banco de dados. As respostas, pontuações e um backup da requisição vão em formato JSON.

        // RESPOSTAS JSON
        $respostas_json = json_encode($respostas);

        // PONTUAÇÃO JSON
        $pontuacao_json = json_encode($pontuacao);

        // REQUEST BODY
        $request_body = $request->get_body();
        $request_body = sanitize_text_field($request_body);

        // SALVA NO BANCO DE DADOS
        (new ReportsModel())->create($nome, $idade, $respostas_json, $pontuacao_json, $request_body);

        return rest_ensure_response($pontuacao);
    }

    public function read($request)
    {

        $id = filter_var($request->get_param('id'), FILTER_SANITIZE_NUMBER_INT);

        $response = (new ReportsModel())->read($id);

        if ($response) {
            return new WP_REST_Response($response, 200);
        } else {
            return new WP_REST_Response(['message' => 'Relatório não encontrado'], 404);
        }




        // return rest_ensure_response($response);
    }


    public function list($request)
    {

        $response = (new ReportsModel())->list_all();

        return rest_ensure_response($response);
    }
}
