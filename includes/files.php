<?php
/* User manager for PureFTPd is made by M.Mastenbroek 2002 - 2017, dnsb 2022
 *  For more info look at http://machiel.generaal.net
 *  Version 2.5
 */

require('constants.php');

class directory_element {

	var $Name;
	var $Path;
	var $Icon;
	var $Size;
	var $Owner;
	var $Group;
	var $Permission;
	var $Modify;
	var $Access;

	var $Type;
	var $Extension;
	var $Description;

	// constructor
	function directory_element($dePath, $deName) {

		global $Extensions, $Icons;

		if (!is_string($dePath) ||
				!is_string($deName) ||
				!file_exists($dePath.$deName)) {
			return false;
		}

		$this->Path = $dePath.$deName;
		$this->Name = $deName;
		// $this->Size = filesize($this->Path);
		$this->Size = sprintf("%u", filesize($this->Path));
		$this->Owner = $this->GetFileOwner($this->Path);
		$this->Group = $this->GetFileGroup($this->Path);
		$this->Permission = fileperms($this->Path);
		$this->Modify = filemtime($this->Path);
		$this->Access = fileatime($this->Path);

		// $this->Type options are: FILE, DIRECTORYREFRESH, DIRECTORYUP, DIRECTORY
		if (!is_dir($this->Path)) {
			$this->Type = 'FILE';
		} elseif ($this->Name == '.') {
			$this->Type = 'DIRECTORYREFRESH';
			$this->Path = dirname($this->Path);
		} elseif ($this->Name == '..') {
			$this->Type = 'DIRECTORYUP';
			$this->Path = dirname($this->Path, 2);
		} else {
			$this->Type = 'DIRECTORY';
		}

		// $this->Extension = preg_split('\.',$this->Name);
		$this->Extension = preg_split('/[.]/', $this->Name);
		$this->Extension = strtolower((count($this->Extension) > 1 ? array_pop($this->Extension) : ''));

		if ($this->Type == 'DIRECTORYREFRESH') {
			$this->Extension = '.';
		} elseif ($this->Type == 'DIRECTORYUP') {
			$this->Extension = '..';
		} elseif (strlen($this->Name) - 1 == strlen($this->Extension)) {
			// A hidden file without an extension
			$this->Extension = '';
		} elseif ($this->Type == 'DIRECTORY') {
			$this->Extension = 'DIRECTORY';
		}

		if (array_key_exists($this->Extension, $Icons)) {
			$this->Icon = $Icons[$this->Extension];
		} else {
			$this->Icon = $Icons['BLANKICON'];
		}

		if ($this->Type == 'DIRECTORYREFRESH' ||
				$this->Type == 'DIRECTORYUP') {
			$this->Description = '';
		} elseif (array_key_exists($this->Extension, $Extensions)) {
			$this->Description = $Extensions[$this->Extension];
		} elseif (isset($Entry['Extension']) && $Entry['Extension'] != '') {
			$this->Description = strtoupper($Entry['Extension'])." "."File";
		} elseif (isset($Filename['Type']) && $Filename['Type'] == 'FT_FILE') {
			$this->Description = ucfirst("File");
		} else {
			$this->Description = "File";
		}

		$this->Name = preg_replace('/&[^amp;]/', '&amp;', $this->Name);
		return true;
	}

	function GetElement() {
		return $this;
	}

	function Name() {
		return $this->Name;
	}

	function Path() {
		return $this->Path;
	}

	function Size($convert) {
		if ($convert == 0) // no
			return $this->Size;
		else
			return $this->DisplayFileSize($this->Size);
	}

	function Type() {
		return $this->Type;
	}

	function Extension() {
		return $this->Extension;
	}

	function Description() {
		return $this->Description;
	}

	function Owner() {
		return $this->Owner;
	}

	function Group() {
		return $this->Group;
	}

	function Permission($convert) {
		if ($convert == 0) // no
			return $this->Permission;
		else // yes
			return $this->DisplayFilePermissions($this->Permission);
	}

	function Modify($convert) {
		if ($convert == 0) // no
			return $this->Modify;
		elseif ($convert == 1)
			return date('d-m-Y H:i', $this->Modify);
		else
			return date('d-m-Y', $this->Modify);
	}

	function Access() {
		return $this->Access;
	}

	function Icon() {
		return $this->Icon;
	}

	function GetFileOwner($File) {
		$File = posix_getpwuid(fileowner($File));
		return $File['name'];
	}

	function GetFileGroup($File) {
		$File = posix_getgrgid(filegroup($File));
		return $File['name'];
	}

	function DisplayFilePermissions($Mode) {
		// Determine Type
		if ($Mode & 0x1000) {
			$Type = 'p';  // FIFO pipe
		} elseif ($Mode & 0x2000) {
			$Type = 'c';  // Character special
		} elseif ($Mode & 0x4000) {
			$Type = 'd';  // Directory
		} elseif ($Mode & 0x6000) {
			$Type = 'b';  // Block special
		} elseif ($Mode & 0x8000) {
			$Type = '-';  // Regular
		} elseif ($Mode & 0xA000) {
			$Type = 'l';  // Symbolic Link
		} elseif ($Mode & 0xC000) {
			$Type = 's';  // Socket
		} else {
			$Type = 'u';  // UNKNOWN
		}

		// Determine permissions
		$Owner['read'] = ($Mode & 00400) ? 'r' : '-';
		$Owner['write'] = ($Mode & 00200) ? 'w' : '-';
		$Owner['execute'] = ($Mode & 00100) ? 'x' : '-';
		$Group['read'] = ($Mode & 00040) ? 'r' : '-';
		$Group['write'] = ($Mode & 00020) ? 'w' : '-';
		$Group['execute'] = ($Mode & 00010) ? 'x' : '-';
		$World['read'] = ($Mode & 00004) ? 'r' : '-';
		$World['write'] = ($Mode & 00002) ? 'w' : '-';
		$World['execute'] = ($Mode & 00001) ? 'x' : '-';

		// Adjust for SUID, SGID and sticky bit
		if ($Mode & 0x800) $Owner['execute'] = ($Owner['execute'] == 'x') ? 's' : 'S';
		if ($Mode & 0x400) $Group['execute'] = ($Group['execute'] == 'x') ? 's' : 'S';
		if ($Mode & 0x200) $World['execute'] = ($World['execute'] == 'x') ? 't' : 'T';

		return
				$Type
				.$Owner['read'].$Owner['write'].$Owner['execute']
				.$Group['read'].$Group['write'].$Group['execute']
				.$World['read'].$World['write'].$World['execute'];
	}

	function DisplayFileSize($filesize) {
		$array = array(
				'YB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
				'ZB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
				'EB' => 1024 * 1024 * 1024 * 1024 * 1024 * 1024,
				'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
				'TB' => 1024 * 1024 * 1024 * 1024,
				'GB' => 1024 * 1024 * 1024,
				'MB' => 1024 * 1024,
				'KB' => 1024,
		);
		if ($filesize <= 1024) {
			$filesize = $filesize.' B';
		}
		foreach ($array as $name => $size) {
			if ($filesize > $size || $filesize == $size) {
				$filesize = round((round($filesize / $size * 100) / 100), 0).' '.$name;
			}
		}
		return $filesize;
	}
}

class directorylist {

	// $this->Type options are: FILE, DIRECTORYREFRESH, DIRECTORYUP, DIRECTORY

	var $directoryup;
	var $directoryrefresh;
	var $directorylist = array();
	var $directorylistsize;
	var $filelist = array();
	var $filelistsize;
	var $error;

	// constructor
	function directorylist($Directory) {

		$this->directorylistsize = 0;
		$this->filelistsize = 0;
		$this->error = "";

		if (substr($Directory, -1) != "/" &&
				$Directory != "/")
			$Directory = $Directory."/";

		while (($Dir = @dir($Directory)) == false) {
			// echo ("<font color='blue'>Warning:</font> Can't open directory $Directory<br>\n");
			$this->error = $this->error."Can't open directory $Directory ";
			// Try to get the oupper directory
			$Directory = dirname($Directory)."/";

			//echo ("Directory = $Directory<br>\n");
			//	$Dir = @dir($Directory);

			if ($Directory == "/" || $Directory == "//") {
				// echo ("<font color='red'>Error:</font> Can't open directory $Directory<br>\n");
				$this->error = $this->error."Can't open directory $Directory ";
				return false;
			}
		}

		// echo ("<b>Directory = $Directory</b><br>\n");

		while ($Filename = $Dir->read()) {

			$directory_element = new directory_element($Directory, $Filename);

			//	echo ("[".$directory_element->Name()."] directory_element->Type() = ".$directory_element->Type()."<br>\n");
			if ($directory_element->Type() == 'DIRECTORYREFRESH') {
				$this->directoryrefresh = $directory_element;
			} elseif ($directory_element->Type() == 'DIRECTORYUP') {
				$this->directoryup = $directory_element;
			} elseif ($directory_element->Type() == 'FILE') {
				$this->filelist[] = $directory_element;
				$this->filelistsize++;
			} else {
				$this->directorylist[] = $directory_element;
				$this->directorylistsize++;
			}
		}

		$Dir->close();

		$this->order("Name", "Asc");

		return true;
	}

	function directory_element($deNumber) {

		//echo ("Waarde van \$deNumber = $deNumber<br>\n");

		if ($deNumber == 0) {
			return $this->directoryrefresh;
		} elseif ($deNumber == 1) {
			return $this->directoryup;
		} elseif ($deNumber < ($this->directorylistsize + 2)) {
			//	echo ("directorylist[".($deNumber - 2)."]<br>\n");
			return $this->directorylist[$deNumber - 2];
		} elseif ($deNumber < ($this->directorylistsize + 2 + $this->filelistsize)) {
			//	echo ("filelist [".($deNumber - 2 - $this->directorylistsize)."]<br>\n");
			return $this->filelist[$deNumber - 2 - $this->directorylistsize];
		} else {
			echo("<font color='red'>[directorylist::directory_element] Error:</font> Size of \$deNumber is to large<br>\n");
			return false;
		}
	}

	function nrof_elements() {

		// directoryrefresh + directoryup + directorylist + filelist
		return 1 + 1 + $this->directorylistsize + $this->filelistsize;
	}

	function order($value, $orderstr) {

		$order = (strtolower($orderstr)!='desc');
		$lvalue = strtolower($value);

		// echo ("\$order = $order<br>\n");
		if ($lvalue=='size') {
			$this->sortlist($this->directorylist, "name", $order);
			$this->sortlist($this->filelist, "size", $order);
		} else { 	// name, owner, group, modify
			$this->sortlist($this->directorylist, $lvalue, $order);
			$this->sortlist($this->filelist, $lvalue, $order);
		}

	}

	function sortlist(&$FileArray, $key, $order) {
		switch ($key) {
			case 'size':
				uasort($FileArray, 'filesort_size_cmp' );
				break;
			case 'owner':
				uasort($FileArray, 'filesort_owner_cmp' );
				break;
			case 'group':
				uasort($FileArray, 'filesort_group_cmp' );
				break;
			case 'modify':
				uasort($FileArray, 'filesort_modify_cmp' );
				break;
			default:  // name
				uasort($FileArray, 'filesort_name_cmp' );
				break;
		}
		if (!$order) {
			$FileArray = array_reverse($FileArray);
		}
		$FileArray = array_values($FileArray);
	}

}

function filesort_name_cmp($a, $b) {
	return strcasecmp($a->Name(), $b->Name());
}

function filesort_size_cmp($a, $b) {
	return $a->Size(0) - $b->Size(0);
}

function filesort_owner_cmp($a, $b) {
	return strcasecmp($a->Owner(), $b->Owner());
}

function filesort_group_cmp($a, $b) {
	return strcasecmp($a->Group(), $b->Group());
}

function filesort_modify_cmp($a, $b) {
	return $a->Modify(0) - $b->Modify(0);
}
