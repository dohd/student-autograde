<?php

// initialize pdo instance for database connection
$pdo = new PDO('sqlite:app.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function query($sql='', $params=[])
{
    global $pdo;

    $stmt = $pdo->prepare($sql);
    if ($params) $stmt->execute($params);
    else $stmt->execute();
    
    if (stripos($sql, 'SELECT') === false) return;    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
