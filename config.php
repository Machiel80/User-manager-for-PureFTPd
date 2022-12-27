<?php
/* 'User manager for PureFTPd' is made by M.Mastenbroek 2002 - 2017, dnsb 2022
 *  For more info look at http://machiel.generaal.net
 *  Version 2.5
 */

$LANG = "english";                  // See the directory language for the available languages.

$DBHost = "127.0.0.1";              // Ip-address of MySQL server
// (Don't change this if you are using the default database)

$DBLogin = "ftp";                   // Username of MySQL user

$DBPassword = "tmppasswd";          // Password of MySQL user

$DBDatabase = "ftpusers";           // Name of database

$FTPAddress = "10.10.128.172:21";   // Domain name or ip-address of your ftp server

$FTPPasswordEncryption = "bcrypt";	// cleartext, md5, bcrypt, sha255-crypt, sha512-crypt

$DEFUserID = "65534"; // nobody     // Default user id of virtual ftp user.

$DEFGroupID = "31";   // guest      // Default group is of virtual ftp user.

$UsersFile = "/etc/passwd";        // The unix user file

$GroupFile = "/etc/group";         // The unix group file

$StyleSheet = "style/default.css"; // The location of the style sheet

$EnableQuota = 1;                  // Enable virtual quota's (0=Off 1=On)

$EnableRatio = 0;                  // Enable ratio (0=Off 1=On)
// The pureftpd server has to be compiled with ratio support.

/* This list of users will NOT appear in the dropdown menu. */
$BlacklistUsers = array('adm', 'bin', 'bind', 'daemon', 'gopher', 'halt', 'kmem', 'lp',
		'mailnull', 'man', 'named', 'nfsnobody', 'nscd', 'operator',
		'pop', 'root', 'rpc', 'rpcuser', 'rpm', 'shutdown', 'smmsp',
		'sshd', 'sync', 'toor', 'tty', 'uucp', 'vcsa', 'xfs');

/* This list of groups will NOT appear in the dropdown menu. */
$BlacklistGroups = array('adm', 'bin', 'bind', 'daemon', 'dialer', 'dip', 'disk', 'floppy', 'gopher', 'kmem',
		'lock', 'lp', 'mailnull', 'man', 'named', 'mem', 'network', 'news',
		'nscd', 'ntp', 'operator', 'pcap', 'root', 'rpc', 'rpcuser', 'rpm', 'slocate', 'smmsp',
		'sshd', 'staff', 'sys', 'tty', 'utmp', 'uucp', 'vcsa', 'wheel', 'xfs');
