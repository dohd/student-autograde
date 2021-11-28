<?php

// form handler
if (isset($_POST['id']) && $_POST['id'] ==  'subject') {
    unset($_POST['id']);

    $stmt = $pdo->prepare('INSERT INTO subjects(name,type) VALUES(?,?)');
    $stmt->execute([$_POST['name'], $_POST['type']]);

    $sql = 'INSERT INTO subjects(name,type) VALUES(?,?)';
    query($sql, array($_POST['name'], $_POST['type']));

    // redirect
    header('Location: /subjects.php');
    exit();
}

$subject_rows = query('SELECT * FROM subjects');

// store in session
$_SESSION['subjects'] = $subject_rows;
