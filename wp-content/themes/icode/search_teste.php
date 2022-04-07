<?php 
$s = get_search_query();

$args = array(
    's' => $s, 
    'post_type' => array('attachment'),
    'post_status' => array('inherit'),
    'wpfts_is_force' => 1,
);

$query = new WP_Query($args);

echo json_encode($query);

/*
foreach($query->posts as $dado){
    echo "<p><strong>Name</strong>: ".$dado->post_name."</p>";
    echo "<p><strong>File</strong>: ".$dado->guid."</p>";
}