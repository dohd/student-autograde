<?php

// form handler
if (isset($_POST['id']) && $_POST['id'] ==  'subject') {
    unset($_POST['id']);

    $stmt = $pdo->prepare('INSERT INTO subjects(name,type) VALUES(?,?)');
    $stmt->execute([$_POST['name'], $_POST['type']]);

    // redirect
    header('Location: /subjects.php');
    exit();
}

// fetch subject rows
$subject_rows = $pdo->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);

// store in session
$_SESSION['subjects'] = $subject_rows;
