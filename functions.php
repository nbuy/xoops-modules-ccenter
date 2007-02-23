<?php
// ccenter common functions
// $Id: functions.php,v 1.1 2007/02/23 05:27:28 nobu Exp $

global $xoopsDB;		// for blocks scope
// using tables
define("FORMS", $xoopsDB->prefix("ccenter_form"));
define('MESSAGE', $xoopsDB->prefix('ccenter_message'));
$myts =& MyTextSanitizer::getInstance();

if (defined('_MD_STATUS_NONE')) {
    $msg_status = array(
	'-'=>_MD_STATUS_NONE,
	'a'=>_MD_STATUS_ACCEPT,
	'b'=>_MD_STATUS_REPLY,
	'c'=>_MD_STATUS_CLOSE,
	'f'=>_MD_STATUS_FIN,
	'x'=>_MD_STATUS_DEL);
}

// attribute config option expanding
function get_form_attribute($defs) {
    $num = 0;
    $result = array();
    $types = array('text', 'checkbox', 'radio', 'textarea', 'select', 'hidden', 'mail', 'file', 'multi');
    foreach (preg_split('/\r?\n/', $defs) as $ln) {
	$ln = trim($ln);
	if (empty($ln)) continue;
	$opts = explode(",", $ln);
	$name = array_shift($opts);
	$type='';
	$comment='';
	$attr = array();
	if (count($opts) && in_array($opts[0], $types)) {
	    $type = array_shift($opts);
	}
	if (count($opts) && preg_match('/^\s*#/', $opts[0])) {
	    $opts[0] = preg_replace('/^\s*#/','', $opts[0]);
	    $comment = join(',',$opts);
	    $opts=array();
	}
	while (isset($opts[0]) && preg_match('/^(size|rows|maxlength|cols|prop)=(\d+)$/', $opts[0], $d)) {
	    array_shift($opts);
	    $attr[$d[1]] = $d[2];
	}
	$options = array();
	if (count($opts)) {
	    foreach($opts as $v) {
		$sv = preg_split('/=/', $v, 2);
		if (count($sv)>1) {
		    $options[$sv[0]] = $sv[1];
		} else $options[$v] = preg_replace('/\+$/', '', $v);
	    }
	}
	$fname = "cc".++$num;
	$result[] = array(
	    'label'=>$name, 'field'=>$fname, 'options'=>$options,
	    'type'=>$type, 'comment'=>$comment, 'attr'=>$attr);
    }
    return $result;
}

function assign_post_values(&$items) {
    global $myts;
    $errors = array();
    foreach ($items as $key=>$item) {
	$name = $item['field'];
	$type = $item['type'];
	$val = '';
	if (isset($_POST[$name])) {
	    $val = $_POST[$name];
	    if (is_array($val)) {
		foreach ($val as $n=>$v) {
		    $val[$n] = $myts->stripSlashesGPC($v);
		}
	    } else {
		$val = $myts->stripSlashesGPC($val);
	    }
	}
	if ($val==='' && preg_match('/\*$/',$lab)) { // require check
	    $errors[] = $lab.": "._MD_REQUIRE_ERROR;
	}
	switch ($type) {
	case 'file':
	    $val = '';		// filename
	    $upfile = isset($_FILES[$name])?$_FILES[$name]:array('name'=>'');
	    if (isset($_POST[$name."_prev"])) {
		$val = $myts->stripSlashesGPC($_POST[$name."_prev"]);
		if (!empty($upfile['name'])) {
		    unlink(XOOPS_UPLOAD_PATH.attach_path(0, $val));
		    $val = '';
		}
	    }
	    if (empty($val)) {
		$val = $upfile['name'];
		if ($val) move_attach_file($upfile['tmp_name'], $val);
		elseif (isset($_POST[$name])) {	// confirm
		    $val = $myts->stripSlashesGPC($_POST[$name]);
		}
	    }
	    break;
	case 'mail':
	    $name .= '_conf';
	    if (isset($_POST[$name])) {
		if ($val != $myts->stripSlashesGPC($_POST[$name])) {
		    $errors[] = sprintf(_MD_CONF_LABEL, $lab).": "._MD_CONFIRM_ERR;
		}
	    }
	    break;
	}
	$items[$key]['value'] = $val;
	$lab = $item['label'];
    }
    return $errors;
}

function assign_form_widgets(&$items, $conf=false) {
    $mconf = !$conf;
    for ($n = 0; $n < count($items); $n++) {
	$item =& $items[$n];
	$val =& $item['value'];
	$fname =& $item['field'];
	if ($conf) {
	    if (is_array($val)) {
		$input = htmlspecialchars(join(', ', $val));
		$fmt = "<input type='hidden' name='{$fname}[]' value='%s'/>";
		foreach ($val as $v) {
		    $v = htmlspecialchars($v);
		    $input .= sprintf($fmt, $v);
		}
	    } else {
		$v = htmlspecialchars($val);
		$input = "$v<input type='hidden' name='$fname' value='$v'/>";
	    }
	} else {
	    $input = make_widget($item);
	    $lab = $item['label'];
	    if ($mconf && $item['type']=='mail' && preg_match('/\*$/', $lab)) {
		$cfname = $fname.'_conf';
		$citem = array(
		    'label'=>sprintf(_MD_CONF_LABEL, $lab),
		    'field'=>$cfname, 'type'=>$item['type'],
		    'comment'=>_MD_CONF_DESC, 'attr'=>$item['attr']);
		$citem['input'] = make_widget($citem);
		array_splice($items, ++$n, 0, array($citem));
		$mconf = false;
	    }
	}
	$item['input'] = $input;
    }
}

function make_widget($item) {
    global $myts;
    $input = '';
    $fname = $item['field'];
    $names = "name='$fname' id='$fname'";
    $options =& $item['options'];
    $type =& $item['type'];
    $attr =& $item['attr'];
    $astr = '';
    if (isset($attr['prop'])) $astr .= ' '.$attr['prop'];
    switch($item['type']) {
    case 'select':
	$def = '';
	if (isset($_POST[$fname])) { // ovarride post value
	    $def = $myts->stripSlashesGPC($_POST[$fname]);
	}
	$input = "<select name='".htmlspecialchars($fname)."'$astr>\n";
	foreach ($options as $key=>$val) {
	    $lab = preg_replace('/\+$/', '', $key);
	    if (empty($def) && $lab != $key) {
		$def = $lab;
	    }
	    $ck = ($def == $lab)?" selected='selected'":"";
	    $lab = htmlspecialchars($lab);
	    $input .= "<option value='$lab'$ck/>$val</option>\n";
	}
	$input .= "</select>\n";
	break;
    case 'radio':
	$def = '';
	if (isset($_POST[$fname])) { // ovarride post value
	    $def = $myts->stripSlashesGPC($_POST[$fname]);
	}
	$input = "";
	foreach ($options as $key=>$val) {
	    $lab = preg_replace('/\+$/', '', $key);
	    if (empty($def) && $lab != $key) {
		$def = $lab;
	    }
	    $ck = ($def == $lab)?" checked='checked'":"";
	    $lab = htmlspecialchars($lab);
	    $val = htmlspecialchars($val);
	    $input .= "<span class='ccradio'><input type='radio' name='$fname' value='$lab'$ck/> $val</span> ";
	}
	break;
    case 'checkbox':
	$def = ($_SERVER['REQUEST_METHOD']=='POST')?array():null;
	if (isset($_POST[$fname])) { // ovarride post value
	    foreach ($_POST[$fname] as $v) {
		$def[] = $myts->stripSlashesGPC($v);
	    }
	}
	$input = "";
	foreach ($options as $key=>$val) {
	    $lab = preg_replace('/\+$/', '', $key);
	    if ($def==null) {
		$ck = ($key!=$lab)?" checked='checked'":"";
	    } else {
		$ck = in_array($lab, $def)?" checked='checked'":"";
	    }
	    $lab = htmlspecialchars($lab);
	    $val = htmlspecialchars($val);
	    $input .= "<span class='cccheckbox'><input type='checkbox' name='".$fname."[]' value='$lab'$ck$astr/> $val</span> ";
	}
	break;
    case 'textarea':
    default:
	$val = is_array($options)?join(',', $options):$options;
	if (isset($_POST[$fname])) { // ovarride post value
	    $val = $myts->stripSlashesGPC($_POST[$fname]);
	} else {
	    $orig = preg_replace('/_conf$/', '', $fname);
	    if (isset($_POST[$orig])) {
		$val = $myts->stripSlashesGPC($_POST[$orig]);
	    }
	}
	$val = htmlspecialchars($val);
	if ($type == 'textarea') {
	    if (isset($attr['rows'])) $astr .= ' rows='.$attr['rows'];
	    if (isset($attr['cols'])) $astr .= ' cols='.$attr['cols'];
	    $input = "<textarea $names $astr>$val</textarea>";
	} else {
	    $input = "";
	    if ($type=='file') {
		if ($val) $input .= "$val<input type='hidden' name='{$fname}_prev' value='$val'/><br/>";
	    } else $type = 'text';
	    if (isset($attr['size'])) $astr .= ' size='.$attr['size'];
	    if (isset($attr['maxlength'])) $astr .= ' maxlength='.$attr['maxlength'];
	    $input .= "<input type='$type' $names value='$val'$astr/>";
	    if ($type=='file') {
	    }
	}
	break;
    }
    return $input;
}

function serialize_text($array) {
    $text = '';
    foreach ($array as $name => $val) {
	if (is_array($val)) $val = join(', ', $val);
	if (preg_match('/\n/', $val)) {
	    $val = preg_replace('/\n\r?/', "\n\t", $val);
	}
	$text .= "$name: $val\n";
    }
    return $text;
}

function unserialize_text($text) {
    $array = array();
    foreach (preg_split("/\r?\n/", $text) as $ln) {
	if (preg_match('/^\s/', $ln)) {
	    $val .= "\n".substr($ln, 1);
	} elseif (preg_match('/^([^:]*):\s?(.*)$/', $ln, $d)) {
	    $name = $d[1];
	    $array[$name] = $d[2];
	    $val =& $array[$name];
	}
    }
    return $array;
}

function template_dir($file='') {
    global $xoopsConfig;
    $lang = $xoopsConfig['language'];
    $dir = dirname(__FILE__).'/language/%s/mail_template/%s';
    $path = sprintf($dir,$lang, $file);
    if (file_exists($path)) {
	$path = sprintf($dir,$lang, '');
    } else {
	$path = sprintf($dir,'english', '');
    }
    return $path;
}

function lang_label() {
    global $xoopsDB;

    $res = $xoopsDB->query("SELECT fid, name, caption FROM ".$xoopsDB->prefix('hakusen_form'));

    if (!$res) {
	global $xoopsConfig;
	$base = XOOPS_ROOT_PATH."/language/";
	$lang = $xoopsConfig['language'];
	$path = "$base/$lang/user.php";
	if (file_exists($path)) include_once $path;
	else include_once "$base/english/user.php";
	return array('name'=>_US_REALNAME, 'email'=>_US_EMAIL,
		     'url'=>_US_WEBSITE, 'timezone_offset'=>_US_TIMEZONE,
		     'user_icq'=>_US_ICQ, 'user_aim'=>_US_AIM,
		     'user_yim'=>_US_YIM, 'user_msnm'=>_US_MSNM,
		     'user_from'=>_US_LOCATION, 'user_occ'=>_US_OCCUPATION,
		     'user_intrest'=>_US_INTEREST, 'user_sig'=>_US_SIGNATURE,
		     'bio'=>_US_EXTRAINFO);
    }

    $ret = array();
    while (list($fid, $name, $caption) = $xoopsDB->fetchRow($res)) {
	if (empty($name)) $name = 'var'.$fid;
	$ret[$name] = $caption;
    }
    return $ret;
}

function attach_path($id, $file) {
    $dir = $id?sprintf("%05d", $id):"work".substr(session_id(), 0, 8);
    return "/ccenter/$dir".($file?"/$file":"");
}

function attach_image($id, $file, $urlonly=false, $add='') {
    if (empty($file)) return "";
    $rurl = "file.php?".($id?"id=$id&":"")."file=".urlencode($file).($add?"&$add":"");
    if ($urlonly) return XOOPS_URL."/modules/".basename(dirname(__FILE__))."/$rurl";
    $path = XOOPS_UPLOAD_PATH.attach_path($id, $file);
    $xy = getimagesize($path);
    if ($xy) {
	if ($xy[0]>$xy[1] && $xy[0]>300) $extra = " width='300'";
	elseif ($xy[1]>300) $extra = " height='300'";
	else $extra = "";
	return "<img src='$rurl' class='myphoto' $extra/>";
    } else {
	$size = return_unit_bytes(filesize($path));
	return "<a href='$rurl' class='myattach'>$file ($size)</a>";
    }
}

function return_unit_bytes($size) {
    $unit = defined('_MD_BYTE_UNIT')?_MD_BYTE_UNIT:"bytes";
    if ($size<10*1024) return number_format($size);
    $size /= 1024;
    if ($size<10*1024) return round($size, 1).'K'.$unit;
    $size /= 1024;
    if ($size<10*1024) return round($size, 1).'M'.$unit;
    $size /= 1024;
    return round($size, 1).'G'.$unit;
}

// Access allow:
//   1. onetime password matched
//   2. administrator
//   3. order from/to users
function check_perm($data) {
    global $xoopsUser, $xoopsModule;
    $uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;

    if (strlen($data['onepass'])>4 && isset($_GET['p']) && $_GET['p']==$data['onepass']) return true;

    $mid = is_object($xoopsModule)?$xoopsModule->getVar('mid'):0;
    if ($uid && $xoopsUser->isAdmin($mid)) return true;
    if ($uid && ($data['uid']==$uid || $data['touid'] == $uid)) return true;
    return false;
}

function is_confirmed($uid, $ok='Y') {
    global $xoopsDB;
    $res = $xoopsDB->query("SELECT confirm FROM ".HAKU." WHERE uid=$uid");
    list($ans) = $xoopsDB->fetchRow($res);
    return strstr($ok, $ans);
}

function gen_onetime_ticket($genseed="mypasswdbasestring") {
    return substr(base64_encode(pack("H*",md5($genseed.time()))), 0, 8);
}

function delete_message($msgid) {
    global $xoopsDB;
    //$res = $xoopsDB->query("DELETE FROM ".MESSAGE." WHERE msgid=".$msgid);
    $dir = XOOPS_UPLOAD_PATH.attach_path(0,'');
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
	echo "<div>$file</div>";
    }
}

function message_entry($data, $link="message.php") {
    global $msg_status;
    $id = $data['msgid'];
    return  array(
	'msgid'=>$id,
	'mdate'=>formatTimestamp($data['mtime']),
	'title'=>"<a href='message.php?id=$id'>".$data['title']."</a>", 
	'uname'=> xoops_getLinkedUnameFromId($data['uid']),
	'status'=>$msg_status[$data['status']]);
}

function is_evaluate($id, $uid, $pass) {
    global $xoopsDB;
    $cond = $pass?'onepass='.$xoopsDB->quoteString($pass):"uid=$uid";
    $res = $xoopsDB->query("SELECT count(uid) FROM ".MESSAGE." WHERE msgid=$id AND $cond AND status='c'");
    list($ret) = $xoopsDB->fetchRow($res);
    return $ret;
}

function notify_mail($tpl, $tags, $users, $email='') {
    global $xoopsConfig, $xoopsModuleConfig, $xoopsUser, $xoopsModule;
    $xoopsMailer =& getMailer();
    $xoopsMailer->useMail();
    $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
    $xoopsMailer->setFromName($xoopsModule->getVar('name'));
    $xoopsMailer->setSubject(_MD_NOTIFY_SUBJ);
    $xoopsMailer->assign($tags);
    $xoopsMailer->setTemplateDir(template_dir($tpl));
    $xoopsMailer->setTemplate($tpl);
    $xoopsMailer->setToUsers($users);
    if ($email) $xoopsMailer->setToEmails($email);
    else $xoopsMailer->setToUsers($xoopsUser);
    return $xoopsMailer->send();
}

function check_form_tags($defs, $desc) {
    global $xoopsConfig;
    $base = dirname(__FILE__).'/language/';
    $path = $base.$xoopsConfig['language'].'/main.php';
    if (file_exists($path)) include_once($path);
    else include_once("$base/english/main.php");
    $items = get_form_attribute($defs);
    assign_form_widgets(&$items);
    $checks = array('{FORM_ATTR}', '{SUBMIT}', '{BACK}', '{CHECK_SCRIPT}');
    foreach ($items as $item) {
	$checks[] = '{'.preg_replace('/\*$/', '', $item['label']).'}';
    }
    $error = "";
    foreach ($checks as $check) {
	$n = substr_count($desc, $check);
	if ($n!=1) {
	    $error .= $check.": ".($n?_AM_CHECK_DUPLICATE:_AM_CHECK_NOEXIST)."<br/>\n";
	}
    }
    return $error;
}
?>