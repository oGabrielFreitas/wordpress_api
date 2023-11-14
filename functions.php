<?php

$template_diretorio = get_template_directory();

require_once($template_diretorio . "/custom-post-type/produto.php");
require_once($template_diretorio . "/custom-post-type/transacao.php");

require_once($template_diretorio . "/endpoints/usuario_post.php");
require_once($template_diretorio . "/endpoints/usuario_get.php");
require_once($template_diretorio . "/endpoints/pdf_generator.php");



// Function to JWT Token expire time
function api_expire_token(){
  return time() + (60*60*24); // 1d
}

add_action('jwt_auth_expire', 'api_expire_token');

?>
