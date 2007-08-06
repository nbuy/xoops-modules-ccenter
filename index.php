<?php
// contact to member
// $Id: index.php,v 1.9 2007/08/06 13:54:27 nobu Exp $

include "../../mainfile.php";
include "functions.php";

$errors = array();
$op = "form";
$myts =& MyTextSanitizer::getInstance();

$id= isset($_GET['form'])?intval($_GET['form']):0;

$cond = "active";
if (is_object($xoopsUser)) {
    $conds = array();
    foreach ($xoopsUser->getGroups() as $gid) {
	$conds[] = "grpperm LIKE '%|$gid|%'";
    }
    if ($conds) $cond .= " AND (".join(' OR ', $conds).")";
} else {
    $cond .= " AND grpperm LIKE '%|".XOOPS_GROUP_ANONYMOUS."|%'";
}
if ($id) {
    $res = $xoopsDB->query("SELECT * FROM ".FORMS." WHERE $cond AND formid=$id");
} else {
    $res = $xoopsDB->query("SELECT * FROM ".FORMS." WHERE $cond ORDER BY weight,formid");
}

if (!$res) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

$breadcrumbs = new XoopsBreadcrumbs();

if ($xoopsDB->getRowsNum($res)!=1) {
    include XOOPS_ROOT_PATH."/header.php";
    $xoopsOption['template_main'] = "ccenter_index.html";
    $forms = array();
    while ($form=$xoopsDB->fetchArray($res)) {
	if ($form['priuid']<0) continue; // need uid setting
	$forms[] = $form;
    }
    $xoopsTpl->assign('forms', $forms);
    include XOOPS_ROOT_PATH."/footer.php";
    exit;
}

if (isset($_POST['op']) && !isset($_POST['edit'])) $op = $_POST['op'];
$form = $xoopsDB->fetchArray($res);
$items = get_form_attribute($form['defs']);
if ($form['priuid']< 0) {	// assign group member
    $priuid = isset($_GET['uid'])?intval($_GET['uid']):0;
    if ($priuid) {
	$member_handler =& xoops_gethandler('member');
	$priuser = $member_handler->getUser($priuid);
	if (!is_object($priuser) || !in_array(-$form['priuid'], $priuser->groups())) $priuid=0;
    }
    if (empty($priuid)) {
	$back = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:XOOPS_URL;
	redirect_header($back, 3, _NOPERM);
	exit;
    } else {
	$form['priuser'] = array('uid'=>$priuser->getVar('uid'),
				 'uname'=>$priuser->getVar('uname'),
				 'name'=>$priuser->getVar('name'));
    }
}

$errors = array();
if ($op!="form") {
    $errors = assign_post_values($items);
    if (count($errors)) {
	$op = 'form';
	assign_form_widgets($items);
    } elseif ($op == 'store') {
	$errors = store_message($items, $form);
    } elseif ($op == 'confirm') {
	assign_form_widgets($items, true);
    }
} else {
    assign_form_widgets($items);
}

$cust = $form['custom'];
$form['items'] = $items;

$hasfile = false;
$require = array();
$confirm = array();
foreach ($items as $item) {
    if (empty($item['field'])) continue;
    $fname = $item['field'];
    $type = $item['type'];
    $lab = $item['label'];
    if ($type == 'file') {
	$hasfile=true;
    } elseif (preg_match('/_conf$/', $fname)) {
	$confirm[preg_replace('/_conf$/', '', $fname)] = $lab;
    } elseif (preg_match('/\*$/', $lab)) {
	$require[$fname] = $lab;
    }
}

$form['check_script'] = checkScript($require, $confirm);
$form['confirm'] = $confirm;
$form['hasfile'] = $hasfile;

$title = htmlspecialchars($form['title']);
$breadcrumbs->set($title, "index.php?form=$id");

if ($cust) {
    $out = custom_template($form, $items, $op == 'confirm');
    if ($cust==1) {
	include XOOPS_ROOT_PATH."/header.php";
	$breadcrumbs->assign();
	$xoopsTpl->assign('xoops_pagetitle', $title);
	if ($errors) xoops_error($errors);
	echo $out;
	include XOOPS_ROOT_PATH."/footer.php";
    } else {
	echo $out;
    }
} else {
    $str = $rep = array();
    if (!empty($form['priuser'])) {
	$priuser =& $form['priuser'];
	$str[] = "{TO_UNAME}";
	$rep[] = $priuser['uname'];
	$str[] = "{TO_NAME}";
	$rep[] = $priuser['name'];
    }
    $form['description'] = $myts->displayTarea(str_replace($str, $rep, $form['description']));
    include XOOPS_ROOT_PATH."/header.php";
    $breadcrumbs->assign();
    $xoopsTpl->assign('xoops_pagetitle', $title);
    $xoopsOption['template_main'] = ($op=='confirm')?"ccenter_confirm.html":"ccenter_form.html";

    $xoopsTpl->assign('errors', $errors);
    $xoopsTpl->assign('form', $form);
    $xoopsTpl->assign('op', 'confirm');

    include XOOPS_ROOT_PATH."/footer.php";
}

function store_message($items, $form) {
    global $xoopsUser, $xoopsDB, $xoopsModuleConfig;

    $uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
    $email = "";
    $attach = array();
    $vals = array();
    foreach ($items as $item) {
	if (empty($item['label'])) continue;
	$name = preg_replace('/\*$/', '', $item['label']);
	$vals[$name] = $item['value'];
	switch ($item['type']) {
	case 'mail':
	    if (empty($email)) { // save first email for contact
		$email = $vals[$name];
		unset($vals[$name]);
	    }
	    break;
	case 'file':
	    $val = $vals[$name];
	    if ($val) {
		$vals[$name] = "file=".$val;
		$attach[] = $val;
	    }
	    break;
	}
    }
    $text = serialize_text($vals);
    $onepass = ($uid==0)?gen_onetime_ticket($email):"";
    if ($form['priuid'] < 0) {
	$touid = empty($form['priuser'])?0:$form['priuser']['uid'];
    } else {
	$touid = $form['priuid'];
    }
    $now = time();
    $values = array(
	'uid'=>$uid, 'touid'=>$touid,
	'ctime'=>$now, 'mtime'=>$now,
	'fidref'=>$form['formid'],
	'email'=>$xoopsDB->quoteString($email),
	'onepass'=>$xoopsDB->quoteString($onepass));
    $parg = $onepass?"&p=".urlencode($onepass):"";
    if ($form['store']) $values['body']=$xoopsDB->quoteString($text);

    $res = $xoopsDB->query("INSERT INTO ".MESSAGE. "(".join(',',array_keys($values)).") VALUES (".join(',', $values).")");
    if ($res===false) return array("Error in DATABASE insert");
    $id = $xoopsDB->getInsertID();
    if ($touid) {
	$member_handler =& xoops_gethandler('member');
	$toUser = $member_handler->getUser($touid);
	$toUname = $toUser->getVar('uname');
    } else {
	$toUser = false;
	$toUname = _MD_CONTACT_NOTYET;
    }
    if (count($attach)) {
	$text .= "\n"._MD_ATTACHMENT."\n";
	foreach ($attach as $i=>$file) {
	    move_attach_file('', $file, $id);
	    $text .= attach_image($id, $file, true)."$parg\n";
	}
	rmdir(XOOPS_UPLOAD_PATH.attach_path(0, ''));
    }
    $dirname = basename(dirname(__FILE__));
    $msgurl = XOOPS_URL."/modules/$dirname/message.php?id=$id";
    $uname = $xoopsUser?$xoopsUser->getVar('uname'):$email;
    $tags = array('VALUES'=>$text,
		  'SUBJECT'=>$form['title'],
		  'TO_USER'=>$toUname,
		  'FROM_USER'=>$uname);
    if ($id) {
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', $id, 'new', $tags);
	// force subscribe sender and recipient
	$notification_handler->subscribe('message', $id, 'comment');
	if ($touid) $notification_handler->subscribe('message', $id, 'comment', null, null, $touid);
    }
    $msgurl .= $parg;
    $tags['MSG_URL'] = $msgurl;
    notify_mail('form_confirm.tpl', $tags, $toUser, $email);
    //$url = str_replace('{UID}', $touid, $url);
    //$url = str_replace('{ID}', $id, $url);
    if (!empty($form['redirect'])) $msgurl = $form['redirect'];
    redirect_header($msgurl, 3, _MD_CONTACT_DONE);
    exit;
}

function checkScript($checks, $confirm) {
    $script = "<script type=\"text/javascript\">
<!--//
function checkItem(obj, lab) {
  msg = lab+\": "._MD_REQUIRE_ERR."\\n\";
  if (obj.selectedIndex && obj.value != \"\") return \"\";
  if (obj.value == \"\") return msg;
  if (obj.length) {
     for (i=0; i<obj.length; i++) {
        if (obj[i].checked) return \"\";
     }
     return msg;
  }
  return \"\";
}
function xoopsFormValidate_ccenter() {
    myform = window.document.ccenter;
    msg = \"\";
    obj = null;
";
    foreach ($checks as $name => $msg) {
	$script .= "
    msg = msg+checkItem(myform.$name, \"$msg\");
    if(msg && obj==null)obj=myform.$name;\n";
    }
    if (count($confirm)) {
	foreach ($confirm as $name => $msg) {
	    $script .= "
    if ( myform.$name.value != myform.{$name}_conf.value ) {
        msg = msg+\"$msg: "._MD_CONFIRM_ERR."\\n\";
        if(obj==null)obj=myform.{$name}_conf;
}\n";
	}
    }
    $script .= "
    if (msg == \"\") return true;
    window.alert(msg);
    if (obj.length==null) obj.focus();
    return false;
}
function checkedEtcText(lab) {
   obj = xoopsGetElementById(lab+\"_eck\");
   if (obj) obj.checked=true;
}
//--></script>";
    return $script;
}

?>