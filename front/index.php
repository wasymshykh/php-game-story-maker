<?php

require_once '../config/init.php';

$g = new Game($db);

$categories = $g->get_categories();



include_once DIR . 'views/control/header.view.php';
include_once DIR . 'views/front/index.view.php';
include_once DIR . 'views/control/footer.view.php';