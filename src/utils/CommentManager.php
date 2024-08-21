<?php
// use namespacing to avoid naming conflict in the future
namespace App\utils;

use App\utils\DB;
use App\classes\Comment;

class CommentManager
{
	private static $instance = null;
	protected $db;

	private function __construct()
	{
		// require_once(ROOT . '/utils/DB.php');
		// require_once(ROOT . '/class/Comment.php');
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

	public function listComments()
	{
		// $db = DB::getInstance();
		$rows = $this->db->select('SELECT * FROM `comment`');

		$comments = [];
		foreach($rows as $row) {
			$n = new Comment();
			$comments[] = $n->setId($row['id'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at'])
			  ->setNewsId($row['news_id']);
		}

		return $comments;
	}

	public function addCommentForNews($body, $newsId)
	{
		// $db = DB::getInstance();
		// $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('". $body . "','" . date('Y-m-d') . "','" . $newsId . "')"; - refactored to sanitize the data being inserted
		$this->db->exec('body', [$body, $newsId, date('Y-m-d')]);
		return $this->db->lastInsertId($sql);
	}

	public function deleteComment(array $idsToDelete)
	{
		// $db = DB::getInstance();
		$sql = "DELETE FROM `comment` WHERE `id` IN (" . implode(', ', $idsToDelete) . ")";
		return $this->db->exec($sql);
	}
}