<?php
require 'vendor/autoload.php';

// use namespacing to avoid naming conflict in the future
use App\utils\NewsManager;
use App\utils\PostManager;
use App\utils\CommentManager;

$newsManager = NewsManager::getInstance();
$commentManager = CommentManager::getInstance();

// require_once(ROOT . '/utils/NewsManager.php');
//require_once(ROOT . '/utils/CommentManager.php');

foreach ($newsManager->listNews() as $news) {
	// sanitize before outputing to prevent XSS
	echo("############ NEWS " . htmlspecialchars($news->getTitle()) . " ############\n");
	echo(htmlspecialchars($news->getBody()) . "\n");
	foreach ($commentManager->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . htmlspecialchars($comment->getBody()) . "\n");
		}
	}
}

$c = $commentManager->listComments();