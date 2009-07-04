<?php
// $Id: main.php,v 1.1 2009/07/04 03:54:37 nobu Exp $

define('_MD_EVALS','評価');
define('_MD_COUNT','件数');

define('_MD_CONF_LABEL','確認用%s');
define('_MD_CONF_DESC','<br />確認のためもう一度入力してください。');

define('_MD_SUBMIT','変更を保存');
define('_MD_SUBMIT_CONF','確認画面へ');
define('_MD_SUBMIT_SEND','この内容で送信');
define('_MD_SUBMIT_EDIT','やり直し');
define('_MD_SUBMIT_VIEW','再表示');

define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_ORDER_NOTE', _MD_REQUIRE_MARK.' は必須項目です');
define('_MD_REQUIRE_ERR', '必須項目の入力がありません');
define('_MD_NUMITEM_ERR', '数値を入力してください。');
define('_MD_ADDRESS_ERR', 'メールアドレスを入力してください');
define('_MD_REGEXP_ERR', '正しい書式で入力してください');
define('_MD_CONFIRM_ERR', '内容が一致しません');

define('_MD_CCENTER_CHARGE','担当問合せ');
define('_MD_CCENTER_QUERY','あなたの問合せ');
define('_MD_CCENTER_RECEPTION','受付担当デスク');
define('_MD_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');
define('_MD_NOTIFY_URL','メッセージは次の URL で参照できます。');
define('_MD_CONTACT_DONE','問合せメッセージを送信しました。');
define('_MD_CONTACT_COMMENT','問合せへのコメント');
define('_MD_CONTACT_FORM','フォーム名');
define('_MD_CONTACT_FROM','依頼者');
define('_MD_CONTACT_TO','担当者');
define('_MD_CONTACT_NOTYET','未定');
define('_MD_CONTACT_MYSELF','担当する');
define('_MD_FORM_INACTIVE','このフォームは使われていません');
define('_MD_NOFORMS','フォームが定義されていません');
define('_MD_DETAIL','詳細');
define('_MD_MSG_ADMIN', '管理');
define('_MD_TIME_UNIT', '%d分,%d時間,%d日,%s 前');

define('_MD_USER_EVAL','これまでのお客様からの評価');
define('_MD_POSTDATE','問合せ日時');
define('_MD_MODDATE','更新日時');
define('_MD_ATTACHMENT','添付ファイル');
define('_MD_MSG_READTHIS','参照済み');
define('_MD_MSG_NOTREAD','未参照');
define('_MD_EVAL_THANKYOU','ご評価ありがとうございました');
define('_MD_EVAL_VALUE','お問合せ対応のご評価');
define('_MD_EVAL_DESC','お問合せへの回答に満足していただけましたか? よろしければ対応のご評価やコメントをご記入ください。更に質問がある場合、回答コメントに対して「返信」を行ってください。');
define('_MD_EVAL_COMMENT','評価コメント');
define('_MD_EVAL_SUBMIT','評価を送信する');
define('_MD_EVAL_DATE','評価日時');
define('_MD_BYTE_UNIT','バイト');

define('_MD_UPDATE_STATUS','メッセージの状態を変更しました');
define('_MD_UPDATE_FAILED','状態の更新は行いませんでした');
define('_MD_NODATA','問い合わせはありません');

define('_MD_EVAL_VAL_LOW','悪い');
define('_MD_EVAL_VAL_MID','普通');
define('_MD_EVAL_VAL_MAX','良い');

define("_MD_EXPORT_CHARSET", "UTF-8");
define('_MD_EXPORT_CSV','CSV形式');
define('_MD_EXPORT_RANGE','期間');

include_once dirname(__FILE__)."/common.php";
?>
