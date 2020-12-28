<?php

class Game
{
    
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function get_categories ()
    {
        $q = 'SELECT * FROM `categories`';
        $s = $this->db->prepare($q);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_categories_front($answers = false)
    {
        $data = [];
        
        $categories = $this->get_categories();
        foreach ($categories as $category) {
            $games = $this->get_game_by('game_category_id', $category['category_id'], true);
            
            array_push($data, $category);
            $category_index = count($data) - 1;

            foreach ($games as $game) {

                if (!array_key_exists('games', $data[$category_index])) {
                    $data[$category_index]['games'] = [];
                }
                array_push($data[$category_index]['games'], $game);
                $game_index = count($data[$category_index]['games']) - 1;
                
                // rounds
                $rounds = $this->get_games_rounds($game['game_id']);
                foreach ($rounds as $round) {
                    
                    if (!array_key_exists('rounds', $data[$category_index]['games'][$game_index])) {
                        $data[$category_index]['games'][$game_index]['rounds'] = [];
                    }
                    array_push($data[$category_index]['games'][$game_index]['rounds'], $round);
                    $round_index = count($data[$category_index]['games'][$game_index]['rounds']) - 1;

                    // text blocks
                    $textblocks = $this->get_all_texts_by_round($round['round_id']);
                    $data[$category_index]['games'][$game_index]['rounds'][$round_index]['textblocks'] = $textblocks;

                    if ($answers) {
                        //  answer blocks
                        $answerblocks = $this->get_all_answers_by_round($round['round_id']);
                        $data[$category_index]['games'][$game_index]['rounds'][$round_index]['answerblocks'] = $answerblocks;
                    }
                }
            }
        }

        return $data;
    }

    public function get_game_front ($game_id)
    {
        
        $game = $this->get_game_by('game_id', $game_id);

        if ($game === false || empty($game)) {
            return false;
        }

        // rounds
        $rounds = $this->get_games_rounds($game['game_id']);
        foreach ($rounds as $round) {
            if (!array_key_exists('rounds', $game)) {
                $game['rounds'] = [];
            }
            array_push($game['rounds'], $round);
            $round_index = count($game['rounds']) - 1;

            // text blocks
            $textblocks = $this->get_all_texts_by_round($round['round_id']);
            $game['rounds'][$round_index]['textblocks'] = $textblocks;

            //  answer blocks
            $answerblocks = $this->get_all_answers_by_round($round['round_id']);
            $game['rounds'][$round_index]['answerblocks'] = $answerblocks;
        }

        return $game;
        
    }

    public function insert_category ($name)
    {
        $q = "INSERT INTO `categories` (`category_name`, `category_created`) VALUE (:n, :dt)";
        $s = $this->db->prepare($q);
        $s->bindParam(':n', $name);
        $datetime = current_date();
        $s->bindParam(':dt', $datetime);
        return $s->execute();
    }
    
    public function update_category ($cat_id, $name)
    {
        $q = "UPDATE `categories` SET `category_name` = :n WHERE `category_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':n', $name);
        $s->bindParam(':i', $cat_id);
        return $s->execute();
    }

    public function remove_category ($cat_id)
    {
        $q = "DELETE FROM `categories` WHERE `category_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $cat_id);
        return $s->execute();
    }

    public function remove_game ($game_id)
    {
        $q = "DELETE FROM `game_conditions` WHERE `gc_game_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $game_id);
        $s->execute();
        
        $q = "DELETE FROM `rounds` WHERE `round_game_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $game_id);
        $s->execute();

        $q = "DELETE FROM `games` WHERE `game_id` = :i";
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $game_id);
        
        return $s->execute();
    }

    public function get_games ()
    {
        $q = 'SELECT * FROM `games` g JOIN `categories` c ON g.`game_category_id` = c.`category_id`';
        $s = $this->db->prepare($q);
    
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_game_by($col, $val, $multiple = false)
    {
        $q = "SELECT * FROM `games` g WHERE `$col` = :v";
        $s = $this->db->prepare($q);
        $s->bindParam(':v', $val);

        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }

    public function get_all_game_information ($game_id)
    {
        $r = $this->get_game_by("game_id", $game_id);
        if ($r && !empty($r)) {
            
            return $r;

        }
        return [];
    }

    public function get_conditions()
    {
        $q = 'SELECT * FROM `conditions`';
        $s = $this->db->prepare($q);
    
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_game_conditions($game_id)
    {
        $q = 'SELECT * FROM `game_conditions` WHERE `gc_game_id` = :i';
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $game_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function insert_game_conditions ($data, $game_id)
    {
        $vals = "";
        $i = 0;
        foreach ($data as $condition_id => $condition_value) {
            if ($i > 0) {
                $vals .= ", ";
            }
            $vals .= "('$game_id', '$condition_id', '$condition_value')";
            $i += 1;
        }

        $q = "INSERT INTO `game_conditions` (`gc_game_id`, `gc_condition_id`, `gc_condition_value`) VALUES $vals";
        $s = $this->db->prepare($q);

        return $s->execute();
    }

    public function update_game_conditions ($data, $game_id)
    {
        foreach ($data as $condition_id => $condition_value) {
            
            $q = "UPDATE `game_conditions` SET `gc_condition_value` = '$condition_value' WHERE `gc_condition_id` = :i AND `gc_game_id` = :gi";
            $s = $this->db->prepare($q);
            $s->bindParam(':i', $condition_id);
            $s->bindParam(':gi', $game_id);

            $s->execute();
        }
    }

    public function create_game ($cat_id, $title, $author, $picture, $audio)
    {
        $q = "INSERT INTO `games` (`game_category_id`, `game_title`, `game_author`, `game_picture`, `game_audio`, `game_created`) VALUE (:ci, :t, :a, :p, :au, :dt)";

        $s = $this->db->prepare($q);
        $s->bindParam(':ci', $cat_id);
        $s->bindParam(':t', $title);
        $s->bindParam(':a', $author);
        $s->bindParam(':p', $picture);
        $s->bindParam(':au', $audio);
        $datetime = current_date();
        $s->bindParam(':dt', $datetime);

        if (!$s->execute()) {
            return false;
        }

        $game_id = $this->db->lastInsertId();
        // insert a 0 round
        $q = "INSERT INTO `rounds` (`round_game_id`, `round_number`) VALUE (:gi, '0')";
        $s = $this->db->prepare($q);
        $s->bindParam(':gi', $game_id);
        $s->execute();

        return $game_id;
    }

    public function get_games_rounds($game_id)
    {
        $q = 'SELECT * FROM `rounds` WHERE `round_game_id` = :i';
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $game_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function get_all_texts_by_round($round_id)
    {
        $q = 'SELECT * FROM `text_blocks` WHERE `tb_round_id` = :i';
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $round_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }
    public function get_all_answers_by_round($round_id)
    {
        $q = 'SELECT * FROM `answer_blocks` WHERE `ab_round_id` = :i';
        $s = $this->db->prepare($q);
        $s->bindParam(':i', $round_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function insert_round ($game_id, $round_number)
    {
        $q = 'INSERT INTO `rounds` (`round_game_id`, `round_number`) VALUE (:g, :n)';
        $s = $this->db->prepare($q);
        $s->bindParam(":g", $game_id);
        $s->bindParam(":n", $round_number);
        
        if ($s->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update_game_information($data, $game_id)
    {
        $q = "UPDATE `games` SET";
        $i = 0;
        foreach ($data as $column => $value) {
            if ($i > 0) {
                $q .= ", ";
            }
            $q .= " `$column` = '$value'";
        }
        $q .= "WHERE `game_id` = '$game_id'";

        $s = $this->db->prepare($q);

        return $s->execute();
    }

    
    public function insert_abs ($data)
    {

        $sorted = [];
        
        foreach ($data as $round_id => $abs) {
            for ($i=0; $i < count($abs['acondition_1']); $i++) {
                if (!array_key_exists($round_id, $sorted)) {
                    $sorted[$round_id] = [];
                }
                array_push($sorted[$round_id], [
                    'ab_condition_1_id' => $abs['acondition_1'][$i], 
                    'ab_condition_between' => $abs['acondition_between'][$i], 
                    'ab_condition_2_id' => $abs['acondition_2'][$i], 
                    'ab_text' => $abs['atext'][$i], 
                    'ab_auto_set' => $abs['aautoset'][$i],
                    'ab_unset' => $abs['aautounset'][$i]
                ]);
            }
        }

        $to_insert = [];
        $to_update = [];
        $to_remove = [];

        foreach ($sorted as $round_id => $answerboxes) {

            $old_answerboxes = $this->get_all_answers_by_round($round_id);

            if (count($answerboxes) >= count($old_answerboxes)) {
                // that means new text box is added
                $i = 0;
                for (; $i < count($old_answerboxes); $i++) {
                    // check if the row needs to be updated
                    if (normal_text($old_answerboxes[$i]['ab_text']) !== $answerboxes[$i]['ab_text'] || normal_text($old_answerboxes[$i]['ab_condition_1_id']) !== $answerboxes[$i]['ab_condition_1_id'] || normal_text($old_answerboxes[$i]['ab_condition_between']) !== $answerboxes[$i]['ab_condition_between'] || normal_text($old_answerboxes[$i]['ab_condition_2_id']) !== $answerboxes[$i]['ab_condition_2_id'] || normal_text($old_answerboxes[$i]['ab_auto_set']) !== $answerboxes[$i]['ab_auto_set'] || normal_text($old_answerboxes[$i]['ab_unset']) !== $answerboxes[$i]['ab_unset']) {
                        $to_update[$old_answerboxes[$i]['ab_id']] = $answerboxes[$i];
                    }
                }
                
                for (; $i < count($answerboxes); $i++) {
                    // the extra new boxes
                    array_push($to_insert, $answerboxes[$i]);
                    $to_insert[count($to_insert)-1]['ab_round_id'] = $round_id;
                }
            } else {

                $i = 0;
                for (; $i < count($answerboxes); $i++) {
                    // check if the row needs to be updated
                    if (normal_text($old_answerboxes[$i]['ab_text']) !== $answerboxes[$i]['ab_text'] || normal_text($old_answerboxes[$i]['ab_condition_1_id']) !== $answerboxes[$i]['ab_condition_1_id'] || normal_text($old_answerboxes[$i]['ab_condition_between']) !== $answerboxes[$i]['ab_condition_between'] || normal_text($old_answerboxes[$i]['ab_condition_2_id']) !== $answerboxes[$i]['ab_condition_2_id'] || normal_text($old_answerboxes[$i]['ab_auto_set']) !== $answerboxes[$i]['ab_auto_set'] || normal_text($old_answerboxes[$i]['ab_unset']) !== $answerboxes[$i]['ab_unset']) {
                        $to_update[$old_answerboxes[$i]['ab_id']] = $answerboxes[$i];
                    }
                }

                for (; $i < count($old_answerboxes); $i++) {
                    // the boxes needs to be removed
                    array_push($to_remove, $old_answerboxes[$i]);
                }

            }
            
        }
        
        $error = false;
        $result = null;
        if (!empty($to_insert)) {
            $result = $this->insert_answer_boxes($to_insert);
            if ($result === false) {
                $error .= "Error while inserting the data. ";
            }
        }

        if (!empty($to_update)) {
            $result = $this->update_answer_boxes($to_update);
            if ($result['failure'] > 0) {
                $error .= "Error while updating the data. ";
            }
        }

        if (!empty($to_remove)) {
            $result = $this->remove_answer_boxes($to_remove);
            if ($result === false) {
                $error .= "Error while removing the data. ";
            }
        }

        if ($error) {
            return ['status' => false, 'message' => $error];
        }

        return ['status' => true];
    }

    public function remove_answer_boxes ($boxes)
    {
        $in = "";
        $i = 0;
        foreach ($boxes as $box) {
            if ($i > 0) {
                $in .= ", ";
            }
            $in .= "'".$box['ab_id']."'";
            $i++;
        }

        $q = "DELETE FROM `answer_blocks` WHERE `ab_id` IN ($in)";
        $s = $this->db->prepare($q);
        
        return $s->execute();
    }

    public function update_answer_boxes ($boxes)
    {
        $failure = 0;
        $success = 0;

        foreach ($boxes as $ab_id => $answer_box) {

            $q = "UPDATE `answer_blocks` SET `ab_text` = :t, `ab_condition_1_id` = :c1, `ab_condition_between` = :cb, `ab_condition_2_id` = :c2, `ab_auto_set` = :a, `ab_unset` = :au WHERE `ab_id` = :i";
            $s = $this->db->prepare($q);
            $s->bindParam(":i", $ab_id);
            $s->bindParam(":t", $answer_box['ab_text']);

            $c1 = !empty($answer_box['ab_condition_1_id']) ? $answer_box['ab_condition_1_id'] : NULL;
            $s->bindParam(":c1", $c1);

            $s->bindParam(":cb", $answer_box['ab_condition_between']);

            $c2 = !empty($answer_box['ab_condition_2_id']) ? $answer_box['ab_condition_2_id'] : NULL;
            $s->bindParam(":c2", $c2);

            $a = !empty($answer_box['ab_auto_set']) ? $answer_box['ab_auto_set'] : NULL;
            $s->bindParam(":a", $a);

            $au = !empty($answer_box['ab_unset']) ? $answer_box['ab_unset'] : NULL;
            $s->bindParam(":au", $au);
            
            if ($s->execute()) {
                $success += 1;
            } else {
                $failure += 1;
            }

        }

        return ['success' => $success, 'failure' => $failure];
    }

    public function insert_answer_boxes ($boxes)
    {
        $cols = "";
        $vals = "";

        $i = 0;
        foreach ($boxes[0] as $col => $val) {
            if ($i > 0) {
                $cols .= ", ";
            }
            $cols .= "`$col`";
            $i++;
        }

        $i = 0;
        foreach ($boxes as $box) {
            if ($i > 0) {
                $vals .= ", ";
            }
            $vals .= "(";
            $j = 0;
            foreach ($box as $col => $val) {
                if ($j > 0) {
                    $vals .= ", ";
                }
                $vals .= !empty($val) ? "'$val'" : "NULL";
                $j++;
            }
            $vals .= ")";
            $i++;
        }
        
        $q = "INSERT INTO `answer_blocks` ($cols) VALUES $vals";
        $s = $this->db->prepare($q);
        
        return $s->execute();
    }



    public function insert_tbs ($data)
    {
        $sorted = [];
        
        foreach ($data as $round_id => $tbs) {
            for ($i=0; $i < count($tbs['condition_1']); $i++) {
                if (!array_key_exists($round_id, $sorted)) {
                    $sorted[$round_id] = [];
                }
                array_push($sorted[$round_id], [
                    'tb_condition_1_id' => $tbs['condition_1'][$i], 
                    'tb_condition_between' => $tbs['condition_between'][$i], 
                    'tb_condition_2_id' => $tbs['condition_2'][$i], 
                    'tb_text' => $tbs['text'][$i], 
                    'tb_auto_set' => $tbs['autoset'][$i]
                ]);
            }
        }

        $to_insert = [];
        $to_update = [];
        $to_remove = [];

        foreach ($sorted as $round_id => $textboxes) {

            $old_textboxes = $this->get_all_texts_by_round($round_id);

            if (count($textboxes) >= count($old_textboxes)) {
                // that means new text box is added
                $i = 0;
                for (; $i < count($old_textboxes); $i++) {
                    // check if the row needs to be updated
                    if (normal_text($old_textboxes[$i]['tb_text']) !== $textboxes[$i]['tb_text'] || normal_text($old_textboxes[$i]['tb_condition_1_id']) !== $textboxes[$i]['tb_condition_1_id'] || normal_text($old_textboxes[$i]['tb_condition_between']) !== $textboxes[$i]['tb_condition_between'] || normal_text($old_textboxes[$i]['tb_condition_2_id']) !== $textboxes[$i]['tb_condition_2_id'] || normal_text($old_textboxes[$i]['tb_auto_set']) !== $textboxes[$i]['tb_auto_set']) {
                        $to_update[$old_textboxes[$i]['tb_id']] = $textboxes[$i];
                    }
                }
                
                for (; $i < count($textboxes); $i++) {
                    // the extra new boxes
                    array_push($to_insert, $textboxes[$i]);
                    $to_insert[count($to_insert)-1]['tb_round_id'] = $round_id;
                }
            } else {

                $i = 0;
                for (; $i < count($textboxes); $i++) {
                    // check if the row needs to be updated
                    if (normal_text($old_textboxes[$i]['tb_text']) !== $textboxes[$i]['tb_text'] || normal_text($old_textboxes[$i]['tb_condition_1_id']) !== $textboxes[$i]['tb_condition_1_id'] || normal_text($old_textboxes[$i]['tb_condition_between']) !== $textboxes[$i]['tb_condition_between'] || normal_text($old_textboxes[$i]['tb_condition_2_id']) !== $textboxes[$i]['tb_condition_2_id'] || normal_text($old_textboxes[$i]['tb_auto_set']) !== $textboxes[$i]['tb_auto_set']) {
                        $to_update[$old_textboxes[$i]['tb_id']] = $textboxes[$i];
                    }
                }

                for (; $i < count($old_textboxes); $i++) {
                    // the boxes needs to be removed
                    array_push($to_remove, $old_textboxes[$i]);
                }

            }
            
        }
        
        $error = false;
        $result = null;
        if (!empty($to_insert)) {
            $result = $this->insert_text_boxes($to_insert);
            if ($result === false) {
                $error .= "Error while inserting the data. ";
            }
        }

        if (!empty($to_update)) {
            $result = $this->update_text_boxes($to_update);
            if ($result['failure'] > 0) {
                $error .= "Error while updating the data. ";
            }
        }

        if (!empty($to_remove)) {
            $result = $this->remove_text_boxes($to_remove);
            if ($result === false) {
                $error .= "Error while removing the data. ";
            }
        }

        if ($error) {
            return ['status' => false, 'message' => $error];
        }

        return ['status' => true];
    }

    public function remove_text_boxes ($boxes)
    {
        $in = "";
        $i = 0;
        foreach ($boxes as $box) {
            if ($i > 0) {
                $in .= ", ";
            }
            $in .= "'".$box['tb_id']."'";
            $i++;
        }

        $q = "DELETE FROM `text_blocks` WHERE `tb_id` IN ($in)";
        $s = $this->db->prepare($q);
        
        return $s->execute();
    }

    public function update_text_boxes ($boxes)
    {
        $failure = 0;
        $success = 0;

        foreach ($boxes as $tb_id => $text_box) {

            $q = "UPDATE `text_blocks` SET `tb_text` = :t, `tb_condition_1_id` = :c1, `tb_condition_between` = :cb, `tb_condition_2_id` = :c2, `tb_auto_set` = :a WHERE `tb_id` = :i";
            $s = $this->db->prepare($q);
            $s->bindParam(":i", $tb_id);
            $s->bindParam(":t", $text_box['tb_text']);

            $c1 = !empty($text_box['tb_condition_1_id']) ? $text_box['tb_condition_1_id'] : NULL;
            $s->bindParam(":c1", $c1);

            $s->bindParam(":cb", $text_box['tb_condition_between']);

            $c2 = !empty($text_box['tb_condition_2_id']) ? $text_box['tb_condition_2_id'] : NULL;
            $s->bindParam(":c2", $c2);

            $a = !empty($text_box['tb_auto_set']) ? $text_box['tb_auto_set'] : NULL;
            $s->bindParam(":a", $a);
            
            if ($s->execute()) {
                $success += 1;
            } else {
                $failure += 1;
            }

        }

        return ['success' => $success, 'failure' => $failure];
    }


    public function insert_text_boxes ($boxes)
    {
        $cols = "";
        $vals = "";

        $i = 0;
        foreach ($boxes[0] as $col => $val) {
            if ($i > 0) {
                $cols .= ", ";
            }
            $cols .= "`$col`";
            $i++;
        }

        $i = 0;
        foreach ($boxes as $box) {
            if ($i > 0) {
                $vals .= ", ";
            }
            $vals .= "(";
            $j = 0;
            foreach ($box as $col => $val) {
                if ($j > 0) {
                    $vals .= ", ";
                }
                $vals .= !empty($val) ? "'$val'" : "NULL";
                $j++;
            }
            $vals .= ")";
            $i++;
        }
        
        $q = "INSERT INTO `text_blocks` ($cols) VALUES $vals";
        $s = $this->db->prepare($q);
        
        return $s->execute();
    }


}

