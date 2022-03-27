<?php

/** Grade each subject score */
function score_grade($v)
{
    $v = (int) $v;
    switch (true) {
        case ($v > 79 && $v < 101):
            return array('point' => 12, 'grade' => 'A');
        case ($v > 74 && $v < 80):
            return array('point' => 11, 'grade' => 'A-');
        case ($v > 69 && $v < 75):
            return array('point' => 10, 'grade' => 'B+');
        case ($v > 64 && $v < 70):
            return array('point' => 9, 'grade' => 'B');
        case ($v > 59 && $v < 65):
            return array('point' => 8, 'grade' => 'B-');
        case ($v > 54 && $v < 60):
            return array('point' => 7, 'grade' => 'C+');
        case ($v > 49 && $v < 55):
            return array('point' => 6, 'grade' => 'C');
        case ($v > 44 && $v < 50):
            return array('point' => 5, 'grade' => 'C-');
        case ($v > 39 && $v < 45):
            return array('point' => 4, 'grade' => 'D+');
        case ($v > 34 && $v < 40):
            return array('point' => 3, 'grade' => 'D');
        case ($v > 29 && $v < 35):
            return array('point' => 2, 'grade' => 'D-');
        case ($v > 0 && $v < 30):
            return array('point' => 1, 'grade' => 'E');
        default:
            return array();
    }   
}

/** Grade mean points */
function mean_grade($v)
{
    switch(true) {
        case ($v > 80 && $v < 85):
            return 'A';
        case ($v > 73 && $v < 81):
            return 'A-';
        case ($v > 66 && $v < 74):
            return 'B+';
        case ($v > 59 && $v < 67):
            return 'B';
        case ($v > 52 && $v < 60):
            return 'B-';
        case ($v > 45 && $v < 53):
            return 'C+';
        case ($v > 38 && $v < 46):
            return 'C';
        case ($v > 31 && $v < 39):
            return 'C-';
        case ($v > 24 && $v < 32):
            return 'D+';
        case ($v > 17 && $v < 25):
            return 'D';
        case ($v > 10 && $v < 18):
            return 'D-';
        case ($v > 6 && $v < 11):
            return 'E';
    }
}

/** 
 *  Mean points obtained from all subject scores 
 *  adhearing to the 3,2,1 rule
 * */
function mean_points($scores=[])
{
    $points = 0;
    // add the first 3 subjects
    for ($i = 0; $i < 3; $i++) {
        $points += $scores[$i]['point'];
        unset($scores[$i]);
    }

    // next 2 sciences
    $tmp_scores = array();
    $science_codes = array(233, 231, 232);
    foreach($scores as $value) {
        $exist = in_array(intval($value['code']), $science_codes);
        if ($exist) $tmp_scores[] = $value;
    }
    // sort and add the highest 2 sciences
    array_multisort(array_column($tmp_scores, 'score'), SORT_DESC, $tmp_scores);
    for ($i = 0; $i < 2; $i++) {
        $points += $tmp_scores[$i]['point'];
        unset($scores[array_search($tmp_scores[$i], $scores)]);
    }

    // next 1 humanity
    $tmp_scores = array();
    $humanity_codes = array(312, 313, 311);
    foreach($scores as $value) {
        $exist = in_array(intval($value['code']), $humanity_codes);
        if ($exist) $tmp_scores[] = $value;
    }
    // sort and add the highest scored humanity
    array_multisort(array_column($tmp_scores, 'score'), SORT_DESC, $tmp_scores);
    $points += $tmp_scores[0]['point'];
    unset($scores[array_search($tmp_scores[0], $scores)]);

    // sort and add the highest subject out of the remainder subjects
    array_multisort(array_column($scores, 'score'), SORT_DESC, $scores);
    $points += array_shift($scores)['point'];

    return $points;
}

/**
 * sort student scores by mean_points and assign positions
 */
function assign_position_by_scores(array $students) 
{
    array_multisort(array_column($students, 'mean_points'), SORT_DESC, $students);
    foreach ($students as $i => $value) {
        $students[$i]['position'] = $i+1;
        if ($i > 0) {
            $prev_points = $students[$i-1]['mean_points'];
            $prev_pos = $students[$i-1]['position'];
            if ($prev_points == $value['mean_points']) {
                $students[$i]['position'] = $prev_pos;
            }    
        }
    }
    return $students;
}

/**
 * sort and group students by stream
 */
function group_by_stream(array $students)
{
    $n = 0;
    $stream_groups = array();
    array_multisort(array_column($students, 'stream_id'), SORT_ASC, $students);
    foreach ($students as $i => $student) {
        if ($i == 0) $stream_groups[$i] = array($student);
        else {
            $prev_student = $students[$i-1];
            if ($prev_student['stream_id'] == $student['stream_id']) {
                $stream_groups[$n][] = $student;
            } else {
                $n++;
                $stream_groups[$n] = array($student);
            }
        }
    }
    return $stream_groups;
}
