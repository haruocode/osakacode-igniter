<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Solid\Collections\Discussion as Discussion;
use Solid\Collections\EmailNotification as EmailNotification;
use Solid\Collections\SystemNotification as SystemNotification;
use Solid\Collections\User as User;
use Solid\Repositories;
use Solid\Repositories\ChannelRepository as ChannelRepository;
use Solid\Repositories\DiscussionRepository as DiscussionRepository;
use Solid\Repositories\EmailNotificationRepository as EmailNotificationRepository;
use Solid\Repositories\PostRepository as PostRepository;
use Solid\Repositories\SystemNotificationRepository as SystemNotificationRepository;
use Solid\Repositories\UserRepository as UserRepository;

/**
 * Class DiscussionsCreateController
 * @property DiscussionRepository $discussionRepository
 * @property PostRepository $postRepository
 * @property ChannelRepository $channelRepository
 * @property Discussions_model $discussions_model
 * @property Post_model $post_model
 * @property Channel_model $channel_model
 * @property \User_model $user_model
 * @property UserRepository $userRepository
 * @property SystemNotificationRepository $systemNotificationRepository
 * @property EmailNotificationRepository $emailNotificationRepository
 * @property CI_Input $input
 * @property Blade $blade
 * @property CI_Loader $load
 * @property Log_likes_model $log_likes_model
 * @property Posts_stats_model $posts_stats_model
 * @property Repositories\LogLikeRepository $logLikeRepository
 * @property Notification_model $notification_model
 * @property Discuss_email_notifications_model $discuss_email_notifications_model
 */
class DiscussionsCreateController extends MY_Controller
{
	private $discussionRepository;
	private $postRepository;
	private $channelRepository;
	private $logLikeRepository;
	private $userRepository;
	private $systemNotificationRepository;
	private $emailNotificationRepository;

	public function __construct(DiscussionRepository $discussionRepository,
	                            PostRepository $postRepository,
	                            ChannelRepository $channelRepository,
	                            Repositories\LogLikeRepository $logLikeRepository,
	                            UserRepository $userRepository,
	                            SystemNotificationRepository $systemNotificationRepository,
	                            EmailNotificationRepository $emailNotificationRepository)
	{
		parent::__construct();
		if (!check_logged()) {
			redirect(base_url());
		}
		$this->discussionRepository = $discussionRepository;
		$this->postRepository = $postRepository;
		$this->channelRepository = $channelRepository;
		$this->logLikeRepository = $logLikeRepository;
		$this->userRepository = $userRepository;
		$this->systemNotificationRepository = $systemNotificationRepository;
		$this->emailNotificationRepository = $emailNotificationRepository;
		$this->load->model('discussions_model');
		$this->load->model('post_model');
		$this->load->model('channel_model');
		$this->load->model('log_likes_model');
		$this->load->model('posts_stats_model');
		$this->load->model('user_model');
		$this->load->model('notification_model');
		$this->load->model('discuss_email_notifications_model');
		$this->load->model('profile_model');
		$this->discussionRepository->setModel($this->discussions_model);
		$this->postRepository->setModel($this->post_model);
		$this->channelRepository->setModel($this->channel_model);
		$this->logLikeRepository->setModel($this->log_likes_model);
		$this->postRepository->setPostStatModel($this->posts_stats_model);
		$this->userRepository->setModel($this->user_model);
		$this->systemNotificationRepository->setModel($this->notification_model);
		$this->emailNotificationRepository->setModel($this->discuss_email_notifications_model);
		$this->userRepository->setProfileModel($this->profile_model);
	}

	public function createDiscuss()
	{
		$this->current_menu = 'create_discussions';
		$channelId = $this->input->get('channel_id', TRUE);
		//var_dump($channelId);die();
		$listChannels = $this->channelRepository->getAll();
		$dataView = [
			'listChannels' => $listChannels,
			'userName' => $this->session->userdata('username'),
			'channel_id' => $channelId,
			'userProfile' => $this->userRepository->getProfileOfUser($this->session->userdata('id')),
		];
		$this->blade->render('front.forum.create', $dataView);
	}

	public function postDiscuss()
	{
		$data['user_id'] = $this->session->userdata('id');
		if ($this->input->post()) {
			$data['title'] = $this->input->post('title', true);
			$data['channel_id'] = $this->input->post('channel');
			$channelName = $this->channelRepository->getChannelNameById($data['channel_id']);
			$data['content'] = $this->input->post('body', true);
			if ($this->discussionRepository->validateData($data)) {
				if ($data['discussion_id'] = $this->discussionRepository->saveData($data)) {
					//get user mention from body
					$data['markdown'] = $data['content'];
					$listUserMention = $this->_parseUserMention($data['content']);
					if ($listUserMention) {
						foreach ($listUserMention as $userMention) {
							//create a collection for notification
							$modelRecord = new stdClass();
							$modelRecord->user_id = $userMention->getId();
							$modelRecord->type = SystemNotification::TYPE_MENTION;
							$modelRecord->status = SystemNotification::STATUS_UNREAD;
							$modelRecord->link = discussion_detail_url($data['title'], $data['discussion_id'], $channelName);
							$modelRecord->description = SystemNotification::generateMentionDescription(CommonService::get_instance()->user_name(), $data['title']);
							$notification = SystemNotification::create($modelRecord);
							//send notification
							$this->_sendNotifyMention($notification);
						}
					}
					$this->postRepository->saveData($data);
					redirect(discussion_detail_url($data['title'], $data['discussion_id'], $channelName), 'location');
				} else {
					show_error("Whoops, looks like something went wrong.");
				}
			} else {
				$this->blade->render('front.forum.create', [
					'data' => $data,
					'userName' => $this->session->userdata('username'),
					'listChannels' => $this->channelRepository->getAll(),
				]);
			}
		}
	}

	/**
	 * Insert link user to string content
	 * @param $str
	 * @return array User
	 */
	private function _parseUserMention(&$str)
	{
		//break word
		$lines = explode(PHP_EOL, $str);
		$words = [];
		foreach($lines as $line) {
			$words = array_merge($words,explode(' ', $line));
		}
		$listUser = [];
		foreach ($words as $w) {
			if (starts_with($w, '@')) {
				$username = trim(substr($w, 1));
				if (!$username) {
					continue;
				}
				if ($username == CommonService::get_instance()->user_name()) {
					continue;
				}
				try {
					$listUser[] = $this->userRepository->findByUsername($username);
					$userMention = $this->_generateUserLinkToMention($username);
					$str = str_replace('@' . $username, $userMention, $str);
				} catch (Exception $e) {
					continue;
				}
			}
		}
		return $listUser;
	}

	private function _generateUserLinkToMention($username) {
		return '<a href="'.link_profile($username).'">@'.$username.'</a>';
	}

	/**
	 * @param SystemNotification $notification
	 */
	private function _sendNotifyMention(SystemNotification $notification)
	{
		$this->systemNotificationRepository->add($notification);
		$this->systemNotificationRepository->save();
	}

	public function editDiscuss($discussId)
	{
		$discuss = $this->discussionRepository->getDiscussById($discussId);
		$post = $this->postRepository->getQuestionByDiscussionId($discussId);
		if ($discuss->user_id != $this->session->userdata('id')) {
			show_error('Whoops, looks like something went wrong.');
		}
		$data['discussId'] = $discuss->id;
		$data['postId'] = $post->id;
		$data['userId'] = $discuss->user_id;
		$data['title'] = $discuss->title;
		$dataPost = $this->postRepository->getPostContentByPostId($post->id);
		$data['content'] = $dataPost->content;
		$data['markdown'] = $dataPost->markdown;
		$data['channel_id'] = $discuss->channel->id;
		$listChannels = $this->channelRepository->getAll();
		$dataView = [
			'listChannels' => $listChannels,
			'data' => $data,
			'userName' => $this->session->userdata('username'),
			'userProfile' => $this->userRepository->getProfileOfUser($this->session->userdata('id')),
		];
		//var_dump($dataView);die();
		$this->blade->render('front.forum.edit', $dataView);
	}

	public function postEditDiscuss()
	{
		if ($this->input->post()) {
			$userId = $this->session->userdata('id');
			$data['title'] = $this->input->post('title', true);
			$data['channel_id'] = $this->input->post('channel');
			$data['content'] = $this->input->post('body', true);
			$data['discussId'] = $this->input->post('discussId');
			$data['postId'] = $this->input->post('postId');
			if(!$this->postRepository->checkPostOwner($userId,$data['postId'])){
				show_error('Whoops, looks like something went wrong.');
			}
			if(!$this->discussionRepository->checkDiscussOwner($data['discussId'],$userId)){
				show_error('Whoops, looks like something went wrong.');
			}
			if ($this->discussionRepository->validateData($data)) {
				if ($this->discussionRepository->updateData($data, $data['discussId'])) {
					$channelName = $this->channelRepository->getChannelNameById($data['channel_id']);
					//get user mention from body
					$data['markdown'] = $data['content'];
					$listUserMention = $this->_parseUserMention($data['content']);
					if ($listUserMention) {
						foreach ($listUserMention as $userMention) {
							//create a collection for notification
							$modelRecord = new stdClass();
							$modelRecord->user_id = $userMention->getId();
							$modelRecord->type = SystemNotification::TYPE_MENTION;
							$modelRecord->status = SystemNotification::STATUS_UNREAD;
							$modelRecord->link = discussion_detail_url($data['title'], $data['discussId'], $channelName);
							$modelRecord->description = SystemNotification::generateMentionDescription(CommonService::get_instance()->user_name(), $data['title']);
							$notification = SystemNotification::create($modelRecord);
							//send notification
							$this->_sendNotifyMention($notification);
						}
					}
					$this->postRepository->updateData($data, $data['postId']);
					redirect(discussion_detail_url($data['title'], $data['discussId'], $channelName), 'location');
				} else {
					show_error("Whoops, looks like something went wrong.");
				}
			} else {
				$this->blade->render('front.forum.edit', [
					'data' => $data,
					'userName' => $this->session->userdata('username')
				]);
			}
		}
	}

	public function postReply($discussId)
	{
		$this->current_menu = 'discussions';
		//get post data
		if ($this->input->post()) {
			$title = $this->input->post('title');
			$channel = $this->input->post('channel');
			$lastPage = $this->input->post('lastPage');
			//var_dump($this->input->post());die();
			if (!empty($this->input->post('body', true))) {
				$data['content'] = $this->input->post('body', true);
				$data['user_id'] = $this->session->userdata('id');
				$data['discussion_id'] = $discussId;
				//get user mention
				$data['markdown'] = $data['content'];
				$listUserMention = $this->_parseUserMention($data['content']);
				$lastInsertId = $this->postRepository->saveData($data);
				//If post success-> last insert id = the id of post
				if ($lastInsertId) {
					$this->discussionRepository->setDiscussUpdatedAt($discussId,time());
					//send notification for user that be mentioned
					if ($listUserMention) {
						foreach ($listUserMention as $userMention) {
							//create a collection for notification
							$modelRecord = new stdClass();
							$modelRecord->user_id = $userMention->getId();
							$modelRecord->type = SystemNotification::TYPE_MENTION;
							$modelRecord->status = SystemNotification::STATUS_UNREAD;
							$modelRecord->link = discussion_detail_url($title, $discussId, $channel, $lastPage) . '#reply-' . $lastInsertId;
							$modelRecord->description = SystemNotification::generateMentionDescription(CommonService::get_instance()->user_name(), $title);
							$notification = SystemNotification::create($modelRecord);
							$this->_sendNotifyMention($notification);
						}
					}
					if($this->discussionRepository->getUserIdByDiscussId($discussId)!=$this->session->userdata('id')) {
						//send notification for owner conversation
						$modelRecord = new stdClass();
						$modelRecord->user_id = $this->discussionRepository->getUserIdByDiscussId($discussId);
						$modelRecord->type = SystemNotification::TYPE_REPLY;
						$modelRecord->status = SystemNotification::STATUS_UNREAD;
						$modelRecord->link = post_create_url($channel, $title, $lastInsertId);
						$modelRecord->description = SystemNotification::generateReplyDescription(CommonService::get_instance()->user_name(), $title);
						$notification = SystemNotification::create($modelRecord);
						$this->_sendNotifyMention($notification);
					}
					//get user subscribe
					$userSubscribe = $this->emailNotificationRepository->getUserSubscribe($discussId);
					foreach ($userSubscribe as $user) {
						//if current user post reply => not send mail
						if ($user->getId() == $this->session->userdata('id')) {
							continue;
						}
						//send email notification
						$replier = CommonService::get_instance()->user_email();
						$temp = new stdClass();
						$temp->receiveEmail = $user->getEmail();
						$temp->emailTitle = EmailNotification::generateEmailSubscribeTitle($replier, $title);
						$temp->htmlContent = EmailNotification::generateHtmlContent([
							'replierName' => CommonService::get_instance()->user_name(),
							'discussionLink' => $this->input->server('SERVER_NAME') . discussion_detail_url($title, $discussId, $channel, $lastPage) . '#reply-' . $lastInsertId,
							'postContent' => $data['content']
						]);
						$temp->senderName = EMAIL_SUPPORT_NAME;
						$temp->senderEmail = EMAIL_SUPPORT_ADDRESS;
						$emailData = EmailNotification::create($temp);
						$this->_sendEmailDiscussionSubscribe($emailData);
					}
				}
			}
			redirect(discussion_detail_url($title, $discussId, $channel, $lastPage));
		} else {
			show_error("Whoops, looks like something went wrong.");
		}
		//$this->viewDiscuss($discussId);
	}

	private function _sendEmailDiscussionSubscribe(EmailNotification $notification)
	{
		$this->emailNotificationRepository->add($notification);
		$this->emailNotificationRepository->save();
	}

	public function ajaxActionEditReply()
	{
		if ($this->input->is_ajax_request()) {
			$postId = $this->input->post('postId');
			//check permission
			if(!$this->_checkPostOwner($this->session->userdata('id'), $postId)){
				die();
			};
			//get info of post
			$postDetail = $this->postRepository->getStandalonePostById($postId);
			$discussionDetail = $this->discussionRepository->getDiscussById($postDetail->getDiscussionId());
			$data['content'] = $this->input->post('body_in_markdown', true);
			if (trim($data['content']) != "") {
				$data['markdown'] = $data['content'];
				$listUserMention = $this->_parseUserMention($data['content']);
				if ($listUserMention) {
					foreach ($listUserMention as $userMention) {
						//create a collection for notification
						$modelRecord = new stdClass();
						$modelRecord->user_id = $userMention->getId();
						$modelRecord->type = SystemNotification::TYPE_MENTION;
						$modelRecord->status = SystemNotification::STATUS_UNREAD;
						$modelRecord->link = discussion_detail_url($discussionDetail->title, $discussionDetail->id, $discussionDetail->channel->name) . '#reply-' . $postId;
						$modelRecord->description = SystemNotification::generateMentionDescription(CommonService::get_instance()->user_name(), $discussionDetail->title);
						$notification = SystemNotification::create($modelRecord);
						//send notification
						$this->_sendNotifyMention($notification);
					}
				}
				$this->postRepository->updateData($data, $postId);
				$arrayReturn = [
					'success' => 1,
					'error' => 0,
					'msg' => trans('front.notification.editreply'),
				];
				echo json_encode($arrayReturn);
				die();
			} else {
				$arrayReturn = [
					'success' => 0,
					'error' => 1,
				];
				echo json_encode($arrayReturn);
				die();
			}
		} else {
			$arrayReturn = [
				'success' => 0,
				'error' => 1,
			];
			echo json_encode($arrayReturn);
			die();
		}
	}

	/**
	 * @param $userId
	 * @param $postId
	 * @return bool
	 */
	private function _checkPostOwner($userId, $postId)
	{
		return $this->postRepository->checkPostOwner($userId, $postId);
	}

	public function ajaxUpdateSubscribeDiscussion($discussId)
	{
		$arrayReturn = [];
		//check login
		if (!$this->checkUserLogin()) {
			$arrayReturn['error'] = 1;
			$arrayReturn['code'] = 401;
			$arrayReturn['msg'] = trans('error.not_login');

		}
		$user = new User((object)['id' => $this->session->userdata('id')]);
		$discussion = new Discussion((object)['id' => $discussId]);
		$result = $this->emailNotificationRepository->toggleSubscribe($user, $discussion);
		if ($result) {
			$arrayReturn = [
				'error' => 0,
				'code' => 200,
				'success' => 1,
				'msg' => trans('front.notification.discussion_subscribe')
			];
		} else {
			$arrayReturn = [
				'error' => 1,
				'code' => 503,
				'success' => 0,
				'msg' => trans('error.common_error')
			];
		}
		set_status_header($arrayReturn['code']);
		echo json_encode($arrayReturn);
		die();
	}

	public function ajaxActionLike()
	{
		if (!$this->checkUserLogin()) {
			$arrayReturn['error'] = 1;
			$arrayReturn['code'] = 401;
			$arrayReturn['msg'] = trans('error.not_login');
			set_status_header($arrayReturn['code']);
			echo json_encode($arrayReturn);
			die();
		}
		if ($this->input->is_ajax_request()) {
			$postId = $this->input->post('postId');
			$userId = $this->session->userdata('id');
			$channelName = $this->input->post('channel_name');
			$title = $this->input->post('discuss_title');
			$userName = $this->session->userdata('username');
			if (!$this->postRepository->findPostStatById($postId)) {
				$this->postRepository->newPostStats($postId);
			}
			if ($this->logLikeRepository->isUserLike($postId, $userId)) {
				$this->logLikeRepository->unLike($postId, $userId);
				$this->postRepository->likeDec($postId);
				$arrayReturn = [
					'success' => 1,
					'isLike' => 0,
					'postId' => $postId,
					'userName' => $userName,
					'code' => 200,
					'msg' => trans('front.notification.unlike'),
					'error' => 0,
				];
				echo json_encode($arrayReturn);
				die();
			} else {
				$this->logLikeRepository->like($postId, $userId, $userName);
				$this->postRepository->likeInc($postId);
				$modelRecord = new stdClass();
				$modelRecord->user_id = $this->postRepository->getUserIdByPostId($postId);
				if($modelRecord->user_id != $this->session->userdata('id')) {
					$modelRecord->type = SystemNotification::TYPE_LIKE;
					$modelRecord->status = SystemNotification::STATUS_UNREAD;
					$modelRecord->link = post_create_url($channelName,$title,$postId);
					$modelRecord->description = SystemNotification::generateLikeDescription($userName, $title);
					$notification = SystemNotification::create($modelRecord);
					//send notification
					$this->_sendNotifyMention($notification);
				}

				$html = "<li class=\"Label Label--small\"><a href=\"" . link_profile($userName) . "\">$userName</a></li>";
				$arrayReturn = [
					'success' => 1,
					'isLike' => 1,
					'postId' => $postId,
					'msg' => trans('front.notification.like'),
					'html' => $html,
					'code' => 200,
					'error' => 0,
				];
				echo json_encode($arrayReturn);
				die();
			}
		} else {
			$arrayReturn = [
				'error' => 1,
				'success' => 0,
				'code' => 503,
				'msg' => trans('error.common_error'),
			];
			echo json_encode($arrayReturn);
			die();
		}
	}

	public function ajaxActionDelete()
	{
		if ($this->input->is_ajax_request()) {
			$postId = $this->input->post('postId');
			$userId = $this->session->userdata('id');
			if (!$this->postRepository->checkPostOwner($userId,$postId)) {
				$arrayReturn = [
					'success' => 0,
					'error' => 1,
				];
				echo json_encode($arrayReturn);
				die();
			}
			if (!$this->postRepository->deleteData($postId)) {
				$arrayReturn = [
					'success' => 0,
					'error' => 1,
				];
				echo json_encode($arrayReturn);
				die();
			}
			$arrayReturn = [
				'success' => 1,
				'error' => 0,
			];
			echo json_encode($arrayReturn);
			die();
		} else {
			$arrayReturn = [
				'error' => 1,
				'success' => 0,
			];
			echo json_encode($arrayReturn);
			die();
		}
	}

	public function ajaxActionBestPost()
	{
		if ($this->input->is_ajax_request()) {
			$postId = $this->input->post('postId');
			$discussId = $this->input->post('discussId');
			if ($this->postRepository->markBestPost($postId, $discussId)) {
				$arrayReturn = [
					'error' => 0,
					'success' => 1,
					'postId' => $postId,
				];
				echo json_encode($arrayReturn);
				die();
			} else {
				$arrayReturn = [
					'error' => 1,
					'success' => 0,
				];
				echo json_encode($arrayReturn);
				die();
			}
		} else {
			$arrayReturn = [
				'error' => 1,
				'success' => 0,
			];
			echo json_encode($arrayReturn);
			die();
		}
	}

	public function ajaxClearNotify()
	{
		if ($this->input->is_ajax_request()) {
			$userId = $this->session->userdata('id');
			$listId = $this->input->post('listId');
			if(is_null($listId)){
				$this->systemNotificationRepository->setReadAllOwnerNotify($userId);
				$arrayReturn = [
					'error' => 0,
					'success' => 1,
					'msg'=> 'You have clear all notify !'
				];
				echo json_encode($arrayReturn);
				die();
			}else {
				if ($this->systemNotificationRepository->checkNotifyOwnerByListNotify($listId, $userId)) {
					$this->systemNotificationRepository->setReadAllNotify($listId);
					$arrayReturn = [
						'error' => 0,
						'success' => 1,
					];
					echo json_encode($arrayReturn);
					die();
				} else {
					$arrayReturn = [
						'error' => 1,
						'success' => 0,
						'msg'=>'Wrong use validate'
					];
					echo json_encode($arrayReturn);
					die();
				}
			}
		} else {
			$arrayReturn = [
				'error' => 1,
				'success' => 0,
				'msg'=>'Error post'
			];
			echo json_encode($arrayReturn);
			die();
		}
	}
}
