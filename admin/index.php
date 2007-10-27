<?php
// adminstration messages
include '../../../include/cp_header.php';
include '../functions.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once 'myformselect.php';

$myts =& MyTextSanitizer::getInstance();
$op = isset($_GET['op'])?$_GET['op']:'';
if (isset($_POST['op'])) $op = $_POST['op'];
$formid = isset($_REQUEST['formid'])?intval($_REQUEST['formid']):0;

$fields = array('title', 'description', 'defs', 'priuid', 'cgroup',
		'store', 'custom', 'weight', 'active', 'redirect');
if ($op == 'delform') {
    $formid = intval($_POST['formid']);
    $xoopsDB->query("DELETE FROM ".FORMS." WHERE formid=".$formid);
    $xoopsDB->query("DELETE FROM ".CCMES." WHERE fidref=".$formid);
    // NOTE: add function delete XOOPS comments.
    // NOTE: add function delete uploads files
    redirect_header('index.php', 1, _AM_FORM_DELETED);
    exit;
} elseif (isset($_POST['formdefs']) && !isset($_POST['preview'])) {
    $formid = intval($_POST['formid']);
    $data = $vals = array();
    foreach ($fields as $fname) {
	$data[$fname] = $v = $myts->stripSlashesGPC($_POST[$fname]);
	$v = $xoopsDB->quoteString($v);
	if ($formid) {
	    $vals[] = $fname."=".$v;
	} else {
	    $vals[$fname] = $v;
	}
    }
    $v = '|';
    foreach ($_POST['grpperm'] as $gid) {
	$v .= intval($gid)."|";
    }
    $v = $xoopsDB->quoteString($v);
    if ($formid) {
	$vals[] = "grpperm=".$v;
	$vals[] = "mtime=".time();
	$res = $xoopsDB->query("UPDATE ".FORMS." SET ".join(',', $vals)." WHERE formid=".$formid);
    } else {
	$vals['grpperm'] = $v;
	$vals['mtime'] = time();
	$res = $xoopsDB->query("INSERT INTO ".FORMS."(".join(',', array_keys($vals)).") VALUES(".join(',', $vals).")");
	$formid = $xoopsDB->getInsertID();
    }
    if ($data['custom']&&check_form_tags($data['defs'],$data['description'])) {
	$redirect = "index.php?formid=".$formid;
    } else $redirect = "index.php";
    if ($res) {
	redirect_header($redirect, 1, _AM_FORM_UPDATED);
    } else {
	redirect_header($redirect, 3, _AM_FORM_UPDATE_FAIL);
    }
    exit;
}

if( ! empty( $_GET['lib'] ) ) {
    global $mydirpath;
    $mydirpath = dirname(dirname(__FILE__));
    $mydirname = basename($mydirpath);
    // common libs (eg. altsys)
    $lib = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET['lib'] ) ;
    $page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_GET['page'] ) ;
    
    if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ) ) {
	include XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ;
	} else if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ) ) {
	include XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ;
    } else {
	die( 'wrong request' ) ;
    }
    exit;
}

xoops_cp_header();

include "mymenu.php";

switch ($op) {
case 'delete':
    $res=$xoopsDB->query("SELECT title FROM ".FORMS." WHERE formid=".$formid);
    list($title) = $xoopsDB->fetchRow($res);
    xoops_confirm(array('op'=>'delform', 'formid'=>$formid), '',
		  _AM_DELETE_FORM.' - '.htmlspecialchars($title)." (ID:$formid)",
		  _DELETE);
    break;
default:
    if ($formid==0) list_forms();
    build_form($formid);
}

xoops_cp_footer();

function list_forms() {
    global $xoopsDB, $xoopsUser;
    $dirname = basename(dirname(dirname(__FILE__)));
    $res = $xoopsDB->query("SELECT formid, title,count(msgid) nmes, priuid,
sum(if(status='-',1,0)) nwait,
sum(if(status='a',1,0)) nwork,
sum(if(status='b',1,0)) nreply,
sum(if(status='c',1,0)) nclose
FROM ".FORMS." LEFT JOIN ".CCMES." ON fidref=formid AND status<>'x' GROUP BY formid");
    if (!$res || $xoopsDB->getRowsNum($res)==0) return false;
    echo "<style>td.num { text-align: right; }</style>";
    echo "<table class='outer' border='0' cellspacing='1'>\n";
    echo "<tr><th>ID</th><th>"._AM_FORM_TITLE."</th><th>"._AM_MSG_COUNT."</th><th>"._AM_MSG_WAIT."</th><th>"._AM_MSG_WORK."</th><th>"._AM_MSG_REPLY."</th><th>"._AM_MSG_CLOSE."</th><th>"._AM_OPERATION."</th></tr>\n";
    $n = 0;
    $mbase = XOOPS_URL."/modules/$dirname";
    $ancfmt = "<td class='num'><a href='msgadm.php?stat=%s&formid=%d'>%d</a></td>\n";
    $msgs = array('- a b c'=>'nmes', '-'=>'nwait', 'a'=>'nwork',
		  'b'=>'nreply', 'c'=>'nclose');
    while ($data = $xoopsDB->fetchArray($res)) {
	$id = $data['formid'];
	$title = htmlspecialchars($data['title']);
	$url = "$mbase?form=$id";
	$form = $url.($data['priuid']<0?"&amp;uid=".$xoopsUser->getVar('uid'):"");
	$bg = $n++%2?'even':'odd';
	$ope = "<a href='?formid=$id'>"._EDIT."</a>".
	    " | <a href='?op=delete&formid=$id'>"._DELETE."</a>".
	    " | <a href='$mbase/reception.php?form=$id'>"._AM_DETAIL."</a>";
	echo "<tr class='$bg'><td>$id</td>
<td><a href='$form' target='preview'>$title</a></td>";
	foreach ($msgs as $stat=>$name) {
	    printf($ancfmt, urlencode($stat), $id, $data[$name]);
	}
	echo "<td>$ope</td></tr>\n";
    }
    echo "</table><hr/>\n";
    return true;
}

function build_form($formid=0) {
    global $xoopsDB, $xoopsUser, $myts, $fields, $xoopsConfig;
    include_once dirname(dirname(__FILE__))."/language/".$xoopsConfig['language'].'/main.php';
    if (isset($_POST['formid'])) {
	$data = array();
	$fields[] = 'priuid';
	$fields[] = 'cgroup';
	foreach ($fields as $name) {
	    $data[$name] = $myts->stripSlashesGPC($_POST[$name]);
	}
	$data['grpperm'] = $_POST['grpperm'];
	$formid = intval($_POST['formid']);
	// form preview
	$items = get_form_attribute($data['defs']);
	assign_form_widgets($items);
	if ($_POST['preview']) {
	    echo "<h2>"._PREVIEW." : ".htmlspecialchars($data['title'])."</h2>\n";
	    echo "<div class='preview'>\n";
	    if ($data['custom']) {
		$data['check_script'] = "";
		$data['formid'] = $formid;
		echo custom_template($data, $items);
	    } else {
		echo $myts->displayTarea($data['description']);
		echo "<form><table class='outer' cellspacing='1' border='0'>\n";
		foreach ($items as $n=>$item) {
		    $bg = $n%2?'even':'odd';
		    if (empty($item['label'])) {
			echo "<tr class='$bg'><td colspan='2'>".$item['comment']."</td></tr>\n";
		    } else {
			echo "<tr class='$bg'><td class='head'>".$item['label']."</td><td>".$item['input'].$item['comment']."</td></tr>\n";
		    }
		}
		echo '</table><p style="text-align: center;"><input type="submit" value="'._SUBMIT.'" disabled="disabled"/></p>';
		echo "\n</form>";
	    }
	    echo "</div>\n<hr size='5'/>\n";
	}
    } elseif ($formid) {
	$res = $xoopsDB->query('SELECT * FROM '.FORMS." WHERE formid=$formid");
	$data = $xoopsDB->fetchArray($res);
	$data['grpperm'] = explode('|', trim($data['grpperm'], '|'));
    } else {
	$data = array('title'=>'', 'description'=>'', 'defs'=>'',
		      'store'=>1, 'custom'=>0, 'weight'=>0, 'active'=>1,
		      'priuid'=>$xoopsUser->getVar('uid'),
		      'cgroup'=>XOOPS_GROUP_ADMIN,
		      'redirect'=>'',
		      'grpperm'=>array(XOOPS_GROUP_USERS));
    }
    $form = new XoopsThemeForm($formid?_AM_FORM_EDIT:_AM_FORM_NEW, 'myform', 'index.php');
    $form->addElement(new XoopsFormHidden('formid', $formid));
    $form->addElement(new XoopsFormText(_AM_FORM_TITLE, 'title', 35, 80, $data['title']), true);
    if (!empty($data['mtime'])) $form->addElement(new XoopsFormLabel(_AM_FORM_MTIME, formatTimestamp($data['mtime'])));
    $desc = new XoopsFormElementTray(_AM_FORM_DESCRIPTION, "<br/>");
    $description = $data['description'];
    $desc->addElement(new XoopsFormDhtmlTextArea('', 'description', $description));
    $button = new XoopsFormButton('', 'ins_tpl', _AM_INS_TEMPLATE);
    $button->setExtra("onClick=\"myform.description.value += defsToString();\"");
    $desc->addElement($button);
    if ($data['custom']) {
	$error = check_form_tags($data['defs'], $description);
	if ($error) $desc->addElement(new XoopsFormLabel('', "<div style='color:red;'>$error</div>"));
    }
    $form->addElement($desc);
    $custom = new XoopsFormSelect(_AM_FORM_CUSTOM, 'custom' , $data['custom']);
    $custom->setExtra(' onChange="myform.ins_tpl.disabled = (this.value==0);"');
    $custom->addOptionArray(array(_AM_CUSTOM_NONE, _AM_CUSTOM_TPL_BLOCK,
				  _AM_CUSTOM_TPL_FULL, _AM_CUSTOM_TPL_FRAME));
    $form->addElement($custom);
    $grpperm = new XoopsFormSelectGroup(_AM_FORM_ACCEPT_GROUPS, 'grpperm', true, $data['grpperm'], 4, true);
    $grpperm->setDescription(_AM_FORM_ACCEPT_GROUPS_DESC);
    $form->addElement($grpperm);
    $defs = new XoopsFormTextArea(_AM_FORM_DEFS, 'defs', $data['defs']);
    $defs->setDescription(_AM_FORM_DEFS_DESC);
    $form->addElement($defs);

    $member_handler =& xoops_gethandler('member');
    $groups = $member_handler->getGroupList(new Criteria('groupid', XOOPS_GROUP_ANONYMOUS, '!='));
    $options = array();
    foreach ($groups as $k=>$v) {
	$options[-$k] = sprintf(_AM_FORM_PRIM_GROUP, $v);
    }
    $options[0] = _AM_FORM_PRIM_NONE;

    $priuid = new MyFormSelect(_AM_FORM_PRIM_CONTACT, 'priuid', $data['priuid']);
    $priuid->addOptionArray($options);
    $priuid->addOptionUsers($data['cgroup']);
    $priuid->setDescription(_AM_FORM_PRIM_DESC);
    $form->addElement($priuid) ;

    $cgroup = new XoopsFormSelect('', 'cgroup', $data['cgroup']);
    $cgroup->setExtra(' onChange="setSelectUID(\'priuid\', 0);"');
    $cgroup->addOption(0, _AM_FORM_CGROUP_NONE);
    $groups = $member_handler->getGroupList(new Criteria('groupid', XOOPS_GROUP_ANONYMOUS, '!='));
    $cgroup->addOptionArray($groups);

    $cgroup_tray = new XoopsFormElementTray(_AM_FORM_CONTACT_GROUP);
    $cgroup_tray->addElement($cgroup) ;
    $cgroup_tray->addElement(new XoopsFormLabel('' , '<noscript><input type="submit" name="chggrp" id="chggrp" value="'._AM_CHANGE.'"/></noscript>'));

    $form->addElement($cgroup_tray) ;

    $form->addElement(new XoopsFormRadioYN(_AM_FORM_STORE, 'store' , $data['store']));
    $form->addElement(new XoopsFormRadioYN(_AM_FORM_ACTIVE, 'active' , $data['active']));

    $form->addElement(new XoopsFormText(_AM_FORM_WEIGHT, 'weight', 2, 8, $data['weight']));
    $form->addElement(new XoopsFormText(_AM_FORM_REDIRECT, 'redirect', 50, 128, $data['redirect']));
    $submit = new XoopsFormElementTray('');
    $submit->addElement(new XoopsFormButton('' , 'formdefs', _SUBMIT, 'submit'));
    $submit->addElement(new XoopsFormButton('' , 'preview', _PREVIEW, 'submit'));
    $form->addElement($submit) ;

    echo "<a name='form'></a>";
    $form->display();
    echo '<script language="JavaScript">'.
	$priuid->renderSupportJS(false).
'function defsToString() {
    value = window.document.myform.defs.value;
    ret = "";
    lines = value.split("\\n");
    conf = "'._MD_CONF_LABEL.'";
    for (i in lines) {
       lab = lines[i].replace(/,.*$/, "");
       if (lab.match(/^\s*#/)) {
           ret += "[desc]<div>"+lines[i].replace(/^\s*#/, "")+"</div>[/desc]\n";
       } else if (lab != "") {
           ret += "<div>"+lab+": {"+lab.replace(/\\*?$/,"")+"}</div>\n";
           if (lines[i].match(/^[^,]+,\\s*mail/i)) {
              lab = conf.replace(/%s/, lab);
              ret += "[desc]<div>"+lab+": {"+lab.replace(/\\*?$/,"")+"}</div>[/desc]\n";
           }
       }
    }
    return "<form {FORM_ATTR}>\n"+ret+
      "<p>{SUBMIT} {BACK}</p>\n</form>\n{CHECK_SCRIPT}";
}

document.myform.ins_tpl.disabled = (document.myform.custom.value==0);
</script>
';
}
?>