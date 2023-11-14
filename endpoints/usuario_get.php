<?php


function api_usuario_get($request)
{

  $user = wp_get_current_user();


  return rest_ensure_response($user);
}


// Neste arquivo vou testar o método mais simpleficado, que aparece na documentação do WP REST
add_action( 'rest_api_init', function () {
  register_rest_route( 'api', '/usuario', array(
    // 'methods' => 'GET',
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'api_usuario_get'
  ) );
} );
