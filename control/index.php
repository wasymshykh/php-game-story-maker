<?php

require_once '../config/init.php';

$error = false;

$g = new Game($db);

$categories = $g->get_categories();
$games = $g->get_games();

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['category_create'])) {

        
        if (!empty($_POST['category_name'])) {
            $name = normal_text($_POST['category_name'] ?? '');
            $r = $g->insert_category($name);
            if ($r) {
                go(URL .'/control');
            }
        } else {
            $error = "Name cannot be empty";
        }

    }

}


include_once DIR . 'views/control/header.view.php';
include_once DIR . 'views/control/index.view.php';
include_once DIR . 'views/control/footer.view.php';
