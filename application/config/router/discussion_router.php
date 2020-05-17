<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/15/2016
 * Time: 2:59 PM
 */
$route['discuss'] = 'discussion/DiscussionsController';
$route['discuss/question'] = 'discussion/DiscussionsController/question';
$route['discuss/post'] = 'discussion/DiscussionsController/post';
$route['discuss/conversations/create']['get'] = 'discussion/DiscussionsCreateController/createDiscuss';
$route['discuss/conversations']['post'] = 'discussion/DiscussionsCreateController/postDiscuss';
$route['discuss/channels/(:any)/(:any)/edit/(:num)']['get'] = 'discussion/DiscussionsCreateController/editDiscuss/$3';
$route['discuss/conversations/edit']['post'] = 'discussion/DiscussionsCreateController/postEditDiscuss/';
$route['discuss/channels/(:any)/(:num)'] = 'discussion/DiscussionsController/index/$2';
$route['discuss/reply'] = 'discussion/DiscussionsController/reply';
$route['discuss/channels/(:any)/(:any)/(:num)']['get'] = 'discussion/DiscussionsController/viewDiscuss/$3';
$route['discuss/channels/(:any)/(:any)/(:num)']['post'] = 'discussion/DiscussionsCreateController/postReply/$3';
$route['discuss/channels/(:any)/(:any)/replies/(:num)'] = 'discussion/DiscussionsController/viewReply/$3';
$route['discuss/channels/(:any)/(:any)/replies/(:num)/edit']['post'] = 'discussion/DiscussionsCreateController/ajaxActionEditReply/';
$route['discuss/channels/action/like']['post'] = 'discussion/DiscussionsCreateController/ajaxActionLike/';
$route['discuss/channels/action/spam']['post'] = 'discussion/DiscussionsController/ajaxActionSpam/';
$route['discuss/channels/action/delete']['post'] = 'discussion/DiscussionsCreateController/ajaxActionDelete/';
$route['discuss/channels/action/bestpost']['post'] = 'discussion/DiscussionsCreateController/ajaxActionBestPost/';
$route['discuss/channels/action/clearnotify']['post'] = 'discussion/DiscussionsCreateController/ajaxClearNotify/';
$route['discuss/notification/(:num)']['post'] = 'discussion/DiscussionsCreateController/ajaxUpdateSubscribeDiscussion/$1';
