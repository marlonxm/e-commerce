<?php 

use \Hcode\page;

$app->get('/', function() {
    
    $page = new Page();

    $page->setTpl("index");

});

 ?>