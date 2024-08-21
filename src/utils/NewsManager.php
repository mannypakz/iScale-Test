<?php
// use namespacing to avoid naming conflict in the future
namespace App\utils;

use App\utils\CommentManager;
use App\utils\DB;
use App\classes\News;

class NewsManager
{
	private static $instance = null;
	protected $db;

	private function __construct()
	{
		// require_once(ROOT . '/utils/DB.php');
		// require_once(ROOT . '/utils/CommentManager.php');
		// require_once(ROOT . '/class/News.php');
		$this->db = DB::getInstance(); // we can instantiate the DB object on constructor rather than on each method as it is redundant
	}

	// not quite sure if to remove this singleton implementation as instructed not to edit the behavior. but this breaks SRP
	public static function getInstance()
	{
		if (null === self::$instance) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	/**
	* list all news
	*/
	public function listNews()
	{
		// $this->db = DB::getInstance();
		// not good to retrieve all records all at once. this will be slow. there should be a limit and/or add offset for pagination. 
		$rows = $this->db->select('SELECT * FROM `news`');

		$news = [];
		foreach($rows as $row) {
			$n = new News();
			$news[] = $n->setId($row['id'])
			  ->setTitle($row['title'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at']);
		}

		return $news;
	}

	/**
	* add a record in news table
	*/
	public function addNews($title, $body)
	{
		// $this->db = DB::getInstance();
		// $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('". $title . "','" . $body . "','" . date('Y-m-d') . "')"; - refactored to sanitize the data being inserted
		$this->db->exec('news',[$title, $body, date('Y-m-d')]);
		return $this->db->lastInsertId();
	}

	/**
	* deletes a news, and also linked comments
	*/
	public function deleteNews($id)
	{
		$comments = CommentManager::getInstance()->listComments();
		$idsToDelete = [];

		foreach ($comments as $comment) {
			if ($comment->getNewsId() == $id) {
				$idsToDelete[] = $comment->getId();
			}
		}

		//refactored to delete all at once. this will be slow if there are a thousand comments 
		// foreach($idsToDelete as $id) {
		// 	CommentManager::getInstance()->deleteComment($id);
		// }

		// parameter is an array of IDS - 1 dimensional array
		CommentManager::getInstance()->deleteComment($idsToDelete);

		// $this->db = DB::getInstance();
		$sql = "DELETE FROM `news` WHERE `id`=" . $id;
		return $this->db->exec($sql);
	}
}