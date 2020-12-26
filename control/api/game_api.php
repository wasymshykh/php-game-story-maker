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


    if (is_numeric($_GET['add_round']) && !empty($_GET['add_round']) && is_numeric($_GET['round_number']) && !empty($_GET['round_number'])) {
        
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

