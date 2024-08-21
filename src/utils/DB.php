<?php
// use namespacing to avoid naming conflict in the future
namespace App\utils;

use App\resource\DotEnv;
(new DotEnv(__DIR__ . '../../../.env'))->load();

class DB
{
	private $pdo;

	private static $instance = null;

	private function __construct()
	{
		$dsn = getenv('DB_CONNECTION').':dbname='.getenv('DB_NAME').';host='.getenv('DB_HOST');
		$user = getenv('DB_USERNAME');
		$password = getenv('DB_PASSWORD');

		$this->pdo = new \PDO($dsn, $user, $password);
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

	public function select($sql)
	{
		$sth = $this->pdo->query($sql);
		return $sth->fetchAll();
	}

	public function exec($table, $values)
	{	
		$sql = 'INSERT INTO '. $table . ' (`title`, `body`, `created_at`) VALUES(?, ?, ?)';
		$statement = $pdo->prepare($sql); // always use prepared statements to sanitize data being inserted
		return $this->pdo->execute($values); // there should be a bulk insert function
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}

}