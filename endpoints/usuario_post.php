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

    $user_id = wp_create_user( $username, $password, $email );

    //$user = get_user_by( 'login' , $username ); // $user->data->ID (MÉTODO ALTERNATIVO PARA BUSCAR USUÁRIO)


    $response = array(
      'ID' => $user_id,
      'display_name' => $name,
      'first_name' => $name,
      'role' => 'subscriber',
    );

    wp_update_user($response);

    // Método para adicionar campos extras ao usuário
    // Estes campos não aparecem dentro do WP, mas vão para o banco de dados
    update_user_meta($user_id, 'Address', $address);
    update_user_meta($user_id, 'Age', $age);


  }
  else {
    $response = new WP_Error('email', 'Email já cadastrado', array('status' => 403));
  }

  return rest_ensure_response($response);
}


// Define qual será o uso da função (nesse caso POST)
// Na documentação do Wordpress ele mostra outra maneira de fazer
// Mas o tutorial em vídeo faz assim, então vou deixar assim por enquanto
function registrar_api_usuario_post()
{

  register_rest_route('api', '/usuario', array(
    array(
      // 'methods' => 'POST',
      'methods' => WP_REST_Server::CREATABLE,
      'callback' => 'api_usuario_post'
    )
  ));
}


// Diz qual o trigger para iniciar a função (é uma função do Wordpress)
// Nesse caso o trigger é 'rest_api_init
// Também é necessário adicionar este arquivo lá em functions.php
add_action('rest_api_init', 'registrar_api_usuario_post');
