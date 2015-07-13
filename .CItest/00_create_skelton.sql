drop database if exists `music_list`;
CREATE DATABASE  IF NOT EXISTS `music_list` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `music_list`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: music_list
-- ------------------------------------------------------
-- Server version	5.6.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `artist_and_list`
--

DROP TABLE IF EXISTS `artist_and_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artist_and_list` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ID_List` smallint(5) unsigned NOT NULL,
  `ID_Artist` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`ID_List`,`ID_Artist`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `ID_Artist_idx` (`ID_List`),
  KEY `ID_List_idx` (`ID_Artist`),
  CONSTRAINT `ID_Artist` FOREIGN KEY (`ID_Artist`) REFERENCES `artist_info` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ID_List` FOREIGN KEY (`ID_List`) REFERENCES `list` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='"On Update" for Foreign Keys is not defined because "ID" that they refers should not be updated.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `artist_and_list_BUPD` BEFORE UPDATE ON `artist_and_list`
FOR EACH ROW BEGIN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'UPDATE for this table is prohibited.';
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `artist_info`
--

DROP TABLE IF EXISTS `artist_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artist_info` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name_lower` varchar(255) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Love` bit(2) NOT NULL DEFAULT b'0',
  `Hide` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`),
  UNIQUE KEY `name_lower_UNIQUE` (`name_lower`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `category_BINS` BEFORE INSERT ON `category` FOR EACH ROW
BEGIN
	declare cat_name_violation varchar(255) default "===Create new category===";
	declare error_message varchar(255);

	if new.`Name` = cat_name_violation then
		set error_message = 'Specified category name is not allowed. Try another name.';
		#select 'error' as `status`, error_message as `result`;
		SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = error_message;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `debug`
--

DROP TABLE IF EXISTS `debug`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debug` (
  `output1` text,
  `output2` text,
  `output3` text,
  `output4` text,
  `output5` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list`
--

DROP TABLE IF EXISTS `list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Url` varchar(255) NOT NULL,
  `IsShuffle` bit(1) NOT NULL,
  `ID_Category` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `ID_Category_idx` (`ID_Category`),
  CONSTRAINT `ID_Category` FOREIGN KEY (`ID_Category`) REFERENCES `category` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='Default value of `Title` is defined in trigger; before insert/update.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `list_BINS` BEFORE INSERT ON `list` FOR EACH ROW
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: 
	--   In order to deny empty title, this trigger replaces it.
	--   
	-- Note: 
	--   Since empty data "" is not equal to null, you cannot deny with NOT NULL restriction.
	-- --------------------------------------------------------------------------------
	set new.`Title` = trim_value(new.`Title`);
	if new.`Title` = "" then
		set new.`Title` = "Untitled";
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `list_AUPD` AFTER UPDATE ON `list` FOR EACH ROW
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: 
	--   After update, belonged category can be empty.
	--   In that case, this trigger deletes orphaned entry of `category`;
	-- --------------------------------------------------------------------------------
	declare is_category_orphaned int;
	select count(ID) into is_category_orphaned from `list` where `ID_Category` = OLD.`ID_Category`;
	if is_category_orphaned = 0 then
		delete from `category` where `ID`=OLD.`ID_Category`;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `list_ADEL` AFTER DELETE ON `list`
FOR EACH ROW BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: 
	--   This trigger deletes entry of `artist_and_list`......
	--   If...
	-- --------------------------------------------------------------------------------
	declare is_category_obsoleted bit(1);
	select count(ID)=0 into is_category_obsoleted from `list` where `ID_Category` = OLD.`ID_Category`;
	#
	delete from `artist_and_list` where `ID_List`=OLD.`ID`;
	#
	if is_category_obsoleted then
		delete from `category` where `ID`=OLD.`ID_Category`;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary table structure for view `view_artist_info`
--

DROP TABLE IF EXISTS `view_artist_info`;
/*!50001 DROP VIEW IF EXISTS `view_artist_info`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_artist_info` (
  `ID_List` tinyint NOT NULL,
  `ID_Artist` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `Count` tinyint NOT NULL,
  `Love` tinyint NOT NULL,
  `Hide` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_artist_info_full`
--

DROP TABLE IF EXISTS `view_artist_info_full`;
/*!50001 DROP VIEW IF EXISTS `view_artist_info_full`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_artist_info_full` (
  `ID` tinyint NOT NULL,
  `ID_Artist` tinyint NOT NULL,
  `Artist_Name` tinyint NOT NULL,
  `Count` tinyint NOT NULL,
  `Love` tinyint NOT NULL,
  `Hide` tinyint NOT NULL,
  `ID_List` tinyint NOT NULL,
  `Title` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_category`
--

DROP TABLE IF EXISTS `view_category`;
/*!50001 DROP VIEW IF EXISTS `view_category`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_category` (
  `ID` tinyint NOT NULL,
  `Name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_list`
--

DROP TABLE IF EXISTS `view_list`;
/*!50001 DROP VIEW IF EXISTS `view_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_list` (
  `ID_List` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `Title` tinyint NOT NULL,
  `Url` tinyint NOT NULL,
  `IsShuffle` tinyint NOT NULL,
  `ID_Category` tinyint NOT NULL,
  `Category` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'music_list'
--
/*!50003 DROP FUNCTION IF EXISTS `get_category_id` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `get_category_id`(_category_name varchar(255)) RETURNS tinyint(3) unsigned
BEGIN
	declare is_new_category bit(1);
	declare category_id tinyint unsigned;
	
	SELECT count(`ID`)=0, `ID` into is_new_category, category_id FROM music_list.`category` where `Name` = _category_name;
	if is_new_category = 1 then
		insert into `category` (`Name`) values (_category_name);
		set category_id = LAST_INSERT_ID();
	end if;
	
	RETURN category_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `trim_value` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `trim_value`(_value text) RETURNS text CHARSET utf8
BEGIN
	declare EXPR varchar(255) default "^(32|14909568|9)$"; # "(1byte space)|(2bytes space)|\t";
	declare trimmed_text text;
	declare text_length varchar(255);
	declare i tinyint unsigned;
	declare is_valid_text bit(1);
	set trimmed_text = _value;
	
	-- Left trim
	set text_length = char_length(trimmed_text);
	set i = 0;
	ltrim: while i <= text_length do
		select ord(substring(trimmed_text, 1, 1)) not regexp EXPR into is_valid_text;
		if is_valid_text = 1 then
			leave ltrim;
		end if;
		set trimmed_text = substring(trimmed_text, 2);
		set i = i + 1;
	end while;
	
	-- Right trim
	set text_length = char_length(trimmed_text);
	rtrim: while -1 >= -text_length do
		select ord(substring(trimmed_text, -1)) not regexp EXPR into is_valid_text;
		if is_valid_text = 1 then
			leave rtrim;
		end if;
		set text_length = text_length - 1;
		set trimmed_text = substring(trimmed_text, 1, text_length);
	end while;
	
	RETURN trimmed_text;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `create_category` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_category`(
	out id_category int(10),
	in category varchar(255)
)
BEGIN
	insert into `category` (
		`Name`
	) values (
		category
	);

	# Return ID of new list to PHP.
	select LAST_INSERT_ID() into id_category;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `create_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_list`(
	# Because the way of returning the ID of list is different between create_list and update_list,
	# they cannot be merged using ON DUPLICATED KEY.

	#out list_id int,
	in list_name varchar(255),		#varchar(255)
	in title varchar(255),			#varchar(255)
	in url varchar(255),			#varchar(255)
	in is_shuffle bit(1),			#bit(1)
	in category_name varchar(255),	#varchar(255)
	in artist_names text			#text
)
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: This procedure is a wrapper for create new catalog.
	-- Note: This procedure should be called from php.
	-- --------------------------------------------------------------------------------	
	declare list_id smallint unsigned;

	-- Abstract:
	--   Abort if length of `artist_names` exceeds limit of text, a type of arg for `insert_artist`.
	#call validate_char_length("artist_names", artist_names, 65535);
	#call validate_boolean("is_shuffle", is_shuffle);
	
	# list_id will be returned by `insert_list`.
	call insert_list(list_id, list_name, title, url, is_shuffle, category_name);
	call insert_artists(list_id, artist_names);
	
	# Return ID of new list to PHP.
	select 'success' as `status`, list_id as `result`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `delete_old_artists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_old_artists`(in list_id int)
BEGIN

declare artist_id int;

 -- 宣言部
 -- ハンドラで利用する変数 v_done を宣言
 declare v_done int default 0;
 -- フェッチした値を格納する変数 artist_name を宣言
 declare artist_name varchar(255);
 -- カーソル宣言

 declare v_cur cursor for
	SELECT * FROM `temp_db_minus`
 ;


 -- SQLステートが02000の場合にv_doneを1にするハンドラを宣言
 declare continue handler for sqlstate '02000' set v_done = 1;

 -- カーソルを開く 
 open v_cur;

 -- repeat関数で繰り返えさせる
 repeat
   -- カーソル v_cur から値を取り出し artist_name に格納
   fetch v_cur into artist_name;
   -- エラーか判断
	if not v_done then
		select ID into artist_id from `artist_info` where `Name`=artist_name;
		#select artist_name as `Artist_Name`, artist_id as `ID_Artist`, list_id as `ID_List`, concat('delete from `artist_and_list` where `ID_Artist`=', artist_id, ' and `ID_List`=', list_id, ';') as `Operation`;
		delete from `artist_and_list` where `ID_Artist`=artist_id and `ID_List`= list_id;
   end if;
 -- エラーの場合はループ終了
 until v_done
 end repeat;

 -- 最後にカーソルを閉じる 
 close v_cur;


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `edit_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_list`(
	in list_id smallint,
	in list_name varchar(255),
	in title varchar(255),
	in url varchar(255),
	in is_shuffle bit(1),
	in category_name varchar(255),
	in artist_names text
)
BEGIN
	call update_list(list_id, list_name, title, url, is_shuffle, category_name);
	call update_artists(list_id, artist_names);

	# Return ID of new list to PHP.
	select 'success' as `status`, list_id as `result`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_artists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_artists`(
	in id_list int(10),
	in artist_names text
)
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: 
	--   This procedure inserts a corresponding `ID_List` and `ID_Category` into `artist_and_list`.
	--   If new artist is specified, we create it before inserting into `artist_info`.
	-- Note: 
	--   This procedure should be called from `create_list` only.
	-- --------------------------------------------------------------------------------
	#declare ARTIST_NAME_LENGTH int(8) default 255; #because its type is varchar(255).
	#declare EXCEEDED_NAME_LENGTH int(5) default 31;

	declare is_new_artist bit(1);
	declare is_duplicated_insert bit(1);
	declare id_artist int(10);
	
	declare delim char(1) default "\n";
	declare delim_length int default char_length(delim);
	declare an_end int(10);
	declare artist_name_original varchar(255);
	declare artist_name_lower varchar(255);
	declare error_message varchar(255);

	-- Abstract:
	--   In order not to overlook last value, `artist_names` should be finish with "\n";
	set artist_names = concat(artist_names, "\n");
	continue_loop: WHILE (LOCATE(delim, artist_names) > 0)
	DO
		set an_end = LOCATE(delim, artist_names) - delim_length;
		if an_end = 0 then
			set an_end = 1;
		end if;

		# Comment out this validation process if it affects to performance.
		#if an_end > ARTIST_NAME_LENGTH then
		#	set error_message = concat('"', substring(artist_names, 1, EXCEEDED_NAME_LENGTH), '..." exceeds limit of length. It should be less than 255 chars.');
		#	select 'error' as `status`, error_message as `result`;
		#	SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = error_message;
		#end if;
		
		SET artist_name_original = trim_value(SUBSTRING(artist_names, 1, an_end));
		SET artist_name_lower = lower(artist_name_original);
		SET artist_names = SUBSTRING(artist_names, LOCATE(delim, artist_names) + delim_length);
		if artist_name_original = "\n" then
			iterate continue_loop;
		end if;
		
		-- Abstract:
		--   If specified artist does not exist, create new artist into `artist_info`
		SELECT count(`Name`)=0, `ID` into is_new_artist, id_artist FROM music_list.`artist_info` where `name_lower` = artist_name_lower;
		if is_new_artist = 1 then
			insert into `artist_info` (`name_lower`, `Name`) values (artist_name_lower, artist_name_original);
			set id_artist = LAST_INSERT_ID();
		end if;
		
		-- Abstract:
		--   Insert datas as usual but skip if duplicated.
		-- BEGINNER'S NOTE:
		--   Since the names of column and variable in where clause are the same, you should specify its table name.
		--   If not, where clause like [`ID` = id] will always be parsed as "true".
		SELECT count(`ID_Artist`)>0 into is_duplicated_insert from music_list.`artist_and_list` where `artist_and_list`.`ID_List` = id_list and `artist_and_list`.`ID_Artist` = id_artist;
		if is_duplicated_insert = 0 then
			insert into `artist_and_list` (
				`ID_List`, `ID_Artist`
			) values (
				id_list, id_artist
			);
		end if;
	END WHILE;
	
	# Return ID of new list to PHP.
	#select LAST_INSERT_ID() into id_category;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_list`(
	out list_id smallint unsigned,
	in list_name varchar(255),
	in title varchar(255),
	in url varchar(255),
	in is_shuffle bit(1),
	in category_name varchar(255)
)
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: This procedure is objected to guarantee the correspondence between list and category.
	--           If new category is specified, we create it before inserting datas into `list`.
	-- Note: This procedure should be called from `create_list` only.
	-- --------------------------------------------------------------------------------
	
	declare is_new_category bit(1);
	declare category_id tinyint unsigned;

	# validator
	# comment out if not needed.
	declare is_listname_exists bit(1);
	declare error_message varchar(255);
	select count(list_name) > 0 into is_listname_exists from `list` where `Name` = list_name;
	if is_listname_exists = 1 then
		set error_message = concat('Specified listname "', list_name ,'" already exists.');
		select 'error' as `status`, error_message as `result`;
		SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = error_message;
	end if;

	-- If specified category name does not exist, create new category and get new `ID_Category`.
	SELECT count(`ID`)=0, `ID` into is_new_category, category_id FROM music_list.`category` where `Name` = category_name;
	if is_new_category = 1 then
		insert into `category` (`Name`) values (category_name);
		set category_id = LAST_INSERT_ID();
	end if;

	-- Insert datas as usual.
	insert into `list` (
		`Name`, `Title`, `Url`, `IsShuffle`, `ID_Category`
	) values (
		list_name, title, url, is_shuffle, category_id
	);

	-- Return ID of new list.
	select LAST_INSERT_ID() into list_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `remove_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `remove_list`(
	in _list_id smallint
)
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: 
	--   This procedure inserts a corresponding `ID_List` and `ID_Category` into `artist_and_list`.
	--   If new artist is specified, we create it before inserting into `artist_info`.
	-- Note: 
	--   This procedure should be called from `create_list` only.
	-- --------------------------------------------------------------------------------
	delete from `list` where `ID` = _list_id;
	
	# Return result to PHP.
	select 'success' as `status`, _list_id as `result`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `remove_obsoleted_artists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `remove_obsoleted_artists`(
	in _id_list smallint,
	in artist_names text
)
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: 
	--   This procedure inserts a corresponding `ID_List` and `ID_Category` into `artist_and_list`.
	--   If new artist is specified, we create it before inserting into `artist_info`.
	-- Note: 
	--   This procedure should be called from `create_list` only.
	-- --------------------------------------------------------------------------------
	#declare ARTIST_NAME_LENGTH int(8) default 255; #because its type is varchar(255).
	#declare EXCEEDED_NAME_LENGTH int(5) default 31;

	declare TEMP_OBSOLETE_LIST varchar(255) default concat('temp_obsolete_list_', now());
	
	declare delim char(1) default "\n";
	declare delim_length int default char_length(delim);
	declare an_end smallint unsigned;
	declare artist_name_original varchar(255);
	declare artist_name_lower varchar(255);
	declare error_message varchar(255);

	
	-- Abstract:
	--   Create a clone table for this id_list;
	create temporary table TEMP_OBSOLETE_LIST select * from `artist_and_list` where `ID_List` = _id_list;

	-- Abstract:
	--   In order not to overlook last value, `artist_names` should be finish with "\n";
	set artist_names = concat(artist_names, "\n");
	continue_loop: WHILE (LOCATE(delim, artist_names) > 0)
	DO
		set an_end = LOCATE(delim, artist_names) - delim_length;
		if an_end = 0 then
			set an_end = 1;
		end if;

		# Comment out this validation process if it affects to performance.
		#if an_end > ARTIST_NAME_LENGTH then
		#	set error_message = concat('"', substring(artist_names, 1, EXCEEDED_NAME_LENGTH), '..." exceeds limit of length. It should be less than 255 chars.');
		#	select 'error' as `status`, error_message as `result`;
		#	SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = error_message;
		#end if;
		
		SET artist_name_original = trim_value(SUBSTRING(artist_names, 1, an_end));
		SET artist_name_lower = lower(artist_name_original);
		SET artist_names = SUBSTRING(artist_names, LOCATE(delim, artist_names) + delim_length);
		if artist_name_original = "\n" then
			iterate continue_loop;
		end if;
		
		-- Abstract:
		--   If specified artist still exists, delete from obsolete list.
		delete from TEMP_OBSOLETE_LIST where `ID_Artist` = (
			select `ID` from artist_info where `name_lower` = artist_name_lower
		);
		
	END WHILE;
	
	-- Abstract:
	--   Delete entry of `artist_and_list` where `ID_Artist` exists in TEMP_OBSOLETE_LIST.
	delete from `artist_and_list` where `ID_List` = _id_list and `ID_Artist` in (select `ID_Artist` from TEMP_OBSOLETE_LIST);
	
	drop table TEMP_OBSOLETE_LIST;
	# Return ID of new list to PHP.
	#select LAST_INSERT_ID() into id_category;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sweap_orphaned_category` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sweap_orphaned_category`()
BEGIN
	declare TABLE_RESULT varchar(255) default concat('temp_result_', now());


	-- 宣言部
	-- ハンドラで利用する変数 v_done を宣言
	declare v_done int default 0;
	
	declare category_id smallint;
	declare is_orphaned_category bit(1);
	
	-- カーソル宣言
	declare v_cur cursor for
		select `ID` from `category`
	;
	-- SQLステートが02000の場合にv_doneを1にするハンドラを宣言
	declare continue handler for sqlstate '02000' set v_done = 1;
	
	-- Create temporary table to show result.
	-- In order to create an empty table, where clause that hits zero row is specified.
	create temporary table TABLE_RESULT select * from `category` where `ID` = -1;

	-- カーソルを開く 
	open v_cur;


	-- repeat関数で繰り返えさせる
	repeat
		-- カーソル v_cur から値を取り出し v_id に格納
		fetch v_cur into category_id;
			-- エラーか判断
			if not v_done then
				
				select count(`ID_Category`)=0 into is_orphaned_category from `list` where `ID_Category` = category_id;
				if is_orphaned_category then
					insert into TABLE_RESULT (select * from `category` where `ID` = category_id);
					delete from `category` where `ID` = category_id;
				end if;

			end if;
			-- エラーの場合はループ終了
		until v_done
	end repeat;

		-- 最後にカーソルを閉じる 
	close v_cur;

	select * from TABLE_RESULT order by `ID`;
	drop table TABLE_RESULT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sweap_orphaned_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sweap_orphaned_list`()
BEGIN
	declare TABLE_RESULT varchar(255) default concat('temp_result_', now());


	-- 宣言部
	-- ハンドラで利用する変数 v_done を宣言
	declare v_done int default 0;
	
	declare list_id smallint;
	declare is_orphaned_list bit(1);
	
	-- カーソル宣言
	declare v_cur cursor for
		select `ID` from `list`
	;
	-- SQLステートが02000の場合にv_doneを1にするハンドラを宣言
	declare continue handler for sqlstate '02000' set v_done = 1;
	
	-- Create temporary table to show result.
	-- In order to create an empty table, where clause that hits zero row is specified.
	create temporary table TABLE_RESULT select * from `list` where `ID` = -1;

	-- カーソルを開く 
	open v_cur;


	-- repeat関数で繰り返えさせる
	repeat
		-- カーソル v_cur から値を取り出し v_id に格納
		fetch v_cur into list_id;
			-- エラーか判断
			if not v_done then
				
				select count(`ID`)=0 into is_orphaned_list from `artist_and_list` where `ID_List` = list_id;
				if is_orphaned_list then
					insert into TABLE_RESULT (select * from `list` where `ID` = list_id);
					delete from `list` where `ID` = list_id;
				end if;

			end if;
			-- エラーの場合はループ終了
		until v_done
	end repeat;

		-- 最後にカーソルを閉じる 
	close v_cur;

	select * from TABLE_RESULT order by `ID`;
	drop table TABLE_RESULT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `tesuto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `tesuto`(
in id bit(2)
)
BEGIN
	select id;

#tinyint = -128 to 127
#tinyint unsigned = 0 to 255
#tinyint(1) = tinyint
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `update_artists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_artists`(
	in id_list smallint,
	in artist_names text
)
BEGIN
	call remove_obsoleted_artists(id_list, artist_names);
	call insert_artists(id_list, artist_names);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `update_artist_and_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_artist_and_list`(in list_id int)
BEGIN
	declare is_artist_exists int;
	declare artist_id int;
	#declare current_id int;
	declare max_id int;

	-- 宣言部
	-- ハンドラで利用する変数 v_done を宣言
	declare v_done int default 0;
	-- フェッチした値を格納する変数 v_id を宣言
	declare artist_name varchar(255);
	-- カーソル宣言
	declare v_cur cursor for
		select * from `temp_db_current`
	;
	-- SQLステートが02000の場合にv_doneを1にするハンドラを宣言
	declare continue handler for sqlstate '02000' set v_done = 1;

	-- カーソルを開く 
	open v_cur;

	-- repeat関数で繰り返えさせる
	repeat
		-- カーソル v_cur から値を取り出し v_id に格納
		fetch v_cur into artist_name;
			-- エラーか判断
			if not v_done then
				select count(`ID`), `ID` into is_artist_exists, artist_id from `artist_info` where name_lower = lower(artist_name);

				if is_artist_exists = 0 then
					# The artist does not exist.
					insert into `artist_info` (`name_lower`, `Name`) values (lower(artist_name), artist_name);
					select LAST_INSERT_ID() into artist_id;
					insert into `artist_and_list` (`ID_List`, `ID_Artist`) values (list_id, artist_id);
				else
					# The artist exists.
					select MAX(`ID`) from `artist_and_list` into max_id;
					insert into `artist_and_list` (`ID_List`, `ID_Artist`) values (list_id, artist_id)
					on duplicate key
					update `ID` = max_id+1;

					#insert into artist_name (Name) values (v_id);
					#select LAST_INSERT_ID() into current_id;
					#insert into artist_info (ID) values (current_id);
					#insert into artist_and_list (ID_Artist, ID_List) values (current_id, list_id);
				end if;

			end if;
			-- エラーの場合はループ終了
		until v_done
	end repeat;

		-- 最後にカーソルを閉じる 
	close v_cur;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `update_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_list`(
	in _list_id smallint,
	in _list_name varchar(255),
	in _title varchar(255),
	in _url varchar(255),
	in _is_shuffle bit(1),
	in _category_name varchar(255)
)
BEGIN
	-- --------------------------------------------------------------------------------
	-- Abstract: This procedure updates list.
	-- Note: This procedure should be called from `edit_list`.
	-- --------------------------------------------------------------------------------	
	declare category_id tinyint unsigned;
	
	set category_id = get_category_id(_category_name);
	
	
	update `list` set
		`Name` = _list_name,
		`Title` = _title,
		`Url` = _url,
		`IsShuffle` = _is_shuffle,
		`ID_Category` = category_id
	where `ID` = _list_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `validate_boolean` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `validate_boolean`(
	in _column_name varchar(64),
	in _target int8 unsigned
)
BEGIN
	declare error_message varchar(255);

	if length(_target) > 2 then
		set error_message = concat('Invalid boolean value has passed to `', _column_name, '`.');
		select 'error' as `status`, error_message as `result`;
		SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = error_message;
	end if;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `validate_char_length` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `validate_char_length`(
	in _column_name varchar(64),
	in _target longtext,
	in _max_length int8 unsigned
)
BEGIN
	declare error_message varchar(255);

	if length(_target) > _max_length then
		set error_message = concat('Too long values has passed to `', _column_name, '`. It should be less than ', _max_length, ' bytes.');
		select 'error' as `status`, error_message as `result`;
		SIGNAL SQLSTATE '23000' SET MESSAGE_TEXT = error_message;
	end if;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `view_artist_info`
--

/*!50001 DROP TABLE IF EXISTS `view_artist_info`*/;
/*!50001 DROP VIEW IF EXISTS `view_artist_info`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_artist_info` AS select `artist_and_list`.`ID_List` AS `ID_List`,`artist_and_list`.`ID_Artist` AS `ID_Artist`,`artist_info`.`Name` AS `Name`,`artist_info`.`Count` AS `Count`,`artist_info`.`Love` AS `Love`,`artist_info`.`Hide` AS `Hide` from (`artist_info` join `artist_and_list` on((`artist_info`.`ID` = `artist_and_list`.`ID_Artist`))) order by `artist_and_list`.`ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_artist_info_full`
--

/*!50001 DROP TABLE IF EXISTS `view_artist_info_full`*/;
/*!50001 DROP VIEW IF EXISTS `view_artist_info_full`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_artist_info_full` AS select `artist_and_list`.`ID` AS `ID`,`artist_and_list`.`ID_Artist` AS `ID_Artist`,`artist_info`.`Name` AS `Artist_Name`,`artist_info`.`Count` AS `Count`,`artist_info`.`Love` AS `Love`,`artist_info`.`Hide` AS `Hide`,`artist_and_list`.`ID_List` AS `ID_List`,`list`.`Title` AS `Title` from ((`artist_info` join `artist_and_list`) join `list`) where ((`artist_and_list`.`ID_Artist` = `artist_info`.`ID`) and (`artist_and_list`.`ID_List` = `list`.`ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_category`
--

/*!50001 DROP TABLE IF EXISTS `view_category`*/;
/*!50001 DROP VIEW IF EXISTS `view_category`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_category` AS select `category`.`ID` AS `ID`,`category`.`Name` AS `Name` from `category` order by `category`.`ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_list`
--

/*!50001 DROP TABLE IF EXISTS `view_list`*/;
/*!50001 DROP VIEW IF EXISTS `view_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_list` AS select `list`.`ID` AS `ID_List`,`list`.`Name` AS `Name`,`list`.`Title` AS `Title`,`list`.`Url` AS `Url`,`list`.`IsShuffle` AS `IsShuffle`,`category`.`ID` AS `ID_Category`,`category`.`Name` AS `Category` from (`list` left join `category` on((`list`.`ID_Category` = `category`.`ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-09 23:33:47


