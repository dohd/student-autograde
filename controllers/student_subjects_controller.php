<?php

if ($_POST['id'] == 'student_subject') {
    $student_id = $_POST['student_id'];
    $subject_ids = $_POST['subject_id'];

    // check if subject count is between 7 and 9
    $n = count($subject_ids);
    if ($n < 7 || $n > 9) {
        return error_alert('At least 7 or at most 9 subjects required!');
    }
    
    // db query
    $placeholder = str_repeat('?,', $n - 1) . '?';
    $sql = 'SELECT * FROM subjects WHERE id IN ('.$placeholder.')';
    // fetch all subjects with given ids
    $stmt = $pdo->prepare($sql);
    $stmt->execute($subject_ids);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // form array of names from results
    $subjects = array();
    foreach($results as $result) {
        $subjects[] = $result['name'];
    }

    // conditional subjects
    $mains = array('maths', 'english', 'kiswahili');
    $sciences = array('chemistry', 'biology', 'physics');
    $humanities = array('geography','cre','history');

    if ($n == 7) {
        // check for the compulsory 3 subjects
        foreach($mains as $value) {
            if (!in_array($value, $subjects)) {
                return error_alert($value . ' is required!');
            }
        }

        // check if science pair exists
        if (in_array($sciences[0], $subjects) && in_array($sciences[1], $subjects)) {
            // 
        } elseif (in_array($sciences[0], $subjects) && in_array($sciences[2], $subjects)) {
            // 
        } elseif (in_array($sciences[1], $subjects) && in_array($sciences[2], $subjects)) {
            // 
        } else {
            return error_alert('At least 2 sciences out of chemistry, biology and physics required!');
        } 

        // check for at least one humanity
        foreach($humanities as $value) {
            if (in_array($value, $subjects)) {
                $humanity = true;
            }
        }
        if (!isset($humanity)) {
            return error_alert('At least 1 humanity out of geography, cre and history required!');
        }

        browser_log($results);
    }
    
    unset($_POST['id']);
}
