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


            if ($normal_save !== false) {
                http_response_code(200);
                echo json_encode(['code' => 200, 'type' => 'success', 'message' => "Data has been saved!"]);
                die();
            } else {
                http_response_code(500);
                echo json_encode(['code' => 500, 'type' => 'error', 'message' => "Couldn't save the data"]);
                die();
            }

        } else {
            http_response_code(400);
            echo json_encode(['code' => 400, 'type' => 'error', 'message' => 'Game not found.']);
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

