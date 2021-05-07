<?php
// $Id: modinfo.php,v 1.3 2009/07/07 12:00:42 nobu Exp $
// Module Info
// Traduzido para o Portugues do Brasil por: Miraldo Antoninho Ohse (m_ohse@hotmail.com).

// The name of this module
define( "_MI_CCENTER_NAME", "Centro de contato" );

// A brief description of this module
define( "_MI_CCENTER_DESC", "Formulario de contato com armazenamento da mensagem no banco de dados e administraçao" );

// Sub Menu
define( "_MI_CCENTER_MYCONTACT", "Minhas mensagens" );
define( "_MI_CCENTER_MYCHARGE", "Contatos para mim" );
define( "_MI_CCENTER_STAFFDESK", "Suporte administrativo" );

// Admin Menu
define( "_MI_CCENTER_FORMADMIN", "Formularios" );
define( "_MI_CCENTER_MSGADMIN", "Mensagens" );
define( "_MI_CCENTER_HELP", "Sobre o modulo" );

// A brief template of this module
define( "_MI_CCENTER_INDEX_TPL", "Lista de Formularios" );
define( "_MI_CCENTER_FORM_TPL", "Formulario de contato" );
define( "_MI_CCENTER_CUST_TPL", "Formulario de contato (personalizar)" );
define( "_MI_CCENTER_CONF_TPL", "Confirmar dados do formulario" );
define( "_MI_CCENTER_LIST_TPL", "Lista de minhas consultas" );
define( "_MI_CCENTER_CHARGE_TPL", "Lista de contatos para mim" );
define( "_MI_CCENTER_MSGS_TPL", "Mostrar mensagem de contato" );
define( "_MI_CCENTER_RECEPT_TPL", "Mostrar suporte administrativo" );
define( "_MI_CCENTER_WIDGET_TPL", "Formulario widgets" );

// A brief blocks of this module
define( "_MI_CCENTER_BLOCK_RECEIPT", "Contato para mim" );
define( "_MI_CCENTER_BLOCK_FORM", "Formulario de contato" );

// Configs
define( "_MI_CCENTER_LISTS", "Numero de elementos listados" );
define( "_MI_CCENTER_LISTS_DESC", "Configurar o numero de lista que serao mostradas" );
define( "_MI_CCENTER_DEF_ATTRS", "Atributos padrao" );
define( "_MI_CCENTER_DEF_ATTRS_DESC", "Configuraçao das definiçoes do formulario e outros atributos <a href='help.php#attr'>Atributos padrao</a>. Examplo: <code>tamanho=60,linhas=5,colunas=50</code>" );
define( "_MI_CCENTER_STATUS_COMBO", "Seleçao dos status" );

define( "_MI_CCENTER_STATUS_COMBO_DESC", "o formato como: <code>Mostrar-etiqueta: [status1[,status2...]]</code>, incluir multiplas linhas. o status é um caracter do (-,a,b,c). Exemplo: <code>Abrir: - a</code>" );
define( "_MI_CCENTER_STATUS_COMBO_DEF", "Todas: - a b c\nAberta: - a\nFechada: b c\n--------:\nPendente: -\nEm analise: a\nRespondidas: b\nEncerradas: c\n" );

// Notifications
define( "_MI_CCENTER_GLOBAL_NOTIFY", "Todos os formularios" );
define( "_MI_CCENTER_FORM_NOTIFY", "Este formulario" );
define( "_MI_CCENTER_MESSAGE_NOTIFY", "Esta mensagem" );

define( "_MI_CCENTER_NEWPOST_NOTIFY", "Mensagem de contato" );
define( "_MI_CCENTER_NEWPOST_NOTIFY_CAP", "Notifique-me das mensagens de contato" );
define( "_MI_CCENTER_NEWPOST_SUBJECT", "Postar mensagem de contato" );

define( "_MI_CCENTER_STATUS_NOTIFY", "Atualizar status" );
define( "_MI_CCENTER_STATUS_NOTIFY_CAP", "Notifique-me sobre as mudanças de status" );
define( "_MI_CCENTER_STATUS_SUBJECT", "Status:[{X_MODULE}]{FORM_NAME}" );

define( "_MI_SAMPLE_FORM", "Criar um exemplo de formulario" );
define( "_MI_SAMPLE_TITLE", "Contate" );
define( "_MI_SAMPLE_DESC", "Por favor, utilize este formulario quando voce desejar fazer contato com o administrador deste site." );
define( "_MI_SAMPLE_DEFS", "Seu nome*,tamanho=40\nE-mail*,mail,tamanho=60\nSobre*,radio,Conteudos do site,Consulta sobre nos,Outros\nMensagem,area de texto,colunas=50,linhas=5" );

// for altsys 
if ( ! defined( '_MD_A_MYMENU_MYTPLSADMIN' ) ) {
	define( '_MD_A_MYMENU_MYTPLSADMIN', 'Modelos' );
	define( '_MD_A_MYMENU_MYBLOCKSADMIN', 'Blocos e Permissoes' );
	define( '_MD_A_MYMENU_MYPREFERENCES', 'Preferecias' );
}
