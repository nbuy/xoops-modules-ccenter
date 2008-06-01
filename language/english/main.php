<?php
// $Id: main.php,v 1.3 2008/06/01 13:54:23 nobu Exp $

define('_MD_EVALS','Evaluate');
define('_MD_COUNT','Count');

define('_MD_CONF_LABEL','Confirm %s');
define('_MD_CONF_DESC','<br />Please input one more time for confirm.');

define('_MD_SUBMIT','Save changes');
define('_MD_SUBMIT_CONF','Confirm');
define('_MD_SUBMIT_SEND','Submit this');
define('_MD_SUBMIT_EDIT','Edit Again');
define('_MD_SUBMIT_VIEW','Refresh');

define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_ORDER_NOTE', _MD_REQUIRE_MARK.' is required');
define('_MD_REQUIRE_ERR', 'Need this field input');
define('_MD_NUMITEM_ERR', 'Please input numbers');
define('_MD_ADDRESS_ERR', 'Please input EMAIL address');
define('_MD_REGEXP_ERR', 'Please input correct format');
define('_MD_CONFIRM_ERR', 'Input value is mismatched');

define('_MD_CCENTER_CHARGE','Contact for me');
define('_MD_CCENTER_QUERY','My Messages');
define('_MD_CCENTER_RECEPTION','Staff desk');
define('_MD_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');
define('_MD_NOTIFY_URL','This message reference to following URL:');
define('_MD_CONTACT_DONE','Sending contact message');
define('_MD_CONTACT_COMMENT','Comment to message');
define('_MD_CONTACT_FORM','Form name');
define('_MD_CONTACT_FROM','Client');
define('_MD_CONTACT_TO','Charge');
define('_MD_CONTACT_NOTYET','None');
define('_MD_CONTACT_MYSELF','I do');
define('_MD_FORM_INACTIVE','Not use this form');
define('_MD_NOFORMS','There is NO forms');
define('_MD_DETAIL','Detail');
define('_MD_MSG_ADMIN', 'Management');
define('_MD_TIME_UNIT', '%dmin,%dhour,%ddays,past %s');

define('_MD_USER_EVAL','Evaluate by client');
define('_MD_POSTDATE','Posted');
define('_MD_MODDATE','Updated');
define('_MD_ATTACHMENT','Attachment');
define('_MD_MSG_READTHIS','Readed');
define('_MD_MSG_NOTREAD','No read');
define('_MD_EVAL_THANKYOU','Thank you, Evaluating.');
define('_MD_EVAL_VALUE','This contact response evaluation');
define('_MD_EVAL_DESC','Contact us to be satisfied with the answers you? Your assessment, if you will respond to comments and please specify. If you have any further questions, the answers to comment "reply" to please.');
define('_MD_EVAL_COMMENT','Evaluate Comment');
define('_MD_EVAL_SUBMIT','Send Evaluate');
define('_MD_EVAL_DATE','Evaluated');
define('_MD_BYTE_UNIT','bytes');

define('_MD_UPDATE_STATUS','Update message status');
define('_MD_UPDATE_FAILED','Update status failer');
define('_MD_NODATA','NO messages');

define('_MD_EVAL_VAL_LOW','worth');
define('_MD_EVAL_VAL_MID','usual');
define('_MD_EVAL_VAL_MAX','best');

define("_MD_EXPORT_CHARSET", "UTF-8");
define('_MD_EXPORT_CSV','CSV format');
define('_MD_EXPORT_RANGE','Range');

include_once dirname(__FILE__)."/common.php";
?>
