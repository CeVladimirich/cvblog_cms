<?php
/** PDO Queries class
 * for CeBlog CMS
 * @author CeVladimirich
 * @version 0.1
 */
class db_query {
    // Connect to database
    function start($server, $user, $password, $dbname) {
        $dsn = "mysql:host=$server;dbname=$dbname;charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $password, $opt);
        return $pdo;
    }
    // Get all from table
    function getArray($pdo, $table, $col, $order, $limit) {
		$limit_sql = "LIMIT :lim";
		$order_sql = "ORDER BY $col $order";
		if ($col != "" || $order != "") {
			if ($limit != "") {
				$sql = "SELECT * FROM $table ".$order_sql.$limit_sql;
				$query = $pdo->prepare($sql);
				$query->execute([':lim' => $limit]);
				$query = $query->fetch(PDO::FETCH_ASSOC);
			} else {
				$query = $pdo->query("SELECT * FROM $table".$order_sql);
			}
		} else {
		$query = $pdo->query("SELECT * FROM $table");
		}
		return $query;
    }
    // get record from table
    function getRecord($pdo, $table, $col, $id, $col_order, $order, $limit) {
		$order_sql = "ORDER BY $col_order $order";
		$limit_sql = "LIMIT :lim";
		if ($col_order != "" || $order != "") {
			if ($limit != "") {
				$sql = "SELECT * FROM $table WHERE $col = :id ".$order_sql.$limit_sql;
				$query = $pdo->prepare($sql);
				$query->execute([':id'=> $id, ':lim' => $limit]);
				$query = $query->fetch(PDO::FETCH_ASSOC);
			} else {
				$sql = "SELECT * FROM $table WHERE $col = :id".$order_sql;
				$prep = $pdo->prepare($sql);
				$prep->execute(['id' => $id]);
				$array = $prep->fetch(PDO::FETCH_ASSOC);
			}
		} else {
			$sql = "SELECT * FROM $table WHERE $col = :id";
			$prep = $pdo->prepare($sql);
			$prep->execute(['id' => $id]);
			$array = $prep->fetch(PDO::FETCH_ASSOC);
		}
		return $array;
    }
	function close($pdo) {
		$pdo = null;
		return $pdo;
	}
}
