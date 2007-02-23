<?php
// adminstration messages
include '../../../include/cp_header.php';
include '../functions.php';

$myts =& MyTextSanitizer::getInstance();
$start = isset($_GET['start'])?intval($_GET['start']):0;
$formid = isset($_GET['formid'])?intval($_GET['formid']):0;

if (isset($_POST['formid'])) {
    $formid = intval($_POST['formid']);
    $fields = array('title', 'description', 'defs', 'priuid', 'cgroup',
		    'store', 'custom');
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

xoops_cp_header();
include "mymenu.php";

include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";

if ($formid==0) list_forms();

build_form($formid);

xoops_cp_footer();

function list_forms() {
    global $xoopsDB;
    $dirname = basename(dirname(dirname(__FILE__)));
    $res = $xoopsDB->query("SELECT formid, title,count(msgid) nmes FROM ".FORMS." LEFT JOIN ".MESSAGE." ON fidref=formid GROUP BY formid");
    if (!$res || $xoopsDB->getRowsNum($res)==0) return false;
    echo "<table class='outer' border='0' cellspacing='1'>\n";
    echo "<tr><th>ID</th><th>"._AM_FORM_TITLE."</th><th>"._AM_MESG_COUNT."</th><th></th></tr>\n";
    $n = 0;
    while ($data = $xoopsDB->fetchArray($res)) {
	$id = $data['formid'];
	$title = htmlspecialchars($data['title']);
	$url = XOOPS_URL."/modules/$dirname/?form=".$id;
	$bg = $n++%2?'even':'odd';
	echo "<tr class='$bg'><td>$id</td><td><a href='$url' target='preview'>$title</a></td><td align='right'>".$data['nmes']."</td><td><a href='?formid=$id'>"._EDIT."</a></td></tr>\n";
    }
    echo "</table>\n<hr/>\n";
    return true;
}

function build_form($formid=0) {
    global $xoopsDB, $xoopsUser;
    $start = isset($_GET['start'])?intval($_GET['start']):0;
    if ($formid) {
	$res = $xoopsDB->query('SELECT * FROM '.FORMS." WHERE formid=$formid");
	$data = $xoopsDB->fetchArray($res);
	$data['grpperm'] = explode('|', trim($data['grpperm'], '|'));
    } else {
	$data = array('title'=>'', 'description'=>'', 'defs'=>'',
		      'store'=>1, 'custom'=>0,
		      'priuid'=>$xoopsUser->getVar('uid'), 'cgroup'=>0,
		      'grpperm'=>array(XOOPS_GROUP_USERS));
    }
    $form = new XoopsThemeForm($formid?_AM_FORM_EDIT:_AM_FORM_NEW, 'myform', 'index.php');
    $form->addElement(new XoopsFormHidden('formid', $formid));
    $form->addElement(new XoopsFormText(_AM_FORM_TITLE, 'title', 35, 80, $data['title']));
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
    $custom->addOptionArray(array(_AM_CUSTOM_NONE, _AM_CUSTOM_TPL_BLOCK,_AM_CUSTOM_TPL_FULL));
    $form->addElement($custom);
    $grpperm = new XoopsFormSelectGroup(_AM_FORM_ACCEPT_GROUPS, 'grpperm', true, $data['grpperm'], 4, true);
    $grpperm->setDescription(_AM_FORM_ACCEPT_GROUPS_DESC);
    $form->addElement($grpperm);
    $form->addElement(new XoopsFormTextArea(_AM_FORM_DEFS, 'defs', $data['defs']));

    $priuid = new XoopsFormSelect(_AM_FORM_PRIM_CONTACT, 'priuid', $data['priuid']);
    $options = array("0"=>_AM_FORM_PRIM_NONE);
    $cond = empty($xoopsModuleConfig['mod_group'])?"":
	" AND groupid IN (".join(',', $xoopsModuleConfig['mod_group']).")";
    $res = $xoopsDB->query("SELECT u.uid, uname
FROM ".$xoopsDB->prefix("groups_users_link")." l, ".$xoopsDB->prefix("users")."
 u WHERE l.uid=u.uid $cond GROUP BY u.uid ORDER BY uname", 100, $start);
    while (list($uid, $uname) = $xoopsDB->fetchRow($res)) {
	$options["$uid"] = htmlspecialchars($uname);
    }
    $priuid->addOptionArray($options);
    $form->addElement($priuid) ;

    $cgroup = new XoopsFormSelect(_AM_FORM_CONTACT_GROUP, 'cgroup', $data['cgroup']);
    $cgroup->addOption(0, _AM_FORM_CGROUP_NONE);
    $member_handler =& xoops_gethandler('member');
    $cgroup->addOptionArray($member_handler->getGroupList(new Criteria('groupid', XOOPS_GROUP_ANONYMOUS, '!=')));
    $form->addElement($cgroup) ;

    $form->addElement(new XoopsFormRadioYN(_AM_FORM_STORE, 'store' , $data['store']));

    $form->addElement(new XoopsFormButton('' , 'domain', _SUBMIT, 'submit')) ;

    $form->display();
    echo '<script>
function defsToString() {
    value = window.document.myform.defs.value;
    ret = "";
    lines = value.split("\\n");
    re = new RegExp(",.*$");
    ar = new RegExp("\\\\*?$");
    for (i in lines) {
       lab = lines[i].replace(re, "");;
       if (lab != "" ) {
           ret += "<div>"+lab+": {"+lab.replace(ar,"")+"}</div>\n";
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