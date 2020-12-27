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

// adding default conditions
foreach ($conditions as $condition) {
    if (strpos($condition['condition_name'], "end") !== false || strpos($condition['condition_name'], "target") !== false) {
        $condition_details[$condition['condition_name']] = ['condition_id' => $conditions_by_name[$condition['condition_name']], 'condition_value' => $conditions_value_by_name[$condition['condition_name']] ?? ''];
    }
}

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

    

}

include_once DIR . 'views/control/header.view.php';
include_once DIR . 'views/control/edit_game.view.php';
include_once DIR . 'views/control/footer.view.php';
