<?php

require_once '../config/init.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    go(URL . '/control');
}

$error = false;

$g = new Game($db);

$categories = $g->get_categories();
$conditions = $g->get_conditions();
$game = $g->get_game_by('game_id', $_GET['id']);

if (!$game) {
    go(URL . '/control');
}

// storing for easier access
$conditions_by_id = [];
$conditions_by_name = [];
foreach ($conditions as $condition) {
    $conditions_by_id[$condition['condition_id']] = $condition['condition_name'];
    $conditions_by_name[$condition['condition_name']] = $condition['condition_id'];
}

// getting saved condition values
$game_conditions = $g->get_game_conditions ($game['game_id']);
$conditions_value_by_id = [];
$conditions_value_by_name = [];
foreach ($game_conditions as $c) {
    $conditions_value_by_id[$c['gc_condition_id']] = $c['gc_condition_value'];
    $conditions_value_by_name[$conditions_by_id[$c['gc_condition_id']]] = $c['gc_condition_value'];
}
$rounds = $g->get_games_rounds($game['game_id']);

$rounds_details = [];
$condition_details = [];
foreach ($rounds as $round) {
    $rounds_details[$round['round_id']]['details'] = $round;
    $rounds_details[$round['round_id']]['texts'] = $g->get_all_texts_by_round($round['round_id']);
    $rounds_details[$round['round_id']]['answers'] = $g->get_all_answers_by_round($round['round_id']);

    $n = 1;
    foreach ($rounds_details[$round['round_id']]['answers'] as $answer) {
        $text = "r".$round['round_number'].'a'.$n;
        if ($round['round_number'] === '0') {
            $text = "item".$n;
        }
        $n = $n + 1;
        $condition_details[$text] = ['condition_id' => $conditions_by_name[$text], 'condition_value' => $conditions_value_by_name[$text] ?? ''];
    }
}

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['conditions'])) {
        $insert = [];
        $update = [];
    
        foreach ($_POST['condition'] as $condition_id => $condition_value) {
            if (empty(normal_text($condition_value))) {
                continue;
            }
            $found = false;
            $condition_value = normal_text($condition_value);
            foreach ($game_conditions as $c) {
                if ($c['gc_condition_id'] == $condition_id) {
                    if ($c['gc_condition_value'] != $condition_value) {
                        $update[$condition_id] = $condition_value;
                    }
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $insert[$condition_id] = $condition_value;
            }
        }
        
        if (!empty($insert)) {
            $g->insert_game_conditions ($insert, $game['game_id']);
        }
        if (!empty($update)) {
            $g->update_game_conditions ($update, $game['game_id']);
        }
    }
    
    if (isset($_POST['game_id'])) {

        $tbs = [];
    
        // condition 1
        foreach ($_POST['conditions_1'] as $round => $values) {
            $tbs[$round]['condition_1'] = $values;  
        }
        // condition between
        foreach ($_POST['condition_between'] as $round => $values) {
            $tbs[$round]['condition_between'] = $values;    
        }
        // condition 2
        foreach ($_POST['conditions_2'] as $round => $values) {
            $tbs[$round]['condition_2'] = $values;    
        }
        // text
        foreach ($_POST['text'] as $round => $values) {
            $tbs[$round]['text'] = $values;
        }
        // auto
        foreach ($_POST['autoset'] as $round => $values) {
            $tbs[$round]['autoset'] = $values;  
        }
        
        // insert tbs
        $g->insert_tbs($tbs);
        
        var_dump($tbs);
        
    }
}

include_once DIR . 'views/control/header.view.php';
include_once DIR . 'views/control/edit_game.view.php';
include_once DIR . 'views/control/footer.view.php';
