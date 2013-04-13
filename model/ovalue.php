<?php

class ovalue extends model{

	function creat($name){
		$insertArray = array(
			'name' => $name,
			'creat_time' => time()
		);
		$result = $this->db()->insert('objects', $insertArray);
		if($result == 0) return false;
		return $this->db()->insertId();
	}




}


?>