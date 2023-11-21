<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\endpoints;


class UsersEndpoint{

  //NOME DA TABELA
  public static $table_name = 'ilsapi_reports';



  public function login($request) {


    $username = sanitize_text_field($request['username']);
    $password = sanitize_text_field($request['password']);

    // // return rest_ensure_response("ola");

    // // Autentica o usuário
    $user = wp_authenticate($username, $password);

    // // $user = "gabriel";

    // return rest_ensure_response($user);

    if (is_wp_error($user)) {
        // Falha na autenticação, retorna código 401
        return new WP_REST_Response(['message' => 'Falha na autenticação'], 401);
    }

    // Requisita o token JWT
    $response = wp_remote_post('http://wpapilocal.local:10003/wp-json/jwt-auth/v1/token', array(
        'method' => 'POST',
        'body'   => array(
            'username' => $username,
            'password' => $password
        )
    ));

    // return rest_ensure_response($response);


    if (is_wp_error($response)) {
        // Houve um erro na requisição, considerar o código apropriado para o erro
        return new WP_REST_Response(['message' => 'Erro na requisição do token'], 400); // ou outro código conforme o erro
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (!empty($data->token)) {
        // Token JWT recebido com sucesso
        return rest_ensure_response($data->token);
    } else {
        // Falha ao receber o token, pode considerar retornar 401 ou outro código conforme a situação
        return new WP_REST_Response(['message' => 'Falha ao obter o token'], 401);
    }

  }


}


