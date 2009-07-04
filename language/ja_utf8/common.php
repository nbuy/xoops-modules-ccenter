<?php
// $Id: common.php,v 1.1 2009/07/04 03:54:37 nobu Exp $
// common user and admin

// message status
define('_CC_STATUS','状況');

define('_CC_STATUS_NONE','受付待');
define('_CC_STATUS_ACCEPT','作業中');
define('_CC_STATUS_REPLY','応答済');
define('_CC_STATUS_CLOSE','完了');
define('_CC_STATUS_DEL','削除');

define('_CC_SORT_ORDER','並び順');
define('_CC_USER_NONE','未定義');

define('_CC_FORM_PRIM_GROUP', 'メンバ [%s]');
define('_CC_LOG_STATUS','状態を変更: "%s" → "%s"');
define('_CC_LOG_TOUSER','担当者の変更: "%s" → "%s"');
define('_CC_LOG_COMMENT','コメント投稿');
define('_CC_LOG_BYCHARGE',':担当者');
define('_CC_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');

define('_CC_EXPORT_THIS_MONTH','今月');
define('_CC_EXPORT_LAST_MONTH','先月');
define('_CC_EXPORT_THIS_YEAR','今年');
define('_CC_EXPORT_LAST_YEAR','前年');
define('_CC_EXPORT_ALL','全期間');
define('_CC_MARK_READIT','[*]');

define('_CC_STORE_MODE','内容を保存する=1,履歴のみ保存=0,全く記録しない=2');
?>
