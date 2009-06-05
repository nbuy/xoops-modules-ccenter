<?php
// $Id: modinfo.php,v 1.1 2009/06/05 07:10:26 nobu Exp $
// Module Info
// Traduzido para o Portugues do Brasil por: Miraldo Antoninho Ohse (m_ohse@hotmail.com).

// The name of this module
define("_MI_CCENTER_NAME","Centro de contato");

// A brief description of this module
define("_MI_CCENTER_DESC","Formulário de contato com armazenamento de mensagem em banco de dados e administração");

// Sub Menu
define("_MI_CCENTER_MYCONTACT", "Minhas mensagens");
define("_MI_CCENTER_MYCHARGE", "Contatos para mim");
define("_MI_CCENTER_STAFFDESK", "Administração");

// Admin Menu
define("_MI_CCENTER_FORMADMIN", "Formulários");
define("_MI_CCENTER_MSGADMIN", "Mensagens");
define("_MI_CCENTER_HELP", "Ajuda");

// A brief template of this module
define("_MI_CCENTER_INDEX_TPL", "Lista de Formulários");
define("_MI_CCENTER_FORM_TPL", "Formulário de contato");
define("_MI_CCENTER_CUST_TPL", "Formulário de contato (custom)");
define("_MI_CCENTER_CONF_TPL", "Confirmar dados do formulário");
define("_MI_CCENTER_LIST_TPL", "Listar minhas consultas");
define("_MI_CCENTER_CHARGE_TPL", "Lista de contatos para mim");
define("_MI_CCENTER_MSGS_TPL", "Mostrar mensagem de contato");
define("_MI_CCENTER_RECEPT_TPL", "Mostrar administração");

// A brief blocks of this module
define("_MI_CCENTER_BLOCK_RECEIPT","Contato para mim");
define("_MI_CCENTER_BLOCK_FORM","Formulário de contato");

// Configs
define("_MI_CCENTER_LISTS","Número de ítens listados");
define("_MI_CCENTER_LISTS_DESC","Configurar o número de lista que serão mostradas");
define("_MI_CCENTER_DEF_ATTRS","Atributos padrão");
define("_MI_CCENTER_DEF_ATTRS_DESC","Configuração das definições do formulário e o valor de outros atributos padrão. Exemplo: <tt>tamanho=60,linhas=5,colunas=50</tt>");
define("_MI_CCENTER_STATUS_COMBO", "Seleções dos status");
define("_MI_CCENTER_STATUS_COMBO_DESC","o formato como: <tt>Mostrar-etiqueta: [status1[,status2...]]</tt>, incluir múltiplas linhas. o status é um caracter do (-,a,b,c). Exemplo: <tt>Abrir: - a</tt>");
define("_MI_CCENTER_STATUS_COMBO_DEF","Todas: - a b c\nAberta: - a\nFechada: b c\n--------:\nPendente: -\nTrabalhando: a\nRespondidas: b\nFeitas: c\n");

// Notifications
define("_MI_CCENTER_GLOBAL_NOTIFY","Todos os formulários");
define("_MI_CCENTER_FORM_NOTIFY","Este formulário");
define("_MI_CCENTER_MESSAGE_NOTIFY","Esta mensagem");

define("_MI_CCENTER_NEWPOST_NOTIFY","Mensagem de contato");
define("_MI_CCENTER_NEWPOST_NOTIFY_CAP","Notifique-me das mensagens de contato");
define("_MI_CCENTER_NEWPOST_SUBJECT","Postar mensagem de contato");

define("_MI_CCENTER_STATUS_NOTIFY","Atualizar status");
define("_MI_CCENTER_STATUS_NOTIFY_CAP","Notifique-me sobre as mudanças de status");
define("_MI_CCENTER_STATUS_SUBJECT","Status:[{X_MODULE}]{FORM_NAME}");

define("_MI_SAMPLE_FORM","Criar um exemplo de formulário");
define("_MI_SAMPLE_TITLE","Faça contato");
define("_MI_SAMPLE_DESC","Por favor, envie o seguinte formulário quando você precisar fazer contato conosco.");
define("_MI_SAMPLE_DEFS","Seu nome*,tamanho=40\nE-mail*,mail,tamanho=60\nSobre*,radio,Conteúdos do site,Consulta sobre nós,Outros\nMensagem,área de texto,colunas=50,linhas=5");

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Modelos');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocos e Permissões');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferências');
}
?>
