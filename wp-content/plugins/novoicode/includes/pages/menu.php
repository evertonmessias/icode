<?php
//Arquivo: wp-content/plugins/novoicode/includes/pages/menu.php
// ***************** Add in Menu ******************************************************************
function menu_icode()
{
    add_menu_page('ICODE', 'ICODE', 'edit_posts', 'icode', 'function_about', 'dashicons-screenoptions', 1);
    add_submenu_page('icode', 'Acessos', 'Acessos', 'edit_posts', 'icode_acessos', 'function_acessos', 2);
    add_submenu_page('icode', 'PDFParser', 'PDFParser', 'edit_posts', 'icode_pdfparser', 'function_pdfparser', 3);
}

add_action('admin_menu', 'menu_icode');

// ***************** Add About ************************************************************
function function_about()
{
    include ABSPATH . '/wp-content/plugins/novoicode/includes/pages/about.php';
}
// ***************** Add Acessos ***************************************************************
function function_acessos()
{
    include ABSPATH . '/wp-content/plugins/novoicode/includes/pages/acessos.php';
}
// ***************** Add page pdfparser ******************************************************
function function_pdfparser()
{
    include ABSPATH . '/wp-content/plugins/novoicode/includes/pages/pdfparser.php';
}