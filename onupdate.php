<?php
# ccenter module onUpdate proceeding.
# $Id: onupdate.php,v 1.2 2007/08/06 13:54:27 nobu Exp $

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
if (add_field(MSG, "ctime", "INT DEFAULT 0 NOT NULL", "touid")) {
    $msgs[] = "&nbsp;&nbsp; Add new field: <b>ctime</b> in ccenter_message";
    // copy mtime to new ctime at first
    $xoopsDB->query("UPDATE ".MSG." SET ctime=mtime");
}

// not use now.
function add_field($table, $field, $type, $after) {
    global $xoopsDB;
    $res = $xoopsDB->query("SELECT $field FROM $table", 1);
    if (empty($res) && $xoopsDB->errno()) { // check exists
	if ($after) $after = "AFTER $after";
	$res = $xoopsDB->query("ALTER TABLE $table ADD $field $type $after");
    } else return false;
    if (!$res) {
	echo "<div class='errorMsg'>".$xoopsDB->errno()."</div>\n";
    }
    return $res;
}
?>