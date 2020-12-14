<?php
define('ARRAY_KEY_FC_LOWERCASE', 25); //FOO => fOO
define('ARRAY_KEY_FC_UPPERCASE', 20); //foo => Foo
define('ARRAY_KEY_UPPERCASE', 15); //foo => FOO
define('ARRAY_KEY_LOWERCASE', 10); //FOO => foo
define('ARRAY_KEY_USE_MULTIBYTE', true); //use mutlibyte functions
/**
 * Function for Input Filtering from POST, GET, or Ordinary Variable
 * @param type $datatype
 * 0 : Ordinary Variable
 * 1 : Input POST Single Data
 * 2 : Input GET Single Data
 * 3 : Input REQUEST Single Data
 * @param type $var
 * @param type $varfilter
 * FILTER_DEFAULT
 * FILTER_SANITIZE_STRING
 * FILTER_SANITIZE_URL
 * FILTER_SANITIZE_EMAIL
 */
function filterinput($datatype, $var='', $varfilter = FILTER_SANITIZE_STRING) {
	switch ($datatype) {
		case 1:
			$retvar	 = stripslashes(trim(filter_var(filter_input(INPUT_POST, $var,
							$varfilter))));
			break;
		case 2:
			$retvar	 = stripslashes(trim(filter_var(filter_input(INPUT_GET, $var,
							$varfilter))));
			break;
		case 3:
			$retvar	 = stripslashes(trim(filter_var(filter_input(INPUT_REQUEST, $var,
							$varfilter))));
			break;
    case 4:
      $retvars = $_POST[$var];
      $retvar = array();
      foreach ($retvars as $i) {
        $s = filter_var($i, $varfilter);
        array_push($retvar, $s);
      }
      break;
		default:
			$retvar	 = stripslashes(trim(filter_var($var, $varfilter)));
			break;
	}
	return $retvar;
}
/**
 * Function for Cryptography with Random Hexdec, Bin2hex and Open SSL Random
 * @param type $min
 * @param type $max
 * @return type
 */
function crypto_rand_secure($min, $max) {
	$range	 = $max - $min;
  if ($range < 1) { return $min; } // not so random...
	$log		 = ceil(log($range, 2));
	$bytes	 = (int) ($log / 8) + 1; // length in bytes
	$bits		 = (int) $log + 1; // length in bits
	$filter	 = (int) (1 << $bits) - 1; // set all lower bits to 1
	do {
		$rnd = (hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)))) & $filter;
	} while ($rnd > $range);
	return $min + $rnd;
}
/**
 * Function for Generate Token
 * @param type $length
 * @return string
 */
function getToken($length) {
	$token				 = "";
	$codeAlphabet	 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$codeAlphabet	 .= "abcdefghijklmnopqrstuvwxyz";
	$codeAlphabet	 .= "0123456789";
	$max					 = strlen($codeAlphabet);
	for ($i = 0; $i < $length; $i++) {
		$token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
	}
	return $token;
}
/**
 * Function for Generate Token with Checking from Database
 * @param type $length
 * @return type
 */
function getTokenDB($length) {
	$token = getToken($length);
	$sql	 = "select ifnull(count(1),0)
		from useraccess
		where authkey = '".$token."'";
	$data	 = Yii::app()->db->createCommand($sql)->queryScalar();
	if ($data > 0) {
		getTokenDB($length);
	} else {
		return $token;
	}
}
/**
 * Function for Change Character Case Oracle Database
 * @param array $array
 * @param type $case
 * @param type $useMB
 * @param type $mbEnc
 * @return array
 */
function array_change_key_case_ext(array $array, $case = 10, $useMB = false,
																	 $mbEnc = 'UTF-8') {
	$newArray = array();
	if ($useMB === false) {
		$function = 'strToUpper'; //default
		switch ($case) {
			case 25:
				if (!function_exists('lcfirst')) {
					$function = create_function('$input',
						'
							return strToLower($input[0]) . substr($input, 1, (strLen($input) - 1));
					');
				} else {
					$function = 'lcfirst';
				}
				break;
			case 20:
				$function	 = 'ucfirst';
				break;
			case 10:
				$function	 = 'strToLower';
		}
	} else {
		switch ($case) {
			case 25:
				$function	 = create_function('$input',
					'
						return mb_strToLower(mb_substr($input, 0, 1, \''.$mbEnc.'\')) . 
								mb_substr($input, 1, (mb_strlen($input, \''.$mbEnc.'\') - 1), \''.$mbEnc.'\');
				');
				break;
			case 20:
				$function	 = create_function('$input',
					'
						return mb_strToUpper(mb_substr($input, 0, 1, \''.$mbEnc.'\')) . 
								mb_substr($input, 1, (mb_strlen($input, \''.$mbEnc.'\') - 1), \''.$mbEnc.'\');
				');
				break;
			case 15:
				$function	 = create_function('$input',
					'
						return mb_strToUpper($input, \''.$mbEnc.'\');
				');
				break;
			default: //case 10:
				$function	 = create_function('$input',
					'
						return mb_strToLower($input, \''.$mbEnc.'\');
				');
		}
	}

	foreach ($array as $key => $value) {
		if (is_array($value)) { //$value is an array, handle keys too
				$newArray[$function($key)] = array_change_key_case_ext($value, $case, $useMB);
    }
    elseif (is_string($key)) { $newArray[$function($key)] = $value; }
    else { $newArray[$key] = $value; } //$key is not a string
	}
	return $newArray;
}
/**
 * Function for Displaying SEO
 * @param type $metatag
 * @param type $description
 */
function display_seo($metatag, $description, $pageTitle) {
  $description = truncateword(getparameter('sitetitle').' '.$pageTitle,100);
  echo '<meta charset="utf-8">'."\n";
  echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'."\n";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">'."\n";
	echo '<meta name="description" content="'.$description.'">'."\n";
	echo '<meta name="generator" content="Capella CMS 1.0.0">';
	echo '<title>'.getparameter('sitetitle').' - '.$pageTitle.'</title>'."\n";
	echo '<meta property="og:site_name" content="'.getparameter('sitename').'">'."\n";
	echo '<meta property="og:description" content="'.$description.'">'."\n";
	if (is_array($metatag)) {
		$s = count($metatag);
		if ($s > 0) {
			foreach ($metatag as $meta) {
				echo '<meta property="article:tag" content="'.$meta.'">'."\n";
			}
		}
	}
}
/**
 * Function for Truncating Word with Length
 * @param type $text
 * @param type $length
 * @param type $ending
 * @param type $exact
 * @param type $considerHtml
 * @return string
 */
function truncateword($text, $length, $ending = "...", $exact = false,
											$considerHtml = true) {
	if ($considerHtml) {
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
    $lines = '';
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length	 = strlen($ending);
		$open_tags		 = array();
		$truncate			 = '';
    $tag_matchings = '';
    $entities = '';
		foreach ($lines as $line_matchings) {
			if (!empty($line_matchings[1])) {
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is',
						$line_matchings[1])) {
					
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1],
						$tag_matchings)) {
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
						unset($open_tags[$pos]);
					}
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1],
						$tag_matchings)) {
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				$truncate .= $line_matchings[1];
			}
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i',
					' ', $line_matchings[2]));
			if ($total_length + $content_length > $length) {
				$left						 = $length - $total_length;
				$entities_length = 0;
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i',
						$line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					foreach ($entities[0] as $entity) {
						if ($entity[1] + 1 - $entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left + $entities_length);
				break;
			} else {
				$truncate			 .= $line_matchings[2];
				$total_length	 += $content_length;
			}
			if ($total_length >= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	if (!$exact) {
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	$truncate .= $ending;
	if ($considerHtml) {
		foreach ($open_tags as $tag) {
			$truncate .= '</'.$tag.'>';
		}
	}
	return $truncate;
}
/**
 *
 * @param type $htmlStr
 * @return type
 */
function parseToXML($htmlStr) {
	$xmlStr	 = str_replace("&", '&amp;',str_replace("'", '&#39;',str_replace('"', '&quot;', str_replace('>', '&gt;', str_replace('<', '&lt;', $htmlStr)))));
	return $xmlStr;
}
/**
 * Function for change from number to character in Indonesian format
 * @param type $value
 * @return type
 */
function eja($value) {
	$number				 = str_replace(',', '', $value);
	$before_comma	 = trim(to_word($number));
	$after_comma	 = trim(comma($number));
	$results			 = str_replace('koma nol', '',str_replace('nol nol', '',str_replace('nol nol nol', '',str_replace('nol nol nol', '',str_replace('nol nol nol nol nol', '',str_replace('nol nol nol nol nol', '', $before_comma.$after_comma))))));
	return ucwords($results);
}
/**
 * 
 * @param type $number
 * @return string
 */
function to_word($number) {
	$words			 = '';
	$arr_number	 = array(
		'',
		'satu',
		'dua',
		'tiga',
		'empat',
		'lima',
		'enam',
		'tujuh',
		'delapan',
		'sembilan',
		'sepuluh',
		'sebelas'
	);
	switch (true) {
		case ($number == 0) :
			$words = ' ';
			break;
		case (($number > 0) && ($number < 12)) :
			$words = ' '.$arr_number[$number];
			break;
		case ($number < 20) :
			$words = to_word($number - 10).' belas';
			break;
		case ($number < 100) :
			$words = to_word($number / 10).' puluh '.to_word($number % 10);
			break;
		case ($number < 200) :
			$words = 'seratus '.to_word($number - 100);
			break;
		case ($number < 1000) :
			$words = to_word($number / 100).' ratus '.to_word($number % 100);
			break;
		case ($number < 2000) :
			$words = 'seribu '.to_word($number - 1000);
			break;
		case ($number < 1000000) :
			$words = to_word($number / 1000).' ribu '.to_word($number % 1000);
			break;
		case ($number < 1000000000) :
			$words = to_word($number / 1000000).' juta '.to_word($number % 1000000);
			break;
		case ($number < 1000000000000) :
			$words = to_word($number / 1000000000).' milyar '.to_word($number % 1000000000);
			break;
		case ($number < 1000000000000000) :
			$words = to_word($number / 1000000000000).' trilyun '.to_word($number % 1000000000000);
			break;
		case ($number < 1000000000000000000) :
			$words = to_word($number / 1000000000000000).' bilyun '.to_word($number % 1000000000000000);
			break;
		default :
			$words = 'undefined';
	}
	return $words;
}
/**
 * 
 * @param type $number
 * @return string
 */
function comma($number) {
	$after_comma = stristr($number, '.');
	$results		 = ' ';
	if ($after_comma == true) {
		$results		 = ' koma ';
		$arr_number	 = array(
			'nol',
			'satu',
			'dua',
			'tiga',
			'empat',
			'lima',
			'enam',
			'tujuh',
			'delapan',
			'sembilan'
		);
		$length			 = strlen($after_comma);
		$i					 = 1;
		while ($i < $length) {
			$get		 = substr($after_comma, $i, 1);
			$results .= ' '.$arr_number[$get];
			$i++;
		}
	}
	return $results;
}
/**
 * Function for Convert from Boolean to String with default value
 * @param type $id
 * @return string
 */
function booltostr($id) {
	if ($id == false) {
		return 'false';
	} else
	if ($id == true) {
		return 'true';
	}
}
/**
 * Function for Convert from Integer to Boolean with default value
 * @param type $id
 * @return boolean
 */
function inttobool($id) {
	if ($id === 0) {
		return false;
	} else
	if ($id === 1) {
		return true;
	}
}
/**
 * Function for Convert from Integer to String with default value
 * @param type $id
 * @return string
 */
function inttostr($id) {
	if ($id == 0) {
		return 'Not Active';
	} else
	if ($id == 1) {
		return 'Active';
	}
}
/**
 * 
 * @param type $id
 * @return int
 */
function strtoint($id) {
	if (strtolower($id) == "active") {
		return 1;
	} else
	if (strtolower($id) == "not active") {
		return 0;
	}
}
/**
 * 
 * @param type $id
 * @return int
 */
function booltoint($id) {
	if ($id === false) {
		return 0;
	} else if ($id === true) {
		return 1;
	}
}
/**
 * 
 * @param type $quecommand
 * @param type $value
 * @return string
 */
function TranslateQuery($quecommand, $value) {
	$ret = '';
	switch ($quecommand) {
		case 'limit' :
			switch (Yii::app()->db->driverName) {
				case 'oci' :
					$ret = ' and rownum = '.$value;
					break;
				default :
					$ret = ' limit '.$value;
			}
			break;
	}
	return $ret;
}
/**
 *
 * @param type $datavalidate
 * @return boolean
 */
function ValidateData($datavalidate) {
	$error = false;
	foreach ($datavalidate as $x) {
		switch ($x[1]) {
			case 'email':
				$data	 = filterinput(1, $x[0], FILTER_SANITIZE_EMAIL);
				break;
			case 'integer':
				$data	 = filterinput(1, $x[0], FILTER_SANITIZE_NUMBER_INT);
				break;
			default:
				$data	 = filterinput(1, $x[0], FILTER_SANITIZE_STRING);
				break;
		}
		if (($data === false) || ($data === null)) {
			$error = true;
			GetMessage('error', $x[2]);
		}
	}
	return $error;
}
/**
 * 
 * @param type $FilePath
 * @param type $OldText
 * @param type $NewText
 * @return string
 */
function replace_in_file($FilePath, $OldText, $NewText) {
	$Result = array('isError' => true, 'message' => '');
	if (file_exists($FilePath) === TRUE) {
		if (is_writeable($FilePath)) {
			try {
				$FileContent = str_replace($OldText, $NewText, file_get_contents($FilePath));
				if (file_put_contents($FilePath, $FileContent) > 0) {
					$Result['isError'] = false;
				} else {
					$Result['message'] = 'Error while writing file';
				}
			} catch (Exception $e) {
				$Result['message'] = 'Error : '.$e;
			}
		} else {
			$Result['message'] = 'File '.$FilePath.' is not writable !';
		}
	} else {
		$Result['message'] = 'File '.$FilePath.' does not exist !';
	}
	return $Result;
}
/**
 * Function for Select Data with some parameter and securing parameter
 * @param type $selecttype
 * @param type $datatype
 * @param type $params
 * @param type $sqlinsert
 * @return type
 */
function SelectCommand($selecttype, $datatype, $params, $sqlinsert) {
	$connection	 = Yii::app()->db;
	$data				 = null;
	try {
		$command = $connection->createCommand($sqlinsert);
		foreach ($params as $data) {
			$command->bindvalue($data[0],
				filterinput($datatype, $data[1], FILTER_SANITIZE_STRING), $data[2]);
		}
		switch ($selecttype) {
			case 1:
				$data	 = $command->queryRow();
				break;
			case 1:
				$data	 = $command->queryAll();
				break;
			default:
				$data	 = $command->queryScalar();
				break;
		}
		return $data;
	} catch (Exception $ex) {
		GetMessage('error', $ex->getMessage());
	}
}
/**
 * Function for Insert, Update, Delete with parameter and securing it
 * @param type $datatype
 * 0 : Ordinary Variable
 * 1 : POST Variable
 * 2 : GET Variable
 * @param type $menuname
 * Menu Name
 * @param type $pk
 * Primary Key of Table
 * @param type $params
 * Parameters of Insert or Update
 * @param type $sqlinsert
 * Query for Insert
 * @param type $sqlupdate
 * Query for Update
 */
function ModifyCommand($datatype, $menuname, $pk, $params, $sqlinsert = '',
											 $sqlupdate = '', $isLog = true) {
	$connection	 = Yii::app()->db;
	$transaction = $connection->beginTransaction();
	try {
		$id			 = filterinput($datatype, $pk, FILTER_SANITIZE_NUMBER_INT);
		$sql		 = (($id !== '') ? (($sqlupdate !== '') ? $sqlupdate : $sqlinsert) : $sqlinsert);
		$command = $connection->createCommand($sql);
		(($id !== '') ? $command->bindvalue($params[0][0], $id, $params[0][2]) : null);
		$i			 = 0;
		foreach ($params as $data) {
			if ($i > 0) {
				if ($data[1] !== 'vcreatedby') {
					$cmd = ((filterinput(1, $data[1]) !== '') ? filterinput(1,
							$data[1]) : null);
				} else {
					$cmd = Yii::app()->user->id;
				}
				$command->bindvalue($data[0], $cmd, $data[2]);
			}
			$i++;
		}
		$command->execute();
		$transaction->commit();
		if ($isLog == true) {
			Inserttranslog($command, $id, $menuname);
		}
		getmessage('success', 'alreadysaved');
	} catch (Exception $ex) {
		$transaction->rollback();
		getmessage('error', $ex->getMessage());
	}
}
/**
 *
 * @return type
 */
function getCompany() {
	$username = filter_input(INPUT_POST, 'username');
	if (($username == '') || ($username == null)) {
		$username = Yii::app()->user->name;
	}
	$company = Yii::app()->db->createCommand(
			"select companyid,companyname
			from company a
			where companyid in
			(
				select gm.menuvalueid from groupaccess c
				inner join usergroup d on d.groupaccessid = c.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				inner join groupmenuauth gm on gm.groupaccessid = c.groupaccessid
				inner join menuauth ma on ma.menuauthid = gm.menuauthid
				where upper(e.username)=upper('".$username."')
					and upper(ma.menuobject) = upper('company')
			)
			limit 1
			")->queryRow();
	return $company;
}
/**
 * 
 * @param type $isadmin
 */
function getTheme($isadmin = false, $module = '') {
	$theme = Yii::app()->theme;
	if ($isadmin === false) {
		if ($module !== '') {
			$dependency				 = new CDbCacheDependency("select count(moduleid) from modules a
					inner join theme b on b.themeid = a.themeid
					where modulename = '".$module."'");
			$theme						 = Yii::app()->db->cache(1000, $dependency)->createCommand(
					"select themename
					from modules a
					inner join theme b on b.themeid = a.themeid
					where modulename = '".$module."'")->queryRow();
			Yii::app()->theme	 = $theme['themename'];
		} else {
			Yii::app()->theme = $theme;
		}
	} else {
		$dependency				 = new CDbCacheDependency("select count(moduleid) from modules a
					inner join theme b on b.themeid = a.themeid
					where modulename = '".$module."'");
		$theme						 = Yii::app()->db->cache(1000, $dependency)->createCommand(
				"select themename
				from modules a
				inner join theme b on b.themeid = a.themeid
				where modulename = 'admin'")->queryRow();
		Yii::app()->theme	 = $theme['themename'];
	}
}
/**
 *
 * @param type $menuname
 * @return type
 */
function getMenuModule($menuname = 'null') {
	$sql = "select a.modulename
			from modules a
			join menuaccess b on b.moduleid = a.moduleid
			where b.menuname = '".$menuname."'";
	return Yii::app()->db->createCommand($sql)->queryScalar().'/'.$menuname;
}
/**
 * 
 * @return type
 */
function getMyID() {
	$id = Yii::app()->db->createCommand("select useraccessid 
		from useraccess
		where username = '".Yii::app()->user->id."'")->queryRow();
	return $id['useraccessid'];
}
/**
 * 
 * @param type $dir
 */
function rrmdir($dir) {
	CFileHelper::removeDirectory($dir);
}
/**
 * 
 * @return type
 */
function getInboxLimit() {
	$dependency	 = new CDbCacheDependency("select count(userinboxid) from userinbox a
			inner join useraccess b on b.useraccessid = a.useraccessid
			inner join useraccess c on c.useraccessid = a.fromuserid
			where b.username = '".Yii::app()->user->id."'");
	$sql				 = "select b.username,c.username as fromusername,a.description,a.senddate,a.recordstatus
			from userinbox a
			inner join useraccess b on b.useraccessid = a.useraccessid
			inner join useraccess c on c.useraccessid = a.fromuserid
			where b.username = '".Yii::app()->user->id."'
			limit 5 ";
	return Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
}
/**
 *
 * @return string
 */
function getUserGroups() {
	$sql	 = "select c.groupname
			from useraccess a
			join usergroup b on b.useraccessid = a.useraccessid
			join groupaccess c on c.groupaccessid = b.groupaccessid
			where username = '".Yii::app()->user->id."'";
	$rows	 = Yii::app()->db->createCommand($sql)->queryAll();
	$grups = '';
	foreach ($rows as $row) {
		$grups .= $row['groupname'].',';
	}
	return $grups;
}
/**
 * 
 * @return type
 */
function getUserData() {
	$sql = "select email,phoneno,realname,userphoto
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			where username = '".Yii::app()->user->id."'";
	$row = Yii::app()->db->createCommand($sql)->queryRow();
	return $row;
}
/**
 * 
 * @return type
 */
function getUserAllMenu($username = '') {
	if ($username == '') {
		$username = Yii::app()->user->id;
	}
	$dependency	 = new CDbCacheDependency("SELECT count(d.menuaccessid)
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where c.isread = 1 and username = '".$username."'
			order by d.sortorder asc");
	$sql				 = "select distinct d.menuurl,d.menuaccessid,d.menuname,d.menutitle,d.description,
				e.modulename,d.parentid
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where c.isread = 1 and username = '".$username."'
			order by d.sortorder asc";
	$row				 = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
	return $row;
}
/**
 * 
 * @return type
 */
function getUserSuperMenu($username = '') {
	if ($username == '') {
		$username = Yii::app()->user->id;
	}
	$dependency	 = new CDbCacheDependency("SELECT count(d.menuaccessid)
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where c.isread = 1 and d.parentid is null and username = '".$username."'
			order by d.sortorder asc");
	$sql				 = "select distinct d.menuurl,d.menuaccessid,d.menuname,d.menutitle,d.description,
				(select count(1) from menuaccess e where e.parentid = d.menuaccessid) as jumlah,
				e.modulename
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where c.isread = 1 and d.parentid is null and username = '".$username."'
			order by d.sortorder asc";
	$row				 = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
	return $row;
}
/**
 * 
 * @param type $id
 * @return type
 */
function getUserMenu($id, $username = '') {
	if ($username == '') {
		$username = Yii::app()->user->id;
	}
	$dependency	 = new CDbCacheDependency("SELECT count(d.menuaccessid)
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where c.isread = 1 and d.parentid = ".$id." and username = '".$username."'
			order by d.sortorder asc");
	$sql				 = "select distinct d.menuurl,d.menuname,d.menutitle,d.description,e.modulename
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where c.isread = 1 and d.parentid = ".$id." and username = '".$username."'
			order by d.sortorder asc";
	$row				 = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
	return $row;
}
/**
 * 
 * @param type $paramname
 * @return type
 */
function GetParameter($paramname) {
	try {
		$sql				 = "select paramvalue ".
			" from parameter a ".
			" where paramname = '".$paramname."'";
		$dependency	 = new CDbCacheDependency('SELECT count(paramid) FROM parameter');
		$menu				 = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryRow();
		return $menu['paramvalue'];
	} catch (CDbException $ex) {
		return $ex->getMessage();
	}
}
/**
 *
 * @param type $status
 * @param type $catalogname
 */
function GetMessage($status, $catalogname) {
	/*$a = substr_count($catalogname, 'uq_');
	if ($a > 0) {
		$catalogname = 'duplicateentry';
	}
	$b = substr_count($catalogname, 'null');
	if ($b > 0) {
		$catalogname = 'notallownull';
	}
	$c = substr_count($catalogname, 'Integrity');
	if ($c > 0) {
		$catalogname = 'relationerror';
	}
	$d = substr_count($catalogname, 'Workflow tidak sesuai, silahkan kontak Admin');
	if ($d > 0) {
		$catalogname = 'Workflow tidak sesuai, silahkan kontak Admin';
	}*/
	echo CJSON::encode(array(
		'status' => $status,
		'msg' => getcatalog($catalogname)
	));
	Yii::app()->end();
}
/**
 * 
 * @param type $menuname
 * @return type
 */
function GetCatalog($menuname) {
	try {
		if (Yii::app()->user->id !== null) {
			$dependency	 = new CDbCacheDependency("SELECT count(catalogsysid)
					from catalogsys a
					inner join useraccess b on b.languageid = a.languageid
					where catalogname = '".$menuname."' and b.username = '".Yii::app()->user->id."'");
			$sql				 = "select catalogval as katalog
					from catalogsys a
					inner join useraccess b on b.languageid = a.languageid
					where catalogname = '".$menuname."' and b.username = '".Yii::app()->user->id."'";
		} else {
			$dependency	 = new CDbCacheDependency("SELECT count(catalogsysid)
					from catalogsys a
					inner join useraccess b on b.languageid = a.languageid
					where catalogname = '".$menuname."' and b.username = 'guest'");
			$sql				 = "select catalogval as katalog
					from catalogsys a
					inner join useraccess b on b.languageid = a.languageid
					where catalogname = '".$menuname."' and b.username = 'guest'";
		}
		$menu = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryScalar();
		if ($menu != null) {
			return $menu;
		} else {
			return $menuname;
		}
	} catch (CDbException $ex) {
		return $ex->getMessage();
	}
}
/**
 * Function to Check Access
 * @param type $menuname
 * @param type $menuaction
 * @param type $username
 * @return boolean
 */
function CheckAccess($menuname, $menuaction, $username = '') {
	$baccess = false;
	if ($username == '') {
		$dependency	 = new CDbCacheDependency("select count(d.menuaccessid) from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			where username = '".Yii::app()->user->id."' and menuname = '".$menuname."'");
		$sql				 = "select `".$menuaction.
			"`	from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			where username = '".Yii::app()->user->id."' and menuname = '".$menuname."' limit 1";
	} else {
		$dependency	 = new CDbCacheDependency("select count(d/menuaccessid) from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			where username = '".$username."' and menuname = '".$menuname."'");
		$sql				 = "select `".$menuaction.
			"`	from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			where username = '".$username."' and menuname = '".$menuname."' limit 1";
	}
	$isaction = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryScalar();
	if ($isaction > 0) {
		$baccess = true;
	} else {
		$baccess = false;
	}
	return $baccess;
}
/**
 * 
 */
function GetTodos() {
	$dependency	 = new CDbCacheDependency("select count(usertodoid from usertodo");
	$s					 = Yii::app()->db->cache(1000, $dependency)->createCommand("select * from usertodo where username = '".Yii::app()->user->id."' order by tododate desc limit 10")->queryAll();
	return $s;
}
/**
 *
 * @return type
 */
function GetTotalTodo() {
	$dependency	 = new CDbCacheDependency("select count(usertodoid from usertodo");
	$s					 = Yii::app()->db->cache(1000, $dependency)->createCommand("select count(1) from usertodo where username = '".Yii::app()->user->id."'")->queryScalar();
	return $s;
}
/**
 * 
 * @param type $command
 * @param type $tableid
 */
function InsertTranslog($command, $tableid = '', $menuname = '') {
	if (getparameter('usinglog') == '1') {
		$useraction = 'Insert';
		if ($tableid !== '') {
			$useraction = 'Update';
		} else if ($tableid == '') {
			$sql		 = "select last_insert_id() as tableid";
			$id			 = Yii::app()->db->createCommand($sql)->queryRow();
			$tableid = $id['tableid'];
		}
		$newdata = $command->pdoStatement->queryString;
		foreach ($command->getParamLog() as $key => $value) {
			$newdata = trim(str_replace($key, $value, $newdata));
		}
		$sql = "insert into translog(username,useraction,newdata,menuname,tableid)
        values (:0,:1,:2,:3,:4)";
    $connection	 = Yii::app()->db;
    $command = $connection->createCommand($sql);
    $command->bindvalue(':0', Yii::app()->user->id, PDO::PARAM_STR);
    $command->bindvalue(':1', $useraction, PDO::PARAM_STR);
    $command->bindvalue(':2', $newdata, PDO::PARAM_STR);
    $command->bindvalue(':3', $menuname, PDO::PARAM_STR);
    $command->bindvalue(':4', $tableid, PDO::PARAM_STR);
    $command->execute();
	}
}
/**
 * 
 * @param type $username
 * @return type
 */
function GetKey($username) {
	$sql = "select authkey from useraccess where username = '".$username."'";
	return Yii::app()->db->createCommand($sql)->queryScalar();
}
/**
 * Function for Authorize User Sender from Capella API
 * @param type $username
 * @param type $token
 * @param type $deviceid
 */
function AuthorizeUserSender($username, $token, $deviceid = '') {
	if ($deviceid == '') {
		$error = ValidateData(array(
			array('username', 'string', 'invaliduser'),
			array('token', 'string', 'invalidtoken'),
		));
	} else {
		$error = ValidateData(array(
			array('username', 'string', 'invaliduser'),
			array('token', 'string', 'invalidtoken'),
			array('deviceid', 'string', 'invaliddevice'),
		));
	}
	$result = $error;
	if ($error == false) {
		$username	 = filterinput(1, 'username', FILTER_SANITIZE_STRING);
		$deviceid	 = filterinput(1, 'deviceid', FILTER_SANITIZE_STRING);
		$token		 = filterinput(1, 'token', FILTER_SANITIZE_STRING);
		$sql			 = "select ifnull(count(1),0)
			from useraccess a
			where a.username = '".$username."'
				and a.authkey = '".$token."'
			";
		$data			 = Yii::app()->db->createCommand($sql)->queryScalar();
		if ($data < 1) {
			$result = true;
		}
	}
	return $result;
}
function getUserObjectValues($menuobject='company') {
	$sql = "select distinct a.menuvalueid 
				from groupmenuauth a
				inner join menuauth b on b.menuauthid = a.menuauthid
				inner join usergroup c on c.groupaccessid = a.groupaccessid 
				inner join useraccess d on d.useraccessid = c.useraccessid 
				where b.menuobject = '".$menuobject."'
				and d.username = '" . Yii::app()->user->name . "'";
	$cid = '';
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	foreach ($datas as $data) {
		if ($cid == '') {
			$cid = $data['menuvalueid'];
		} else 
		if ($cid !== '') {
			$cid .= ','.$data['menuvalueid'];
		}
	}
	return $cid;
}
function getUserRecordStatus($wfname) {
	$sql = "select b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join usergroup d on d.groupaccessid = b.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where a.wfname = '".$wfname."' and e.username = '" . Yii::app()->user->name . "'";
	$cid = '';
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	foreach ($datas as $data) {
		if ($cid == '') {
			$cid = $data['wfbefstat'];
		} else 
		if ($cid !== '') {
			$cid .= ','.$data['wfbefstat'];
		}
	}
	return $cid;
}
function findstatusname($workflowname,$recordstatus)
{
	$status = Yii::app()->db->createCommand("select wfstatusname
		from wfstatus a
		inner join workflow b on b.workflowid = a.workflowid
		where b.wfname = '".$workflowname."' and a.wfstat = ".$recordstatus)->queryScalar();
	if ($status != '')
	{
		return $status;
	}
	else 
	{
		return 0;
	}
}
function hasmodule($modulename) {
  $status = Yii::app()->db->createCommand("select ifnull(count(1),0)
		from modules a
		where a.modulename = '".$modulename."'")->queryScalar();
	return $status;
}
function resize($imagetype,$imageres,$width,$height,$oldwidth,$oldheight) {
  $layer=imagecreatetruecolor($width,$height);
  if ($imagetype == IMAGETYPE_PNG) {
    $background = imagecolorallocate($layer,0,0,0);
    imagecolortransparent($layer,$background);
    imagealphablending($layer,false);
    imagesavealpha($layer,true);
  }
  imagecopyresampled($layer,$imageres,0,0,0,0,$width,$height, $oldwidth,$oldheight);
  return $layer;
}
function convertImageToWebP($content, $destination, $quality=80) {
  $output = imagewebp($content, $destination, $quality);
  return $output;
}
function getpicture($filename,$alt='',$width=0,$height=0,$cssclass='',$isback=0) {
  $newfile = $_SERVER['DOCUMENT_ROOT'].$filename;
  $image_prop = getimagesize($newfile);
  $image_type = $image_prop[2];
  if ($image_type == IMAGETYPE_JPEG) {
    $filename = $filename."_thumb".$width."x".$height.".jpg";
    if (!file_exists($newfile."_thumb".$width."x".$height.".jpg")) {
      $imageres = imagecreatefromjpeg($newfile);
      $layer = resize(IMAGETYPE_JPEG,$imageres,$width,$height,$image_prop[0],$image_prop[1]);
      imagejpeg($layer,$_SERVER['DOCUMENT_ROOT'].$filename,92);
    }
  } else 
  if ($image_type == IMAGETYPE_PNG) {
    $filename = $filename."_thumb".$width."x".$height.".png";
    if (!file_exists($newfile."_thumb".$width."x".$height.".png")) {
      $imageres = imagecreatefrompng($newfile);
      $layer = resize(IMAGETYPE_PNG,$imageres,$width,$height,$image_prop[0],$image_prop[1]);
      imagepng($layer,$_SERVER['DOCUMENT_ROOT'].$filename,9);
    }
  } else
  if ($image_type == IMAGETYPE_GIF) {
    $filename = $filename."_thumb".$width."x".$height.".gif";
    if (!file_exists($newfile."_thumb".$width."x".$height.".gif")) {
      $imageres = imagecreatefromgif($newfile);
      $layer = resize(IMAGETYPE_GIF,$imageres,$width,$height,$image_prop[0],$image_prop[1]);
      imagegif($layer,$_SERVER['DOCUMENT_ROOT'].$filename,9);
    }
  }
  
  if ($isback == 0) {
  echo "<img src='".$filename."' alt='".$alt."' class='".$cssclass." lazyload' style='width:".$width."px;height:".$height."px'>";
  } else {
    echo "background-image: url(".$filename.");";
  }
}
function getcategoryparent() {
  if (Yii::app()->hasModule('blog')) {
    $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM category');
    $sql = "select categoryid,title,description,slug
      from category
      where recordstatus = 1 and parentid is null";
    return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
  } else {
    return null;
  }
}
function getcategorychild($parentid) {
  if (Yii::app()->hasModule('blog')) {
    $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM category where parentid = '.$parentid);
    $sql = 'select categoryid,title,description,slug
      from category
      where recordstatus = 1 and parentid = '.$parentid;
    return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
  } else {
    return null;
  }
}
function hascategorychild($parentid) {
  if (Yii::app()->hasModule('blog')) {
    $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM category where parentid = '.$parentid);
    $sql = 'select ifnull(count(1),0)
      from category
      where recordstatus = 1 and parentid = '.$parentid;
    return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryScalar();
  } else {
    return 0;
  }
}
function gettagcategory($categoryid) {
  $splittag	 = explode(',', $categoryid);
  $tagku		 = "";
  foreach ($splittag as $tag) {
    $sql				 = "select slug,title ".
      " from category a ".
      " where categoryid = ".$tag;
    $dependency	 = new CDbCacheDependency('SELECT updatedate FROM category');
    $tagg				 = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryRow();
    if ($tagku == "") {
      $tagku = "<a href=".Yii::app()->createUrl('blog/category/read/'.$tagg['slug']).">".$tagg['title']."</a>";
    } else {
      $tagku += ",".$tagg['title'];
    }
  }
  return $tagku;
}
function getallcategory() {
  $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM category');
  $sql = "select categoryid,title,description,slug
    from category
    where recordstatus = 1";
  return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
}
function getalltag() {
  $sql = "select slug
    from category
    where recordstatus = 1
    union 
    select slug
    from post
    where recordstatus = 1
    ";
  return Yii::app()->db->createCommand($sql)->queryAll();
}
function getslideshow($category='',$limit=0,$latest=1){
  $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM slideshow');
  $sql = "select a.slidetitle,a.slidedesc,a.slideurl,a.slidepic
    from slideshow a 
    left join slideshowcategory b on b.slideshowid = a.slideshowid 
    left join category c on c.categoryid = b.categoryid ";
  if ($category != '') {
    $sql .= " where coalesce(c.title,'') = '".$category."'";
  }
  if ($latest == 1) {
    $sql .= " order by a.updatedate desc";
  }
  if ($limit > 0) {
    $sql .= " limit ".$limit;
  }
  return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
}
function getpost($category='',$limit=0,$latest=0) {
  $dependency = new CDbCacheDependency('SELECT max(postupdate) FROM post');
  $sql = "select a.postpic,a.title,a.description,a.metatag,a.slug
    from post a
    left join postcategory b on b.postid = a.postid 
    left join category c on c.categoryid = b.categoryid ";
  if ($category != '') {
    $sql .= " where coalesce(c.title,'') = '".$category."'";
  };
  if ($latest == 1) {
    $sql .= " order by a.postupdate desc ";
  }
  if ($limit > 0) {
    $sql .= " limit ".$limit;
  }
  return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
}
function getmaterialgroup($materialtype='',$limit=0,$latest=1){
  $dependency = new CDbCacheDependency('SELECT max(updatedate) FROM materialgroup');
  $sql = "select a.materialgroupcode,a.description,a.materialgrouppic,a.slug
    from materialgroup a 
    left join materialtype b on b.materialtypeid = a.materialtypeid 
  ";
  if ($materialtype != '') {
    $sql .= " where coalesce(b.materialtypecode,'') = '".$materialtype."'";
  }
  if ($latest == 1) {
    $sql .= " order by a.updatedate desc";
  }
  if ($limit > 0) {
    $sql .= " limit ".$limit;
  }
  return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
}
function getproduct($limit=0,$latest=1,$filters=[]){
  $sql = "select a.productcode,a.productname,a.productpic,c.uomcode,b.materialgroupcode,a.slug
    from product a 
    join materialgroup b on b.materialgroupid = a.materialgroupid 
    join unitofmeasure c on c.unitofmeasureid = a.unitofissue
  ";
  if (count($filters) > 0) {
    $sql .= " where ";
    foreach ($filters as $filter) {
      switch ($filter['filter']) {
        case "materialgroup":
          $sql .= " coalesce(b.materialgroupcode,'') ".$filter['type']." ".$filter['value'];
          break;
        case "productcode":
          $sql .= " coalesce(a.productcode,'') ".$filter['type']." '".$filter['value']."'";
          break;
      }
    }
  }

  if ($latest == 1) {
    $sql .= " order by a.updatedate desc";
  }
  if ($limit > 0) {
    $sql .= " limit ".$limit;
  }
  return Yii::app()->db->createCommand($sql)->queryAll();
}
function gettokotrust($limit=0){
  $sql = "select a.fullname,a.logo,a.url
    from addressbook a
    order by rating desc 
    limit ".$limit;
  return Yii::app()->db->createCommand($sql)->queryAll();
}