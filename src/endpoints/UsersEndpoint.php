<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\endpoints;

use WP_REST_Request, WP_REST_Response, WP_Error;

class UsersEndpoint{


  public function login( WP_REST_Request $request ) {


    $username = sanitize_text_field($request['username']);
    $password = sanitize_text_field($request['password']);
    $username = sanitize_user( $username );
	  $password = trim( $password );


    // // Autentica o usuário
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user)) {
        // Falha na autenticação, retorna código 401
        return new WP_REST_Response(['message' => 'Falha na autenticação (AUE1)'], 401);
    }

    $site_url = site_url( );

    // Requisita o token JWT
    $response = wp_remote_post( ILSAPI_SITEURL . ILSAPI_JWT_URL , array(

        'method' => 'POST',
        'body'   => array(
            'username' => $username,
            'password' => $password
        )
    ));

    if (is_wp_error($response)) {
        // Houve um erro na requisição, considerar o código apropriado para o erro
        return new WP_REST_Response(['message' => 'Falha na autenticação (AUE2)'], 400); // ou outro código conforme o erro
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (!empty($data->token)) {
        // Token JWT recebido com sucesso
        return rest_ensure_response($data);

    } else {
        // Falha ao receber o token, pode considerar retornar 401 ou outro código conforme a situação
        return new WP_REST_Response(['message' => 'Falha ao obter o token (AUE3)'], 401);
    }

  }


}


