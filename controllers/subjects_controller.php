<?php

$subject_rows = $pdo->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);

if ($_POST['id'] == 'subject') {
    // store data
    $stmt = $pdo->prepare('INSERT INTO subjects(name,type) VALUES(?,?)');
    $stmt->execute([$_POST['name'], $_POST['type']]);

    unset($_POST['id']);
}
