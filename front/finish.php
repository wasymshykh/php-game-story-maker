<?php

require_once '../config/init.php';

$g = new Game($db);

if ((!isset($_SESSION['end1']) && empty($_SESSION['end1'])) && 
    (!isset($_SESSION['end2']) && empty($_SESSION['end2'])) && 
    (!isset($_SESSION['end3']) && empty($_SESSION['end3'])) && 
    (!isset($_SESSION['end4']) && empty($_SESSION['end4'])) && 
    (!isset($_SESSION['end5']) && empty($_SESSION['end5'])) && 
    (!isset($_SESSION['game']) && empty($_SESSION['game'])) ) {

    if (isset($_SESSION['game']) && !empty($_SESSION['game'])) {
        go(URL . '/front/play.php?game=' . $_SESSION['game']);
    }
    go(URL . '/front');
}

$game = $g->get_game_by('game_id', $_SESSION['game']);
if (!$game || empty($game)) {
    go(URL . '/front');
}

$error = false;

$_SESSION['finished'] = $_SESSION['game'];

// saving data for post request
if (isset($_POST) && !empty($_POST)) {
    
    if (isset($_POST['name']) && !empty($_POST['name'])) {

        $name = normal_text($_POST['name']);

        $ending = "";
        if (isset($_SESSION['end1']) && !empty($_SESSION['end1'])) {
            $ending = "end1";
        } else if (isset($_SESSION['end2']) && !empty($_SESSION['end2'])) {
            $ending = "end2";
        } else if (isset($_SESSION['end3']) && !empty($_SESSION['end3'])) {
            $ending = "end3";
        } else if (isset($_SESSION['end4']) && !empty($_SESSION['end4'])) {
            $ending = "end4";
        } else if (isset($_SESSION['end5']) && !empty($_SESSION['end5'])) {
            $ending = "end5";
        }

        $game_count = $game['game_'.$ending] + 1;
        $r = $g->save_game_ending($ending, $game_count, $game['game_id'], $name);
        if ($r) {
            
            // unsetting all important session
            unset($_SESSION['finished']);
            unset($_SESSION['game']);
            unset($_SESSION['round']);
            
            $conditions = $g->get_conditions();
            foreach ($conditions as $condition) {
                if (isset($_SESSION[$condition['condition_name']])) {
                    unset($_SESSION[$condition['condition_name']]);
                }
            }

            go(URL . '/front');
            
        } else {
            $error = "Unable to save the data";
        }

    } else {
        $error = "Sorry, name cannot be empty";
    }

}


include_once DIR . 'views/front/header.view.php';
include_once DIR . 'views/front/finish.view.php';
include_once DIR . 'views/front/footer.view.php';
