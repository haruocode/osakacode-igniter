<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function generate_lesson_time($lesson_time)
{
    return ['m' => (int)($lesson_time / 60), 's' => (int)($lesson_time % 60)];
}

function list_year($step = 16){
    $cur_year = date('Y');

    for ($i = $cur_year; $i < $cur_year + $step; $i++ ){
        echo "<option value=\"$i\">$i</option>";
    }
}

function list_month(){
    $cur_month = date('n');

    $month = [
        1 => '1月',
        2 => '2月',
        3 => '3月',
        4 => '4月',
        5 => '5月',
        6 => '6月',
        7 => '7月',
        8 => '8月',
        9 => '9月',
        10 => '10月',
        11 => '11月',
        12 => '12月'
    ];

    for ($i = 1; $i <= 12; $i++ ){
        echo "<option value=\"$i\">$month[$i]</option>";
    }
}