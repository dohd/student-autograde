<?php

if ($_POST['id'] == 'student_mark') {
    // store data
    $stmt = $pdo->prepare('INSERT INTO student_marks(mark, student_id, subject_id) VALUES(?,?,?)');
    $stmt->execute([$_POST['mark'], $_POST['student_id'], $_POST['subject_id']]);

    unset($_POST['id']);
}
