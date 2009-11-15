<?php
// $Id: admin.php,v 1.4 2009/11/15 09:51:08 nobu Exp $

define('_AM_FORM_EDIT', 'コンタクトフォームの編集');
define('_AM_FORM_NEW', '新規コンタクトフォームの作成');
define('_AM_FORM_TITLE', 'フォーム名');
define('_AM_FORM_MTIME', '更新時間');
define('_AM_FORM_DESCRIPTION', '説明文');
define('_AM_INS_TEMPLATE', 'テンプレートの追加');
define('_AM_FORM_ACCEPT_GROUPS', '受付グループ');
define('_AM_FORM_ACCEPT_GROUPS_DESC', 'このフォームで受付を行うグループを指定します');
define('_AM_FORM_DEFS', 'フォームの定義');
define('_AM_FORM_DEFS_DESC', '<a href="help.php#form" target="_blank">定義詳細</a> <small>型: text checkbox radio textarea select const hidden mail file</small>');
define('_AM_FORM_PRIM_CONTACT', '担当者');
define('_AM_FORM_PRIM_NONE', '担当者なし');
define('_AM_FORM_PRIM_DESC', 'メンバを指定した場合、担当者をそのグループから引数(uid)で指定する。');
define('_AM_FORM_CONTACT_GROUP', '担当グループ');
define('_AM_FORM_CGROUP_NONE', '担当グループなし');
define('_AM_FORM_STORE', 'データベースに保存');
define('_AM_FORM_CUSTOM', '説明文の扱い');
define('_AM_FORM_WEIGHT', '表示順');
define('_AM_FORM_REDIRECT', '送信後の表示ページ');
define('_AM_FORM_OPTIONS', 'オプション変数');
define("_AM_FORM_OPTIONS_DESC","フォームの要素に指定する<a href='help.php#attr'>オプション変数</a>などを設定する。例 <tt>size=60,rows=5,cols=50</tt>");
define('_AM_FORM_ACTIVE', 'フォームを受付ける');
define('_AM_DELETE_FORM', 'フォームを削除します');
define('_AM_FORM_LAB', '項目名');
define('_AM_FORM_LABREQ', '項目名を入力してください');
define('_AM_FORM_REQ','必須項目');
define('_AM_FORM_ADD', '追加');
define('_AM_FORM_OPTREQ', '引数が必要です');
define('_AM_CUSTOM_DESCRIPTION', '0=通常の説明文[bb],4=HTML説明文[bb],1=通常テンプレート,2=全体テンプレート');
define('_AM_CHECK_NOEXIST', 'タグが存在しません');
define('_AM_CHECK_DUPLICATE', 'タグが重複しています');
define('_AM_DETAIL', '詳細');
define('_AM_OPERATION', '操作');
define('_AM_CHANGE','変更');
define('_AM_SEARCH_USER', 'ユーザ検索');

define('_AM_MSG_ADMIN', '問合せ管理');
define('_AM_MSG_CHANGESTATUS', '状態の一括変更');
define('_AM_SUBMIT', '更新');

define('_AM_MSG_COUNT', '件数');
define('_AM_MSG_STATUS', '状況');
define('_AM_MSG_CHARGE', '担当者');
define('_AM_MSG_FROM', '依頼者');
define('_AM_MSG_COMMS', 'コメント');

define('_AM_MSG_WAIT', '待ち');
define('_AM_MSG_WORK', '作業');
define('_AM_MSG_REPLY', '済み');
define('_AM_MSG_CLOSE', '完了');
define('_AM_MSG_DEL', '削除');

define('_AM_MSG_CTIME', '登録日時');
define('_AM_MSG_MTIME', '更新日時');

define('_AM_MSG_UPDATED', '状態を変更しました');
define('_AM_MSG_UPDATE_FAIL', '変更に失敗しました');

define('_AM_LOGGING','対応履歴');

define('_AM_FORM_UPDATED', 'フォームをデータベースに保存しました');
define('_AM_FORM_DELETED', 'フォームを削除しました');
define('_AM_FORM_UPDATE_FAIL', 'フォームの更新に失敗しました');
define('_AM_TIME_UNIT', '%d分,%d時間,%d日,%s 前');
define('_AM_NODATA', 'データがありません');
define('_AM_SUBMIT_VIEW','再表示');
define('_AM_OPTVARS_SHOW','設定項目を表示する');
define('_AM_OPTVARS_LABEL','notify_with_email=メールアドレスを通知に表示する
redirect=フォーム送信後に遷移するページ
reply_comment=応答メールに付加する文
reply_use_comtpl=付加文を応答メールのテンプレートにする
others=その他の変数 (「名前=値」の形式)
');

include_once dirname(__FILE__)."/common.php";
?>
