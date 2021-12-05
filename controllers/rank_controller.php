<?php

require_once 'helpers.php';
require_once 'services/score_grade_service.php';

function rank_formhandler($student_id, $subject_ids=[], $scores=[])
{
    $id_exists = query('SELECT student_id FROM student_scores WHERE student_id=' . $student_id . ' LIMIT 1');
    if ($id_exists) return error_alert('Student already ranked!');
    
    try {
        $sql = 'INSERT INTO student_scores(student_id, subject_id, score) VALUES(?,?,?)';
        foreach ($subject_ids as $key => $value) {
            query($sql, array($student_id, $value, $scores[$key]));
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
SELECT std.id, std.reg_no, std.name FROM students std 
INNER JOIN student_scores ss ON ss.student_id = std.id
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
    $student['scores'] = array();
    foreach ($subject_scores as $score_row) {
        if ($student_row['id'] == $score_row['student_id']) {
            $score = $score_row['score'];
            if (empty($score)) {
                $student['scores'][] = $score_row;
                continue;
            }
            $student['scores'][] = array_merge($score_row, score_grade((int) $score));
        }
    }
    $points = mean_points($student['scores']);
    $student['mean_points'] = $points;
    $student['mean_grade'] = mean_grade($points);
    $student_scores[] = $student;
}

// sort student scores by mean_points and assign positions
array_multisort(array_column($student_scores, 'mean_points'), SORT_DESC, $student_scores);
foreach ($student_scores as $key => $value) {
    $student_scores[$key]['position'] = $key+1;
    if (!$key) continue;
    $prev_points = $student_scores[$key-1]['mean_points'];
    $prev_pos = $student_scores[$key-1]['position'];
    if ($prev_points == $value['mean_points']) {
        $student_scores[$key]['position'] = $prev_pos;
    }
}
