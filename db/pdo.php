<?php



$db = new db();


//示例查询一
$sql = 'SELECT * FROM `cmf_citys` WHERE id<10';
$rs = $db->query($sql);
//var_dump($yellow);exit;


//查询示例二
// 设置 PDO 错误模式为异常
$db->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 预处理 SQL 并绑定参数
$sth = $db->conn->prepare('SELECT * FROM `cmf_citys` WHERE id<?');
//查询1
$sth->execute(array(10));
$rs = $sth->fetchAll();
//var_dump($rs);exit;
//查询2
$sth->execute(array(2));
$rs = $sth->fetchAll();
//var_dump($rs);exit;


class db{
	private $servername = "192.168.1.250";
	private $username = "root";
	private $password = "123456";

	private $dbname = "cms_sys";

	public $conn;

	public function __construct()
	{
		try {
			$this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}
	}


	/**
	 * 示例查询一
	 */
	public function query( $sql ){
		$res = $this->conn->query($sql, PDO::FETCH_ASSOC);

		$rs = [];
		foreach($res  as $row) {
			$rs[] = $row;
		}
		return $rs;
	}




	public function __destruct()
	{
		$this->conn = null;
	}

}

?>