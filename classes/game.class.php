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

    public function get_games ()
    {
        $q = 'SELECT * FROM `games` g JOIN `categories` c ON g.`game_category_id` = c.`category_id`';
        $s = $this->db->prepare($q);
    
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
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

        return $this->db->lastInsertId();
    }

}

