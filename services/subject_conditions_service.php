<?php

/** select pair values without repetition */ 
function pair_combination($list=[], $store=[])
{
    $l = count($list) - 1;
    for ($i = 0; $i < $l; $i++) {
        // store pair (first and next) elements
        $store[] = array($list[0], $list[$i+1]);
        // if last index of loop
        if ($i == $l-1) {
            // reduce the list by the first element
            array_shift($list);
            // if list size is greater than one, recurse
            if (count($list) > 1) {
                return pair_combination($list, $store);
            }
        }
    }
    return $store;
}

/** check if given subjects meet condition for 7 */
function condition_for_seven($subjects=array(), $default=array())
{
    // check for the compulsory first 3 subjects and reduce subjects by 3
    foreach($default['mains'] as $value) {
        if (!in_array($value, $subjects)) return error_alert($value . ' is required!');    
        unset($subjects[array_search($value, $subjects)]);
    }
    // check if science pair exist in subjects and reduce subjects by 2
    $science_pairs = pair_combination($default['sciences']);
    foreach ($science_pairs as $pair) {
        if (in_array($pair[0], $subjects) && in_array($pair[1], $subjects)) {
            $pair_exist = true;
            unset($subjects[array_search($pair[0], $subjects)]);
            unset($subjects[array_search($pair[1], $subjects)]);
        }
    }
    if (!isset($pair_exist)) return error_alert('At least 2 sciences required!');
    // check for at least one humanity and reduce subjects by 1
    foreach($default['humanities'] as $value) {
        if (in_array($value, $subjects)) {
            $humanity_exist = true;
            unset($subjects[array_search($value, $subjects)]);
            break;
        }
    }
    if (!isset($humanity_exist)) return error_alert('At least 1 humanity required!');
    return $subjects;
}

/** check if given subjects meet condition for 8 */
function condition_for_eight($subjects=array(), $default=array())
{
    $subjects = condition_for_seven($subjects, $default);    
    // check for at least one science or humanity and reduce subjects by 1
    foreach($default['sciences'] as $value) {
        if (in_array($value, $subjects)) {
            $science_exist = true;
            unset($subjects[array_search($value, $subjects)]);
            break;
        }
    }
    foreach($default['humanities'] as $value) {
        if (in_array($value, $subjects)) {
            $humanity_exist = true;
            unset($subjects[array_search($value, $subjects)]);
            break;
        }
    }

    if (isset($science_exist) || isset($humanity_exist)) return $subjects;
    return error_alert('Multiple industrial subjects not allowed! Replace one with a science or humanity.');
}

/** check if given subjects meet condition for 9 */
function condition_for_nine($subjects=array(), $default=array())
{
    $subjects = condition_for_eight($subjects, $default);        
    // check for at most one science or one humanity or one 
    // industrial subject and reduce subjects by 1 
    foreach($default['sciences'] as $value) {
        if (in_array($value, $subjects)) {
            $science_exist = true;
            unset($subjects[array_search($value, $subjects)]);
            break;
        }
    } 
    foreach($default['humanities'] as $value) {
        if (in_array($value, $subjects)) {
            $humanity_exist = true;
            unset($subjects[array_search($value, $subjects)]);
            break;
        }
    }

    if (isset($science_exist) || isset($humanity_exist)) return $subjects;
    if (count($subjects) > 1) {
        return error_alert('Multiple industrial subjects not allowed! Replace one with a science or humanity.');
    }
}
