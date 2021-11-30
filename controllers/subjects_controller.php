<?php

// form handler
if (isset($_POST['id']) && $_POST['id'] ==  'subject') {
    unset($_POST['id']);

    try {
        query('INSERT INTO subjects(code,name) VALUES(?,?)', array($_POST['code'], $_POST['name']));
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }

    // redirect
    header('Location: /subjects.php');
    exit();
}

$subject_rows = query('SELECT * FROM subjects');

// store in session
$_SESSION['subjects'] = $subject_rows;
