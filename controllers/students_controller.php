<?php

$student_rows = $pdo->query('SELECT * FROM students')->fetchAll(PDO::FETCH_ASSOC);

if ($_POST['id'] == 'student') {
    // store data
    $pdo->prepare('INSERT INTO students(name) VALUES(?)')->execute([$_POST['name']]);

    unset($_POST['id']);
}
