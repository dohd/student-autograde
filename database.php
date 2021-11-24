<?php

// initialize pdo instance for database connection
$pdo = new PDO('sqlite:app.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
