<?php
// $Id: main.php,v 1.2 2009/07/07 12:00:42 nobu Exp $
// Traduzido para o Portugues do Brasil por: Miraldo Antoninho Ohse (m_ohse@hotmail.com).

define('_MD_EVALS','Avaliação');
define('_MD_COUNT','Contagem');

define('_MD_CONF_LABEL','Confirmar %s');
define('_MD_CONF_DESC','<br />Por favor, informe mais uma vez para confirmar.');

define('_MD_SUBMIT','Salvar mudanças');
define('_MD_SUBMIT_CONF','Confirmar');
define('_MD_SUBMIT_SEND','Enviar');
define('_MD_SUBMIT_EDIT','Editar novamente');
define('_MD_SUBMIT_VIEW','Atualizar');

define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_ORDER_NOTE', _MD_REQUIRE_MARK.' é requerido');
define('_MD_REQUIRE_ERR', 'Necessário informar este campo');
define('_MD_NUMITEM_ERR', 'Por favor, informe números');
define('_MD_ADDRESS_ERR', 'Por favor, informe o endereço de e-mail');
define('_MD_REGEXP_ERR', 'Por favor, informe o formato correto');
define('_MD_CONFIRM_ERR', 'O valor informado é inadequado');

define('_MD_CCENTER_CHARGE','Contato para mim');
define('_MD_CCENTER_QUERY','Minhas mensagens');
define('_MD_CCENTER_RECEPTION','Suporte administrativo');
define('_MD_NOTIFY_SUBJ','{X_SITENAME}:{SUBJECT}');
define('_MD_NOTIFY_URL','Esta mensagem provêm da seguinte URL:');
define('_MD_CONTACT_DONE','Mensagem de contato enviada');
define('_MD_CONTACT_COMMENT','Comentar a mensagem');
define('_MD_CONTACT_FORM','Nome do formulário');
define('_MD_CONTACT_FROM','Usuário');
define('_MD_CONTACT_TO','Charge');
define('_MD_CONTACT_NOTYET','Nenhum');
define('_MD_CONTACT_MYSELF','Eu faço');
define('_MD_FORM_INACTIVE','Não use este formulário');
define('_MD_NOFORMS','Não existem formulários');
define('_MD_DETAIL','Detalhe');
define('_MD_MSG_ADMIN', 'Administração');
define('_MD_TIME_UNIT', '%dmin,%dhour,%ddays,past %s');

define('_MD_USER_EVAL','Avaliação do usuário');
define('_MD_POSTDATE','Postado');
define('_MD_MODDATE','Atualizado');
define('_MD_ATTACHMENT','Anexar');
define('_MD_MSG_READTHIS','Lida');
define('_MD_MSG_NOTREAD','Não lida');
define('_MD_EVAL_THANKYOU','Obrigado pela sua avaliação.');
define('_MD_EVAL_VALUE','Este contato responde pela avaliação');
define('_MD_EVAL_DESC','Faça contato, se você não estiver satifeito com nossas respostas? Sua avaliação é importante. Se você responder, por favor seja especifico nos comentários. Se você tiver mais algumas dúvidas, por favor responda ao comentário clicando no botão "responder".');
define('_MD_EVAL_COMMENT','Avaliar comentário');
define('_MD_EVAL_SUBMIT','Enviar avaliação');
define('_MD_EVAL_DATE','Avaliação');
define('_MD_BYTE_UNIT','bytes');

define('_MD_UPDATE_STATUS','Atualizar status da mensagem');
define('_MD_UPDATE_FAILED','Falhou a atualização do status');
define('_MD_NODATA','Não existem mensagens');

define('_MD_EVAL_VAL_LOW','ruim');
define('_MD_EVAL_VAL_MID','normal');
define('_MD_EVAL_VAL_MAX','bom');

define("_MD_EXPORT_CHARSET", "UTF-8");
define('_MD_EXPORT_CSV','Formato CSV');
define('_MD_EXPORT_RANGE','Faixa');

include_once dirname(__FILE__)."/common.php";
?>
