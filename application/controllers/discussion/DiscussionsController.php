<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Solid\Repositories\LogLikeRepository;
use Solid\Repositories\ChannelRepository as ChannelRepository;
use Solid\Repositories\DiscussionRepository as DiscussionRepository;
use Solid\Repositories\PostRepository as PostRepository;
use Solid\Repositories\EmailNotificationRepository as EmailNotificationRepository;
use Solid\Repositories\UserRepository as UserRepository;

/**
 * Class DiscussionsController
 * @property DiscussionRepository $discussionRepository
 * @property EmailNotificationRepository $emailNotificationRepository
 * @property PostRepository $postRepository
 * @property ChannelRepository $channelRepository
 * @property Discussions_model $discussions_model
 * @property Post_model $post_model
 * @property Channel_model $channel_model
 * @property CI_Input $input
 * @property Blade $blade
 * @property CI_Loader $load
 * @property LogLikeRepository $logLikeRepository
 * @property Log_likes_model $log_likes_model
 * @property Discuss_email_notifications_model $discuss_email_notifications_model
 * @property Posts_stats_model $posts_stats_model
 * @property User_model $user_model
 * @property Profile_model $profile_model
 * @property UserRepository $userRepository
 */
class DiscussionsController extends MY_Controller
{
	const PAGE_SIZE = 20;
	const DISCUSS_SIZE = 16;
	private $discussionRepository;
	private $postRepository;
	private $channelRepository;
	private $logLikeRepository;
	private $emailNotificationRepository;
	private $userRepository;

	public function __construct(DiscussionRepository $discussionRepository,
	                            PostRepository $postRepository,
	                            ChannelRepository $channelRepository,
	EmailNotificationRepository $emailNotificationRepository,
								LogLikeRepository $logLikeRepository,
								UserRepository $userRepository)

	{
		parent::__construct();
		$this->discussionRepository = $discussionRepository;
		$this->postRepository = $postRepository;
		$this->channelRepository = $channelRepository;
		$this->logLikeRepository = $logLikeRepository;
		$this->emailNotificationRepository = $emailNotificationRepository;
		$this->userRepository = $userRepository;
		$this->load->model('discussions_model');
		$this->load->model('post_model');
		$this->load->model('posts_stats_model');
		$this->load->model('channel_model');
		$this->load->model('log_likes_model');
		$this->load->model('discuss_email_notifications_model');
		$this->load->model('user_model');
		$this->load->model('profile_model');
		$this->discussionRepository->setModel($this->discussions_model);
		$this->postRepository->setModel($this->post_model);
		$this->postRepository->setPostStatModel($this->posts_stats_model);
		$this->channelRepository->setModel($this->channel_model);
		$this->logLikeRepository->setModel($this->log_likes_model);
		$this->emailNotificationRepository->setModel($this->discuss_email_notifications_model);
		$this->userRepository = $userRepository;
		$this->userRepository->setModel($this->user_model);
		$this->userRepository->setProfileModel($this->profile_model);
	}

	public function index($channelId = null)
	{
		$this->current_menu = 'discussions';
		$page = $this->input->get('page', TRUE);
		$page = ($page == null) ? 1 : $page;
		$totalRecord = $this->discussionRepository->countAll($channelId);
		$listDiscussion = $this->discussionRepository->getList($totalRecord,$page, self::PAGE_SIZE, $channelId,['updated_at' => 'DESC']);
		$this->parseListDiscussion($listDiscussion);
		//get list channel
		$listChannels = $this->channelRepository->getAll();
		$channelName = $this->channelRepository->getChannelNameById($channelId);
		$url = $channelId?discussion_channel_detail_url($channelName,$channelId):discussion_url();
		$dataView = [
			'head_title' => 'プログラミング専用掲示板',
			'head_keyword' => 'プログラミング,学習,掲示板',
			'head_desc' => 'プログラミング専用の掲示板です。',
			'current_menu' => $this->current_menu,
			'list' => $listDiscussion,
			'listChannels' => $listChannels,
			'totalRecord' => $totalRecord,
			'pagination' => get_pagination_string(self::PAGE_SIZE, $totalRecord, $url, ['page' => $page]),
			'page' => $page,
			'channelName' => $channelName,
			'channelId' => $channelId
		];
		$this->blade->render('front.forum.index', $dataView);
	}

	private function parseListDiscussion(&$listDiscussion)
	{
		$arrayDiscussId = [];
		foreach ($listDiscussion as $item) {
			$arrayDiscussId[] = $item->id;
		}
		try {
			$latestPost = $this->postRepository->getLatestInDiscussion($arrayDiscussId);
			$countReply = $this->postRepository->countReplyInDiscussion($arrayDiscussId);
		} catch (\Exception $e) {
			show_error(trans('error.request.not_found'), 404);
		}

		foreach ($listDiscussion as $item) {
			if (!property_exists($item, 'user')) {
				$item->user = new stdClass();
				$item->user->username = '';
			}
			if (!property_exists($item, 'channel')) {
				$item->channel = new stdClass();
				$item->channel->name = '';
				$item->channel->id = 0;
			}
			$item->latestPost = new stdClass();
			$item->latestPost->username = isset($latestPost[$item->id]) ? $latestPost[$item->id]->username : '';
			$item->latestPost->updated = isset($latestPost[$item->id]) ? intval($latestPost[$item->id]->created_at) : '0';
			$item->countReply = isset($countReply[$item->id]) ? $countReply[$item->id] : 0;
			$item->lastPage = ceil(($item->countReply+1)/SELF::DISCUSS_SIZE);
			$item->userProfile = $this->userRepository->getProfileOfUser($item->user_id);
		}
	}


	public function viewDiscuss($discussId)
	{
		$this->current_menu = 'discussions';
		$page = $this->input->get('page', TRUE);
		$page = ($page == null) ? 1 : $page;
		$listPost = $this->postRepository->getList($discussId, $page, self::DISCUSS_SIZE);
		$discuss = $this->discussionRepository->getDiscussById($discussId);
		$totalRecord = $this->postRepository->countReplyByDiscussion($discussId);
		$url = discussion_detail_url($discuss->title,$discuss->id,$discuss->channel->name);
		if (!$listPost) {
			show_error("This is fail record (this discussion have any post). Please choose another record.");
		}
		$listPost = $this->parseListPost($listPost);
		$question = ($page==1)?array_shift($listPost):null;
		$dataView = [
			'head_title' => $discuss->title,
			'head_keyword' => 'プログラミング,学習,掲示板,スレッド',
			'head_desc' => '「' . $discuss->title . '」' . 'がタイトルの掲示板スレッドです。',
			'current_menu' => $this->current_menu,
			'question' => $question,
      'isHasBestAnswer' => $this->postRepository->checkDiscussHaveBestAnswer($discussId),
			'listPost' => $listPost,
			'discuss' => $discuss,
			'pagination' => get_pagination_string(self::DISCUSS_SIZE, $totalRecord, $url, ['page' => $page]),
			'lastPage' => ceil(($totalRecord+1)/self::DISCUSS_SIZE),
			'currentPage' => $page,
			'isSubscribe'=> $this->emailNotificationRepository->checkSubscribeDiscussion($this->session->userdata('id'),$discussId)
		];
		$this->blade->render('front.forum.channel', $dataView);
	}

	private function parseListPost($records)
	{
		foreach ($records as $record) {
			$record->isPostOfUser = $record->user_id == $this->session->userdata('id');
			$record->isDiscussOfUser = $record->discussion->user_id == $this->session->userdata('id');
			$record->listLike = $this->logLikeRepository->findById($record->id);
			$record->likeCount = $record->listLike?count($record->listLike):0;
			$record->likeClass = $this->logLikeRepository->isUserLike($record->id,$this->session->userdata('id'))?"is-liked":"";
		}
		return $records;
	}

	public function viewReply($postId)
	{
		$this->current_menu = 'reply';
		$page = $this->input->get('page', TRUE);
		$page = ($page == null) ? 1 : $page;
		$post = $this->postRepository->getPostById($postId);
		if(!$post){
			show_error("This is fail record (this discussion have any post). Please choose another record.");
		}
		$question = $this->postRepository->getQuestionByDiscussionId($post->discussion_id);
		if($question->id==$post->id){
			show_error("Whoops, looks like something went wrong.");
		}
		$listPost[] = $post;
		$listPost = $this->parseListPost($listPost);
		$dataView = [
			'current_menu' => $this->current_menu,
			'listPost' => $listPost,
			'isUserPost' => $listPost[0]->user_id == $this->session->userdata('id'),
			'currentPage' => $page,
		];
		$dataView['discuss'] = $this->discussionRepository->getDiscussById($post->discussion_id);
		$this->blade->render('front.forum.reply', $dataView);
	}

	public function ajaxActionSpam()
	{
		if ($this->input->post()) {
			$post = $this->input->post();
			$postId = $post['postId'];
			if (!$this->postRepository->findPostStatById($postId)) {
				$this->postRepository->newPostStats($postId);
			}
			$this->postRepository->spamInc($postId);
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

}