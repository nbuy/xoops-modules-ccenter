# Contact Center Module for XOOPS
# $Id: mysql.sql,v 1.2 2007/03/06 17:46:56 nobu Exp $

#
# Table structure for table `ccenter_form`
#   form definition table
#

CREATE TABLE ccenter_form (
  formid  int(8) unsigned NOT NULL auto_increment,
  mtime   int(10) NOT NULL default '0',
  title   varchar(80) NOT NULL default '',
  description text,
  defs    text,
  grpperm varchar(40)  NOT NULL default '', -- acceptting groups |ID|ID..|
  priuid  int(8)  NOT NULL default '0',	-- primary contact person
  cgroup  int(8)  NOT NULL default '0', -- contacting group id
  store   int(1)  NOT NULL default '1', -- store in database
  custom  int(1)  NOT NULL default '0', -- use custom template (as description)
  active  int(1)  NOT NULL default '1',
  weight  int(8)  NOT NULL default '0',
  redirect varchar(128) NOT NULL default '',
  PRIMARY KEY  (formid)
) TYPE=MyISAM;

#
# Table structure for table `ccenter_message`
#   store form value
#

CREATE TABLE ccenter_message (
  msgid  int(8) unsigned NOT NULL auto_increment,
  uid   int(5) NOT NULL default '0',
  touid int(8) NOT NULL default '0',
  mtime int(10) NOT NULL default '0',
  fidref int(8) NOT NULL default '0',
  email varchar(60) NOT NULL default '',
  body  text NOT NULL default '',
  status char(1) NOT NULL default '-',
  value int(4) NOT NULL default '0',
  comment text NOT NULL default '',
  comtime int(10) NOT NULL default '0',
  onepass varchar(10) NOT NULL default '',
  PRIMARY KEY  (msgid)
) TYPE=MyISAM;
