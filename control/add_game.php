<?php

require_once '../config/init.php';

$error = false;


$g = new Game($db);

$categories = $g->get_categories();

if (isset($_POST) && !empty($_POST)) {

    $title = normal_text($_POST['title']);
    $category = normal_text($_POST['category']);
    $author = normal_text($_POST['author']);

    if (!empty(normal_text($_POST['picture']))) {

        $picture = normal_text($_POST['picture']);

    } else {
        
        if (isset($_FILES) && isset($_FILES['picture-file']) && !empty($_FILES['picture-file']['size'])) {
            $check = getimagesize($_FILES["picture-file"]["tmp_name"]);
            if($check !== false) {
            
                $file_ext = strtolower(pathinfo(basename($_FILES["picture-file"]["name"]), PATHINFO_EXTENSION));
                $file_name = time() . '.' . $file_ext;
                $target_file = DIR . "uploads/images/" . $file_name;
    
                if ($_FILES["picture-file"]["size"] < 500000) {
                    if (move_uploaded_file($_FILES["picture-file"]["tmp_name"], $target_file)) {
                        $picture = URL . '/uploads/images/'. $file_name;
                    } else {
                        $error = 'Sorry could not upload the picture';
                    }
                } else {
                    $error = 'Uploaded picture is not too large';
                }
    
            } else {
                $error = 'Uploaded picture is not an image';
            }
        }

    }

    if (!empty(normal_text($_POST['audio']))) {

        $audio = normal_text($_POST['audio']);

    } else {
        
        if (isset($_FILES) && isset($_FILES['audio-file']) && !empty($_FILES['audio-file']['size'])) {
            
            $file_ext = strtolower(pathinfo(basename($_FILES["audio-file"]["name"]), PATHINFO_EXTENSION));
            $file_name = time() . '.' . $file_ext;
            $target_file = DIR . "uploads/media/" . $file_name;

            if ($_FILES["audio-file"]["size"] < 500000) {
                if (move_uploaded_file($_FILES["audio-file"]["tmp_name"], $target_file)) {
                    $audio = URL . '/uploads/media/'. $file_name;
                } else {
                    $error = 'Sorry could not upload the audio';
                }
            } else {
                $error = 'Uploaded audio is not too large';
            }
            
        }

    }

    if (!$error) {

        if (!empty($title) && !empty($category) && !empty($author)) {
            $r = $g->create_game($category, $title, $author, $picture, $audio);
            if ($r !== false) {

                go (URL . '/control/edit_game.php?id='.$r);

            } else {
                $error = "Sorry, cannot insert the record";
            }
        } else {
            $error = "Title, category and author cannot be empty!";
        }

    }

}

include_once DIR . 'views/control/header.view.php';
include_once DIR . 'views/control/add_game.view.php';
include_once DIR . 'views/control/footer.view.php';
