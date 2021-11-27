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
