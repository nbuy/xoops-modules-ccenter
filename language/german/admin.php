<?php
// $Id: admin.php,v 1.3 2009/11/15 09:51:08 nobu Exp $

define('_AM_FORM_EDIT', 'Edit contact form');
define('_AM_FORM_NEW', 'Neues Kontaktformular erstellen');
define('_AM_FORM_TITLE', 'Name des Formulares');
define('_AM_FORM_MTIME', 'Aktualisiert');
define('_AM_FORM_DESCRIPTION', 'Beschreibung');
define('_AM_INS_TEMPLATE', 'Adding template');
define('_AM_FORM_ACCEPT_GROUPS', 'Gruppenauswahl');
define('_AM_FORM_ACCEPT_GROUPS_DESC', 'Dieses Formular kann von folgenden Gruppen benutzt werden');
define('_AM_FORM_DEFS', 'Formular Definitionen');
define('_AM_FORM_DEFS_DESC', '<a href="help.php#form" target="_blank">Definitionen</a> <small>Typen: text checkbox radio textarea select const hidden mail file</small>');
define('_AM_FORM_PRIM_CONTACT', 'Kontaktperson');
define('_AM_FORM_PRIM_NONE', 'Kein');
define('_AM_FORM_PRIM_DESC', 'WŽÃŽ¤hlen Sie die Mitglieder der Gruppe, The contact person need select by uid argument from the group');
define('_AM_FORM_CONTACT_GROUP', 'Kontaktgruppe');
define('_AM_FORM_CGROUP_NONE', 'Kein');
define('_AM_FORM_STORE', 'In der Datenbank speichern');
define('_AM_FORM_CUSTOM', 'Beschreibungstyp');
define('_AM_FORM_WEIGHT', 'Reihenfolge');
define('_AM_FORM_REDIRECT', 'Display page after sending');
define('_AM_FORM_OPTIONS', 'Optionelle Variablen');
define("_AM_FORM_OPTIONS_DESC","Voreinstellungen definieren und andere Eigenschaften <a href='help.php#attr'>Voreingestellte Optionen</a>. <br />Beispiel: <tt>size=60,rows=5,cols=50</tt>");
define('_AM_FORM_ACTIVE', 'Aktiv?');
define('_AM_DELETE_FORM', 'Formular lŽÃŽ¶schen');
define('_AM_FORM_LAB', 'Name des Feldes');
define('_AM_FORM_LABREQ', 'Please input item name');
define('_AM_FORM_REQ','Erforderlich');
define('_AM_FORM_ADD', 'HinzufŽÃŽ¼gen');
define('_AM_FORM_OPTREQ', 'Need option argument');
define('_AM_CUSTOM_DESCRIPTION', '0=Normal[bb],4=HTML Beschreibung[bb],1=Part template,2=Overall template');
define('_AM_CHECK_NOEXIST', 'Variables not exist');
define('_AM_CHECK_DUPLICATE', 'Variable duplicates');
define('_AM_DETAIL', 'Details');
define('_AM_OPERATION', 'Aktionen');
define('_AM_CHANGE','ŽÃ§Ïdern');
define('_AM_SEARCH_USER', 'Suche Benutzer');

define('_AM_MSG_ADMIN', 'Contact Admin');
define('_AM_MSG_CHANGESTATUS', 'Status ŽÃ§Ïdern');
define('_AM_SUBMIT', 'Aktualisieren');

define('_AM_MSG_COUNT', 'Anzahl');
define('_AM_MSG_STATUS', 'Status');
define('_AM_MSG_CHARGE', 'Verantwortlicher');
define('_AM_MSG_FROM', 'Von');
define('_AM_MSG_COMMS', 'Kommentare');

define('_AM_MSG_WAIT', 'Warten');
define('_AM_MSG_WORK', 'in Bearbeitung');
define('_AM_MSG_REPLY', 'Beantwortet');
define('_AM_MSG_CLOSE', 'Geschlossen');
define('_AM_MSG_DEL', 'LŽÃŽ¶schen');

define('_AM_MSG_CTIME', 'Registerd');
define('_AM_MSG_MTIME', 'Aktualisiert');

define('_AM_MSG_UPDATED', 'Status geŽÃŽ¤ndert');
define('_AM_MSG_UPDATE_FAIL', 'Aktualisierung fehlgeschlagen');

define('_AM_LOGGING','Historie');

define('_AM_FORM_UPDATED', 'Formular gespeichert');
define('_AM_FORM_DELETED', 'Formular gelŽÃŽ¶scht');
define('_AM_FORM_UPDATE_FAIL', 'Aktualisierung des Formulares fehlgeschlagen');
define('_AM_TIME_UNIT', '%d Min , %d Stunden , %d Tage , vor %s');
define('_AM_NODATA', 'Keine Daten');
define('_AM_SUBMIT_VIEW','Refresh');
define('_AM_OPTVARS_SHOW','Zeige mehr Einstellungen');
define('_AM_OPTVARS_LABEL','notify_with_email=Benachrichtigen Sie per E-Mail-Adresse angezeigt
redirect=Weiterleitung nach vorzulegen
reply_comment=Nachricht hinzuf«ägen in automatische E-Mail
reply_use_comtpl=Hinzuf«ägen Nachricht an e-Mail-Vorlage
others=Andere Variablen ("Name=Value"-Stil)
');

include_once dirname(__FILE__)."/common.php";
?>