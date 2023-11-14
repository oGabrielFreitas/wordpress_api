<?php


function forms_test($request)
{

  // Os sanitize é uma função do Wordpress que evita entradas maliciosas
  $email = sanitize_email( $request['email'] );
  $username = sanitize_text_field( $request['username'] );

  $response = array(
    'Email' => $email,
    'Username' => $username
  );

  return rest_ensure_response($response);
}


add_action( 'rest_api_init', function () {
  register_rest_route( 'api', '/test', array(
    'methods' => 'POST',
    'callback' => 'forms_test'
  ) );
} );
