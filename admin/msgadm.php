<?php
// adminstration messages
include '../../../include/cp_header.php';
include '../functions.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once 'myformselect.php';

$myts =& MyTextSanitizer::getInstance();
$op = isset($_REQUEST['op'])?$myts->stripSlashesGPC($_REQUEST['op']):'';

if (isset($_POST['store'])) {
    $msgid = intval($_POST['msgid']);
    $touid = intval($_POST['touid']);
    $stat = $myts->stripSlashesGPC($_POST['status']);
    $res = $xoopsDB->query("SELECT * FROM ".CCMES." WHERE msgid=".$msgid);
    $back = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"msgadm.php";
    if ($res && $xoopsDB->getRowsNum($res)==1) {
	$data = $xoopsDB->fetchArray($res);
	$sets = array();
	$log = '';
	if ($data['status'] != $stat) {
	    $sets[] = 'status='.$xoopsDB->quoteString($stat);
	    $log .= sprintf(_CC_LOG_STATUS, $msg_status[$data['status']], $msg_status[$stat]);
	}
	if ($data['touid'] != $touid) {
	    $sets[] = 'touid='.$touid;
	    if ($log) $log .= "\n";
	    $log .= sprintf(_CC_LOG_TOUSER, ccUname($data['touid']), ccUname($touid));
	} else {
	    $touid = 0;		// not changed
	}
	if (count($sets)) {
	    $sets[] = 'mtime='.time();
	    $res = $xoopsDB->query("UPDATE ".CCMES." SET ".join(",", $sets)." WHERE msgid=".$msgid);
	    if ($res && $touid) { // switch person in charge
		$notification_handler =& xoops_gethandler('notification');
		$notification_handler->subscribe('message', $msgid, 'comment', null, null, $touid);
		$notification_handler->subscribe('message', $msgid, 'status', null, null, $touid);
	    }
	    cc_log_message($data['fidref'], $log, $msgid);
	    redirect_header($back, 1, _AM_MSG_UPDATED);
	    exit;
	}
    }
    redirect_header($back, 3, _AM_MSG_UPDATE_FAIL);
    exit;
} elseif (!empty($op)) {
    $uid = $xoopsUser->getVar('uid');
    foreach ($_POST['ids'] as $msgid) {
	change_message_status(intval($msgid), 0, $op);
    }
    $back = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"msgadm.php";
    redirect_header($back, 1, _AM_MSG_UPDATED);
    exit;
}

xoops_cp_header();

include "mymenu.php";

if (empty($_GET['msgid'])) msg_list();
else msg_detail(intval($_GET['msgid']));

xoops_cp_footer();

function msg_list() {
    global $msg_status, $xoopsDB, $xoopsUser, $xoopsModuleConfig, $xoopsModule, $myts;

    $labels=array('mtime'=>_AM_FORM_MTIME, 'status'=>_AM_MSG_STATUS,
		  'fidref'=>_AM_FORM_TITLE, 'cfrom'=>_AM_MSG_FROM,
		  'uname'=>_AM_MSG_CHARGE, 'comms'=>_AM_MSG_COMMS,
		  'ope'=>_AM_OPERATION);
    $orders=array('mtime'=>'ASC', 'fidref'=>'ASC', 'uname'=>'ASC',
		  'status'=>'ASC', 'uid'=>'ASC', 'orders'=>array('mtime'));

    $listctrl = new ListCtrl('msgadm', $orders);
    
    $start = isset($_GET['start'])?intval($_GET['start']):0;
    $search = isset($_GET['q'])?$myts->stripSlashesGPC($_GET['q']):'';
    $max = $xoopsModuleConfig['max_lists'];

    $users = $xoopsDB->prefix('users');
    $comms = $xoopsDB->prefix('xoopscomments');
    $mid = $xoopsModule->getVar('mid');
    $sql0 = "FROM ".CCMES." m LEFT JOIN ".FORMS." ON fidref=formid 
LEFT JOIN $users u ON touid=u.uid LEFT JOIN $users f ON m.uid=f.uid";
    $sql1 = "LEFT JOIN $comms ON com_modid=$mid AND com_itemid=msgid";
    $sql2 = "WHERE ".$listctrl->sqlcondition();
    $formid = isset($_REQUEST['formid'])?intval($_REQUEST['formid']):0;
    if ($formid) $sql2 .= " AND fidref=$formid";
    if ($search) $sql2 .= " AND CONCAT(body,' ',m.email) like ".$xoopsDB->quoteString("%$search%");

    $res = $xoopsDB->query("SELECT count(msgid) $sql0 $sql2");
    list($total) = $xoopsDB->fetchRow($res);
    $args = $formid?"formid=$formid":"";
    $nav = new XoopsPageNav($total, $max, $start, "start", $args);

    $res = $xoopsDB->query("SELECT m.*,title,u.uname, f.uname cfrom, count(com_id) comms $sql0 $sql1 $sql2 GROUP BY msgid".$listctrl->sqlorder(), $max, $start);
    echo "<style>td.num { text-align: right; }</style>\n";
    echo "<h2>"._AM_MSG_ADMIN."</h2>\n";
    echo "<table class='ccinfo' width='100%'>\n<tr><td width='30%'>"._AM_MSG_COUNT." $total</td>\n";
    echo "<td align='center'>".$nav->renderNav()."</td>\n";
    echo "<td align='right' width='30%'>
  <form method='get'>"._SEARCH."
    <input name='q' value=\"".htmlspecialchars($search).'" size="8" /> &nbsp; '.
	_CC_STATUS." ".$listctrl->renderStat()."
      <noscript> <input type='submit' type='submit' value='"._AM_SUBMIT_VIEW."'></noscript>
  </form>
</td></tr>\n";
    echo "</table>\n";

    if ($res && $xoopsDB->getRowsNum($res)) {
	$sorts = array('mtime', 'status', 'fidref', 'touid', 'comms');
	echo "<form method='post' name='msglist'>\n";
	echo "<table class='outer' border='0' cellspacing='1'>\n";
	echo "<tr><th><input type='checkbox' id='checkall' name='checkall' onClick='xoopsCheckAll(\"msglist\", \"checkall\");'/>";
	foreach ($listctrl->getLabels($labels) as $lab) {
	    if (isset($lab['value'])) {
		$extra = empty($lab['extra'])?'':$lab['extra'];
		$args = $lab['name']."=".$lab['next'];
		$anc = " <a href='?$args' title='"._CC_SORT_ORDER."'$extra><img src='../images/".$lab['value'].".gif'></a>";
	    } else $anc = '';
		
	    echo "<th>".$lab['text']."$anc</th>\n";
	}
	echo "</tr>\n";
	$n = 0;
	$dirname = basename(dirname(dirname(__FILE__)));
	$mbase = XOOPS_URL."/modules/$dirname";
	$strcut = (XOOPS_USE_MULTIBYTES && function_exists('mb_strcut'))?'mb_strcut':'substr';
	if (!function_exists('easiestml')) { /* XXX: support multi lang site */
	    function easiestml($text) { return $text; }
	} else {
	    $GLOBALS['easiestml_lang'] = substr($GLOBALS['xoopsConfig']['language'], 0, 2);
	}
	while ($data = $xoopsDB->fetchArray($res)) {
	    $id = $data['msgid'];
	    $title = easiestml(htmlspecialchars($data['title']));
	    $stat = $data['status'];
	    $url = "$mbase/message.php?id=$id";
	    $msg = $url.($data['touid']<0?"&amp;uid=".$xoopsUser->getVar('uid'):"");
	    $bg = $n++%2?'even':'odd';
	    $date = myTimestamp($data['mtime'], "m", _AM_TIME_UNIT);
	    $priuname = empty($data['uname'])?_AM_FORM_PRIM_NONE:htmlspecialchars($data['uname']);
	    $from = empty($data['uid'])?$data['email']:htmlspecialchars($data['cfrom']);
	    $box = "<input type='checkbox' name='ids[]' value='$id'/>";
	    $ope = "<a href='$msg'>"._AM_DETAIL."</a>";
	    $ope .= " | <a href='?msgid=$id'>"._EDIT."</a>";
	    $vals = unserialize_text($data['body']);
	    $fval = preg_replace('/[\n\r].*$/', '...', array_shift($vals));
	    $slen = 30;
	    if (strlen($fval)>$slen) {
		$fval = preg_replace('/\.\.\.$/', '', $fval);
		$fval = $strcut($fval, 0, $slen)."...";
	    }
	    $readit = $data['mtime']<$data['atime']?_CC_MARK_READIT:'';
	    echo "<tr class='$bg stat$stat'><td align='center'>$box</td><td>$date</td><td>".$msg_status[$stat].$readit."</td><td>$title: $fval</td><td>$from</td><td>$priuname</td><td class='num'>".$data['comms']."</td><td>$ope</td></tr>\n";
	}
	echo "</table>\n";
	echo "<div>"._AM_MSG_CHANGESTATUS." <select name='op'><option></option>\n";
	foreach ($msg_status as $k=>$v) {
	    echo "<option value='$k'>$v</option>\n";
	}
	echo "</select>\n";
	echo "<input type='submit' value='"._AM_SUBMIT."'/>";
	echo "</div>\n";
	echo "</form>\n";
    } else {
	echo _AM_NODATA;
    }
}

function select_widget($name, $sel, $def) {
    $input = "<select name='$name' id='$name'>\n";
    foreach ($sel as $id=>$lab) {
	$ck = $def==$id?' selected="selected"':'';
	$input .= "<option value='$id'$ck>$lab</option>\n";
    }
    $input .= "</select>";
    return $input;
}

function msg_detail($msgid) {
    global $xoopsDB, $msg_status, $myts;
    $users = $xoopsDB->prefix('users');
    $res = $xoopsDB->query("SELECT m.*,title,priuid,u.uname,cgroup,f.uname cfrom FROM ".CCMES." m LEFT JOIN ".FORMS." ON fidref=formid LEFT JOIN $users u ON touid=u.uid LEFT JOIN $users f ON m.uid=f.uid WHERE msgid=$msgid");
    $data = $xoopsDB->fetchArray($res);
    $data['stat'] = $msg_status[$data['status']];
    $data['cdate'] = formatTimestamp($data['ctime'], 'm');
    $data['mdate'] = myTimestamp($data['mtime'], 'm', _AM_TIME_UNIT);
    $labs = array('title'=>_AM_FORM_TITLE, 'uid'=>_AM_MSG_FROM,
		  'stat'=>_AM_MSG_STATUS, 'cdate'=>_AM_MSG_CTIME, 
		  'mdate'=>_AM_MSG_MTIME, 'uname'=>_AM_MSG_CHARGE);
    $touid = false;
    echo "<h2>"._AM_MSG_ADMIN."</h2>\n";
    echo "<form method='post'>\n";
    echo "<input type='hidden' name='msgid' value='$msgid'/>\n";
    echo "<table class='ccinfo' cellspacing='1' width='100%'>\n";
    $n = 0;
    $upage = "../message.php?id=$msgid";
    foreach ($labs as $k=>$lab) {
	$bg = ($n++%2)?'even':'odd';
	$val = htmlspecialchars($data[$k]);
	switch($k) {
	case 'title':
	    $val = "<a href='$upage'>$val</a>\n";
	    break;
	case 'uid':
	    if ($val>0) {
		$val = "<a href='".XOOPS_URL."/userinfo.php?uid=$val'>".htmlspecialchars($data['cfrom'])."</a>";
	    } else {
		if ($data['email']) {
		    $val = htmlspecialchars($data['email']);
		    $val = "<a href='mailto:$val'>$val</a>";
		} else {
		    $val = _CC_USER_NONE;
		}
	    }
	    break;
	case 'stat':
	    $val = select_widget('status', $msg_status, $data['status']);
	    break;
	case 'uname':
	    $touid = new MyFormSelect(_AM_FORM_PRIM_CONTACT, 'touid', $data['touid']);
	    $gid = ($data['priuid']<0)?-$data['priuid']:$data['cgroup'];
	    $touid->addOption('0', _AM_FORM_PRIM_NONE);
	    $touid->addOptionUsers($gid);
	    $val = $touid->render()."\n<input type='hidden' name='cgroup' id='cgroup' value='$gid'/>\n";
	    break;
	default:
	}
	echo "<tr><th>$lab</th><td>$val</td></tr>\n";
    }
    echo "<tr><th></th><td><input type='submit' name='store' value='"._AM_SUBMIT."'/></td></tr>\n";
    echo "</table>\n";
    echo "</from><br/>\n";
    if (!empty($touid)) {
	echo $touid->renderSupportJS();
    }
    echo "<table class='outer' cellspacing='1'>\n";
    $n = 0;
    foreach (unserialize_text($data['body']) as $k=>$v) {
	$bg = $n++%2?'even':'odd';
	$k = htmlspecialchars($k);
	$v = nl2br(htmlspecialchars($v));
	echo "<tr><td class='head'>$k</td><td class='$bg'>$v</td></tr>\n";
    }
    echo "</table>\n";

    $res = $xoopsDB->query("SELECT l.*,uname FROM ".CCLOG." l LEFT JOIN ".$xoopsDB->prefix('users')." ON euid=uid WHERE midref=$msgid ORDER BY logid DESC");
    $log = array();
    echo '<a id="logging"></a><h3>'._AM_LOGGING."</h3>\n";

    if ($xoopsDB->getRowsNum($res)) {
	$anon = $GLOBALS['xoopsConfig']['anonymous'];
	echo "<table>\n";
	$reg = array('/\(comid=(\d+)\)/');
	$rep = array('(<a href="'.$upage.'#comment\1">comid=\1</a>)');
	while ($data = $xoopsDB->fetchArray($res)) {
	    $uname = htmlspecialchars(empty($data['uname'])?$anon:$data['uname']);
	    $comment = preg_replace($reg, $rep,
				    $myts->displayTarea($data['comment']));
	    echo "<tr><td nowrap>".formatTimestamp($data['ltime'])."</td><td nowrap>".
		"[$uname]</td><td width='100%'>$comment</td></tr>\n";
	}
	echo "</table>\n";
    } else {
	echo _AM_NODATA;
    }
}

function ccUname($uid) {
    if ($uid<=0) return _CC_USER_NONE;
    return XoopsUser::getUnameFromId($uid);
}
?>