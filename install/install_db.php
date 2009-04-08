<?
/*========================================================================
*   Open eClass 2.1
*   E-learning and Course Management System
* ========================================================================
*  Copyright(c) 2003-2008  Greek Universities Network - GUnet
*  A full copyright notice can be read in "/info/copyright.txt".
*
*  Developers Group:	Costas Tsibanis <k.tsibanis@noc.uoa.gr>
*			Yannis Exidaridis <jexi@noc.uoa.gr>
*			Alexandros Diamantidis <adia@noc.uoa.gr>
*			Tilemachos Raptis <traptis@noc.uoa.gr>
*
*  For a full list of contributors, see "credits.txt".
*
*  Open eClass is an open platform distributed in the hope that it will
*  be useful (without any warranty), under the terms of the GNU (General
*  Public License) as published by the Free Software Foundation.
*  The full license can be read in "/info/license/license_gpl.txt".
*
*  Contact address: 	GUnet Asynchronous eLearning Group,
*  			Network Operations Center, University of Athens,
*  			Panepistimiopolis Ilissia, 15784, Athens, Greece
*  			eMail: info@openeclass.org
* =========================================================================*/

mysql_query("DROP DATABASE IF EXISTS ".$mysqlMainDb);
if (mysql_version()) mysql_query("SET NAMES utf8");
if (mysql_version()) {
	$cdb=mysql_query("CREATE DATABASE $mysqlMainDb CHARACTER SET utf8");

} else {
	$cdb=mysql_query("CREATE DATABASE $mysqlMainDb");
}
	mysql_select_db ($mysqlMainDb);

	// drop old tables (if existed)
mysql_query("DROP TABLE IF EXISTS admin");
mysql_query("DROP TABLE IF EXISTS admin_announcements");
mysql_query("DROP TABLE IF EXISTS agenda");
mysql_query("DROP TABLE IF EXISTS annonces");
mysql_query("DROP TABLE IF EXISTS auth");
mysql_query("DROP TABLE IF EXISTS cours");
mysql_query("DROP TABLE IF EXISTS cours_user");
mysql_query("DROP TABLE IF EXISTS faculte");
mysql_query("DROP TABLE IF EXISTS institution");
mysql_query("DROP TABLE IF EXISTS loginout");
mysql_query("DROP TABLE IF EXISTS loginout_summary");
mysql_query("DROP TABLE IF EXISTS monthly_summary");
mysql_query("DROP TABLE IF EXISTS prof_request");
mysql_query("DROP TABLE IF EXISTS user");

$charset_spec = 'DEFAULT CHARACTER SET=utf8';

// create tables

#
# table `annonces`
#


mysql_query("CREATE TABLE annonces (
      id mediumint(11) NOT NULL auto_increment,
	title varchar(255) default NULL,
      contenu text,
      temps date default NULL,
      code_cours varchar(20) default NULL,
      ordre mediumint(11) NOT NULL,
      PRIMARY KEY  (id))
      TYPE=MyISAM $charset_spec");


#
# table admin_announcements
#
mysql_query("CREATE TABLE admin_announcements (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	gr_title VARCHAR(255) NULL,
	 gr_body TEXT NULL,
	 gr_comment VARCHAR(255) NULL,
	 en_title VARCHAR(255) NULL,
	 en_body TEXT NULL,
	en_comment VARCHAR(255) NULL,
	date DATE NOT NULL,
	visible ENUM('V', 'I') NOT NULL
	) TYPE = MyISAM $charset_spec");

#
# table `agenda`
#

mysql_query("CREATE TABLE `agenda` (
  `id` int(11) NOT NULL auto_increment,
  `lesson_event_id` int(11) NOT NULL default '0',
  `titre` varchar(200) NOT NULL default '',
  `contenu` text NOT NULL,
  `day` date NOT NULL default '0000-00-00',
  `hour` time NOT NULL default '00:00:00',
  `lasting` varchar(20) NOT NULL default '',
  `lesson_code` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM $charset_spec");

#
# table `cours`
#

mysql_query("CREATE TABLE `cours` (
  `cours_id` int(11) NOT NULL auto_increment,
  `code` varchar(20) default NULL,
  `languageCourse` varchar(15) default NULL,
  `intitule` varchar(250) default NULL,
  `description` text default NULL,
  `course_keywords` text default NULL,
  `course_addon` text default NULL,
  `faculte` varchar(100) default NULL,
  `visible` tinyint(4) default NULL,
  `titulaires` varchar(200) default NULL,
  `fake_code` varchar(20) default NULL,
  `departmentUrlName` varchar(30) default NULL,
  `departmentUrl` varchar(180) default NULL,
  `lastVisit` date NOT NULL default '0000-00-00',
  `lastEdit` datetime NOT NULL default '0000-00-00 00:00:00',
  `expirationDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `first_create` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` ENUM( 'pre', 'post', 'other' ) DEFAULT 'pre' NOT NULL,
  `doc_quota` float NOT NULL default '40000000',
  `video_quota` float NOT NULL default '20000000',
  `group_quota` float NOT NULL default '40000000',
  `dropbox_quota` float NOT NULL default '40000000',
  `password` varchar(50) default NULL,
  `faculteid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cours_id`))
  TYPE=MyISAM $charset_spec");


# #
 # Table `cours_faculte`	 
 #
 mysql_query("CREATE TABLE cours_faculte ( 	 
       id int(11) NOT NULL auto_increment, 	 
       faculte varchar(100) NOT NULL, 	 
       code varchar(20) NOT NULL, 	 
       facid int(11) NOT NULL default '0', 	 
       PRIMARY KEY  (id)) 	 
       TYPE=MyISAM $charset_spec");

#
# Table `cours_user`
#

mysql_query("CREATE TABLE cours_user (
      code_cours varchar(30) NOT NULL default '0',
      user_id int(11) unsigned NOT NULL default '0',
      statut tinyint(4) NOT NULL default '0',
      team int(11) NOT NULL default '0',
      tutor int(11) NOT NULL default '0',
      reg_date DATE NOT NULL,
      PRIMARY KEY  (code_cours,user_id))
      TYPE=MyISAM $charset_spec");

#
# Table `faculte`
#

mysql_query("CREATE TABLE faculte (
      id int(11) NOT NULL auto_increment,
      code varchar(10) NOT NULL,
      name varchar(100) NOT NULL,
      number int(11) NOT NULL default 0,
      generator int(11) NOT NULL default 0,
      PRIMARY KEY  (id))
      TYPE=MyISAM $charset_spec");


mysql_query("INSERT INTO faculte VALUES (1, 'TMA', 'Τμήμα 1', 10, 100)");
mysql_query("INSERT INTO faculte VALUES (2, 'TMB', 'Τμήμα 2', 20, 100)");
mysql_query("INSERT INTO faculte VALUES (3, 'TMC', 'Τμήμα 3', 30, 100)");
mysql_query("INSERT INTO faculte VALUES (4, 'TMD', 'Τμήμα 4', 40, 100)");
mysql_query("INSERT INTO faculte VALUES (5, 'TME', 'Τμήμα 5', 50, 100)");

#
# Table `user`
#

mysql_query("CREATE TABLE user (
      user_id mediumint unsigned NOT NULL auto_increment,
      nom varchar(60) default NULL,
      prenom varchar(60) default NULL,
      username varchar(20) default 'empty',
      password varchar(50) default 'empty',
      email varchar(100) default NULL,
      statut tinyint(4) default NULL,
      phone varchar(20) default NULL,
      department int(10) default NULL,
      am varchar(20) default NULL,
      registered_at int(10) NOT NULL default '0',
      expires_at int(10) NOT NULL default '0',
     `perso` enum('yes','no') NOT NULL default 'no',
	 `lang` enum('el','en') DEFAULT 'el' NOT NULL,
 	`announce_flag` date NOT NULL default '0000-00-00',
 	 `doc_flag` date NOT NULL default '0000-00-00',
    `forum_flag` date NOT NULL default '0000-00-00',
     PRIMARY KEY  (user_id))
      TYPE=MyISAM $charset_spec");

mysql_query("CREATE TABLE admin (
      idUser mediumint unsigned  NOT NULL default '0',
      UNIQUE KEY idUser (idUser))
      TYPE=MyISAM $charset_spec");

mysql_query("CREATE TABLE loginout (
      idLog mediumint(9) unsigned NOT NULL auto_increment,
      id_user mediumint(9) unsigned NOT NULL default '0',
      ip char(16) NOT NULL default '0.0.0.0',
      loginout.when datetime NOT NULL default '0000-00-00 00:00:00',
      loginout.action enum('LOGIN','LOGOUT') NOT NULL default 'LOGIN',
      PRIMARY KEY  (idLog))
      TYPE=MyISAM $charset_spec");

// haniotak:
// table for loginout rollups
// only contains LOGIN events summed up by a period (typically weekly)
mysql_query("CREATE TABLE loginout_summary (
        id mediumint unsigned NOT NULL auto_increment,
        login_sum int(11) unsigned  NOT NULL default '0',
        start_date datetime NOT NULL default '0000-00-00 00:00:00',
        end_date datetime NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (id))
        TYPE=MyISAM $charset_spec");

//table keeping data for monthly reports
mysql_query("CREATE TABLE monthly_summary (
        id mediumint unsigned NOT NULL auto_increment,
        `month` varchar(20)  NOT NULL default '0',
        profesNum int(11) NOT NULL default '0',
        studNum int(11) NOT NULL default '0',
        visitorsNum int(11) NOT NULL default '0',
        coursNum int(11) NOT NULL default '0',
        logins int(11) NOT NULL default '0',
        details text,
        PRIMARY KEY  (id))
        TYPE=MyISAM $charset_spec");


// encrypt the admin password into DB
$password_encrypted = md5($passForm);
$exp_time = time() + 140000000;
mysql_query("INSERT INTO `user` (`prenom`, `nom`, `username`, `password`, `email`, `statut`,`registered_at`,`expires_at`)
    VALUES ('$nameForm', '$surnameForm', '$loginForm','$password_encrypted','$emailForm','1',".time().",".$exp_time.")");
$idOfAdmin=mysql_insert_id();
mysql_query("INSERT INTO loginout (loginout.idLog, loginout.id_user, loginout.ip, loginout.when, loginout.action) VALUES ('', '".$idOfAdmin."', '".$REMOTE_ADDR."', NOW(), 'LOGIN')");


#add admin in list of admin
mysql_query("INSERT INTO admin VALUES ('".$idOfAdmin."')");

#
# Table structure for table `institution`
#

mysql_query("CREATE TABLE institution (
            inst_id int(11) NOT NULL auto_increment,
             nom varchar(100) NOT NULL default '',
             ldapserver varchar(30) NOT NULL default '',
             basedn varchar(40) NOT NULL default '',
	         PRIMARY KEY  (inst_id))
    	      TYPE=MyISAM $charset_spec");

#
# Dumping data for table `institution`
#

mysql_query("INSERT INTO institution (inst_id, nom, ldapserver, basedn) VALUES ('1', '$institutionForm', '$ldapserver', '$dnldapserver')");

#
# Table structure for table `prof_request`
#

mysql_query("CREATE TABLE `prof_request` (
          `rid` int(11) NOT NULL auto_increment,
            `profname` varchar(255) NOT NULL default '',
              `profsurname` varchar(255) NOT NULL default '',
            `profuname` varchar(255) NOT NULL default '',
            `profpassword` varchar(255) NOT NULL default '',
          `profemail` varchar(255) NOT NULL default '',
            `proftmima` varchar(255) default NULL,
              `profcomm` varchar(20) default NULL,
            `status` int(11) default NULL,
        `date_open` datetime default NULL,
        `date_closed` datetime default NULL,
        `comment` text default NULL,
	`lang` ENUM( 'el', 'en' ) NOT NULL DEFAULT 'el',
	`statut`  tinyint(4) NOT NULL default 1,
        PRIMARY KEY  (`rid`))
        TYPE=MyISAM $charset_spec");


###############PHPMyAdminTables##################

mysql_query("
    CREATE TABLE `pma_bookmark` (
       id int(11) NOT NULL auto_increment,
       dbase varchar(255) NOT NULL,
       user varchar(255) NOT NULL,
       label varchar(255) NOT NULL,
       query text NOT NULL,
       PRIMARY KEY (id))
       TYPE=MyISAM $charset_spec");

mysql_query("
	CREATE TABLE `pma_relation` (
       `master_db` varchar(64) NOT NULL default '',
       `master_table` varchar(64) NOT NULL default '',
       `master_field` varchar(64) NOT NULL default '',
       `foreign_db` varchar(64) NOT NULL default '',
       `foreign_table` varchar(64) NOT NULL default '',
       `foreign_field` varchar(64) NOT NULL default '',
       PRIMARY KEY (`master_db`, `master_table`, `master_field`),
       KEY foreign_field (foreign_db, foreign_table))
       TYPE=MyISAM $charset_spec");


mysql_query("
	CREATE TABLE `pma_table_info` (
       `db_name` varchar(64) NOT NULL default '',
       `table_name` varchar(64) NOT NULL default '',
       `display_field` varchar(64) NOT NULL default '',
       PRIMARY KEY (`db_name`, `table_name`))
       TYPE=MyISAM $charset_spec");

mysql_query("
     CREATE TABLE `pma_table_coords` (
       `db_name` varchar(64) NOT NULL default '',
       `table_name` varchar(64) NOT NULL default '',
       `pdf_page_number` int NOT NULL default '0',
       `x` float unsigned NOT NULL default '0',
       `y` float unsigned NOT NULL default '0',
       PRIMARY KEY (`db_name`, `table_name`, `pdf_page_number`))
       TYPE=MyISAM $charset_spec");

mysql_query("
     CREATE TABLE `pma_pdf_pages` (
       `db_name` varchar(64) NOT NULL default '',
       `page_nr` int(10) unsigned NOT NULL auto_increment,
       `page_descr` varchar(50) NOT NULL default '',
       PRIMARY KEY (page_nr),
       KEY (db_name))
       TYPE=MyISAM $charset_spec");

mysql_query("
	CREATE TABLE `pma_column_comments` (
       id int(5) unsigned NOT NULL auto_increment,
       db_name varchar(64) NOT NULL default '',
       table_name varchar(64) NOT NULL default '',
       column_name varchar(64) NOT NULL default '',
       comment varchar(255) NOT NULL default '',
       PRIMARY KEY (id),
       UNIQUE KEY db_name (db_name, table_name, column_name))
       TYPE=MyISAM $charset_spec");

// New table auth for authentication methods
// added by kstratos
mysql_query("
CREATE TABLE `auth` (
  `auth_id` int(2) NOT NULL auto_increment,
  `auth_name` varchar(20) NOT NULL default '',
  `auth_settings` text ,
  `auth_instructions` text ,
  `auth_default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`auth_id`))
  TYPE=MyISAM $charset_spec");

mysql_query("INSERT INTO `auth` VALUES (1, 'eclass', '', '', 1)");
mysql_query("INSERT INTO `auth` VALUES (2, 'pop3', '', '', 0)");
mysql_query("INSERT INTO `auth` VALUES (3, 'imap', '', '', 0)");
mysql_query("INSERT INTO `auth` VALUES (4, 'ldap', '', '', 0)");
mysql_query("INSERT INTO `auth` VALUES (5, 'db', '', '', 0)");


mysql_query("CREATE TABLE `config` (
		`id` MEDIUMINT NOT NULL ,
		`version` VARCHAR( 255 ) NOT NULL ,
		PRIMARY KEY (`id`)
	) ENGINE = MYISAM $charset_spec");

mysql_query("INSERT INTO `config` (`id`,`version`) VALUES ('1', '$langEclassVersion')");

#
# Table passwd_reset (used by the password reset module)
#

mysql_query("CREATE TABLE `passwd_reset` (
  	`user_id` int(11) NOT NULL,
  	`hash` varchar(40) NOT NULL,
  	`password` varchar(8) NOT NULL,
  	`datetime` datetime NOT NULL
	) TYPE=MyISAM $charset_spec");


//dhmiourgia full text indexes
mysql_query("ALTER TABLE `annonces` ADD FULLTEXT `annonces` (`contenu` ,`code_cours`)");
mysql_query("ALTER TABLE `cours` ADD FULLTEXT `cours` (`code` ,`description` ,`intitule` ,`course_objectives` ,`course_prerequisites` ,`course_keywords` ,`course_references`)");

