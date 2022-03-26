<?php

if (isset($_POST['id']) && $_POST['id'] ==  'student') {
    unset($_POST['id']);

    try {
        query(
            'INSERT INTO students(reg_no,name,stream_id) VALUES(?,?,?)', 
            array($_POST['reg_no'], $_POST['name'], $_POST['stream_id'])
        );
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }

    // redirect
    header('Location: /students.php');
    exit();
}

// fetch student rows
$student_rows = query('SELECT * FROM students');
// store in session
$_SESSION['students'] = $student_rows;
