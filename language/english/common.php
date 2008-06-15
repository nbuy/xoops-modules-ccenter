<?php
// $Id: common.php,v 1.3 2008/06/15 13:57:15 nobu Exp $
// common user and admin

// message status
define('_CC_STATUS','Status');

define('_CC_STATUS_NONE','None');
define('_CC_STATUS_ACCEPT','Accept');
define('_CC_STATUS_REPLY','Reply');
define('_CC_STATUS_CLOSE','Close');
define('_CC_STATUS_DEL','Delete');

define('_CC_SORT_ORDER','Order');
define('_CC_USER_NONE','None');

define('_CC_FORM_PRIM_GROUP', 'Member [%s]');
define('_CC_LOG_STATUS','Status: from "%s" to "%s"');
define('_CC_LOG_TOUSER','Charge: from "%s" to "%s"');
define('_CC_LOG_COMMENT','Post comment');
define('_CC_LOG_BYCHARGE',':charge');
define('_CC_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');

define('_CC_EXPORT_THIS_MONTH','This month');
define('_CC_EXPORT_LAST_MONTH','Last month');
define('_CC_EXPORT_THIS_YEAR','This year');
define('_CC_EXPORT_LAST_YEAR','Last year');
define('_CC_EXPORT_ALL','All');
define('_CC_MARK_READIT','[x]');

define('_CC_STORE_MODE','Store information=1,Logging only=0,Never store=2');
?>
