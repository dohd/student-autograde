<?php

require_once 'helpers.php';

/**
 * Form POST
 */
if (isset($_POST['id']) && $_POST['id'] ==  'student_mark') {
    unset($_POST['id']);

    $stmt = $pdo->prepare('INSERT INTO student_marks(mark, student_id, subject_id) VALUES(?,?,?)');
    $stmt->execute([$_POST['mark'], $_POST['student_id'], $_POST['subject_id']]);

    // redirect
    header('Location: /student_marks.php');
    exit();    
}

/**
 * Fetch data
 */
$student_subjects = $_SESSION['student_subjects'];
$subject_rows = $_SESSION['subjects'];
