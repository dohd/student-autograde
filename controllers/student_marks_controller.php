<?php

require_once 'helpers.php';

/**
 * Form POST
 */
if (isset($_POST['id']) && $_POST['id'] ==  'student_score') {
    unset($_POST['id']);
    $student_id = $_POST['student_id'];
    $subject_ids = $_POST['subject_id'];
    $scores = $_POST['score'];

    $sql = 'INSERT INTO student_scores(student_id, subject_id, score) VALUES(?,?,?)';

    try {
        foreach ($subject_ids as $key => $value) {
            if (!isset($scores[$key])) $scores[$key] = null;
            query($sql, array($student_id, $value, $scores[$key]));
        }
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }

    // redirect
    header('Location: /student_marks.php');
    exit();
}

/**
 * Fetch data
 */
$student_subjects = $_SESSION['student_subjects'];
// select all subjects sorted by subject code
$subject_rows = query('SELECT name from subjects ORDER BY code');



browser_log($student_subjects);
