<?php
	/* 'User manager for PureFTPd' is made by M.Mastenbroek 2002 - 2017
	 *  For more info look at http://machiel.generaal.net
	 *  Version 2.2
	 */

	function sql_close($DBLink) { 
		if (function_exists ("mysql_close"))
		{	
			return mysql_close($DBLink);
		}else
		{
			return mysqli_close($DBLink); 
		} 
	}
	 

	function sql_result($res, $row, $field=0) { 
		if (function_exists ("mysql_result"))
		{	return mysql_result($res,$row,$field);
		}else
		{
			$res->data_seek($row); 
			$datarow = $res->fetch_array(); 
			return $datarow[$field]; 
		} 
	}

	function sql_num_rows($result)
	{
		if (function_exists ("mysql_num_rows"))
			return mysql_num_rows($result);
		else
			return mysqli_num_rows($result);
	}

	function sql_error($DBLink)
	{
		if (function_exists ("mysql_error"))
			return mysql_error($DBLink);
		else
			return mysqli_error($DBLink);
	}	

	function sql_connect($DBHost, $DBLogin, $DBPassword)
	{
		if (function_exists ("mysql_connect"))
			return mysql_connect($DBHost, $DBLogin, $DBPassword);
		else
			return mysqli_connect($DBHost, $DBLogin, $DBPassword);
	}

	function sql_query($DBQuery, $DBLink)
	{
		if (function_exists ("mysql_query"))
			return mysql_query($DBQuery, $DBLink);
		else
			return mysqli_query($DBLink, $DBQuery);
	}

	function sql_select_db($DBTable, $DBLink)
	{
		if (function_exists ("mysql_select_db"))
			return mysql_select_db($DBTable, $DBLink);
		else
			return mysqli_select_db($DBLink, $DBTable);
	}	

	function sql_fetch_array($resource)
	{
		if (function_exists ("mysql_fetch_array"))
			return mysql_fetch_array($resource);
		else
			return mysqli_fetch_array($resource);
	}	
		 
?>