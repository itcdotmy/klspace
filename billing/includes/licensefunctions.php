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
class WHMCSLicense581
{
	public $licensekey;
	public $localkey;
	public $keydata = array();
	public $incronrun = false;
	public $version = "7baB82d4z1aE90bT496SBecEC0cD7bbK";

	public function WHMCSLicense581()
	{
		global $license;
		global $CONFIG;
		$this->licensekey = $license;
		$this->localkey = $CONFIG['License'];
		$this->decodeLocal();
		/*
		if( isset( $_GET['forceremote'] ) )
		{
			$this->forceRemoteCheck();
			exit();
		}
		if( isset( $_GET['licensedebug'] ) )
		{
			echo "<textarea cols=100 rows=10>Status: ".$this->keydata['status']."\nLicense Key: ".$this->licensekey."\nVersion: ".$CONFIG['Version']."\nSystem URLs: ".$CONFIG['SystemURL']." | ".$CONFIG['SystemSSLURL']."\nProduct ID: ".$this->keydata['productid']."\nReg Date: ".$this->keydata['regdate']."\nValid Domain: ".$this->keydata['validdomain']."\nValid IP: ".$this->keydata['validip']."\nChkd: ".$this->keydata['checkdate']."</textarea><br>";
			exit();
		}
		if( isset( $_GET['revokelocal'] ) )
		{
			$this->revokeLocal();
		}
		*/
	}

	public function remoteCheck()
	{
		$licensekey = $this->licensekey;
		$localkey = $this->localkey;
		$localkeydays = 10;
		$licensing_secret_key = "feF245f7D1ddA4ba4cC503Ff60419fc0Cc38315G";
		//$whmcsurl = "http://www.whmcs.com/members/";
		$checkdate = date( "Ymd" );
		$usersip = isset( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
		$allowcheckfaildays = 5;
		$localkeyvalid = false;
		if( $localkey )
		{
			$localkeyvalid = $this->decodeLocal();
			if( isset( $_GET['licensedebug'] ) )
			{
				echo "Local Key Validation: {$localkeyvalid}<br>";
			}
		}
		if( $localkeyvalid )
		{
			$originalcheckdate = $this->keydata['checkdate'];
			$localexpiry = date( "Ymd", mktime( 0, 0, 0, date( "m" ), date( "d" ) - $localkeydays, date( "Y" ) ) );
			if( $originalcheckdate < $localexpiry )
			{
				$localkeyvalid = false;
				$this->keydata = array();
			}
			$localmax = date( "Ymd", mktime( 0, 0, 0, date( "m" ), date( "d" ) + 2, date( "Y" ) ) );
			if( $localmax < $originalcheckdate )
			{
				exit();
			}
		}
		if( !$localkeyvalid )
		{
			$postfields['licensekey'] = $licensekey;
			$postfields['domain'] = $_SERVER['SERVER_NAME'];
			$postfields['ip'] = $usersip;
			$postfields['dir'] = ROOTDIR;
			if( isset( $_GET['licensedebug'] ) )
			{
				echo "Performing Remote Check: ".print_r( $postfields, true )."<br>";
			}
			$postfields['check_token'] = sha1( time().$licensekey.mt_rand( 1000000000, 1e+010 ) );
			$query_string = "";
			foreach( $postfields as $k => $v )
			{
				$query_string .= "{$k}=".urlencode( $v )."&";
			}
			
			/*
			$whmcsurl .= "modules/servers/licensing/verify44.php";
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $whmcsurl );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $query_string );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			$data = curl_exec( $ch );
			if( isset( $_GET['licensedebug'] ) && curl_error( $ch ) )
			{
				echo "Curl Error: ".curl_error( $ch )." - ".curl_errno( $ch )."<br>";
			}
			curl_close( $ch );
			if( isset( $_GET['licensedebug'] ) )
			{
				echo "Raw Remote Response: {$data}<br>";
			}
			*/

			// Keygen start
			global $CONFIG;
			$data = "<status>Active</status>\n";
			$data .= "<registeredname>{$CONFIG['CompanyName']}</registeredname>\n";
			$data .= "<productid>5</productid>\n";
			$data .= "<productname>Owned License No Branding</productname>\n";
			$data .= "<regdate>2010-12-31</regdate>\n";
			$data .= "<nextduedate>0000-00-00</nextduedate>\n";
			$data .= "<billingcycle>One Time</billingcycle>\n";
			$data .= "<validdomain>{$_SERVER["HTTP_HOST"]},www.{$_SERVER["HTTP_HOST"]}</validdomain>\n";
			$data .= "<validip>{$usersip}</validip>\n";
			$data .= "<validdirectory>".ROOTDIR."</validdirectory>\n";
			$data .= "<configoptions></configoptions>\n";
			$data .= "<customfields>Reseller=LicensePal</customfields>\n";
			$data .=
			"<addons>"
				. "name=Branding Removal;status=Active|"
				. "name=Support and Updates;nextduedate=2050-12-01;status=Active|"
				. "name=Mobile Edition;nextduedate=2050-12-01;status=Active|"
				. "name=iPhone App;nextduedate=2050-12-01;status=Active|"
				. "name=Android App;nextduedate=2050-12-01;status=Active|"
				. "name=Configurable Package Addon;nextduedate=2050-12-01;status=Active"
			. "</addons>\n";
			$data .= "<md5hash>".md5( 'uC8enAkEmW6q' . $postfields['check_token'] )."</md5hash>\n";
			$data .= "<latestversion>".$CONFIG['Version']."</latestversion>";
			// Keygen end			

			if( !$data )
			{
				$localexpiry = date( "Ymd", mktime( 0, 0, 0, date( "m" ), date( "d" ) - ( $localkeydays + $allowcheckfaildays ), date( "Y" ) ) );
				if( $localexpiry < $originalcheckdate )
				{
					$results = $localkeyresults;
				}
				else
				{
					$results['status'] = "noconnection";
				}
			}
			else
			{
				preg_match_all( "/<(.*?)>([^<]+)<\\/\\1>/i", $data, $matches );
				$results = array();
				foreach( $matches[1] as $k => $v )
				{
					$results[$v] = $matches[2][$k];
				}
				if( $results['md5hash'] != md5( "uC8enAkEmW6q".$postfields['check_token'] ) )
				{
					$results['status'] = "Invalid";
				}
			}
			$data_encoded = "";
			if( $results['status'] == "Active" )
			{
				$results['checkdate'] = $checkdate;
				unset( $results['md5hash'] );
				$data_encoded = serialize( $results );
				$data_encoded = base64_encode( $data_encoded );
				$data_encoded = sha1( $checkdate.$licensing_secret_key ).$data_encoded;
				$data_encoded = strrev( $data_encoded );
				$splpt = strlen( $data_encoded ) / 2;
				$data_encoded = substr( $data_encoded, $splpt ).substr( $data_encoded, 0, $splpt );
				$data_encoded = sha1( $data_encoded.$licensing_secret_key ).$data_encoded.sha1( $data_encoded.$licensing_secret_key.time() );
				$data_encoded = base64_encode( $data_encoded );
				$data_encoded = wordwrap( $data_encoded, 80, "\n", true );
				if( $results['nextduedate'] == "0000-00-00" )
				{
					$results['nextduedate'] = "Never";
				}
				$configoptions = array();
				$tempresults = explode( "|", $results['configoptions'] );
				foreach( $tempresults as $tempresult )
				{
					$values = explode( "=", $tempresult );
					$configoptions[$values[0]] = $values[1];
				}
				$results['configoptions'] = $configoptions;
				$tempresults = explode( "|", html_entity_decode( $results['addons'] ) );
				foreach( $tempresults as $tempresult )
				{
					$tempresults2 = explode( ";", $tempresult );
					$temparr = array();
					foreach( $tempresults2 as $tempresult )
					{
						$tempresults3 = explode( "=", $tempresult );
						$temparr[$tempresults3[0]] = $tempresults3[1];
					}
					$addons[] = $temparr;
				}
				$results['addons'] = $addons;
			}
			update_query( "tblconfiguration", array( "value" => $data_encoded ), array( "setting" => "License" ) );
			$results['remotecheck'] = true;
			$this->keydata = $results;
		}
		if( isset( $_GET['licensedebug'] ) )
		{
			exit( "Remote Check Completed" );
		}
		unset( $postfields );
		unset( $data );
		unset( $matches );
		unset( $whmcsurl );
		unset( $licensing_secret_key );
		unset( $checkdate );
		unset( $usersip );
		unset( $localkeydays );
		unset( $allowcheckfaildays );
		unset( $md5hash );
	}

	public function forceRemoteCheck()
	{
		$this->localkey = "";
		$this->remoteCheck();
	}

	public function decodeLocal()
	{
		$localkey = $this->localkey;
		$licensing_secret_key = "feF245f7D1ddA4ba4cC503Ff60419fc0Cc38315G";
		$usersip = isset( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
		$localkey = str_replace( "\n", "", $localkey );
		$localkey = base64_decode( $localkey );
		$localdata = substr( $localkey, 40, strlen( $localdata ) - 40 );
		$md5hash = substr( $localkey, 0, 40 );
		if( $md5hash == sha1( $localdata.$licensing_secret_key ) )
		{
			$splpt = strlen( $localdata ) / 2;
			$localdata = substr( $localdata, $splpt ).substr( $localdata, 0, $splpt );
			$localdata = strrev( $localdata );
			$md5hash = substr( $localdata, 0, 40 );
			$localdata = substr( $localdata, 40 );
			$localdata = base64_decode( $localdata );
			$localkeyresults = unserialize( $localdata );
			$originalcheckdate = $localkeyresults['checkdate'];
			if( $md5hash == sha1( $originalcheckdate.$licensing_secret_key ) )
			{
				$localkeyvalid = true;
				$results = $localkeyresults;
				$validdomains = explode( ",", $results['validdomain'] );
				if( $results['status'] != "Active" )
				{
					$localkeyvalid = false;
					if( isset( $_GET['licensedebug'] ) )
					{
						echo "Local Key Validation Failed at Status Check<br>";
					}
				}
				/*
				if( !$this->incronrun )
				{
					if( !in_array( $_SERVER['SERVER_NAME'], $validdomains ) )
					{
						$localkeyvalid = false;
						$results = array();
						$results['status'] = "Invalid";
						if( isset( $_GET['licensedebug'] ) )
						{
							echo "Local Key Validation Failed at Domain Check<br>";
						}
					}
					if( $results['validip'] )
					{
						$validips = explode( ",", $results['validip'] );
					}
					if( $usersip && $validips && !in_array( $usersip, $validips ) )
					{
						$localkeyvalid = false;
						$results = array();
						$results['status'] = "Invalid";
						if( isset( $_GET['licensedebug'] ) )
						{
							echo "Local Key Validation Failed at IP Check<br>";
						}
					}
					if( $results['validdirectory'] != ROOTDIR )
					{
						$localkeyvalid = false;
						$results = array();
						$results['status'] = "Invalid";
						if( isset( $_GET['licensedebug'] ) )
						{
							echo "Local Key Validation Failed at Directory Check<br>";
						}
					}
				}
				*/
			}
			else if( isset( $_GET['licensedebug'] ) )
			{
				echo "Local Key MD5 Hash 2 Invalid<br>";
			}
		}
		else if( isset( $_GET['licensedebug'] ) )
		{
			echo "Local Key MD5 Hash Invalid<br>";
		}
		if( $localkeyvalid )
		{
			$configoptions = array();
			$tempresults = explode( "|", $results['configoptions'] );
			foreach( $tempresults as $tempresult )
			{
				$values = explode( "=", $tempresult );
				$configoptions[$values[0]] = $values[1];
			}
			$results['configoptions'] = $configoptions;
			$tempresults = explode( "|", html_entity_decode( $results['addons'] ) );
			foreach( $tempresults as $tempresult )
			{
				$tempresults2 = explode( ";", $tempresult );
				$temparr = array();
				foreach( $tempresults2 as $tempresult )
				{
					$tempresults3 = explode( "=", $tempresult );
					$temparr[$tempresults3[0]] = $tempresults3[1];
				}
				$addons[] = $temparr;
			}
			$results['addons'] = $addons;
		}
		if( $results['nextduedate'] == "0000-00-00" )
		{
			$results['nextduedate'] = "Never";
		}
		$this->keydata = $results;
		return $localkeyvalid;
	}

	public function revokeLocal()
	{
		update_query( "tblconfiguration", array( "value" => "" ), array( "setting" => "License" ) );
	}

	public function getStatus()
	{
		return $this->keydata['status'];
	}

	public function getBrandingRemoval()
	{
		if( $this->keydata['productname'] == "Owned License No Branding" || $this->keydata['productname'] == "Monthly Lease No Branding" )
		{
			return true;
		}
		if( $this->keydata['addons'] )
		{
			foreach( $this->keydata['addons'] as $addon )
			{
				if( $addon['name'] == "Branding Removal" && $addon['status'] == "Active" )
				{
					return true;
				}
			}
		}
		return false;
	}

}

if( !defined( "WHMCS" ) )
{
	exit();
}
?>