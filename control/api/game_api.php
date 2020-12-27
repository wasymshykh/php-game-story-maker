<?php

require_once '../../config/init.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if (isset($_GET['delete'])) {

    if (is_numeric($_GET['delete']) && !empty($_GET['delete'])) {

        $g = new Game($db);
        $r = $g->remove_game(normal_text($_GET['delete']));

        if ($r) {
            http_response_code(200);
            echo json_encode(['code' => 200, 'type' => 'success', 'message' => 'Game is removed.']);
            die();
        } else {
            http_response_code(400);
            echo json_encode(['code' => 400, 'type' => 'error', 'message' => 'Game cannot be removed.']);
            die();
        }

    }

}
elseif (isset($_GET['add_round']) && isset($_GET['round_number'])) {


    if (is_numeric($_GET['add_round']) && !empty($_GET['add_round']) && is_numeric($_GET['round_number']) && (!empty($_GET['round_number'])) || $_GET['round_number'] === '0') {
        
        $g = new Game($db);

        $r = $g->get_game_by('game_id', $_GET['add_round']);

        if ($r) {

            $r = $g->insert_round($_GET['add_round'], $_GET['round_number']);

            if ($r !== false) {

                http_response_code(200);
                echo json_encode(['code' => 200, 'type' => 'success', 'message' => ['round_id' => $r]]);
                die();
                
            } else {
                http_response_code(400);
                echo json_encode(['code' => 400, 'type' => 'error', 'message' => 'Round cannot be added.']);
                die();
            }

        } else {
            http_response_code(400);
            echo json_encode(['code' => 400, 'type' => 'error', 'message' => 'Game cannot be found.']);
            die();
        }


    }

} else if (isset($_POST['save_game'])) {

    if (is_numeric($_POST['save_game']) && !empty($_POST['save_game'])) {

        $games = [];
        $g = new Game($db);
        $r = $g->get_game_by('game_id', normal_text($_POST['save_game']));
        if (!empty($r)) {

            $normal_save = null;

            // saving normal data
            $game_title = isset($_POST['title']) ? normal_text($_POST['title']) : '';
            $game_category = isset($_POST['category']) ? normal_text($_POST['category']) : '';
            $game_author = isset($_POST['author']) ? normal_text($_POST['author']) : '';
            $game_picture = isset($_POST['picture']) ? normal_text($_POST['picture']) : '';
            $game_audio = isset($_POST['audio']) ? normal_text($_POST['audio']) : '';
            
            $to_update = [];
            if ($game_title != $r['game_title']) {
                $to_update['game_title'] = $game_title;
            } 
            if ($game_category != $r['game_category_id']) {
                $to_update['game_category_id'] = $game_category;
            } 
            if ($game_author != $r['game_author']) {
                $to_update['game_author'] = $game_author;
            } 
            if ($game_picture != $r['game_picture']) {
                $to_update['game_picture'] = $game_picture;
            } 
            if ($game_audio != $r['game_audio']) {
                $to_update['game_audio'] = $game_audio;
            } 

            if (!empty($to_update)) {
                $normal_save = $g->update_game_information($to_update, $r['game_id']);
            }
            
            $text_boxes_save = null;
            // text boxes
            if (isset($_POST['conditions_1'])) {
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
                $result = $g->insert_tbs($tbs);
                
                if ($result['status']) {
                    $text_boxes_save = true;
                } else {
                    $text_boxes_save = false;
                }

            }

            $answer_boxes_save = null;
            // text boxes
            if (isset($_POST['aconditions_1'])) {
                $abs = [];
                
                // condition 1
                foreach ($_POST['aconditions_1'] as $round => $values) {
                    $abs[$round]['acondition_1'] = $values;  
                }
                // condition between
                foreach ($_POST['acondition_between'] as $round => $values) {
                    $abs[$round]['acondition_between'] = $values;    
                }
                // condition 2
                foreach ($_POST['aconditions_2'] as $round => $values) {
                    $abs[$round]['acondition_2'] = $values;    
                }
                // text
                foreach ($_POST['atext'] as $round => $values) {
                    $abs[$round]['atext'] = $values;
                }
                // auto set
                foreach ($_POST['aautoset'] as $round => $values) {
                    $abs[$round]['aautoset'] = $values;  
                }
                // auto unset
                foreach ($_POST['aautounset'] as $round => $values) {
                    $abs[$round]['aautounset'] = $values;  
                }
                
                // insert abs
                $result = $g->insert_abs($abs);
                
                if ($result['status']) {
                    $answer_boxes_save = true;
                } else {
                    $answer_boxes_save = false;
                }

            }


            if ($normal_save !== false) {

                if ($text_boxes_save === false || $answer_boxes_save === false) {
                    http_response_code(500);
                    echo json_encode(['code' => 500, 'type' => 'error', 'message' => "Couldn't save the data properly"]);
                    die();
                }

                http_response_code(200);
                echo json_encode(['code' => 200, 'type' => 'success', 'message' => "Data has been saved!"]);
                die();
            } else {
                http_response_code(500);
                echo json_encode(['code' => 500, 'type' => 'error', 'message' => "Couldn't save the data properly"]);
                die();
            }

        } else {
            http_response_code(400);
            echo json_encode(['code' => 400, 'type' => 'error', 'message' => 'Game not found.']);
            die();
        }

    }

} else if (isset($_POST['save_conditions'])) {

    if (isset($_POST['condition'])) {
        $insert = [];
        $update = [];
        

        $g = new Game($db);
        $game_conditions = $g->get_game_conditions ($_POST['save_conditions']);

    
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
        
        $success = true;
        if (!empty($insert)) {
            $success = $g->insert_game_conditions ($insert, $_POST['save_conditions']);
        }
        if (!empty($update)) {
            $success = $g->update_game_conditions ($update, $_POST['save_conditions']);
        }
        
        if ($success) {
            http_response_code(200);
            echo json_encode(['code' => 200, 'type' => 'success', 'message' => 'Condition values are saved.']);
            die();
        } else {
            http_response_code(500);
            echo json_encode(['code' => 500, 'type' => 'error', 'message' => 'Cannot update the conditions.']);
            die();
        }
    }

} else if (isset($_GET['game'])) {

    if (is_numeric($_GET['game']) && !empty($_GET['game'])) {

        $games = [];
        $g = new Game($db);
        $r = $g->get_all_game_information(normal_text($_GET['game']));

        if (!empty($r)) {            
            http_response_code(200);
            echo json_encode(['code' => 200, 'type' => 'success', 'message' => $r]);
            die();
        } else {
            http_response_code(400);
            echo json_encode(['code' => 400, 'type' => 'error', 'message' => 'Game not found.']);
            die();
        }

    }

}

