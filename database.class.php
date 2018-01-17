<?php
Class AsternicDB{
	// define $resource
	public $resource;

	// define hostname
	public $hostname;

	// define username
	public $username;

	// define password
	public $password;
	
	// define database
	public $database;

	public function __construct(?array $data){
		// set hostname
		$this->hostname = $data['hostname'] ?: $data[0];

		// set username
		$this->username = $data['username'] ?: $data[1];

		// set password
		$this->password = $data['password'] ?: $data[2];

		// set database
		$this->database = $data['database'] ?: $data[3];
	}

	public function connect(){
		if(!($this->resource = new mysqli($this->hostname, $this->username, $this->password, $this->database))){
			throw new \Exception('Unable to connect to the database: ' . $this->resource->errono . ' ' . $this->resource->error);
		}

		// return resource
		return $this->resource;
	}

	/* alias for @disconnect */
	public function close(){
		return $this->disconnect();
	}

	public function disconnect(){
		// close mysqli connection
		return $this->resource->close();
	}

	public function query(...$data){
		switch(count($data)){
			case 0:
				return false;
			break;
			
			case 1:
				// define $query
				$query = $data[0] ?: $data;

				// define $stmt
				if($stmt = $this->resource->query($query)){
					//echo 'Solo query: ' . "\n"; var_dump($stmt, $data);
				}
			break;

			default:
				// define $query
				$query = array_shift($data);

				// define $stmt, $query post vsprintf magic
				if($stmt = $this->resource->query($query = vsprintf($query, array_map([&$this->resource, 'mysqli_real_escape_string'], $data)))){
					//echo 'Statement Default: ' . "\n"; var_dump($stmt, $query);
				}
			break;
		}

		/*
		if($_SERVER['REMOTE_ADDR'] === '136.52.17.133'){
			echo 'query ' . $i++ . ':' . $query . "\r\n";
		}
		*/

		// echo 'QUERY:' . $query . "\r\n";

		if(!$stmt->errno){
			// return $stmt
			return $stmt;
		} else {
			echo $this->resource->errno . ':' . $this->resource->error . "\r\n";
		}

		// throw exception
		throw new \Exception('Unable to execute the following query: ' . $query);

		// return false
		return false;
	}

	public function __debugInfo(){
		// define $debug
		$debug = ['hostname' => $this->hostname, 'username' => $this->username, 'password' => str_repeat('*', strlen($this->password)), 'database' => $this->database];

		// return $debug
		return $debug;
	}
}

?>
