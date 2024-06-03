<?php

function dump($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function dd($data) {
    dump($data);
    die;
}

function load($fillable = [])
{
    $data = [];
    foreach ($_POST as $k => $v) {
        if (in_array($k, $fillable)) {
           $data[$k] = $v;
        }
    }
    return $data;
}