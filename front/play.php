<?php

require_once '../config/init.php';

$g = new Game($db);

if (!isset($_GET['game']) || !is_numeric($_GET['game']) || empty(normal_text($_GET['game']))) {
    go(URL . '/front');
}

$game = $g->get_game_front(normal_text($_GET['game']));

$conditions = $g->get_conditions();
$conditions_id = [];
foreach ($conditions as $condition) {
    $conditions_id[$condition['condition_id']] = $condition['condition_name'];
}

if (!$game || empty($game)) {
    go(URL . '/front');
}

// check which round user is in
$last_round = false;
if (isset($_SESSION['round']) && !empty($_SESSION['round'])) {
    $round_number = $_SESSION['round'];
} else {
    $round_number = '0';
    $_SESSION['round'] = $round_number;
}

$zero_round = $round_number === '0' ? true : false;

$current_round = [];
$textblocks = [];
$answerblocks = [];

$round_index = 0;
foreach ($game['rounds'] as $round) {
    if ($round['round_number'] === $round_number) {
        $current_round = $round;
        if ($round_index === (count($game['rounds']) - 1)) {
            $last_round = true;
        }

        foreach ($round['textblocks'] as $textblock) {
            // check wheither to show text block or not
            $cond_1 = false;
            if (isset($textblock['tb_condition_1_id']) && !empty($textblock['tb_condition_1_id']) && array_key_exists($textblock['tb_condition_1_id'], $conditions_id)) {
                $cond_1 = $conditions_id[$textblock['tb_condition_1_id']];
            }

            $cond_2 = false;
            if (isset($textblock['tb_condition_2_id']) && !empty($textblock['tb_condition_2_id']) && array_key_exists($textblock['tb_condition_2_id'], $conditions_id)) {
                $cond_2 = $conditions_id[$textblock['tb_condition_2_id']];
            }

            $passed = true;
            if ($cond_1 !== false) {
                // check if condition 1 is set
                if(!isset($_SESSION[$cond_1])) {
                    $passed = false;
                }
            }

            if ($cond_2 !== false) {
                // check if condition 2 is set
                if(!isset($_SESSION[$cond_2])) {
                    $passed = false;
                }
            }

            if ($cond_1 !== false && $cond_2 !== false) {
                if (!empty($textblock['tb_condition_between']) && ($textblock['tb_condition_between'] === 'A' || $textblock['tb_condition_between'] === 'O')) {
                    if ($textblock['tb_condition_between'] === 'A' && (!isset($_SESSION[$cond_1]) && !isset($_SESSION[$cond_2]))) {
                        $passed = false;
                    }
                    if ($textblock['tb_condition_between'] === 'O' && (!isset($_SESSION[$cond_1]) || !isset($_SESSION[$cond_2]))) {
                        $passed = false;
                    }
                }
            }

            // pushing passed input to text block
            if ($passed) {
                array_push($textblocks, $textblock);
            }
        }

        foreach ($round['answerblocks'] as $answerblock) {
            // check wheither to show text block or not
            $cond_1 = false;
            if (isset($answerblock['ab_condition_1_id']) && !empty($answerblock['ab_condition_1_id']) && array_key_exists($answerblock['ab_condition_1_id'], $conditions_id)) {
                $cond_1 = $conditions_id[$answerblock['ab_condition_1_id']];
            }

            $cond_2 = false;
            if (isset($answerblock['ab_condition_2_id']) && !empty($answerblock['ab_condition_2_id']) && array_key_exists($answerblock['ab_condition_2_id'], $conditions_id)) {
                $cond_2 = $conditions_id[$answerblock['ab_condition_2_id']];
            }

            $passed = true;
            if ($cond_1 !== false) {
                // check if condition 1 is set
                if(!isset($_SESSION[$cond_1])) {
                    $passed = false;
                }
            }

            if ($cond_2 !== false) {
                // check if condition 2 is set
                if(!isset($_SESSION[$cond_2])) {
                    $passed = false;
                }
            }

            if ($cond_1 !== false && $cond_2 !== false) {
                if (!empty($answerblock['ab_condition_between']) && ($answerblock['ab_condition_between'] === 'A' || $answerblock['ab_condition_between'] === 'O')) {
                    if ($answerblock['ab_condition_between'] === 'A' && (!isset($_SESSION[$cond_1]) && !isset($_SESSION[$cond_2]))) {
                        $passed = false;
                    }
                    if ($answerblock['ab_condition_between'] === 'O' && (!isset($_SESSION[$cond_1]) || !isset($_SESSION[$cond_2]))) {
                        $passed = false;
                    }
                }
            }

            // pushing passed input to text block
            if ($passed) {
                array_push($answerblocks, $answerblock);
            }
        }

        break;
    }
    $round_index++;
}


include_once DIR . 'views/front/header.view.php';
include_once DIR . 'views/front/play.view.php';
include_once DIR . 'views/front/footer.view.php';
