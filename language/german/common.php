<?php
// $Id: common.php,v 1.1 2009/07/02 01:57:48 nobu Exp $
// common user and admin

// message status
define('_CC_STATUS','Status');

define('_CC_STATUS_NONE','Kein');
define('_CC_STATUS_ACCEPT','Angenommen');
define('_CC_STATUS_REPLY','Geantwortet');
define('_CC_STATUS_CLOSE','Geschlossen');
define('_CC_STATUS_DEL','Gelöscht');

define('_CC_SORT_ORDER','Reihenfolge');
define('_CC_USER_NONE','Kein');

define('_CC_FORM_PRIM_GROUP', 'Mitglied [%s]');
define('_CC_LOG_STATUS','Status: von "%s" zu "%s"');
define('_CC_LOG_TOUSER','Verantwortlicher: von "%s" zu "%s"');
define('_CC_LOG_COMMENT','Kommentar schreiben');
define('_CC_LOG_BYCHARGE',': Verantwortlicher');
define('_CC_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');

define('_CC_EXPORT_THIS_MONTH','Diesen Monat');
define('_CC_EXPORT_LAST_MONTH','Letzten Monat');
define('_CC_EXPORT_THIS_YEAR','Dieses Jahr');
define('_CC_EXPORT_LAST_YEAR','Letztes Jahr');
define('_CC_EXPORT_ALL','Alle');
define('_CC_MARK_READIT','[x]');

define('_CC_STORE_MODE','Informationen speichern=1,Nur aufzeichnen=0,Nie speichern=2');
?>