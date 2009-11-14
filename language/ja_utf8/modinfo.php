<?php
// $Id: modinfo.php,v 1.3 2009/11/14 18:23:57 nobu Exp $
// Module Info

// The name of this module
define("_MI_CCENTER_NAME","お問合せ窓口");

// A brief description of this module
define("_MI_CCENTER_DESC","フォームを使った問い合わせの蓄積と管理");

// Sub Menu
define("_MI_CCENTER_MYCONTACT", "あなたの問合せ");
define("_MI_CCENTER_MYCHARGE", "担当問合せ");
define("_MI_CCENTER_STAFFDESK", "受付担当デスク");

// Admin Menu
define("_MI_CCENTER_FORMADMIN", "フォームの作成");
define("_MI_CCENTER_MSGADMIN", "問合せ管理");
define("_MI_CCENTER_HELP", "お問合せ窓口について");

// A brief template of this module
define("_MI_CCENTER_INDEX_TPL", "フォームの一覧");
define("_MI_CCENTER_FORM_TPL", "お問合せフォーム");
define("_MI_CCENTER_CUST_TPL", "お問合せフォーム(カスタム)");
define("_MI_CCENTER_CONF_TPL", "フォーム入力の確認");
define("_MI_CCENTER_LIST_TPL", "あなたの問合せ一覧");
define("_MI_CCENTER_CHARGE_TPL", "担当問い合わせ一覧");
define("_MI_CCENTER_MSGS_TPL", "メッセージ表示");
define("_MI_CCENTER_RECEPT_TPL", "受付担当デスク");
define("_MI_CCENTER_WIDGET_TPL", "フォーム部品");

// A brief blocks of this module
define("_MI_CCENTER_BLOCK_RECEIPT","担当問合せ");
define("_MI_CCENTER_BLOCK_FORM","お問合せフォーム");

// Configs
define("_MI_CCENTER_LISTS","一覧表示の数");
define("_MI_CCENTER_LISTS_DESC","一覧表示で表示する行数を指定する");
define("_MI_CCENTER_DEF_ATTRS","オプション既定値");
define("_MI_CCENTER_DEF_ATTRS_DESC","フォームの要素に指定する<a href='../../ccenter/admin/help.php#attr'>オプション変数</a>などを設定する。例 <tt>size=60,rows=5,cols=50</tt>");
define("_MI_CCENTER_STATUS_COMBO","状況の選択肢");
define("_MI_CCENTER_STATUS_COMBO_DESC","書式は <tt>表示名: [状態1[,状態2...]]</tt> を複数行指定する。状態は (-,a,b,c) の文字で指定する。例 <tt>作業待ち: - a</tt>");
define("_MI_CCENTER_STATUS_COMBO_DEF","全部: - a b c\n作業待ち: - a\n作業済み: b c\n--------:\n受付待: -\n作業中: a\n応答済: b\n完了: c\n");

// Notifications
define("_MI_CCENTER_GLOBAL_NOTIFY","全フォーム");
define("_MI_CCENTER_FORM_NOTIFY","個別フォーム");
define("_MI_CCENTER_MESSAGE_NOTIFY","個別問合せ");

define("_MI_CCENTER_NEWPOST_NOTIFY","問合せがありました");
define("_MI_CCENTER_NEWPOST_NOTIFY_CAP","お問合せを通知する");
define("_MI_CCENTER_NEWPOST_SUBJECT","問合せが送信されました");

define("_MI_CCENTER_STATUS_NOTIFY","状態の変更");
define("_MI_CCENTER_STATUS_NOTIFY_CAP","状況が変更されたら通知する");
define("_MI_CCENTER_STATUS_SUBJECT","状態変更:[{X_MODULE}]{FORM_NAME}");

define("_MI_SAMPLE_FORM","サンプルフォームを作成しました");
define("_MI_SAMPLE_TITLE","お問い合わせ");
define("_MI_SAMPLE_DESC","本サイトへのお問い合わせはこちらのフォームからどうぞ。");
define("_MI_SAMPLE_DEFS","お名前*,size=40\nメール*,mail,size=60\n種類*,radio,掲載内容,改善要望,その他\n備考,textarea,cols=50,rows=5");

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYLANGADMIN','言語定数管理');
    define('_MD_A_MYMENU_MYTPLSADMIN','テンプレート管理');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','ブロック/アクセス管理');
    define('_MD_A_MYMENU_MYPREFERENCES','一般設定');
}
?>
