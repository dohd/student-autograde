<?php

function browser_log(...$args)
{
    foreach ($args as $arg) {
        echo '<script>console.log('.json_encode($arg).')</script>';
    }
}

function browser_alert($msg='')
{
    echo '<script>alert('.json_encode($msg).')</script>';
}

function error_alert($msg='') {
    echo '<div class="alert alert-danger" role="alert">' . $msg . 
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
}

// permute without repetition with sample of 2
function permute_subjects($list=array(), $store=array())
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
                return permute_subjects($list, $store);
            }
        }
    }
    return $store;
}