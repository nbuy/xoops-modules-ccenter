<?php
// $Id: admin.php,v 1.8 2012/01/22 09:22:18 nobu Exp $
// Traduzido para o Portugues do Brasil por: Miraldo Antoninho Ohse (m_ohse@hotmail.com).

define( '_AM_FORM_EDIT', 'Editar o formulario de contato' );
define( '_AM_FORM_NEW', 'Criar novo formulario de contato' );
define( '_AM_FORM_TITLE', 'Nome do formulario' );
define( '_AM_FORM_MTIME', 'Atualizaçao' );
define( '_AM_FORM_DESCRIPTION', 'Descriçao' );
define( '_AM_INS_TEMPLATE', 'Adicionar modelo' );
define( '_AM_FORM_ACCEPT_GROUPS', 'Grupos permitidos' );
define( '_AM_FORM_ACCEPT_GROUPS_DESC', 'Este formulario de contato possibilita a configuraçao dos grupos' );
define( '_AM_FORM_DEFS', 'Definiçoes do formulario' );
define( '_AM_FORM_DEFS_DESC', '<a href="help.php#form" target="_blank">Definiçoes</a> <small>Tipos: text checkbox radio textarea selecione a constante aceito pelo arquivo mail</small>' );
define( '_AM_FORM_PRIM_CONTACT', 'Contato pessoal' );
define( '_AM_FORM_PRIM_NONE', 'Nenhum' );
define( '_AM_FORM_PRIM_DESC', 'Selecione o membro do grupo. O contato pessoal necessita ser selecionado pelo argumento uid do grupo' );
define( '_AM_FORM_CONTACT_GROUP', 'Grupo de contato' );
define( '_AM_FORM_CGROUP_NONE', 'Nenhum' );
define( '_AM_FORM_STORE', 'Armazenar no banco de dados' );
define( '_AM_FORM_CUSTOM', 'Digite a descriçao' );
define( '_AM_FORM_WEIGHT', 'Peso' );
define( '_AM_FORM_REDIRECT', 'Pagina que sera mostrada apos o envio' );
define( '_AM_FORM_OPTIONS', 'Opçao de variaveis' );
define( "_AM_FORM_OPTIONS_DESC", "Configuraçao da definiçao do formulario e outros atributos <a href='help.php#attr'>Opçoes padrao</a>. Exemplo: <code>size=60,rows=5,cols=50</code>" );
define( '_AM_FORM_ACTIVE', 'Formulario ativo' );
define( '_AM_DELETE_FORM', 'Deletar formulario' );
define( '_AM_FORM_LAB', 'Nome do item' );
define( '_AM_FORM_LABREQ', 'Por favor, informe o nome do item' );
define( '_AM_FORM_REQ', 'Requerido' );
define( '_AM_FORM_ADD', 'Adicionar' );
define( '_AM_FORM_OPTREQ', 'Necessario a opçao do argumento' );
define( '_AM_CUSTOM_DESCRIPTION', '0=Normal[bb],4=Descriçao do Html[bb],1=Parte do modelo,2=Todo o modelo' );
define( '_AM_CHECK_NOEXIST', 'As variaves nao existem' );
define( '_AM_CHECK_DUPLICATE', 'Variaveis duplicadas' );
define( '_AM_DETAIL', 'Detalhe' );
define( '_AM_OPERATION', 'Operaçao' );
define( '_AM_CHANGE', 'Mudança' );
define( '_AM_SEARCH_USER', 'Buscar usuario' );

define( '_AM_MSG_ADMIN', 'Administrar contato' );
define( '_AM_MSG_CHANGESTATUS', 'Mudar status' );
define( '_AM_SUBMIT', 'Atualizaçao' );

define( '_AM_MSG_COUNT', 'Contagem' );
define( '_AM_MSG_STATUS', 'Status' );
define( '_AM_MSG_CHARGE', 'Mudar' );
define( '_AM_MSG_FROM', 'De' );
define( '_AM_MSG_COMMS', 'Comentarios' );
define( '_AM_MSG_VALUE', 'Avaliar' );

define( '_AM_MSG_WAIT', 'Aguardar' );
define( '_AM_MSG_WORK', 'Em analise' );
define( '_AM_MSG_REPLY', 'Responder' );
define( '_AM_MSG_CLOSE', 'Fechar' );
define( '_AM_MSG_DEL', 'Deletar' );

define( '_AM_MSG_CTIME', 'Registrad' );
define( '_AM_MSG_MTIME', 'Atualizada' );

define( '_AM_MSG_UPDATED', 'Status mudado' );
define( '_AM_MSG_UPDATE_FAIL', 'Atualizaçao falhou' );

define( '_AM_LOGGING', 'Historico' );

define( '_AM_FORM_UPDATED', 'O formulario foi armazenado no banco de dados' );
define( '_AM_FORM_DELETED', 'O formulario foi deletado' );
define( '_AM_FORM_UPDATE_FAIL', 'A atualizaçao do formulario falhou' );
define( '_AM_TIME_UNIT', '%dmin,%dhour,%ddays,past %s' );
define( '_AM_NODATA', 'Nao existe dados' );
define( '_AM_SUBMIT_VIEW', 'Atualizar' );
define( '_AM_OPTVARS_SHOW', 'Mostrar configuraçoes mais' );
define( '_AM_OPTVARS_LABEL', 'notify_with_email=Informe-mail mostrar
redirect=Pagina de redirecionamento apos submeter-se
reply_comment=Adicionar mensagem no correio de resposta automatica
reply_use_comtpl=Adicionar mensagem de e-mail para ser modelo
input_mail_confirm=Use de entrada para confirmar endereço de email
input_mail_login=Login do usuario endereço de email de entrada
accept_ext=Aceitar upload de de arquivo (Exemplo: <code>pdf|doc|jpg</code>)
accept_type=Aceitar upload do arquivo mime types (Exemplo: <code>application/pdf|image/*</code>)
others=Outras variaveis ("Name=Valor" style)
' );
define( '_AM_EMAIL_LOGIN_NOCONF', 'Sem confirmar' );

