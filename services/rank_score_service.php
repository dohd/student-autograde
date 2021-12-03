<?php

function rank_score($score)
{
    $v = (int) $score;
    $rank = array();
    switch (true) {
        case ($v >= 80):
            $rank['point'] = 12;
            $rank['grade'] = 'A';
            break;
        case ($v > 74 && $v < 80):
            $rank['point'] = 11;
            $rank['grade'] = 'A-';
            break;
        case ($v > 69 && $v < 75):
            $rank['point'] = 10;
            $rank['grade'] = 'B+';
            break;
        case ($v > 64 && $v < 70):
            $rank['point'] = 9;
            $rank['grade'] = 'B';
            break;
        case ($v > 59 && $v < 65):
            $rank['point'] = 8;
            $rank['grade'] = 'B-';
            break;
        case ($v > 54 && $v < 60):
            $rank['point'] = 7;
            $rank['grade'] = 'C+';
            break;
        case ($v > 49 && $v < 55):
            $rank['point'] = 6;
            $rank['grade'] = 'C';
            break;                    
        case ($v > 44 && $v < 50):
            $rank['point'] = 5;
            $rank['grade'] = 'C-';
            break;                   
        case ($v > 39 && $v < 45):
            $rank['point'] = 4;
            $rank['grade'] = 'D+';
            break;   
        case ($v > 34 && $v < 40):
            $rank['point'] = 3;
            $rank['grade'] = 'D';
            break;   
        case ($v > 29 && $v < 35):
            $rank['point'] = 2;
            $rank['grade'] = 'D-';
            break;
        case ($v > 0 && $v < 30):
            $rank['point'] = 1;
            $rank['grade'] = 'E';
            break; 
        default:
            throw new Exception('Value out of range!');
    }
    
    return $rank;
}