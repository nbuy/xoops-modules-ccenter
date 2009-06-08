# Contact Center Module for XOOPS
# $Id: mysql.sql,v 1.8 2009/06/08 02:03:29 nobu Exp $

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
  store   int(1)  NOT NULL default '1', -- store in database (0:no, 1:store, 2:never)
  custom  int(1)  NOT NULL default '0', -- use custom template (as description)
  active  int(1)  NOT NULL default '1',
  weight  int(8)  NOT NULL default '0',
  optvars text,				-- override option variables
  PRIMARY KEY  (formid)
);

#
# Table structure for table `ccenter_message`
#   store form value
#

CREATE TABLE ccenter_message (
  msgid  int(8) unsigned NOT NULL auto_increment,
  uid   int(5) NOT NULL default '0',	-- contactee uid. guest is 0
  touid int(8) NOT NULL default '0',	-- uid of charge
  ctime int(10) NOT NULL default '0',	-- contact(create) time
  mtime int(10) NOT NULL default '0',
  atime int(10) NOT NULL default '0',	-- last access time by contactee
  fidref int(8) NOT NULL default '0',	-- formid external reference
  email varchar(256) NOT NULL default '',-- guest access email address
  body  text,	-- contact form siralized value
  status char(1) NOT NULL default '-',	-- '-':not yet, a:accept, b:replyed, c:close, x:deleted
  value int(4) NOT NULL default '0',	-- evaluate value for this contact
  comment text,	-- comment for evaluate
  comtime int(10) NOT NULL default '0',	-- time for evaluate
  onepass varchar(10) NOT NULL default '', -- onetime password for guest
  PRIMARY KEY  (msgid)
);

#
# Table structure for table `ccenter_log`
#   store action history
#

CREATE TABLE ccenter_log (
  logid  int(8) unsigned NOT NULL auto_increment,
  ltime  int(10) NOT NULL default '0',
  fidref int(8) NOT NULL default '0',
  midref int(8) NOT NULL default '0',
  euid int(8) NOT NULL default '0',
  comment tinytext,
  PRIMARY KEY  (logid)
);
