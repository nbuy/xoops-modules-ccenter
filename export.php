<?php
// Export data in CSV format
// $Id: export.php,v 1.7 2007/11/01 14:01:34 nobu Exp $

include "../../mainfile.php";
include "functions.php";

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}

$myts =& MyTextSanitizer::getInstance();
$id= isset($_GET['form'])?intval($_GET['form']):0;

$cond = 'formid='.$id;
if (!$xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    $cond .= ' AND (priuid='.$xoopsUser->getVar('uid').
	' OR cgroup IN ('.join(',', $xoopsUser->getGroups()).'))';
}

$res = $xoopsDB->query("SELECT formid,defs FROM ".FORMS." WHERE $cond");

if (!$res || $xoopsDB->getRowsNum($res)==0) {
    $back = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"index.php";
    redirect_header($back, 3, _NOPERM);
    exit;
}
$form = $xoopsDB->fetchArray($res);

$cond = "fidref=$id AND status<>'x'";
$range = isset($_GET['range'])?$myts->stripSlashesGPC($_GET['range']):"";
switch ($range) {
case 'm0':
    // start this month
    $ym = explode('-', formatTimestamp(time(), 'Y-m'));
    $stime = userTimeToServerTime(mktime(0, 0, 0, $ym[1], 1, $ym[0]));
    $cond .= " AND ctime>$stime";
    break;
case 'm1':
    // last month
    $ym = explode('-', formatTimestamp(time(), 'Y-m'));
    $stime = userTimeToServerTime(mktime(0, 0, 0, $ym[1]-1, 1, $ym[0]));
    $ym = explode('-', formatTimestamp(time(), 'Y-m'));
    $ltime = userTimeToServerTime(mktime(0, 0, 0, $ym[1], 1, $ym[0])-1);
    $cond .= " AND ctime BETWEEN $stime AND $ltime";
    break;
case 'y0':
    // start this year
    $ym = explode('-', formatTimestamp(time(), 'Y-m'));
    $stime = userTimeToServerTime(mktime(0, 0, 0, 1, 1, $ym[0]));
    $cond .= " AND ctime>$stime";
    break;
case 'y1':
    $ym = explode('-', formatTimestamp(time(), 'Y-m'));
    $stime = userTimeToServerTime(mktime(0, 0, 0, 0, 1, $ym[0]));
    $ym = explode('-', formatTimestamp(time(), 'Y-m'));
    $ltime = userTimeToServerTime(mktime(0, 0, 0, 1, 1, $ym[0])-1);
    $cond .= " AND ctime BETWEEN $stime AND $ltime";
    break;
default:
    $range = "all";
    break;
}

$res = $xoopsDB->query('SELECT * FROM '.CCMES." WHERE $cond ORDER BY msgid");

$items = get_form_attribute($form['defs']);
$labels = array('ID', _MD_POSTDATE, _CC_STATUS, _MD_CONTACT_FROM, _MD_CONTACT_TO);
$n = $mpos = -1;
foreach ($items as $item) {
    if (empty($item['label'])) continue;	// skip comment
    $n++;
    if ($mpos<0 && $item['type'] == 'mail') $mpos = $n;
    $labels[] = $item['label'];
}

$contents = csv_str($labels)."\n";
while ($data = $xoopsDB->fetchArray($res)) {
    $values = unserialize_text($data['body']);
    if ($mpos>=0) {
	array_splice($values, $mpos, 0, array($data['email']));
    }
    $fixval = array($data['msgid'], formatTimestamp($data['mtime']),
		    $msg_status[$data['status']],
		    $xoopsUser->getUnameFromId($data['uid']),
		    $xoopsUser->getUnameFromId($data['touid']));
    $contents .= csv_str($fixval).",".csv_str($values)."\n";
}

$tm=formatTimestamp(time(), 'Ymd');
$file = "ccenter_form$id-$range-$tm.csv";
header("Content-type: text/csv; charset="._MD_EXPORT_CHARSET);
header('Content-Disposition:attachment;filename="'.$file.'"');
header("Cache-Control: public");
header("Pragma: public");
if (function_exists("mb_convert_encoding")) {
    echo mb_convert_encoding($contents, _MD_EXPORT_CHARSET, _CHARSET);
} else {
    echo $contents;
}

exit;

function csv_str($data) {
    $vals = array();
    foreach ($data as $v) {
	$vals[] = q($v);
    }
    return join(',',$vals);
}

function q($str) {
    if (is_array($str)) {
	$str = join("\n",$str);
    }
    if (preg_match('/^-?\d*$/', $str)) return $str;
    return '"'.preg_replace('/\"/', '""', $str).'"';
}
?>