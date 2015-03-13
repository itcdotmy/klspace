<?php //00d4b
// *************************************************************************
// *                                                                       *
// * WHMCS - The Complete Client Management, Billing & Support Solution    *
// * Copyright (c) WHMCS Ltd. All Rights Reserved,                         *
// * Release Date: 14th December 2011                                      *
// * Version 5.0.3 Stable                                                  *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: info@whmcs.com                                                 *
// * Website: http://www.whmcs.com                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.  This software  or any other *
// * copies thereof may not be provided or otherwise made available to any *
// * other person.  No title to and  ownership of the  software is  hereby *
// * transferred.                                                          *
// *                                                                       *
// * You may not reverse  engineer, decompile, defeat  license  encryption *
// * mechanisms, or  disassemble this software product or software product *
// * license.  WHMCompleteSolution may terminate this license if you don't *
// * comply with any of the terms and conditions set forth in our end user *
// * license agreement (EULA).  In such event,  licensee  agrees to return *
// * licensor  or destroy  all copies of software  upon termination of the *
// * license.                                                              *
// *                                                                       *
// * Please see the EULA file for the full End User License Agreement.     *
// *                                                                       *
// *************************************************************************
function select_query( $table, $fields, $where, $orderby = "", $orderbyorder = "", $limit = "", $innerjoin = "" )
{
	global $CONFIG;
	global $query_count;
	global $mysql_errors;
	global $whmcsmysql;
	if( !$fields )
	{
		$fields = "*";
	}
	$query = "SELECT {$fields} FROM {$table}";
	if( $innerjoin )
	{
		$query .= " INNER JOIN {$innerjoin}";
	}
	if( $where )
	{
		if( is_array( $where ) )
		{
			$query .= " WHERE";
			foreach( $where as $key => $value )
			{
				if( is_array( $value ) )
				{
					if( $value['sqltype'] == "LIKE" )
					{
						$query .= " {$key} LIKE '%".mysql_real_escape_string( $value['value'] )."%' AND";
					}
					else if( $value['sqltype'] == "NEQ" )
					{
						$query .= " {$key}!='".mysql_real_escape_string( $value['value'] )."' AND";
					}
					else if( $value['sqltype'] == ">" )
					{
						$query .= " {$key}>".mysql_real_escape_string( $value['value'] )." AND";
					}
					else if( $value['sqltype'] == "<" )
					{
						$query .= " {$key}<".mysql_real_escape_string( $value['value'] )." AND";
					}
					else if( $value['sqltype'] == "<=" )
					{
						$query .= " {$key}<=".mysql_real_escape_string( $value['value'] )." AND";
					}
					else if( $value['sqltype'] == ">=" )
					{
						$query .= " {$key}>=".mysql_real_escape_string( $value['value'] )." AND";
					}
					else if( $value['sqltype'] == "TABLEJOIN" )
					{
						$query .= " {$key}=".$value['value']." AND";
					}
				}
				else
				{
					$query .= " {$key}='".mysql_real_escape_string( $value )."' AND";
				}
			}
			$query = substr( $query, 0, 0 - 4 );
		}
		else
		{
			$query .= " WHERE {$where}";
		}
	}
	if( $orderby )
	{
		$query .= " ORDER BY `{$orderby}` {$orderbyorder}";
	}
	if( $limit )
	{
		$query .= " LIMIT {$limit}";
	}
	$result = mysql_query( $query, $whmcsmysql );
	if( !$result && ( $CONFIG['SQLErrorReporting'] || $mysql_errors ) )
	{
		logActivity( "SQL Error: ".mysql_error( $whmcsmysql )." - Full Query: ".$query );
	}
	++$query_count;
	return $result;
}

function update_query( $table, $array, $where )
{
	global $CONFIG;
	global $query_count;
	global $mysql_errors;
	global $whmcsmysql;
	$query = "UPDATE {$table} SET ";
	foreach( $array as $key => $value )
	{
		$query .= "`{$key}`=";
		if( $value === "now()" )
		{
			$query .= "'".date( "YmdHis" )."',";
		}
		else
		{
			if( $value === "+1" )
			{
				$query .= "`{$key}`+1,";
			}
			else
			{
				if( substr( $value, 0, 11 ) == "AES_ENCRYPT" )
				{
					$query .= "{$value},";
				}
				if( $value === "NULL" )
				{
					$query .= "NULL,";
				}
				else
				{
					$query .= "'".mysql_real_escape_string( $value )."',";
				}
			}
		}
	}
	$query = substr( $query, 0, 0 - 1 );
	if( is_array( $where ) )
	{
		$query .= " WHERE";
		foreach( $where as $key => $value )
		{
			$query .= " {$key}='".mysql_real_escape_string( $value )."' AND";
		}
		$query = substr( $query, 0, 0 - 4 );
	}
	else if( $where )
	{
		$query .= " WHERE {$where}";
	}
	$result = mysql_query( $query, $whmcsmysql );
	if( !$result && ( $CONFIG['SQLErrorReporting'] || $mysql_errors ) )
	{
		logActivity( "SQL Error: ".mysql_error( $whmcsmysql )." - Full Query: ".$query );
	}
	++$query_count;
}

function insert_query( $table, $array )
{
	global $CONFIG;
	global $query_count;
	global $mysql_errors;
	global $whmcsmysql;
	$query = "INSERT INTO {$table} ";
	foreach( $array as $key => $value )
	{
		$fieldnamelist .= "`{$key}`,";
		if( $value === "now()" )
		{
			$fieldvaluelist .= "'".date( "YmdHis" )."',";
		}
		else if( $value === "NULL" )
		{
			$fieldvaluelist .= "NULL,";
		}
		else
		{
			$fieldvaluelist .= "'".mysql_real_escape_string( $value )."',";
		}
	}
	$fieldnamelist = substr( $fieldnamelist, 0, 0 - 1 );
	$fieldvaluelist = substr( $fieldvaluelist, 0, 0 - 1 );
	$query .= "({$fieldnamelist}) VALUES ({$fieldvaluelist})";
	$result = mysql_query( $query, $whmcsmysql );
	if( !$result && ( $CONFIG['SQLErrorReporting'] || $mysql_errors ) )
	{
		logActivity( "SQL Error: ".mysql_error( $whmcsmysql )." - Full Query: ".$query );
	}
	++$query_count;
	$id = mysql_insert_id( $whmcsmysql );
	return $id;
}

function delete_query( $table, $where )
{
	global $CONFIG;
	global $query_count;
	global $mysql_errors;
	global $whmcsmysql;
	$query = "DELETE FROM {$table} WHERE";
	if( is_array( $where ) )
	{
		foreach( $where as $key => $value )
		{
			$query .= " {$key}='".mysql_real_escape_string( $value )."' AND";
		}
		$query = substr( $query, 0, 0 - 4 );
	}
	else
	{
		$query .= " {$where}";
	}
	$result = mysql_query( $query, $whmcsmysql );
	if( !$result && ( $CONFIG['SQLErrorReporting'] || $mysql_errors ) )
	{
		logActivity( "SQL Error: ".mysql_error( $whmcsmysql )." - Full Query: ".$query );
	}
	++$query_count;
}

function full_query( $query )
{
	global $CONFIG;
	global $query_count;
	global $mysql_errors;
	global $whmcsmysql;
	$result = mysql_query( $query, $whmcsmysql );
	if( !$result && ( $CONFIG['SQLErrorReporting'] || $mysql_errors ) )
	{
		logActivity( "SQL Error: ".mysql_error( $whmcsmysql )." - Full Query: ".$query );
	}
	++$query_count;
	return $result;
}

function get_query_val( $table, $field, $where, $orderby = "", $orderbyorder = "", $limit = "", $innerjoin = "" )
{
	$result = select_query( $table, $field, $where, $orderby, $orderbyorder, $limit, $innerjoin );
	$data = mysql_fetch_array( $result );
	return $data[0];
}

function get_query_vals( $table, $field, $where, $orderby = "", $orderbyorder = "", $limit = "", $innerjoin = "" )
{
	$result = select_query( $table, $field, $where, $orderby, $orderbyorder, $limit, $innerjoin );
	$data = mysql_fetch_array( $result );
	return $data;
}

function db_escape_string( $string )
{
	$string = mysql_real_escape_string( $string );
	return $string;
}

function db_escape_array( $array )
{
	$array = array_map( "db_escape_string", $array );
	return $array;
}

function db_escape_numarray( $array )
{
	$array = array_map( "intval", $array );
	return $array;
}

$query_count = 0;
?>