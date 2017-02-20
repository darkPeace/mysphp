<?php 
class mysphp
{
	private $host, $dbname, $dbuser, $dbpassword, $pdo;
	
	function __construct($host, $dbname, $dbuser, $dbpassword)
	{
		if (is_null($host)) {
			throw new Exception("Error Processing Request: string \$host, string \$user not supplied", 1);
			return false;
		}

		
		$this->host = $host;
		$this->dbname = $dbname;
		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->connect();
	}

	function __destruct()
	{
		# code...
	}

	private function connect()/*instantiate connection*/
	{
		try{
			return $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->dbuser,$this->dbpassword);
		}
		catch(PDOException $e){
			echo "<pre>".
			$e."</pre>" ;
		}
	}

	public function insert($table, $column, $values)/*insert*/
	{
		
		$ins=$this->pdo->prepare("INSERT INTO $table (".implode(',', $column).") VALUES (:".implode(',:', $column).")");
		foreach ($values as $k => $v) {
			$ins -> bindValue(':'.$column[$k], $v);
		} 

		return $ins -> execute();
	}

	public function update($table, $column, $values, $id)/*update*/
	{
		
		$upd=$this->pdo->prepare("UPDATE `$table` SET `".implode('`= ?,`', $column)."`= ? WHERE `id`= ?");
		foreach ($values as $k => $v) {
			$upd -> bindValue($k+1, $v);
		}
			$upd -> bindValue(count($values)+1, $id);

		return $upd -> execute();
	}

	public function delete($table, $id)/*delete*/
	{		
		return $this->pdo->exec("DELETE FROM `$table` WHERE `id`= $id");
	}

	public function select($table, $column, $id)/*select*/
	{
		if (count($column)==1) {
			$qry="SELECT ".$column." FROM `$table` WHERE `id`= $id";
		}else{
			$qry="SELECT `".implode(',`', $column)."` FROM `$table` WHERE `id`= $id";
		}
		/*need different cases such as multiple or no id, etc*/
		$get=$this->pdo->query($qry);
		foreach ($values as $k => $v) {
			$upd -> bindValue($k+1, $v);
		}
			$upd -> bindValue(count($values)+1, $id);

		return $upd -> execute();
	}

/*create*/
}
echo "<pre>";


echo "</pre>";
?>