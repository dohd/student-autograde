<?php


if (isset($_POST['id']) && $_POST['id'] ==  'student') {
    unset($_POST['id']);
    $pdo->prepare('INSERT INTO students(name) VALUES(?)')->execute([$_POST['name']]);

    // redirect
    header('Location: /students.php');
    exit();
}

// fetch student rows
$student_rows = $pdo->query('SELECT * FROM students')->fetchAll(PDO::FETCH_ASSOC);

// store in session
$_SESSION['students'] = $student_rows;
