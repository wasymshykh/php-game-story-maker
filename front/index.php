<?php

require_once '../config/init.php';

$g = new Game($db);

$categories = $g->get_categories_front();


include_once DIR . 'views/front/header.view.php';
include_once DIR . 'views/front/index.view.php';
include_once DIR . 'views/front/footer.view.php';
