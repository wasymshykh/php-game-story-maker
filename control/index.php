<?php

require_once '../config/init.php';

$error = false;

$g = new Game($db);

$categories = $g->get_categories();
$games = $g->get_games();

if (isset($_GET['inactive']) && is_numeric($_GET['inactive'])) {
    $game = $g->get_game_by('game_id', normal_text($_GET['inactive']));
    if ($game && !empty($game)) {
        $r = $g->set_game_status('0', $game['game_id']);
        go (URL . '/control');

    } else {
        go(URL . '/control');
    }
}
if (isset($_GET['active']) && is_numeric($_GET['active'])) {
    $game = $g->get_game_by('game_id', normal_text($_GET['active']));
    if ($game && !empty($game)) {
        $r = $g->set_game_status('1', $game['game_id']);
        go (URL . '/control');

    } else {
        go(URL . '/control');
    }
}

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
