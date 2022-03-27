<?php

require_once 'helpers.php';
require_once 'services/score_grade_service.php';

function rank_formhandler($student_id, $subject_ids=[], $scores=[])
{
    $id_exists = query('SELECT student_id FROM student_scores WHERE student_id=' . $student_id . ' LIMIT 1');
    if ($id_exists) return error_alert('Student already ranked!');
    
    try {
        $sql = 'INSERT INTO student_scores(student_id, subject_id, score) VALUES(?,?,?)';
        foreach ($subject_ids as $i => $value) {
            query($sql, array($student_id, $value, $scores[$i]));
        }

        // redirect
        header('Location: /rank.php');
        exit();
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }
}
if (isset($_POST['id']) && $_POST['id'] ==  'rank') {
    unset($_POST['id']);
    rank_formhandler($_POST['student_id'], $_POST['subject_id'], $_POST['score']);
}

/**
 * Fetch data
 */
$student_subjects = $_SESSION['student_subjects'];
$subject_rows = query('SELECT code, name from subjects ORDER BY code');

// students
$sql = '
SELECT std.id, std.reg_no, std.name, std.stream_id, str.name as stream_name FROM students std 
INNER JOIN student_scores ss ON ss.student_id = std.id
INNER JOIN streams as str ON str.id = std.stream_id
GROUP BY std.id
';
$students = query($sql);

// subject scores
$sql = '
SELECT subj.code, subj.name, ss.score, ss.student_id FROM subjects subj
INNER JOIN student_scores ss ON ss.subject_id = subj.id
ORDER BY subj.code
';
$subject_scores = query($sql);

// associate each student with corresponding scores
$student_scores = array();
foreach ($students as $student_row) {
    $student = $student_row;
    // assign scores
    $student['scores'] = array();
    foreach ($subject_scores as $score_row) {
        if ($student_row['id'] == $score_row['student_id']) {
            $score = $score_row['score'];
            if (!$score) $student['scores'][] = $score_row;
            else $student['scores'][] = $score_row + score_grade($score);
        }
    }
    // assign mean points and mean grade
    $points = mean_points($student['scores']);
    $student['mean_points'] = $points;
    $student['mean_grade'] = mean_grade($points);
    $student_scores[] = $student;
}
// assign overal positions
$student_scores = assign_position_by_scores($student_scores);

// group students into streams
$stream_groups = group_by_stream($student_scores);
// assign positions in each stream
$stream_groups = array_reduce($stream_groups, function($init, $stream) {
    $init[] = assign_position_by_scores($stream);
    return $init;
}, []);
$stream_student_scores = array_merge(...$stream_groups);
