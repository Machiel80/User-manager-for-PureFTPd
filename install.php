<?php
	/* 'User manager for PureFTPd' is made by M.Mastenbroek 2002 - 2017
	 *  For more info look at http://machiel.generaal.net
	 *  Version 2.2
	 */

	$ConfigVersion = "Version 2.2";

	// ini_set('display_errors', 'On');

	require ('includes/sql.php');
	
	function end_session($error_message)
	{
		$_SESSION['stage'] = 'stage_1_start';
		die($error_message);
	}
	
	if (isset($_GET['image']))
	{
		$name = $_GET['image'];
		unset($img);
		$img=array(
			'bluebar.gif'=>
			'R0lGODlhAQAZAMQAAAAAAP///6LB7ZK26JW46Ze66Zq86py965+/7KXE7ajG7piy1qvI767K8LDM'.
			'8cDW9MPY9cba9sve99Hi+cjd9s3g+M/h+NPk+dXm+tfn+9no+f///wAAAAAAAAAAAAAAACH5BAEA'.
			'ABsALAAAAAABABkAAAUVoJZh12RVEhVBj9MwSiIgh1EQwxICADs=',
			'yellowbar.gif'=>
			'R0lGODlhAgAZAMQAAAAAAP////ndkfnelPrglvrhmfjYifjZi/jbj/fRf/jUgvjVhvO7UPTAV/fM'.
			'dvfPfPKxQPKzRPO2SPO4TPS9VO+jK/CmL/CoMvGqNfGsOfGuPP///wAAAAAAAAAAAAAAACH5BAEA'.
			'ABsALAAAAAACABkAAAUqYFEQxDAIAoIch2Esi6IkyfM4TtNQFMNME4kkEoFANJpMBoO5XCyWSiUE'.
			'ADs=',
			'dot.gif'=>
			'R0lGODlhCQALAMQfAJu129bk+aG84s3e9uvz/trm+myJs8TZ9azE536cxuHs+8HW9LXO8d/r+3iU'.
			'u7bN742o0NLi+I+s15+75crc95St03WPtoWiy8jb9YWcvubw/Zasy7fP8bGxsXp6ev///yH5BAEA'.
			'AB8ALAAAAAAJAAsAAAU54CeOZDl2Xqp6KEFoSjFwKVxEGCekTUAtDAEkJQMiAJdU5PBATCSJ1OFY'.
			'gSQsKcQm47AYDKyVqhMCADs=',
			'background.jpg'=>
			'/9j/4AAQSkZJRgABAgAAZABkAAD/7AARRHVja3kAAQAEAAAAPAAA/+4ADkFkb2JlAGTAAAAAAf/b'.
			'AEMABgQEBAUEBgUFBgkGBQYJCwgGBggLDAoKCwoKDBAMDAwMDAwQDA4PEA8ODBMTFBQTExwbGxsc'.
			'Hx8fHx8fHx8fH//bAEMBBwcHDQwNGBAQGBoVERUaHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8f'.
			'Hx8fHx8fHx8fHx8fHx8fHx8fHx8fH//AABEIAPgBkAMBEQACEQEDEQH/xAAfAAABBQEBAQEBAQAA'.
			'AAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEU'.
			'MoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2Rl'.
			'ZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK'.
			'0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUG'.
			'BwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS'.
			'8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4'.
			'eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri'.
			'4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APqmgBKACmAlABQAUCEoAKBCUwCgBKAExTAT'.
			'FACYoEFMBKACgQmKAExTASgBMUCExTAKAEoASmITFACUxBQAmKAExTASgQUAJigBMUwExQITFMAo'.
			'ASgBKYgoASgApgJQIKAEoASmAUAJQAUAFMDoK4DrCgAoASmAUCEoGFAhKACgBMUxBQAlACEUwDFA'.
			'CYoEJTASgAoATFAhMUwEoAMUAJimITFACUAFMQhFACGgBKYhMUAIRTASgAoEJQAEUwExQISmAlAC'.
			'YoASmAUCEoAKAEpgFAhKACmAlACUAFAHQVwnWFABQAUAJQAUwEoAKACgQlABTEJQAlABigBMUwEx'.
			'QISmAUAJQAUCEpgJQAmKAExTEJigBKACmITFACYoATFMQlABigBKYCUCCgBMUwExQAlMQlABigBM'.
			'UwEoEFACUAFMBKBCUAFMBKACgDfrhOsKACgAoAKACgBKYBQISgYUCEoAKAEpiCgBKAExTASgAxQI'.
			'SmAlABQISgBMUwEoAQimITFABQAlABTEJigBMUxCYoATFACYpgJQAUCEoAQimAmKBCUwCgBKAEpg'.
			'FAhKACmAmKBBQAlACUwN+uE6woAKACgAoAKACgBKACmISgYUCEoAKACmISgBKADFACUwExQISmAl'.
			'ABQAhFAhKYBQAlACYpiEoASgApiExQAmKAEpiEoATFMBKACgQlABTATFAhMUwEoATFABTASgQUAJ'.
			'QAUwEoEJQBvVxHWFABQAUAFABQAUAFACUAFMQlAwoAKBCUAFMQlACUAFACUwExQAlAgpgJQAUCEp'.
			'gJQAmKAEIpiExQAlABQAmKYhCKAExTEFACYoASmAlAgoATFMBMUAJigQlMAoATFMBKBBQAlABTAS'.
			'gRu1xHWFABQAUAFABQAUAFABQAUAJTAKBCUDCgQlABQAlMQUAJQAlMAoASgQlMBKACgQmKAEpgJQ'.
			'AYoAQimITFACUAGKYhMUAJigBKYhMUAJimAlABQISgBCKYCGgQYpgJQAlACUwCgQlABQBuVxnUFA'.
			'BQAUAFABQAUAFABQAUAFACUwCgQlAwoAKBCUAFMQlACUAGKAEpgJigQlABTASgBKBCYpgFACYoAS'.
			'mIQigBKACmITFACYoATFMQlACEUwEoAKBBQAmKYCYoEJimAlACGgApgJQIKANuuM6goAKACgAoAK'.
			'ACgAoAKACgAoAKAEoAKYCUAFABQISgAoEJimAUAJQAmKYCYoAKBCUwEoAKBCYoASmAmKAExTATFA'.
			'hKACgBMUxCEUAJimIMUAJigBKYCUCCgBMUAJimAlAhMUwCgBKAEpiNuuM6goAKACgAoAKACgAoAK'.
			'ACgAoAKACgAoASmAUCEoGFAhKACgBKYgoASgBKYBQAmKBCUwEoAKAEoEJTASgAxQAmKYhMUAJQAU'.
			'xCYoATFACYpiEoATFMBMUAFAhKAEpgGKBCUwEoATFAG1XIdIUAFABQAUAFABQAUAFABQAUAFABQA'.
			'UAFACUAFMQlAwoASgQUAFMQlACUAFACUwEoEJTAKAEoATFAgpgJQAmKAEIpiEoASgApiExQAmKAE'.
			'piCgBMUAJimAlAgoAQimAlAhMUwEoA2a5DpCgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgBKYB'.
			'QISgYUCEoAKAEpiCgBKAExTATFABQISmAlABQITFACUwEoASgBDTEJQAUwCgQhFACYpiEoATFACU'.
			'wEoEFACUAIRTATFAjYrlOkKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgBKYBQISgYUAJQIK'.
			'ACmISgBKACgBMUwEoEJTASgAoATFAhKYBQAmKAExTEJigBKACmIQ0AJigBKYhMUAJimAlABQISgA'.
			'xTA1q5ToCgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKAEoAKYCUAFABQISgAoEJTASgAoA'.
			'TFMBKAEoEFMBKADFAhMUwEoAQigBMUxCYoASgAoEJTATFACYpiCgBMUAJTASgQUAatcx0BQAUAFA'.
			'BQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAlABTEFACUDCgQlABQAlMQUAJQAlMAoAbigQUwE'.
			'oAKBCYoASmAlABigBpFMQUAJQAYpiEIoATFMBKBCYoATFMBKANWuY3CgAoAKACgAoAKACgAoAKAC'.
			'gAoAKACgAoAKACgAoAKACgAoAKAEoAKYhKBhQAlAgoAKYhKAEoAKAEpgJigQmKACmAlACYoEJTAK'.
			'AExQAmKYhMUAJQAUxCYoATFACUxCYoAQigDUrnNwoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAo'.
			'AKACgAoAKACgAoASgApgJQAUAFAhKACmISgBKADFACUwEoASgQUwEoAKBCYoASmAmKAExTATFAhK'.
			'ACgBMUxCEUAIRTEGKANKuc3CgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAo'.
			'AKAEpgFAhKBhQISgAoASmIKAEoASmAYoATFAhKYCUAFACUCExTAKAExQAmKYhKAEoAKYhMUAJigD'.
			'RrA2CgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgBKACmISgAoGJQI'.
			'KACmISgBKACgBMUwExQISgApgJQAmKBCYpgFACUAJTEJigBKACmIQigDQrA2CgAoAKACgAoAKACg'.
			'AoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoASgApiCgBKBhQISgApgJQIKAEoASmAmK'.
			'AEoEFMBKACgQhFACUwEoAQimAmKBBQAlAF+sTUKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKAC'.
			'gAoAKACgAoAKACgAoAKACgAoAKAEpgFAhKBhQISgAoASmIKAEoASgApgJigQlMBKACgBKBCYpgFA'.
			'CYoATFMQmKAL1YmoUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFA'.
			'BQAUAFACUAFMQlAwoEFACUAFAhKYCUAFACYpgJigBMUCCmAlABQITFMBKAExQAmKYi7WJqFABQAU'.
			'AFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFACUxBQAlAwo'.
			'EJQAUAJTEFACUAJTASgAxQISmAlABQITFACUwEoAuVkaBQAUAFABQAUAFABQAUAFABQAUAFABQAU'.
			'AFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAJQAUxCUDCgBKBBQAUxCUAJQAYoASmAlAh'.
			'KYCUAFACUCEpgW6yNAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoA'.
			'KACgAoAKACgAoAKACgBKACmISgYUAFAhKACmITFACUAFACUwEoASgQUwEoAKBFmszQKACgAoAKAC'.
			'gAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgBKYBQ'.
			'ISgYUCEoAKAEpiCgBKAExTAMUAJigQlMBKALNZlhQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQ'.
			'AUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFACUAFMQlAwoASgQUAFMQlACUAGKAEp'.
			'gJigQmKALFQWFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAF'.
			'ABQAUAFABQAUAFABQAUAFACUAFMQUAJQMKBCUAFMQlACUAFACYpgJQInqCwoAKACgAoAKACgAoAK'.
			'ACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgBKY'.
			'BQAlABQISgAoASmIKAEoATFMCaoKCgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAK'.
			'ACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgBKACmISgYUAFAhKACmISgBKAJakoKAC'.
			'gAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKA'.
			'CgAoAKACgAoAKACgBKACmAUAJQAUCEoAKAEpiP/Z'
		);


		header("Content-type: image/gif");
		header("Cache-control: public");
		header("Expires: ".date("r",mktime(0,0,0,1,1,2030)));
		header("Cache-control: max-age=".(60*60*24*7));
		header("Last-Modified: ".date("r",filemtime(__FILE__)));
		die (base64_decode($img[$name]));
	}

	session_start();

	if(isset($_POST['next_stage']) && $_POST['next_stage'] != "none") $_SESSION['stage'] = $_POST['next_stage'];
    if (isset($_GET['stage']))
	{	
		//echo ("GET(stage) = ".$_GET['stage']."<br/>\n");
		$_SESSION['stage'] = $_GET['stage'];
	}
	if (!isset($_SESSION['stage'])) $_SESSION['stage'] = 'stage_1_start'; // Default value
    

	$stage = $_SESSION['stage'];
	
	//echo ("Stage: ".$stage."<br/>\n");
	
	/* posible values
       
	   1) stage_1_start
	   2) stage_2_new_database
	   3) stage_3_create_database
	   4) stage_4_configuration_file
	   5) stage_5_configure_administrators
	   6) stage_6_pureftpd_config
	   7) stage_7_finish
    */
		
	$step = substr(substr($stage, 0,7),-1);
	$default_db_host = '127.0.0.1';
	$default_db_user = 'root';
	$default_db_pswd = '';

	if($stage == 'stage_4_configuration_file')
	{
		if(isset($_POST['save']))
		{
			// echo ("Save<br>\n");
			$filecontent = "";
			$filename = "config.php";

			$filecontent .= "<?php\n";
			$filecontent .= "  /* 'User manager for PureFTPd' is made by M.Mastenbroek 2002 - 2005\n";
			$filecontent .= "   *  For more info look at http://machiel.generaal.net\n";
			$filecontent .= "   *  $ConfigVersion\n";
			$filecontent .= "   */\n\n";
			$filecontent .= "  \$LANG = \"".$_POST['language']."\";                  // See the directory language for the available languages.\n\n";
			$filecontent .= "  \$LocationImages =  \"".$_POST['image_location']."\";        // Location of images\n\n";
			$filecontent .= "  \$DBHost = \"".$_POST['Hostname']."\";              // Ip-address of MySQL server\n";
			$filecontent .= "                                      // (Don’t change this if you are using the default database)\n\n";
			$filecontent .= "  \$DBLogin = \"".$_POST['Login']."\";                   // Username of MySQL user\n\n";
			$filecontent .= "  \$DBPassword = \"".$_POST['Password']."\";          // Password of MySQL user\n\n";
			$filecontent .= "  \$DBDatabase = \"".$_POST['Database']."\";           // Name of database\n\n";
			$filecontent .= "  \$FTPAddress = \"".$_POST['ftp_address']."\";   // Domain name or ip-address of your ftp server\n\n";
			$filecontent .= "  \$DEFUserID = \"".$_POST['default_user_id']."\"; // nobody     // Default user id of virtual ftp user.\n\n";
			$filecontent .= "  \$DEFGroupID = \"".$_POST['default_group_id']."\";   // guest      // Default group is of virtual ftp user.\n\n";
			$filecontent .= "  \$UsersFile = \"".$_POST['location_passwd']."\";        // The unix user file\n\n";
			$filecontent .= "  \$GroupFile = \"".$_POST['location_groupfile']."\";         // The unix group file\n\n";
			$filecontent .= "  \$StyleSheet = \"".$_POST['stylesheet']."\"; // The location of the style sheet\n\n";

			if (isset($_POST['quota_support']))
				$quota_support = 1;
			else
				$quota_support = 0;

			if (isset($_POST['ratio_support']))
				$ratio_support = 1;
			else
				$ratio_support = 0;

			$filecontent .= "  \$EnableQuota = $quota_support;                  // Enable virtual quota's (0=Off 1=On)\n\n";

			$filecontent .= "  \$EnableRatio = $ratio_support;                  // Enable ratio (0=Off 1=On)\n";
			$filecontent .= "                                     // The pureftpd server has to be compiled with ratio support.\n\n";

			$filecontent .= "  /* This list of users will NOT appear in the dropdown menu. */\n";
			$filecontent .= "  \$BlacklistUsers = array ('adm','bin','bind','daemon','gopher','halt','kmem','lp',\n";
			$filecontent .= "                           'mailnull','man','named','nfsnobody','nscd','operator',\n";
			$filecontent .= "                           'pop','root','rpc','rpcuser','rpm','shutdown','smmsp',\n";
			$filecontent .= "                           'sshd','sync','toor','tty','uucp','vcsa','xfs');\n\n";

			$filecontent .= "  /* This list of groups will NOT appear in the dropdown menu. */\n";
			$filecontent .= "  \$BlacklistGroups = array ('adm','bin','bind','daemon','dialer','dip','disk','floppy','gopher','kmem',\n";
			$filecontent .= "                           'lock','lp','mailnull','man','named','mem','network','news',\n";
			$filecontent .= "                           'nscd','ntp','operator','pcap','root','rpc','rpcuser','rpm','slocate','smmsp',\n";
			$filecontent .= "                           'sshd','staff','sys','tty','utmp','uucp','vcsa','wheel','xfs');\n\n";
			$filecontent .= "?>";

			$fh = fopen($filename,"w");
			fwrite($fh, $filecontent);
			fclose($fh);
		}
	}

	if($stage != 'stage_1_start')
	{

		if(!include('config.php'))
			end_session("<br>Error: couldn't open file <b>config.php</b><br>\n");
	}

	if($stage == 'stage_3_create_database' )
	{
		if (isset($_POST['AdminHostname']))
			$_SESSION['Admin_DBHost'] = $_POST['AdminHostname'];

		if (isset($_POST['AdminLogin']))
			$_SESSION['Admin_DBLogin'] = $_POST['AdminLogin'];

		if (isset($_POST['AdminPassword']))
			$_SESSION['Admin_DBPassword'] = $_POST['AdminPassword'];
	}
	
	if($stage == 'stage_5_configure_administrators')
	{
		$link = sql_connect("$DBHost", "$DBLogin", "$DBPassword");
		if(!$link)
		{
			
			end_session("<br>Error: MySql server not found.<br><br>MySql error : ".sql_error($link));
		}
		if (!@sql_select_db("$DBDatabase", $link))
			end_session("<br>Error: Database 'ftpusers' doesn't exist.<br><br>MySql error : ".sql_error($link));

		$table_users  = "SELECT * FROM admin ORDER BY Username ASC";
		$query_users  = sql_query($table_users, $link);
		if (!$query_users)
			end_session("<br>Error: Table 'admin' from database 'ftpusers' doesn't exist.<br><br>MySql error : ".sql_error($link));


		/* Password change request for Administrator */
		if (isset($_POST["admin_change"]) &&
			isset($_POST["admin_password"]) &&
			$_POST["admin_password"] != "fake_password")
		{
			if(!sql_query("UPDATE admin SET Password='".md5($_POST['admin_password'])."' WHERE Username='Administrator'",$link))
				echo ("Failed to change the Administrator password<br>".sql_error($link)."<br>\n");
			else
				echo ("The 'Administrator' password has been changed!<br>\n");
		}

		if (isset($_POST["admin_current_id"]) &&
			$_POST["admin_current_id"] != "empty_value")
		{
			$admin_id = $_POST["admin_current_id"];
			$user = $_POST["admin_current_".$admin_id."_name"];
			$password = $_POST["admin_current_".$admin_id."_password"];

			//echo ("The 'Administrator' ID = ".$admin_id."<br>\n");

			if (isset($_POST["admin_current_change"]))
			{
				if ($password == "fake_password") // Change only username
				{
					if(!sql_query("UPDATE admin SET Username='$user' WHERE Username='$admin_id'",$link))
						echo ("Failed to change the username '$user'<br>".sql_error($link)."<br>\n");
					else
						echo ("The username '$user' has been changed!<br>\n");
				}else // Change username and password.
				{
					if(!sql_query("UPDATE admin SET Username='$user',Password='".md5($password)."' WHERE Username='$admin_id'",$link))
						echo ("Failed to change the username and password of '$user'<br>".sql_error($link)."<br>\n");
					else
						echo ("The username and password of the user '$user' has been changed!<br>\n");

				}
			}else if (isset($_POST["admin_current_delete"]))
			{

				if(!sql_query("DELETE FROM admin WHERE Username='$admin_id'",$link))
					echo ("Failed to remove the user $admin_id<br>".sql_error($link)."<br>\n");
				else
					echo ("Delete user $admin_id<br>\n");
			}

		}

		if (isset($_POST["admin_new_name"]) &&
			isset($_POST["admin_new_password"]) &&
			isset($_POST["admin_new_button"]))
		{
			$user = $_POST["admin_new_name"];
			$password = $_POST["admin_new_password"];

			if ($user != "" && $password != "")
			{
				if(!sql_query("INSERT INTO admin (Username,Password) VALUES ('$user','".md5($password)."')",$link))
					echo ("Failed to add user $user!<br>".sql_error($link)."<br>\n");
			}
		}

	}

	echo ("<html>\n");
	echo ("<head>\n");
	echo ("<title>Installation Wizard for the 'User manager for PureFTPd'</title>\n");
	echo ("<meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"utf-8\">\n");
	echo ("<meta name=\"description\" content=\"The ‘User manager for PureFTPd’ is a software project from Machiel Mastenbroek,");
	echo (" more information about this free software could be found on my website: http://machiel.generaal.net/index.php?subject=user_manager_pureftpd \">\n");

	echo ("<style type=\"text/css\">\n");
	echo ("A {\n");
	echo ("  TEXT-DECORATION: underline;\n");
	echo ("  COLOR: #821517; TEXT-DECORATION: none;\n");
	echo ("}\n");
	echo ("A:hover {\n");
	echo ("  TEXT-DECORATION: underline\n");
	echo ("  COLOR: #821517; TEXT-DECORATION: underline\n");
	echo ("}\n");



	echo ("</style>\n");
	echo ("</head>\n");


	echo ("<body style=\"COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #ffffff; TEXT-ALIGN: center\">\n");



	error_reporting(E_ERROR);



	echo ("<form action=\"$_SERVER[PHP_SELF]\" method=\"post\" name=\"configuration\">\n");
	echo ("<input type=\"hidden\" id=\"next_stage\" name=\"next_stage\" value=\"none\">\n");

	echo ("<table style=\"BORDER-RIGHT: #003399 1px solid; BORDER-TOP: #003399 1px solid; BACKGROUND: url(".$_SERVER[PHP_SELF]."?image=background.jpg) ");
	echo ("#fff no-repeat right top; MARGIN: 0px auto; BORDER-LEFT: #003399 1px solid; WIDTH: 740px; TEXT-ALIGN: left ");
	echo ("border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n");
	echo ("<tr style=\"BACKGROUND: url(".$_SERVER[PHP_SELF]."?image=yellowbar.gif) #fff repeat-x 50% top\">\n");
	echo ("<td>\n");
	echo ("&nbsp;<img src=\"".$_SERVER[PHP_SELF]."?image=dot.gif\" style=\"margin-top: 1px;\">&nbsp;Configuration 'User manager for PureFTPd'\n");
	echo ("</td>\n");
	echo ("<td align=\"right\">\n");
	echo ("<span style=\"FONT-WEIGHT: bold; FONT-SIZE: 12px\">Step [".$step." - 7]&nbsp;</span>\n");
	echo ("</td>\n");
	echo ("</tr>\n");
	echo ("<tr style=\"BACKGROUND: url(".$_SERVER[PHP_SELF]."?image=bluebar.gif) #fff repeat-x 50% top\">\n");
	echo ("<td colspan=\"2\" style=\"BORDER-TOP: #003399 1px solid; BORDER-BOTTOM: #003399 1px solid;\" align=\"right\">&nbsp;</td>\n");
	echo ("</tr>\n");
	echo ("<tr align=\"left\" valign=\"top\">\n");
	echo ("<td colspan=\"2\">\n");
	echo ("<table width=\"100%\" border=\"0\" cellpadding=\"0\">\n");

	$errors = 0;

	if($stage == 'stage_1_start')
	{

		echo ("<tr>\n");
		echo ("<td width=\"60%\">&nbsp;</td>\n");
		echo ("<td width=\"30%\">&nbsp;</td>\n");
		echo ("<td width=\"10%\">&nbsp;</td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td colspan=\"3\">This configuration script has carried out a few checks to see if everything is ready to start the configuration.</td>\n");
		echo ("</tr>\n");

		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");


		echo ("<tr>\n");
		echo ("<td>Checking if config.php exists</td>\n");
		if(!file_exists("config.php")) {
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$errors += 1;
		} else {
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Checking if config.php is writable</td>\n");
		if(!is_writable("config.php")) {
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$errors += 1;
		} else {
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td>Checking if PHP Extension MYSQL is enabled</td>\n");
		if (!extension_loaded('mysql') && !extension_loaded('mysqli')) {
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$errors += 1;
		} else {
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Checking if PHP Extension PCRE is enabled</td>\n");
		if (!extension_loaded('pcre')) {
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$errors += 1;
		} else {
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Checking if PHP Extension POSIX is enabled</td>\n");
		if (!extension_loaded('posix')) {
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$errors += 1;
		} else {
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Checking if PHP Extension SESSION is enabled</td>\n");
		if (!extension_loaded('session')) {
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$errors += 1;
		} else {
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");

		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

		if ($errors != 0)
		{
			echo ("<tr>\n");
			echo ("<td colspan=\"3\">Unfortunately, The configuration cannot continue at the moment, due to the above error(s). Please correct the error(s), and try again.</td>\n");
			echo ("</tr>\n");
		}else
		{
			echo ("<tr>\n");
			echo ("<td colspan=\"2\">&nbsp;</td><td align=\"right\">
			<input type=\"submit\" name=\"next\" value=\"Step 2\" onclick=\"document.getElementById('next_stage').value='stage_2_new_database';\">
			</td>\n");
			echo ("</tr>\n");
		}
	}else if($stage == 'stage_2_new_database')
	{
			echo ("<tr>\n");
			echo ("<td width=\"60%\">&nbsp;</td>\n");
			echo ("<td width=\"30%\">&nbsp;</td>\n");
			echo ("<td width=\"10%\">&nbsp;</td>\n");
			echo ("</tr>\n");

			echo ("<tr>\n");
			echo ("<td colspan=\"3\">Please choose your configuration type:.</td>\n");
			echo ("</tr>\n");

			echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

			echo ("<tr>\n");
			echo ("<td><a href=\"".$_SERVER[PHP_SELF]."?stage=stage_3_create_database\">");
			echo ("New installation,<br>create a new database.</a></td>\n");
			echo ("<td>&nbsp;</td>\n");
			echo ("<td>&nbsp;</td>\n");
			echo ("</tr>\n");
			echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

			echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

			echo ("<tr>\n");
			echo ("<td>
			<input type=\"submit\" name=\"next\" value=\"Step 1\" onclick=\"document.getElementById('next_stage').value='stage_1_start';\">
			</td><td >&nbsp;</td>\n");
			echo ("<td>&nbsp;</td>");
			echo ("</tr>\n");
			
	}

	else if ($stage == 'stage_3_create_database')
	{
		echo ("<tr>\n");
		echo ("<td width=\"60%\">&nbsp;</td>\n");
		echo ("<td width=\"30%\">&nbsp;</td>\n");
		echo ("<td width=\"10%\">&nbsp;</td>\n");
		echo ("</tr>\n");


	

			echo ("<tr>\n");
			echo ("<td colspan=\"3\">Before the installation of the new database we need ");
			echo ("a MySQL user with enough privileges to create a new user, a database, and 2 tables. ");
			echo ("The attributes username and password will only be used for this goal and will <b>not</b> ");
			echo ("be saved or stored after this php session.</td>\n");
			echo ("</tr>\n");

			echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

			echo ("<tr>\n");
			echo ("<td>Hostname</td>\n");
			echo ("<td><input type=\"text\" name=\"AdminHostname\" value=\"".$_SESSION['Admin_DBHost']."\" size=\"25\" maxlength=\"25\"></td>\n");
			echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.AdminHostname.value=\"".$default_db_host."\";'></td>\n");
			echo ("</tr>\n");

			echo ("<tr>\n");
			echo ("<td>Username</td>\n");
			echo ("<td><input type=\"text\" name=\"AdminLogin\" value=\"".$_SESSION['Admin_DBLogin']."\" size=\"25\" maxlength=\"25\"></td>\n");
			echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.AdminLogin.value=\"".$default_db_user."\";'></td>\n");
			echo ("</tr>\n");

			echo ("<tr>\n");
			echo ("<td>Password</td>\n");
			echo ("<td><input type=\"password\" name=\"AdminPassword\" value=\"".$_SESSION['Admin_DBPassword']."\" size=\"25\" maxlength=\"25\"></td>\n");
			echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.AdminPassword.value=\"".$default_db_pswd."\";'></td>\n");
			echo ("</tr>\n");

			echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

			echo ("<tr>\n");


			echo ("<td>Checking connection to MySQL server </td>\n");
				
			$connection_oke = false;
			if(isset($_SESSION['Admin_DBHost']) && 
			   isset($_SESSION['Admin_DBLogin']) && 
			   isset($_SESSION['Admin_DBPassword']))
			{
				//echo ("step 1");
				if (strlen($_SESSION['Admin_DBHost']) > 0 &&
				    strlen($_SESSION['Admin_DBLogin']) > 0 )
				{
				
					//echo ("step 2".$_SESSION['Admin_DBPassword'] );
					$adminlink = mysqli_connect($_SESSION['Admin_DBHost'], $_SESSION['Admin_DBLogin'], $_SESSION['Admin_DBPassword']);
					if($adminlink)
					{
					//	echo ("step 3");
						$connection_oke = true;
					}
				}
			}
			if($connection_oke) 
			{
				echo ("<td><font color=\"green\">OK!</font></td>\n");
			}
			else
			{
				echo ("<td><font color=\"red\">Failed!</font></td>\n");
				$error += 1;
			}

			
			if ($error == 0)
				echo ("<td>&nbsp;</td>\n");
			else
				echo ("<td><input type=\"submit\" name=\"connect\" value=\"Connect\"></td>\n");

			echo ("</tr>\n");
			
			$error_new_database = 1;

			if ($error == 0)
			{
				$error_new_database = 0;

				echo ("<tr>\n");
				echo ("<td>Create user FTP</td>\n");
			//	$errormsg = sql_query("INSERT INTO mysql.user (Host, User, Password, Select_priv, Insert_priv, Update_priv, Delete_priv, Create_priv, Drop_priv, Reload_priv, Shutdown_priv, Process_priv, File_priv, Grant_priv, References_priv, Index_priv, Alter_priv) VALUES('127.0.0.1','ftp',PASSWORD('tmppasswd'),'Y','Y','Y','Y','N','N','N','N','N','N','N','N','N','N');", $adminlink);
				
				$errormsg = sql_query("CREATE USER 'ftp'@'127.0.0.1' IDENTIFIED BY 'tmppasswd';",$adminlink);
				$errormsg += sql_query("GRANT ALL PRIVILEGES ON ftpusers.* TO 'ftp'@'127.0.0.1';",$adminlink);
				$errormsg += sql_query("FLUSH PRIVILEGES;", $adminlink);
					
					
				$query_users  = sql_query("SELECT User FROM mysql.user WHERE User='ftp' AND Host='127.0.0.1';", $adminlink);
				
				  // printf("Select returned %d rows.\n", mysqli_num_rows($query_users));
				   
				if (!$query_users)
				{
					echo ("<td><font color=\"red\">Failed!</font></td>\n");
					$error_new_database += 1;
				}
				else
					echo ("<td><font color=\"green\">OK!</font></td>\n");

				echo ("<td>&nbsp</td>\n");
				echo ("</tr>\n");

				echo ("<tr>\n");
				echo ("<td>Create database ftpusers</td>\n");
				$errormsg = sql_query("CREATE DATABASE ftpusers;", $adminlink);
				$errormsg += sql_query("USE ftpusers;", $adminlink);


				$select_db = sql_select_db('ftpusers',$adminlink);
				//$select_db = mysqli_select_db($adminlink


				if (!@$select_db)
				{
					$error_new_database += 1;
					echo ("<td><font color=\"red\">Failed!</font></td>\n");
				}
				else
					echo ("<td><font color=\"green\">OK!</font></td>\n");

				echo ("<td>&nbsp</td>\n");
				echo ("</tr>\n");

				echo ("<tr>\n");
				echo ("<td>Create table admin</td>\n");
//				$errormsg = sql_query("CREATE TABLE admin (Username varchar(35) NOT NULL default '',Password char(32) binary NOT NULL default '',PRIMARY KEY  (Username)) TYPE=MyISAM;", $adminlink);
				$errormsg = sql_query("CREATE TABLE admin (Username varchar(35) NOT NULL default '',Password char(32) binary NOT NULL default '',PRIMARY KEY  (Username)) Engine=MyISAM;", $adminlink);
				
				// printf("Select returned %d rows.\n", mysqli_num_rows($errormsg));
				
				
				$errormsg += sql_query("INSERT INTO admin VALUES ('Administrator',MD5('tmppasswd'));", $adminlink);
				$query_admin  = sql_query("SELECT * FROM admin ORDER BY Username ASC", $adminlink);
				if (!$query_admin)
				{
					$error_new_database += 1;
					echo ("<td><font color=\"red\">Failed!</font></td>\n");
				}
				else
				{
					echo ("<td><font color=\"green\">OK!</font></td>\n");
				}
				echo ("<td>&nbsp</td>\n");
				echo ("</tr>\n");

				echo ("<tr>\n");
				echo ("<td>Create table users</td>\n");


				$errormsg = sql_query("CREATE TABLE `users` (`User` varchar(16) NOT NULL default '',`Password` varchar(32) binary NOT NULL default '',PRIMARY KEY  (`User`), UNIQUE KEY `User` (`User`)) Engine=MyISAM;", $adminlink);
				// $errormsg += sql_query("INSERT INTO admin VALUES ('Administrator',MD5('tmppasswd'));", $adminlink);
				// $errormsg += sql_query("ALTER TABLE ftpusers.users ADD Status enum('0','1') NOT NULL default '1';", $admin_link);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `Uid` int(11) NOT NULL default '14';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `Gid` int(11) NOT NULL default '5';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `Dir` varchar(128) NOT NULL default '';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `QuotaFiles` int(10) NOT NULL default '500';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `QuotaSize` int(10) NOT NULL default '30';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `ULBandwidth` int(10) NOT NULL default '80';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `DLBandwidth` int(10) NOT NULL default '80';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `Ipaddress` varchar(15) NOT NULL default '*';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `Comment` tinytext;", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `Status` enum('0','1') NOT NULL default '1';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `ULRatio` smallint(5) NOT NULL default '1';", $adminlink);
				$errormsg += sql_query("ALTER TABLE ftpusers.users ADD `DLRatio` smallint(5) NOT NULL default '1';", $adminlink);
				$errormsg += sql_query("INSERT INTO ftpusers.users VALUES ('ftpuser_1',MD5('tmppasswd'),65534, 31, '/usr', 100, 50, 75, 75, '*', 'Ftp user (for example)', '1', 0, 0);", $adminlink);

				$query_users  = sql_query("SELECT * FROM users ORDER BY User ASC",$adminlink);
				if (!$query_users)
				{
					$error_new_database += 1;
					echo ("<td><font color=\"red\">Failed!</font></td>\n");

				}
				else
				{
					echo ("<td><font color=\"green\">OK!</font></td>\n");
				}

				echo ("<td>&nbsp</td>\n");
				echo ("</tr>\n");


			echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
			//echo ("<tr><td colspan=\"3\"><input type=\"submit\" name=\"none\" value=\"Try again\"></td></tr>\n");

			echo ("<tr>\n");
			echo ("<td><input type=\"submit\" name=\"Step\" value=\"Step 2\" onclick=\"document.getElementById('next_stage').value='stage_2_new_database';\"></td><td >&nbsp;</td>\n");
			
			if ($error_new_database == 0)
				echo ("<td align=\"right\"><input type=\"submit\" onclick=\"document.getElementById('next_stage').value='stage_4_configuration_file';\" name=\"next\" value=\"Step 4\" ></td>");
			else
				echo ("<td align=\"right\"><input type=\"submit\" name=\"none\" value=\"Try again\"></td>");
			echo ("</tr>\n");


		}

	}else if ($stage == 'stage_4_configuration_file')
	{

		echo ("<tr>\n");
		echo ("<td width=\"60%\">&nbsp;</td>\n");
		echo ("<td width=\"30%\">&nbsp;</td>\n");
		echo ("<td width=\"10%\">&nbsp;</td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td colspan=\"3\">Here you can change the configuration of the 'User manager for PureFTPd'.<br>");
		echo ("This attributes will be stored in the <b>config.php</b> file.</td>\n");
		echo ("</tr>\n");

		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

		
		// $_SESSION['Admin_DBHost']
		
		//  $_SESSION['LocalValue_DBHost']
		
		echo ("<tr>\n");
		echo ("<td>Hostname</td>\n");
		echo ("<td><input type=\"text\" name=\"Hostname\" value=\"".$DBHost."\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.Hostname.value=\"127.0.0.1\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Login</td>\n");
		echo ("<td><input type=\"text\" name=\"Login\" value=\"".$DBLogin."\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.Login.value=\"ftp\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Password</td>\n");
		echo ("<td><input type=\"text\" name=\"Password\" value=\"".$DBPassword."\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.Password.value=\"tmppasswd\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Database</td>\n");
		echo ("<td><input type=\"text\" name=\"Database\" value=\"".$DBDatabase."\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.Database.value=\"ftpusers\";'></td>\n");
		echo ("</tr>\n");

		
		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

		echo ("<tr>\n");
		echo ("<td>Language</td>\n");
		echo ("<td>");
		echo ("<select name=\"language\">\n");
		$Directory = "language";
		if(($Dir = @dir($Directory)) == false)
			echo ("<font color='blue'>Warning:</font> Can't open directory $Directory<br>\n");

		while ($Filename = $Dir->read()) {

			if (substr($Filename,-4)  == '.php' && $Filename != "index.php")
			{

				$Filename = substr($Filename,0,-4); // remove '.php'
				$Filename = ucfirst($Filename);     // Upper case first charakter
				if ($LANG == $Filename)
					echo ("<option value=\"$Filename\" selected=\"selected\">$Filename</option>\n");
				else
					echo ("<option value=\"$Filename\">$Filename</option>\n");
			}
		}
		echo ("</select>\n");
		echo ("</td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.language.value=\"English\";'></td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td>FTP Address</td>\n");
		echo ("<td><input type=\"text\" name=\"ftp_address\" value=\"$FTPAddress\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.ftp_address.value=\"myipaddress.com:21\";'></td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td>Image location</td>\n");
		echo ("<td><input type=\"text\" name=\"image_location\" value=\"$LocationImages\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.image_location.value=\"images\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Default user ID</td>\n");
		echo ("<td><input type=\"text\" name=\"default_user_id\" value=\"$DEFUserID\" size=\"5\" maxlength=\"7\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.default_user_id.value=\"65534\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Default group ID</td>\n");
		echo ("<td><input type=\"text\" name=\"default_group_id\" value=\"$DEFGroupID\" size=\"5\" maxlength=\"7\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.default_group_id.value=\"31\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Location of passwd file</td>\n");
		echo ("<td><input type=\"text\" name=\"location_passwd\" value=\"$UsersFile\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.location_passwd.value=\"/etc/passwd\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Location of group file</td>\n");
		echo ("<td><input type=\"text\" name=\"location_groupfile\" value=\"$GroupFile\" size=\"25\" maxlength=\"25\"></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.location_groupfile.value=\"/etc/group\";'></td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td>StyleSheet</td>\n");
		echo ("<td>");
		echo ("<select name=\"stylesheet\">\n");
		$Directory = "style";
		if(($Dir = @dir($Directory)) == false)
			echo ("<font color='blue'>Warning:</font> Can't open directory $Directory<br>\n");


		while ($Filename = $Dir->read()) {

			if (substr($Filename,-4) == '.php' &&
				$Filename != "index.php")
			{
				// $Filename[strlen($Filename) - 4] = _;
				$Label = substr($Filename,0,-4); // remove '.php'
				$Label = ucfirst($Label); // Upper case first charakter
				$Filename = "style/$Filename";

				if ($StyleSheet == $Filename)
					echo ("<option value=\"$Filename\" selected=\"selected\">$Label</option>\n");
				else
					echo ("<option value=\"$Filename\">$Label</option>\n");
			}
		}
		echo ("</select>\n");
		echo ("</td>\n");
		
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.stylesheet.value=\"style/default.css.php\";'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Quota support</td>\n");
		if ($EnableQuota == 0)
			echo ("<td><input type=\"checkbox\" name=\"quota_support\" value=\"checkbox\"></td>\n");
		else
			echo ("<td><input type=\"checkbox\" name=\"quota_support\" value=\"checkbox\" checked></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.quota_support.checked=false;'></td>\n");
		echo ("</tr>\n");

		echo ("<tr>\n");
		echo ("<td>Ratio support</td>\n");
		if ($EnableRatio == 0)
			echo ("<td><input type=\"checkbox\" name=\"ratio_support\" value=\"checkbox\"></td>\n");
		else
			echo ("<td><input type=\"checkbox\" name=\"ratio_support\" value=\"checkbox\" checked></td>\n");
		echo ("<td><input type=\"button\" value=\"default\" onclick='document.configuration.ratio_support.checked=false;'></td>\n");
		echo ("</tr>\n");

		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

		echo ("<tr>\n");
		echo ("<td>Save this configuration in config.php</td>");
		echo ("<td><input type=\"submit\" name=\"save\" value=\"Save\"></td>");
		echo ("<td>&nbsp;</td>");
		echo ("</tr>\n");

		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
		echo ("<tr>\n");
		echo ("<td>Checking connection to MySQL server ".$_SESSION['LocalValue_DBHost']."</td>\n");
		
		$link = sql_connect($DBHost, $DBLogin, $DBPassword);
		if(!$link)
		{
			echo ("<td><font color=\"red\">Failed!</font></td>\n");
			$error += 1;
		}
		else
		{
			echo ("<td><font color=\"green\">OK!</font></td>\n");
		}
		echo ("<td>&nbsp;</td>\n");
		echo ("</tr>\n");		
		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
		echo ("<tr>\n");
		
		

		echo ("<td><input onclick=\"document.getElementById('next_stage').value='stage_3_create_database';\" type=\"submit\" name=\"prev\" value=\"Step 3\"></td>\n");
		
		echo ("<td>&nbsp</td>\n");
		if($error > 0)
		{
			echo ("<td>&nbsp;</td>\n");
		}else{
			echo ("<td align=\"right\"><input onclick=\"document.getElementById('next_stage').value='stage_5_configure_administrators';\"  type=\"submit\" name=\"next\" value=\"Step 5\"></td>");
		}		
		
		echo ("</tr>\n");


	}else if ($stage == 'stage_5_configure_administrators')
	{
		echo ("<tr>\n");
		echo ("<td width=\"35%\">&nbsp;</td>\n");
		echo ("<td width=\"35%\">&nbsp;</td>\n");
		echo ("<td width=\"30%\">&nbsp;</td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td colspan=\"3\">For security reasons a user must first has been authorized \n");
		echo ("before he can start creating FTP accounts with the &acute;User \n");
		echo ("manager for PureFTPd&acute;. <br> Therefore a user must select a username and \n");
		echo ("fill in a valid password. \n");
		echo ("<p>Here you can make or change, at least one, username and password \n");
		echo ("for the &acute;User manager for PureFTPd&acute; authorization. There is only \n");
		// echo ("one security level, you are authorized or not, so when you creating \n");
		echo ("one security level, so when you creating \n");
		echo ("more than one user there is no differences, except the password, \n");
		echo ("between them.</p>\n");
		echo ("</td>\n");
		echo ("</tr>\n");
		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
		// echo ("<tr><td colspan=\"2\">Username: ");
		echo ("<tr><td>Username: ");
		echo ("<input type=\"text\" name=\"admin\" value=\"Administrator\">\n");
		echo ("<script>\n");
		echo ("document.configuration.admin.disabled=\"true\";\n");
		echo ("</script>\n");
		echo ("</td><td> Password:");
		// echo (" Password:");
		echo ("<input type=\"password\" name=\"admin_password\" value=\"fake_password\">\n");
        echo ("</td><td align=\"left\">");
        echo ("<input type=\"submit\" name=\"admin_change\" value=\"Change\">");
		echo ("</td></tr>\n");

		// echo ("DBHost : ".$DBHost.",DBLogin : ".$DBLogin.",DBPassword : ".$DBPassword."<br/>\n");
		
		$link = sql_connect("$DBHost", "$DBLogin", "$DBPassword");
		if(!$link)
			end_session("<br>Error: MySql server not found.<br><br>MySql error : ".sql_error());

		if (!@sql_select_db("$DBDatabase",$link))
			end_session("<br>Error: Database 'ftpusers' doesn't exist.<br><br>MySql error : ".sql_error());

		$table_users  = "SELECT * FROM admin ORDER BY Username ASC;";
		$query_users  = sql_query($table_users, $link);
		if (!$query_users)
			end_session("<br>Error: Table 'admin' from database 'ftpusers' doesn't exist.<br><br>MySql error : ".sql_error($link));

		$length_users = sql_num_rows($query_users);

		echo ("<input type=\"hidden\" id=\"admin_current_id\" name=\"admin_current_id\" value=\"empty_value\">");

		for ($iCounter=1;$iCounter<$length_users;$iCounter++)
		{
			$user     = sql_result($query_users,$iCounter,"Username");

			if ($user != "Administrator")
			{
				echo ("<tr><td>Username: ");
				echo ("<input type=\"text\" name=\"admin_current_".$user."_name\" value=\"$user\">\n");
				echo ("</td><td> Password:");
				echo ("<input type=\"password\" name=\"admin_current_".$user."_password\" value=\"fake_password\">\n");
			    echo ("</td><td align=\"left\">");
			    echo ("<input type=\"submit\" onclick=\"document.getElementById('admin_current_id').value='$user';\" name=\"admin_current_change\" value=\"Change\"> &nbsp;");
			    echo ("<input type=\"submit\" onclick=\"document.getElementById('admin_current_id').value='$user';\" name=\"admin_current_delete\" value=\"Delete\"> &nbsp;");
				echo ("</td></tr>\n");
			}
		}
			
		
		echo ("<tr><td>Username: ");
		echo ("<input type=\"text\" name=\"admin_new_name\" value=\"\">\n");
		echo ("</td><td> Password:");
		// echo (" Password:");
		echo ("<input type=\"password\" name=\"admin_new_password\" value=\"\">\n");
		echo ("</td><td align=\"left\">");
		echo ("<input type=\"submit\" name=\"admin_new_button\" value=\"Add\">");
		echo ("</td></tr>\n");
		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");

		echo ("<tr>\n");
		echo ("<td><input type=\"submit\" name=\"prev\" value=\"Step 4\" onclick=\"document.getElementById('next_stage').value='stage_4_configuration_file';\"></td>\n");
		echo ("<td>&nbsp</td>\n");
		echo ("<td align=\"right\"><input type=\"submit\" name=\"next\" value=\"Step 6\" onclick=\"document.getElementById('next_stage').value='stage_6_pureftpd_config';\"></td>");
		echo ("</tr>\n");
	}else if ($stage == 'stage_6_pureftpd_config')
	{
		echo ("<tr>\n");
		echo ("<td width=\"10%\">&nbsp;</td>\n");
		echo ("<td width=\"40%\">&nbsp;</td>\n");
		echo ("<td width=\"40%\">&nbsp;</td>\n");
		echo ("</tr>\n");


		echo ("<tr>\n");
		echo ("<td colspan=\"3\">\n");
		echo ("<p>The configuration of the 'User manager for PureFTPd' is completed.\n");
		echo ("Before you can use this user manager in conjunction with the FTP\n");
		echo ("server you must configure PureFTPd. For this goal you have to\n");
		echo ("change two configuration files of PureFTPd.</p>\n");
		echo ("<p>The first one is <b>pure-ftpd.conf</b>, this file contains the\n");
		echo ("main configuration of the FTP server for example: Maximum number\n");
		echo ("of clients or the location of the LOG files.</p>\n");
		echo ("<p>The second one called <b>pureftpd-mysql.conf</b> tells the PureFTPd\n");
		echo ("server how to handle the database. </p>\n");
		echo ("<p>The location of both files is depending on your operation system,\n");
		echo ("for FreeBSD for example this is '/usr/local/etc/'. When you can't \n");
		echo ("find those files you probably still have to copy the two example \n");
		echo ("files of PureFTPd called: <b>pure-ftpd.conf.sample</b> and <b>pureftpd-mysql.conf.sample</b>.\n");
		echo ("In this Step we will tell you how configure those two files so\n");
		echo ("that the PureFTPd server and this user manager can work together\n");
		echo ("with the same database.<br>\n");
		echo ("</p>\n");
		echo ("</td></tr>\n");

		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
		echo ("<tr><td colspan=\"3\">Step A)</td></tr>\n");
		echo ("<tr><td>&nbsp;</td>");
		echo ("<td colspan=\"2\">\n");
		echo ("Edit the configuration file <b>pure-ftpd.conf</b>\n");
		echo ("and make sure that following line with the attribute 'MySQLConfigFile'\n");
		echo ("is enabled and points to the right location.\n");
		echo ("<pre># MySQL configuration file (see README.MySQL)\n");
		echo ("MySQLConfigFile /usr/local/etc/pureftpd-mysql.conf</pre>");
		echo ("</td></tr>");

		echo ("<tr><td colspan=\"3\">Step B)</td></tr>\n");
		echo ("<tr><td>&nbsp;</td>");
		echo ("<td colspan=\"2\">\n");
		echo ("The entire content for the file <b>pureftpd-mysql.conf</b> \n");
		echo ("you can find below, just copy and past the content to a new pureftpd-mysql.conf\n");
		echo ("file. The red color text marks the changes that are made based on\n");
		echo ("the values you choused in Step 4 of this configuration process.<br><br>\n");
		echo ("</td></tr>");

		echo ("<tr><td>&nbsp;</td>");
		echo ("<td colspan=\"2\" bgcolor=\"#CCCCCC\">\n");

		echo ("<pre>\n");

		echo ("############################################################################\n");
		echo ("#                                                                          #\n");
		echo ("# PureFTPd MySQL configuration file.                                       #\n");
		echo ("# Generated by the installation wizard for the 'User manager for PureFTPd' #\n");
		echo ("# See http://machiel.generaal.net for more info                            #\n");
		echo ("# or read the README.MySQL for explanations of the syntax.                 #\n");
		echo ("#                                                                          #\n");
		echo ("############################################################################\n");
		echo ("\n");
		echo ("# Optional : MySQL server name or IP. Don't define this for unix sockets.\n");
		echo ("\n");
		echo ("MYSQLServer     <font color=\"red\">$DBHost</font>\n");
		echo ("\n");

		echo ("# Optional : MySQL port. Don't define this if a local unix socket is used.\n");
		echo ("\n");
		echo ("# MYSQLPort       3306\n");
		echo ("\n");
		echo ("\n");
		echo ("# Optional : define the location of mysql.sock if the server runs on this host.\n");
		echo ("\n");
		echo ("MYSQLSocket     /tmp/mysql.sock\n");
		echo ("\n");
		echo ("\n");
		echo ("# Mandatory : user to bind the server as.\n");
		echo ("\n");
		echo ("MYSQLUser      <font color=\"red\">$DBLogin</font>\n");
		echo ("\n");
		echo ("\n");
		echo ("# Mandatory : user password. You must have a password.\n");
		echo ("\n");
		echo ("MYSQLPassword   <font color=\"red\">$DBPassword</font>\n");
		echo ("\n");
		echo ("\n");
		echo ("# Mandatory : database to open.\n");
		echo ("\n");
		echo ("MYSQLDatabase  <font color=\"red\">$DBDatabase</font>\n");
		echo ("\n");
		echo ("\n");
		echo ("# Mandatory : how passwords are stored\n");
		echo ("# Valid values are : \"cleartext\", \"crypt\", \"md5\" and \"password\"\n");
		echo ("# (\"password\" = MySQL password() function)\n");
		echo ("# You can also use \"any\" to try \"crypt\", \"md5\" *and* \"password\"\n");
		echo ("\n");
		echo ("MYSQLCrypt      <font color=\"red\">md5</font>\n");
		echo ("\n");
		echo ("\n");
		echo ("# In the following directives, parts of the strings are replaced at\n");
		echo ("# run-time before performing queries :\n");
		echo ("#\n");
		echo ("# \L is replaced by the login of the user trying to authenticate.\n");
		echo ("# \I is replaced by the IP address the user connected to.\n");
		echo ("# \P is replaced by the port number the user connected to.\n");
		echo ("# \R is replaced by the IP address the user connected from.\n");
		echo ("# \D is replaced by the remote IP address, as a long decimal number.\n");
		echo ("#\n");
		echo ("# Very complex queries can be performed using these substitution strings,\n");
		echo ("# especially for virtual hosting.\n");
		echo ("\n");
		echo ("\n");
		echo ("# Query to execute in order to fetch the password\n");
		echo ("\n");
		echo ("<font color=\"red\">MYSQLGetPW      SELECT Password FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		echo ("\n");
		echo ("\n");
		echo ("# Query to execute in order to fetch the system user name or uid\n");
		echo ("\n");
		echo ("<font color=\"red\">MYSQLGetUID     SELECT Uid FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		echo ("\n");
		echo ("\n");
		echo ("# Optional : default UID - if set this overrides MYSQLGetUID\n");
		echo ("\n");
		echo ("#MYSQLDefaultUID 1000\n");
		echo ("\n");
		echo ("\n");
		echo ("# Query to execute in order to fetch the system user group or gid\n");
		echo ("\n");
		echo ("<font color=\"red\">MYSQLGetGID     SELECT Gid FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		echo ("\n");
		echo ("# Optional : default GID - if set this overrides MYSQLGetGID\n");
		echo ("\n");
		echo ("#MYSQLDefaultGID 1000\n");
		echo ("\n");
		echo ("\n");
		echo ("# Query to execute in order to fetch the home directory\n");
		echo ("\n");
		echo ("<font color=\"red\">MYSQLGetDir     SELECT Dir FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		echo ("\n");
		echo ("# Optional : query to get the maximal number of files\n");
		echo ("# Pure-FTPd must have been compiled with virtual quotas support.\n");
		echo ("\n");

		if ($EnableQuota == 1)
			echo ("<font color=\"red\">MySQLGetQTAFS  SELECT QuotaFiles FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		else
			echo ("# MySQLGetQTAFS  SELECT QuotaFiles FROM users WHERE User=\"\\L\"\n");

		echo ("\n");
		echo ("# Optional : query to get the maximal disk usage (virtual quotas)\n");
		echo ("# The number should be in Megabytes.\n");
		echo ("# Pure-FTPd must have been compiled with virtual quotas support.\n");
		echo ("\n");

		if ($EnableQuota == 1)
			echo ("<font color=\"red\">MySQLGetQTASZ  SELECT QuotaSize FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		else
			echo ("# MySQLGetQTASZ  SELECT QuotaSize FROM users WHERE User=\"\\L\"\n");

		echo ("\n");
		echo ("\n");
		echo ("# Optional : ratios. The server has to be compiled with ratio support.\n");
		echo ("\n");
		if ($EnableRatio == 1)
		{
			echo ("<font color=\"red\">MySQLGetRatioUL SELECT ULRatio FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
			echo ("<font color=\"red\">MySQLGetRatioDL SELECT DLRatio FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		}else
		{
			echo ("# MySQLGetRatioUL SELECT ULRatio FROM users WHERE User=\"\\L\"\n");
			echo ("# MySQLGetRatioDL SELECT DLRatio FROM users WHERE User=\"\\L\"\n");
		}
		echo ("\n");
		echo ("\n");
		echo ("# Optional : bandwidth throttling.\n");
		echo ("# The server has to be compiled with throttling support.\n");
		echo ("# Values are in KB/s .\n");
		echo ("\n");
		// echo ("# MySQLGetBandwidthUL SELECT ULBandwidth FROM users WHERE User=\"\\L\"\n");
		// echo ("# MySQLGetBandwidthDL SELECT DLBandwidth FROM users WHERE User=\"\\L\"\n");
		echo ("<font color=\"red\">MySQLGetBandwidthUL SELECT ULBandwidth FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		echo ("<font color=\"red\">MySQLGetBandwidthDL SELECT DLBandwidth FROM users WHERE User=\"\\L\" AND Status=\"1\" AND (Ipaddress = \"*\" OR Ipaddress LIKE \"\\R\")</font>\n");
		echo ("\n");
		echo ("# Enable ~ expansion. NEVER ENABLE THIS BLINDLY UNLESS :\n");
		echo ("# 1) You know what you are doing.\n");
		echo ("# 2) Real and virtual users match.\n");
		echo ("\n");
		echo ("# MySQLForceTildeExpansion 1\n");
		echo ("\n");
		echo ("\n");
		echo ("# If you upgraded your tables to transactionnal tables (Gemini,\n");
		echo ("# BerkeleyDB, Innobase...), you can enable SQL transactions to\n");
		echo ("# avoid races. Leave this commented if you are using the\n");
		echo ("# traditionnal MyIsam databases or old (< 3.23.x) MySQL versions.\n");
		echo ("\n");
		echo ("# MySQLTransactions On\n");
		echo ("</pre>");
		echo ("</td></tr>");


		echo ("<tr><td colspan=\"3\">Step C)</td></tr>\n");
		echo ("<tr><td>&nbsp;</td>");
		echo ("<td colspan=\"2\">\n");
		echo ("Start or restart your FTP server to activate those changes.\n");
		echo ("</td></tr>");



		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
		echo ("<tr>\n");
		echo ("<td><input type=\"submit\" name=\"Step\" value=\"Step 5\" onclick=\"document.getElementById('next_stage').value='stage_5_configure_administrators';\"></td>\n");
		echo ("<td>&nbsp</td>\n");
		echo ("<td align=\"right\"><input type=\"submit\" name=\"Step\" value=\"Step 7\" onclick=\"document.getElementById('next_stage').value='stage_7_finish';\"></td>");
		echo ("</tr>\n");
	}else if ($stage == 'stage_7_finish')
	{
		echo ("<tr>\n");
		echo ("<td width=\"60%\">&nbsp;</td>\n");
		echo ("<td width=\"30%\">&nbsp;</td>\n");
		echo ("<td width=\"10%\">&nbsp;</td>\n");
		echo ("</tr>\n");


		echo ("<tr><td colspan=\"3\">&nbsp;</td></tr>\n");
		echo ("<tr><td colspan=\"3\" align=\"center\">Congratulations, the\n");
		echo ("configuration of the 'User manager for PureFTPd' is finished.\n");
		echo ("<br><br>\n");
		echo ("Because this configuration doesn't need any authorization anyone\n");
		echo ("could use it without any permission. Therefore it's better that\n");
		echo ("you store this file on a save location, another good solution\n");
		echo ("is to rename the extension from php to txt.\n");
		echo ("<br><br>\n");
		echo ("</td></tr>\n");


		echo ("<tr>\n");
		echo ("<td><input type=\"submit\" name=\"Step\" value=\"Step 6\" onclick=\"document.getElementById('next_stage').value='stage_6_pureftpd_config';\"></td>\n");
		echo ("<td>&nbsp</td>\n");
		echo ("<td>&nbsp</td>\n");
		echo ("</tr>\n");
	}

	echo ("</table>\n");
	echo ("</td>\n");
	echo ("</tr>\n");
	echo ("<tr style=\"BACKGROUND: url(".$_SERVER[PHP_SELF]."?image=bluebar.gif) #fff repeat-x 50% top\">\n");
	echo ("<td colspan=\"2\" style=\"BORDER-TOP: #003399 1px solid; BORDER-BOTTOM: #003399 1px solid;\">&nbsp;</td>\n");
	echo ("</tr>\n");
	echo ("</table>\n");

	echo ("</form>\n");
	echo ("</body>\n");
	echo ("</html>\n");

?>
