<?php
# ccenter module onUpdate proceeding.
# $Id: onupdate.php,v 1.3 2008/06/01 13:54:23 nobu Exp $

global $xoopsDB;

// ccenter_log table add in 0.72 later
define('LOG', $xoopsDB->prefix('ccenter_log'));
define('MSG', $xoopsDB->prefix('ccenter_message'));

// add logging (after ccenter-0.80)
$xoopsDB->query('SELECT * FROM '.LOG, 1);
if ($xoopsDB->errno()) { // check exists
    $msgs[] = "Update Database...";
    $msgs[] = "&nbsp;&nbsp; Add new table: <b>ccenter_log</b>";
    
    $xoopsDB->query("CREATE TABLE ".LOG." (
  logid  int(8) unsigned NOT NULL auto_increment,
  ltime  int(10) NOT NULL default '0',
  fidref int(8) NOT NULL default '0',
  midref int(8) NOT NULL default '0',
  euid int(8) NOT NULL default '0',
  comment tinytext,
  PRIMARY KEY  (logid)
)");
}

// add create time fields (after ccenter-0.80)
add_field(MSG, "ctime", "INT DEFAULT 0 NOT NULL", "touid");
// add access time fields (after ccenter-0.87)
if (add_field(MSG, "atime", "INT DEFAULT 0 NOT NULL", "mtime")) {
    // last access initially same as ctime
    $xoopsDB->query("UPDATE ".MSG." SET atime=ctime");
}

function add_field($table, $field, $type, $after) {
    global $xoopsDB;
    $res = $xoopsDB->query("SELECT $field FROM $table", 1);
    if (empty($res) && $xoopsDB->errno()) { // check exists
	if ($after) $after = "AFTER $after";
	$res = $xoopsDB->query("ALTER TABLE $table ADD $field $type $after");
    } else return false;
    report_message(" Add new field: <b>$table.$field</b>");
    if (!$res) {
	echo "<div class='errorMsg'>".$xoopsDB->errno()."</div>\n";
    }
    return $res;
}

function report_message($msg) {
    global $msgs;		// module manager's variable
    static $first = true;
    if ($first) {
	$msgs[] = "Update Database...";
	$first = false;
    }
    $msgs[] = "&nbsp;&nbsp; $msg";
}
?>
