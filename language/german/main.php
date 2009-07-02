<?php
// $Id: main.php,v 1.1 2009/07/02 01:57:48 nobu Exp $

define('_MD_EVALS','Evaluate');
define('_MD_COUNT','Anzahl');

define('_MD_CONF_LABEL','%s bestätigen');
define('_MD_CONF_DESC','<br />Bitte zur Bestätigung erneut eingeben.');

define('_MD_SUBMIT','Änderungen speichern');
define('_MD_SUBMIT_CONF','Vorschau');
define('_MD_SUBMIT_SEND','Absenden');
define('_MD_SUBMIT_EDIT','Erneut bearbeiten');
define('_MD_SUBMIT_VIEW','Refresh');

define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_ORDER_NOTE', _MD_REQUIRE_MARK.' wird benötigt');
define('_MD_REQUIRE_ERR', ' Dieses Feld wird benötigt, bitte ausfüllen.');
define('_MD_NUMITEM_ERR', 'Bitte Nummern eingeben');
define('_MD_ADDRESS_ERR', 'Email Adresse eingeben');
define('_MD_REGEXP_ERR', 'Bitte das korrekte Format eingeben');
define('_MD_CONFIRM_ERR', 'Input value is mismatched');

define('_MD_CCENTER_CHARGE','Kontakte an mich');
define('_MD_CCENTER_QUERY','Meine Nachrichten');
define('_MD_CCENTER_RECEPTION','Staff desk');
define('_MD_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');
define('_MD_NOTIFY_URL','Diese Nachricht wurde gesendet von der folgenden URL:');
define('_MD_CONTACT_DONE','Nachricht wurde gesendet, vielen Dank.');
define('_MD_CONTACT_COMMENT','Comment to message');
define('_MD_CONTACT_FORM','Formularname');
define('_MD_CONTACT_FROM','Kunde');
define('_MD_CONTACT_TO','Verantwortlicher');
define('_MD_CONTACT_NOTYET','Kein');
define('_MD_CONTACT_MYSELF','I do');
define('_MD_FORM_INACTIVE','Not use this form');
define('_MD_NOFORMS','Es gibt keine Formulare');
define('_MD_DETAIL','Details');
define('_MD_MSG_ADMIN', 'Management');
define('_MD_TIME_UNIT', '%d Min , %d Stunde , %d Tage , vor %s');

define('_MD_USER_EVAL','Evaluate by client');
define('_MD_POSTDATE','Geschrieben am');
define('_MD_MODDATE','Aktualisiert');
define('_MD_ATTACHMENT','Attachment');
define('_MD_MSG_READTHIS','Gelesen');
define('_MD_MSG_NOTREAD','Nicht gelesen');
define('_MD_EVAL_THANKYOU','Thank you, Evaluating.');
define('_MD_EVAL_VALUE','This contact response evaluation');
define('_MD_EVAL_DESC','Contact us to be satisfied with the answers you? Your assessment, if you will respond to comments and please specify. If you have any further questions, the answers to comment "reply" to please.');
define('_MD_EVAL_COMMENT','Evaluate Comment');
define('_MD_EVAL_SUBMIT','Send Evaluate');
define('_MD_EVAL_DATE','Evaluated');
define('_MD_BYTE_UNIT','Bytes');

define('_MD_UPDATE_STATUS','Status der Nachricht aktualisiert');
define('_MD_UPDATE_FAILED','Aktualisierung des Status der Nachricht fehlgeschlagen');
define('_MD_NODATA','NO messages');

define('_MD_EVAL_VAL_LOW','worth');
define('_MD_EVAL_VAL_MID','usual');
define('_MD_EVAL_VAL_MAX','best');

define("_MD_EXPORT_CHARSET", "UTF-8");
define('_MD_EXPORT_CSV','CSV Format');
define('_MD_EXPORT_RANGE','Auswahl');

include_once dirname(__FILE__)."/common.php";
?>