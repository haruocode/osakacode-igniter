<?php
defined('BASEPATH') OR exit('No direct script access allowed');
defined('PUBLICPATH') OR exit('No direct script access allowed');
define('BASE_URI', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

if (!function_exists('lessons_rewrite_url')) {
    function lessons_rewrite_url($lesson)
    {
        $is_single_lesson = !isset($lesson->courses) || !$lesson->courses ;
        $rewrite_url = '';
        switch ($is_single_lesson) {
            case TRUE:
                //$rewrite_url = '/lessons/' . url_title($lesson->title, '-', TRUE) . '/' . $lesson->id;
                $rewrite_url = '/lessons/' . $lesson->id;
                break;
            case FALSE:
                $rewrite_url = series_episode_rewrite_url($lesson->courses,$lesson->order);
                break;
        }
        return $rewrite_url;
    }
}

if (!function_exists('series_episode_rewrite_url')) {
    function series_episode_rewrite_url($series, $episode)
    {
        //return '/series/' . url_title($series->title, '-', TRUE) . '/' . $series->id .'/episodes/' . $episode;
        return '/series/' . $series->id .'/episodes/' . $episode;
    }
}

if (!function_exists('series_rewrite_url')) {
    function series_rewrite_url($course)
    {
        //return '/series/' . url_title($course->title, '-', TRUE) . '/' . $course->id;
        return '/series/' . $course->id;
    }
}

if (!function_exists('series_url')) {
    function series_url($lesson)
    {
        return '/series/' . url_title($lesson->title, '-', TRUE) . '/' . $lesson->course_id .'/episodes/' . $lesson->order;
    }
}

if( !function_exists('skill_detail_rewrite_url'))
{
    function skill_detail_rewrite_url($skill)
    {
        //return '/skills/' . url_title($skill->name, '-', TRUE) . '/' . $skill->id;
        return '/skills/' . $skill->id;
    }
}

if( !function_exists('tag_detail_rewrite_url'))
{
    function tag_detail_rewrite_url($tag) {
        return '/tag/' . url_title($tag->name, '-', TRUE) . '/' . $tag->id;
    }
}
if(!function_exists('discussion_url')) {
    function discussion_url() {
        return '/discuss';
    }
}
if(!function_exists('discussion_create_url')) {
    function discussion_create_url($channelId=null) {
        return $channelId?'/discuss/conversations/create?channel_id='.$channelId:'/discuss/conversations/create';
    }
}

function discussion_channel_detail_url($channelTitle,$channelId, $page = null) {
    if($page === null) {
        return '/discuss/channels/'.url_title($channelTitle).'/'.$channelId;    
    }else{
        return '/discuss/channels/'.url_title($channelTitle).'/'.$channelId.'?page='.$page;
    }
}
function discussion_detail_url($discussTitle,$discussId,$channelName,$page = null) {
    if($page === null) {
        return '/discuss/channels/'.url_title($channelName).'/'.url_title($discussTitle).'/'.$discussId;    
    }else{
        return '/discuss/channels/'.url_title($channelName).'/'.url_title($discussTitle).'/'.$discussId.'?page='.intval($page);
    }
}

function link_profile($username) {
    return '/@'.$username;
}
function admin_login(){
    return '/admin/login';
}

if(!function_exists('post_create_url')) {
    function post_create_url($channelName,$discussTitle,$postId) {
        return '/discuss/channels/'.url_title($channelName).'/'.url_title($discussTitle).'/replies/'.$postId;
    }
}

if(!function_exists('edit_reply_url')) {
    function edit_reply_url($channelName,$discussTitle,$postId) {
        return '/discuss/channels/'.url_title($channelName).'/'.url_title($discussTitle).'/replies/'.$postId."/edit";
    }
}

if(!function_exists('delete_reply_url')) {
    function delete_reply_url($channelName,$discussTitle,$postId) {
        return '/discuss/channels/'.url_title($channelName).'/'.url_title($discussTitle).'/replies/'.$postId."/delete";
    }
}

if(!function_exists('discussion_edit_url')) {
    function discussion_edit_url($channelName,$discussTitle,$discussId) {
        return '/discuss/channels/'.url_title($channelName).'/'.url_title($discussTitle).'/edit/'.$discussId;
    }
}

if(!function_exists('discussion_post_edit_url')) {
    function discussion_post_edit_url() {
        return '/discuss/conversations/edit/';
    }
}

if(!function_exists('discussion_post_url')) {
    function discussion_post_url() {
        return '/discuss/conversations/';
    }
}
if(!function_exists('discussion_subscribe_url')) {
    function discussion_subscribe_url($discussId) {
        return '/discuss/notification/'.$discussId;
    }
}
if(!function_exists('discussion_create_account')) {
    function discussion_create_account() {
        return '/signup/none';
    }
}
if(!function_exists('login_url')) {
    function login_url() {
	    return '/login';
    }
}
if(!function_exists('upload_avatar_url')){
	function upload_avatar_url(){
		return '/profile/avatar';
	}
}
if(!function_exists('post_signup_url')) {
    function post_signup_url() {
        return '/signup/none';
    }
}

if(!function_exists('spam_url')) {
    function spam_url() {
        return '/discuss/channels/action/spam';
    }
}

if(!function_exists('delete_url')) {
    function delete_url() {
        return '/discuss/channels/action/delete';
    }
}

if(!function_exists('clear_notify_url')) {
    function clear_notify_url() {
        return '/discuss/channels/action/clearnotify';
    }
}

if(!function_exists('add_credit_card_url')) {
    function add_credit_card_url() {
        return '/settings/card/edit';
    }
}

if(!function_exists('change_plan_url')) {
    function change_plan_url() {
        return '/settings/subscription/plan';
    }
}