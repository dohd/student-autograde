<?php

if (isset($_POST['id']) && $_POST['id'] ==  'stream') {
    unset($_POST['id']);

    $id_exists = query('SELECT id FROM streams WHERE name="' . $_POST['name'] . '" LIMIT 1');
    if ($id_exists) return error_alert('Stream exists!');

    try {
        query('INSERT INTO streams(name) VALUES(?)', array($_POST['name']));
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }

    // redirect
    header('Location: /streams.php');
    exit();
}

// fetch stream rows
$stream_rows = query('SELECT * FROM streams');
// store in session
$_SESSION['streams'] = $stream_rows;
