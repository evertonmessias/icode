<?php

//Functions Theme

//*************URL theme [ get_template_directory_uri() ]
define('SITEPATH', '/wp-content/themes/icode/');

//************* URL from breadcrumbs
function url_active()
{
  return explode("/", $_SERVER['REQUEST_URI']);
}
add_action('url_active', 'url_active');