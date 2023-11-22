<?php
/**
 * @package LanceNoDigital.Medical-ILS-API-Plugin
 */

namespace src\helpers;

use WP_REST_Request, WP_REST_Response, WP_Error;

class ValidateJWT{

  public function is_validated( WP_REST_Request $request ) {

    $token = $request->get_headers()['authorization'];

    // Token vazio
    if (empty($token)) {
      return false;
    }

    $token = $token[0];

    // Cria um hash do token para usar como chave de cache
    $cache_key = 'jwt_validation_' . md5($token);
    $cached_validation = get_transient($cache_key);

    // Se a validação já estiver no cache e for válida, retorna true
    if ($cached_validation == true) {
      return true;
    }

    // Faz uma requisição ao plugin de jwt
    $response = wp_remote_post( ILSAPI_SITEURL . ILSAPI_JWT_URL . '/validate' , array(
      'method' => 'POST',
      'headers'   => array(
        'authorization' => $token,
      )
    ));

    // Houve um erro na requisição?
    if (is_wp_error($response)) {
      return false;
    }

    // Verifica o status code
    $status_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    // Se for 200, autoriza a rota
    if ($status_code == 200 && !empty($data)) {
      set_transient($cache_key, true, 15 * MINUTE_IN_SECONDS);
      return true;
    }

    return false;

  }


}


