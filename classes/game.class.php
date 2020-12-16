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

    public function insert_tbs ($data)
    {
        $sorted = [];
        foreach ($data as $round_id => $tbs) {
            for ($i=0; $i < count($tbs['condition_1']); $i++) {
                array_push($sorted, [
                    'round_id' => $round_id, 
                    'condition_1' => $tbs['condition_1'][$i], 
                    'condition_between' => $tbs['condition_between'][$i], 
                    'condition_2' => $tbs['condition_2'][$i], 
                    'text' => $tbs['text'][$i], 
                    'autoset' => $tbs['autoset'][$i]
                ]);
            }
        }

        die(var_dump($sorted));

    }


}

