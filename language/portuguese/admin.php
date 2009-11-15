<?php
// $Id: admin.php,v 1.5 2009/11/15 09:51:08 nobu Exp $
// Traduzido para o Portugues do Brasil por: Miraldo Antoninho Ohse (m_ohse@hotmail.com).

define('_AM_FORM_EDIT', 'Editar o formulário de contato');
define('_AM_FORM_NEW', 'Criar novo formulário de contato');
define('_AM_FORM_TITLE', 'Nome do formulário');
define('_AM_FORM_MTIME', 'Atualização');
define('_AM_FORM_DESCRIPTION', 'Descrição');
define('_AM_INS_TEMPLATE', 'Adição de modelo');
define('_AM_FORM_ACCEPT_GROUPS', 'Grupos permitidos');
define('_AM_FORM_ACCEPT_GROUPS_DESC', 'Este formulário de contato possibilita a configuração dos grupos');
define('_AM_FORM_DEFS', 'Definições do formulário');
define('_AM_FORM_DEFS_DESC', '<a href="help.php#form" target="_blank">Definições</a> <small>Tipos: text checkbox radio textarea selecione a constante aceito pelo arquivo mail</small>');
define('_AM_FORM_PRIM_CONTACT', 'Contato pessoal');
define('_AM_FORM_PRIM_NONE', 'Nenhum');
define('_AM_FORM_PRIM_DESC', 'Selecione o membro do grupo. O contato pessoal necessita ser selecionado pelo argumento uid do grupo');
define('_AM_FORM_CONTACT_GROUP', 'Grupo de contato');
define('_AM_FORM_CGROUP_NONE', 'Nenhum');
define('_AM_FORM_STORE', 'Armazenar no banco de dados');
define('_AM_FORM_CUSTOM', 'Digite a descrição');
define('_AM_FORM_WEIGHT', 'Peso');
define('_AM_FORM_REDIRECT', 'Página que será mostrada após o envio');
define('_AM_FORM_OPTIONS', 'Opção de variáveis');
define("_AM_FORM_OPTIONS_DESC","Configuração da definição do formulário e outros atributos <a href='help.php#attr'>Opções padrão</a>. Exemplo: <tt>size=60,rows=5,cols=50</tt>");
define('_AM_FORM_ACTIVE', 'Formulário ativo');
define('_AM_DELETE_FORM', 'Deletar formulário');
define('_AM_FORM_LAB', 'Nome do item');
define('_AM_FORM_LABREQ', 'Por favor, informe o nome do item');
define('_AM_FORM_REQ','Requerido');
define('_AM_FORM_ADD', 'Adicionar');
define('_AM_FORM_OPTREQ', 'Necessário a opção do argumento');
define('_AM_CUSTOM_DESCRIPTION', '0=Normal[bb],4=Descrição do Html[bb],1=Parte do modelo,2=Todo o modelo');
define('_AM_CHECK_NOEXIST', 'As variáves não existem');
define('_AM_CHECK_DUPLICATE', 'Variáveis duplicadas');
define('_AM_DETAIL', 'Detalhe');
define('_AM_OPERATION', 'Operação');
define('_AM_CHANGE','Mudança');
define('_AM_SEARCH_USER', 'Buscar usuário');

define('_AM_MSG_ADMIN', 'Administrar contato');
define('_AM_MSG_CHANGESTATUS', 'Mudar status');
define('_AM_SUBMIT', 'Atualização');

define('_AM_MSG_COUNT', 'Contagem');
define('_AM_MSG_STATUS', 'Status');
define('_AM_MSG_CHARGE', 'Mudar');
define('_AM_MSG_FROM', 'De');
define('_AM_MSG_COMMS', 'Comentários');

define('_AM_MSG_WAIT', 'Aguardar');
define('_AM_MSG_WORK', 'Em análise');
define('_AM_MSG_REPLY', 'Responder');
define('_AM_MSG_CLOSE', 'Fechar');
define('_AM_MSG_DEL', 'Deletar');

define('_AM_MSG_CTIME', 'Registrad');
define('_AM_MSG_MTIME', 'Atualizada');

define('_AM_MSG_UPDATED', 'Status mudado');
define('_AM_MSG_UPDATE_FAIL', 'Atualização falhou');

define('_AM_LOGGING','Histórico');

define('_AM_FORM_UPDATED', 'O formulário foi armazenado no banco de dados');
define('_AM_FORM_DELETED', 'O formulário foi deletado');
define('_AM_FORM_UPDATE_FAIL', 'A atualização do formulário falhou');
define('_AM_TIME_UNIT', '%dmin,%dhour,%ddays,past %s');
define('_AM_NODATA', 'Não existe dados');
define('_AM_SUBMIT_VIEW','Atualizar');
define('_AM_OPTVARS_SHOW','Mostrar configurações mais');
define('_AM_OPTVARS_LABEL','notify_with_email=Informe-mail mostrar
redirect=Página de redirecionamento após submeter-se
reply_comment=Adicionar mensagem no correio de resposta automática
reply_use_comtpl=Adicionar mensagem de e-mail para ser modelo
others=Outras variáveis ("Name=Valor" style)
');

include_once dirname(__FILE__)."/common.php";
?>
