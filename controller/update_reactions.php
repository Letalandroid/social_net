<?php

require_once 'Reactions.php';

use Letalandroid\controllers\Reactions;

if (isset($_POST['post_id']) && isset($_POST['user_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
}

Reactions::update((int) $post_id, (int) $user_id);
