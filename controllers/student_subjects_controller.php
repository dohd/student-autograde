<?php

require_once 'helpers.php';
require_once 'services/subject_conditions_service.php';

function student_subject_formhandler($student_id, $subject_ids=[]) {
    // db query
    $placeholder = str_repeat('?,', count($subject_ids) - 1) . '?';
    $sql = 'SELECT * FROM subjects WHERE id IN ('.$placeholder.')';
    // fetch all subjects with given ids
    $results = query($sql, $subject_ids);

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

    if (!isset($res)) return;
    try {
        // save valid subjects with corresponsing student
        foreach ($results as $result) {
            query('INSERT INTO student_subjects(student_id, subject_id) VALUES(?,?)', array($student_id, $result['id']));
        }
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }

    // redirect
    header('Location: /student_subjects.php');
    exit();
}
if (isset($_POST['id']) && $_POST['id'] ==  'student_subject') {
    unset($_POST['id']);
    student_subject_formhandler($_POST['student_id'], $_POST['subject_id']);   
}

/**
 * Fetch data
 */
$student_options = $_SESSION['students'];
$subject_options = $_SESSION['subjects'];

// fetch student rows
$sql = '
SELECT std.id, std.name, std.reg_no FROM students std 
INNER JOIN student_subjects ss ON ss.student_id = std.id
GROUP BY std.id
';
$student_rows = query($sql);

// fetch subject rows
$sql = '
SELECT subj.id, subj.name, subj.code, ss.student_id FROM subjects subj
INNER JOIN student_subjects ss ON ss.subject_id = subj.id
';
$subject_rows = query($sql);

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
