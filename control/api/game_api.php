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

