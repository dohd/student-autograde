<?php

require_once 'helpers.php';
require_once 'services/rank_score_service.php';

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
    $ttl_points = 0;
    $ttl_score = 0;
    foreach ($subject_scores as $score_row) {
        if ($student_row['id'] == $score_row['student_id']) {
            if (!empty($score_row['score'])) {
                $score_row = array_merge($score_row, rank_score($score_row['score']));
                $ttl_points += $score_row['point'];
                $ttl_score += $score_row['score'];    
            }
            $student['scores'][] = $score_row;
        }
    }

    $n = count($student['scores']);
    $avg_points = number_format(($ttl_points/$n), 4) ;
    $avg_score = $ttl_score/$n;
    $student['avg_points'] = $avg_points;
    $student['avg_grade'] = rank_score($avg_score)['grade'];

    $student_scores[] = $student;
}

// sort student scores by avg_points
array_multisort(array_column($student_scores, 'avg_points'), SORT_DESC, $student_scores);
// assign positions on sorted student scores
foreach ($student_scores as $key => $student) {
    $student_scores[$key]['position'] = $key+1;
    if (!$key) continue;
    $prev_points = $student_scores[$key-1]['avg_points'];
    $curr_points = $student['avg_points'];
    if ($prev_points == $curr_points) {
        $student_scores[$key]['position'] = $key;
    }
}
