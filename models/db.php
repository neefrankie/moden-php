<?php
/**
 * Connect to database
 */
require './settings.php';

class Test {
	public $pdo;
	private $sql = 'SELECT profiles_domain FROM cmstmp01.userinfo WHERE profiles_domain = :domain';
	private $stmt;

	public function __construct($pdo) {
		$this->pdo = $pdo;
		$this->stmt = $this->pdo->prepare($this->sql);
	}

	public function getRandUserProfilesDomain() {
		$domain = mt_rand(21474836, mt_getrandmax());

		echo "$domain: " . $domain . "\n";

		$this->stmt->bindValue(':domain', $domain);
		$this->stmt->execute();

		$result = $this->stmt->fetchAll();

		print_r($result);

		if (isset($result[0])) {
			return $this->getRandUserProfilesDomain();
		} else {
			return $domain;
		}
	}
}

try {
	$pdo = new PDO(
		sprintf(
			'mysql:host=%s;dbname=%s;port=%s;charset=%s',
			$settings['host'],
			$settings['name'],
			$settings['port'],
			$settings['charset']
		),
		$settings['username'],
		$settings['password']
	);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	$test = new Test($pdo);
	$test->getRandUserProfilesDomain();

	// $sql = 'SELECT user_id AS userId FROM cmstmp01.userinfo WHERE email = :email';
	// $stmt = $pdo->prepare($sql);
	// // $email = filter_input(INPUT_GET, 'email');
	// $email = "weiguo.ni@ftchinese.com";
	// $stmt->bindValue(':email', $email);
	// $stmt->execute();

	// $result = $stmt->fetchAll();
	// var_dump($result);
	// var_dump($result[0]);

	// while (($result = $stmt->fetch()) !== false) {
	//     var_dump($result);
	// }
} catch (PDOException $e) {
	echo "Database connection failed";
	exit;
}