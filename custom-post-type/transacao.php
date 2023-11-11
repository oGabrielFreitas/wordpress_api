<?php

function registrar_cpt_transacao() {
  register_post_type('Transacao', array(
    'label' => 'Transacao',
    'description' => 'Transacao',
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'transacao', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom_fields', 'author', 'title'),
    'publicly_queryble' => true
  ));
}

add_action('init', 'registrar_cpt_transacao');

?>
