<?php
class Tools{
	
	static function connect($host="servitsj.beget.tech",
		$user="servitsj_powcode",
		$pass="123456",
		$dbname="servitsj_powcode")	{
			
			$cs='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
			$options=array(
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
				PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8');
			try{
				$pdo=new PDO($cs,$user,$pass,$options);
				return $pdo;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
				return false;

			}
	}
}
?>