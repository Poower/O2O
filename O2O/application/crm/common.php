<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/3
 * Time: 21:52
 */
function customersstatus($status){
    switch ($status){
        case 0:
            return '<span class="label label-secondary radius">初访</span>';
            break;
        case 1:
            return '<span class="label label-primary radius">意向</span>';
            break;
        case 2:
            return '<span class="label label-primary radius">报价</span>';
            break;
        case 3:
            return '<span class="label label-success radius">成交</span>';
            break;
        case -1:
            return '<span class="label label-danger radius">未成交</span>';
            break;
        case -2:
            return '<span class="label label-warning radius">暂时搁置</span>';
            break;

    }

}

function ctype($type){
    switch ($type){
        case 0:
            return '<span class="label label-secondary radius">普通客户</span>';
            break;
        case 1:
            return '<span class="label label-primary radius">重要客户</span>';
            break;
        case 2:
            return '<span class="label label-secondary radius">低价值客户</span>';
            break;


    }

}