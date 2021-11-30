<?php

require_once 'helpers.php';
require_once 'services/subject_conditions_service.php';

/**
 * Form handler
 */
if (isset($_POST['id']) && $_POST['id'] ==  'student_subject') {
    unset($_POST['id']);
    $student_id = $_POST['student_id'];
    $subject_ids = $_POST['subject_id'];
    
    // db query
    $placeholder = str_repeat('?,', count($subject_ids) - 1) . '?';
    $sql = 'SELECT * FROM subjects WHERE id IN ('.$placeholder.')';
    // fetch all subjects with given ids
    $stmt = $pdo->prepare($sql);
    $stmt->execute($subject_ids);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // extract subject names
    $subjects = array();
    foreach($results as $result) {
        $subjects[] = $result['code'];
    }

    // conditional subjects
    $mains = array(121, 101, 102);
    $sciences = array(233, 231, 232);
    $humanities = array(312, 313, 311);

    switch (count($subjects)) {
        case 7:
            $res = condition_for_seven($subjects, compact('mains','sciences','humanities'));
            break;
        case 8:
            $res = condition_for_eight($subjects, compact('mains','sciences','humanities'));
            break;
        case 9:
            $res = condition_for_nine($subjects, compact('mains','sciences','humanities'));
            break;
        default:
            error_alert('At least 7 or at most 9 subjects required!');
    }

    // save valid subjects with corresponsing student
    if (isset($res)) {
        foreach ($results as $result) {
            $stmt = $pdo->prepare('INSERT INTO student_subjects(student_id, subject_id) VALUES(?,?)');
            $stmt->execute([$student_id, $result['id']]);
        }
        // redirect
        header('Location: /student_subjects.php');
        exit();    
    }
}

/**
 * Fetch data
 */

 // get from session
$student_options = $_SESSION['students'];
$subject_options = $_SESSION['subjects'];

// fetch student rows
$sql = '
SELECT std.id, std.name FROM students std 
INNER JOIN student_subjects ss ON ss.student_id = std.id
GROUP BY std.id
';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$student_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// fetch subject rows
$sql = '
SELECT subj.id, subj.name, ss.student_id FROM subjects subj
INNER JOIN student_subjects ss ON ss.subject_id = subj.id
';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$subject_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// associate each student with corresponding subjects
$student_subjects = array();
foreach ($student_rows as $student_row) {
    $student = $student_row;
    $student['subject'] = array();
    foreach ($subject_rows as $subject_row) {
        if ($student_row['id'] == $subject_row['student_id']) {
            $student['subject'][] = $subject_row;
        }
    }
    $student_subjects[] = $student;
}

// store in session
$_SESSION['student_subjects'] = $student_subjects;
