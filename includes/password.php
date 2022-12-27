<?php
/* 'User manager for PureFTPd' is made by M.Mastenbroek 2002 - 2017, dnsb 2022
 *  For more info look at http://machiel.generaal.net
 *  Version 2.5
 */

function hash_password($type, $password) {
	switch ($type) {
		case 'cleartext':
			$hash = $password;
			break;
		case 'md5':
			$hash = md5($password);
			break;
		case 'bcrypt':
			$hash = password_hash($password, PASSWORD_BCRYPT);
			break;
		case 'sha255-crypt':
			$randomString = random_bytes(32);
			$salt = base64_encode($randomString);
			$hash = crypt($password, '$5$'.$salt);
			break;
		case 'sha512-crypt':
			$randomString = random_bytes(32);
			$salt = base64_encode($randomString);
			$hash = crypt($password, '$6$'.$salt);
			break;
		default:
			$hash = $password;
	}
	return $hash;
}