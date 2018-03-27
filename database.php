<?php
class Database{

	public $host = DB_HOST;
	public $user = DB_USER;
	public $pass = DB_PASS;
	public $name = DB_NAME;

	public $link;
	public $error;

	public function __construct()
	{
		$this->connectDB();
	}

	private function connectDB()
	{
		$this->link = new mysqli($this->host,$this->user,$this->pass,$this->name);
		if(!$this->link)
		{
			$this->$error = "connectionfailed".$this->link->connect_error;
			return false;
		}
	}

	// select data from table

	public function select($query)
	{
		$result = $this->link->query($query) or die($this->link->error.__LINE__);
		if($result->num_rows > 0)
		{
			return $result;
		}
		else{
			return false;
		}
	}


	// insert data into table

	public function insert($query)
	{
		$result = $this->link->query($query) or die($this->link->error.__LINE__);
		if($result)
		{
			return $result;
		}
		else{
			return false;
		}
	}

	// update data into table

	public function update($query)
	{
		$result = $this->link->query($query) or die($this->link->error.__LINE__);
		if($result)
		{
			return $result;
		}
		else{
			return false;
		}
	}

	// Delete data

	public function delete($query)
	{
		$result = $this->link->query($query) or die($this->link->error.__LINE__);
		if($result)
		{
			return $result;
		}
		else{
			return false;
		}
	}



}