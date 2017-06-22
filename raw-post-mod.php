<?php
/**
 * Plugin Name: Raw Post mod
 * Plugin URI: https://github.com/vuldin/raw-post-mod
 * Description: Modifies WP REST-API post GET response to include a JSON version of the raw content
 * Version: 1.0.0
 * Author: Joshua Purcell
 * Author URI: https://github.com/vuldin
 * License: GPL3
 */
add_action( 'rest_api_init', function() {
  register_rest_field( 'post', 'content_rawmod', array('get_callback' => 'add_content_rawmod', ));
});

function add_content_rawmod( $object, $field_name, $request ) {
  $response = preg_split('/\r\n|\r|\n/', $object['content']['raw']);
  $response = array_filter($response);
  $response = array_values($response);
  return $response;
}
