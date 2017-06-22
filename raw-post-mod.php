<?php
/**
 * Plugin Name: raw-post-mod
 * Plugin URI: https://github.com/vuldin/raw-post-mod
 * Description: shows raw content in post GET responses
 * Version: 1.0.0
 * Author: Joshua Purcell
 * Author URI: https://github.com/vuldin/
 * License: GPL2
 */
add_action( 'rest_api_init', function() {
  register_rest_field( 'post', 'rawcontent', array('get_callback' => 'add_rawcontent', ));
});

function add_rawcontent( $object, $field_name, $request ) {
  $response = preg_split('/\r\n|\r|\n/', $object['content']['raw']);
  $response = array_filter($response);
  $response = array_values($response);
  return $response;
}
