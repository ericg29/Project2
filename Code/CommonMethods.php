<?php 

class Common
{	
	var $conn;
	var $debug;
			
	function Common($debug)
	{
		$this->debug = $debug; 
		$rs = $this->connect("eric29"); // db name really here
		return $rs;
	}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
	
	function connect($db)// connect to MySQL
	{
		$conn = @mysql_connect("studentdb-maria.gl.umbc.edu", "eric29", "fd*9RMu^5ZDQjCpe") or die("Could not connect to MySQL");
		$rs = @mysql_select_db($db, $conn) or die("Could not connect select $db database");
		$this->conn = $conn; 
	}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
	
	function executeQuery($sql, $filename) // execute query
	{
		if($this->debug == true) { echo("$sql <br>\n"); }
		$rs = mysql_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename"); 
		return $rs;
	}			

} // ends class, NEEDED!!


function getInfo($userID, $admin, $com)
{
	if (admin == true)
	{
		$sql = "SELECT * from `Proj2Advisors` where `Username` = '$userID'";
		$rs = $com->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		
		return $row;
	}
	else
	{
		$sql = "SELECT * from `Proj2Students` where `Username` = '$StudentID'";
		$rs = $com->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		
		return $row;
	}
}

?>