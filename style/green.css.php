<?php

	require ('../config.php');

?>

/* Global */

body {
	font-family: Verdana,  Arial;
	text-decoration:none;
	color: #000000;
	font-size: 12px;
}

input {
	font-family: Verdana,  Arial;
	text-decoration:none;
	color: #000000;
	font-size: 12px;
}

table {
	font-size: 12px;
}

a {
	text-decoration:none;
	color: #000000;
}

a:visited {
	text-decoration: none;
	color: default;
}

a:hover {
	color: #FF0000;
}

.help {
	cursor: help
}

/* Login page */

table.login_user {
	background-color: #CCCCCC;
}

table.login_user_border {
	background-color: #000000;
}

input.login_button {
}

/* Admin page */

table.select_user {
	background-color: rgb(0, 0, 0);
}

/* green color 2-3 */
tr.select_user {
	background-color: rgb(198, 219, 156);


}

tr.select_locked_user {
	/* background-color: rgb(235, 234, 219); */
	/* background-color: rgb(198, 219, 156); */
	background-color: rgb(239, 255, 214);
}

input.name {

	border: 0px solid purple;
	height: 19px;
	width:100px;
	margin:2px 0px 0px 0px;
	background-color: transparent;
	cursor:hand;
	vertical-align: bottom;

}

input.directory_location {
	border: 0px solid purple;
	height: 19px;
	width: 300px;
	margin:3px 0px 0px 0px;
	vertical-align: bottom;
	horizontal-align: right;
	margin-left: 4px;
	background-color: transparent;
}
/* green color 1-3 */
tr.column_name_select_user {
	background-color: rgb(49, 97, 24);
	color: rgb(255, 255, 255);
	font-weight: bold;

}

table.edit_user {
	border-collapse:collapse;
}

/* green color 3-3 */
tr.edit_user {
	/*background-color: rgb(198, 219, 156);*/
	background-color: rgb(239, 255, 214);
}


/* l = left
   r = right
   t = top
   b = bottom */

td.border_ltb {
	padding-left: 3px;
	border-left:   1px solid black;
	border-top:    1px solid black;
	border-bottom: 1px solid black;
}

td.border_lrtb {
	padding-left: 3px;
	border-left:   1px solid black;
	border-right:  1px solid black;
	border-top:    1px solid black;
	border-bottom: 1px solid black;
}

td.border_rtb {
	border-right:  1px solid black;
	border-top:    1px solid black;
	border-bottom: 1px solid black;
}

td.border_r {
	border-right:  1px solid black;
}

td.border_rb {
	border-right:  1px solid black;
	border-bottom: 1px solid black;
}

td.border_l {
	padding-left: 3px;
	border-left:   1px solid black;
}

td.border_lr {
	padding-left: 3px;
	border-left:   1px solid black;
	border-right:  1px solid black;
}

img.icon {
	width: 16px;
	height: 16px;
	border-style: none;
	border-width: 0px;
	vertical-align: center;
	margin-left: 2px;
}

table.header {
	border-collapse:collapse;
	background-repeat: repeat-x;
	background-position: left top;
	background-image: url(<?=$LocationImages?>/header.png);
}

td.header-left, td.header-right {
	background-image: url(<?=$LocationImages?>/header_seperator.png);
	background-repeat: no-repeat;
	background-position: right top;

}

td.header-left {
	padding-left: 1px;
	text-align: left;
}

td.header-right {
	text-align: right;
	padding-right: 4px;
}

input.description {
	font-size: 11px;
	background-color: transparent;
	cursor:hand;
	border: 0px solid purple;
	height: 17px;
	vertical-align: bottom;
}

td.left, td.right {
	vertical-align: bottom;
	background-image: url(<?=$LocationImages?>/header_seperator2.png);
	background-repeat: no-repeat;
	background-position: right top;
	border-top:     #ffffff 1px solid;
	border-left:    #ffffff 1px solid;
	border-bottom:  #cccccc 1px solid;
}

td.left {
	text-align: left bottom;
	padding: 0px;
	padding-left: 1px;
	font-size: 12px;
}

td.right {
	text-align: right;
	padding-right: 4px;
	font-size: 12px;
}

td.last {
	text-align: left bottom;
	vertical-align: bottom;
	background-repeat: no-repeat;
	background-position: right top;
	border-top:     #ffffff 1px solid;
	border-left:    #ffffff 1px solid;
	border-bottom:  #cccccc 1px solid;
}