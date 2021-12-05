<?php

/** Grade each subject score */
function score_grade($v)
{
    $result = array();
    switch (true) {
        case ($v > 79 && $v < 101):
            $result['point'] = 12;
            $result['grade'] = 'A';
            break;
        case ($v > 74 && $v < 80):
            $result['point'] = 11;
            $result['grade'] = 'A-';
            break;
        case ($v > 69 && $v < 75):
            $result['point'] = 10;
            $result['grade'] = 'B+';
            break;
        case ($v > 64 && $v < 70):
            $result['point'] = 9;
            $result['grade'] = 'B';
            break;
        case ($v > 59 && $v < 65):
            $result['point'] = 8;
            $result['grade'] = 'B-';
            break;
        case ($v > 54 && $v < 60):
            $result['point'] = 7;
            $result['grade'] = 'C+';
            break;
        case ($v > 49 && $v < 55):
            $result['point'] = 6;
            $result['grade'] = 'C';
            break;                    
        case ($v > 44 && $v < 50):
            $result['point'] = 5;
            $result['grade'] = 'C-';
            break;                   
        case ($v > 39 && $v < 45):
            $result['point'] = 4;
            $result['grade'] = 'D+';
            break;   
        case ($v > 34 && $v < 40):
            $result['point'] = 3;
            $result['grade'] = 'D';
            break;   
        case ($v > 29 && $v < 35):
            $result['point'] = 2;
            $result['grade'] = 'D-';
            break;
        case ($v > 0 && $v < 30):
            $result['point'] = 1;
            $result['grade'] = 'E';
            break; 
    }
    
    return $result;
}

/** Grade sum of subject scores */
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
