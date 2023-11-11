<?php


function api_usuario_post($request)
{

  // Os sanitize é uma função do Wordpress que evita entradas maliciosas
  $email = sanitize_email( $request['email'] );
  $username = $email;
  $password = sanitize_text_field( $request['password'] );
  $name = sanitize_text_field( $request['name'] );
  $address = sanitize_text_field( $request['address'] );
  $age = sanitize_text_field( $request['age'] );


  // Verifica se o usuário já existe (função Wordpress)
  $user_exists = username_exists( $username ); // Nesse caso, o username será o email
  $email_exists = email_exists( $email );

  // Se não existir
  if(!$user_exists && !$email_exists && $email && $password) {

    wp_create_user( $username, $password, $email );

  }


  $response = array(
    'nome' => $name,
    'email' => $email,
  );

  return rest_ensure_response($response);
}


// Define qual será o uso da função (nesse caso POST)
// Na documentação do Wordpress ele mostra outra maneira de fazer
// Mas o tutorial em vídeo faz assim, então vou deixar assim por enquanto
function registrar_api_usuario_post()
{

  register_rest_route('api', '/usuario', array(
    array(
      'methods' => 'POST',
      'callback' => 'api_usuario_post'
    )
  ));
}


// Diz qual o trigger para iniciar a função (é uma função do Wordpress)
// Nesse caso o trigger é 'rest_api_init
// Também é necessário adicionar este arquivo lá em functions.php
add_action('rest_api_init', 'registrar_api_usuario_post');
