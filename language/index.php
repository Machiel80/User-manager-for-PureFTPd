<?php

	/* 'User manager for PureFTPd' is made by M.Mastenbroek 2002 - 2017
	 *  For more info look at http://machiel.generaal.net
	 *  Version 2.2
	 *
	 *
	 *  I can only speak my natural language (Dutch) and a little bit English, so if people
	 *  use my script and have the time, knowledge and the spitted to add a language
	 *  feel yourself free. I think the syntax speaks for itself. If you added a language or you have
	 *  questions about it, you can contact me at machiel.mastenbroek@gmail.com, if
	 *  that doesn’t work check my website how to contact me.
	 */

	$LFile = strtolower($LANG).".php";

	/* If the language doesn't exist we use the 'default' language english */
	if (!file_exists("language/".$LFile))
	{
		$LFile = "english.php";
	}

	/* Read the language file */
	require("language/".$LFile);

?>
