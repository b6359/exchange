-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 30, 2023 at 08:31 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `change`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE IF NOT EXISTS `app_user` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(20) character set latin1 collate latin1_general_ci default NULL,
  `password` varchar(20) character set latin1 collate latin1_general_ci default NULL,
  `full_name` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `id_trans` bigint(20) default '111',
  `id_filiali` bigint(20) default '1',
  `id_usertype` bigint(20) default '1',
  `phone` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `e_mail` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `date_created` date default NULL,
  `status` char(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `usename` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `app_user`
--

INSERT INTO `app_user` (`id`, `username`, `password`, `full_name`, `id_trans`, `id_filiali`, `id_usertype`, `phone`, `e_mail`, `date_created`, `status`) VALUES
(1, 'Admin', 'Admin', 'Administrator', 111, 1, 1, NULL, NULL, NULL, 'T'),
(2, 'Arka', 'Arka', 'Arka', 112, 1, 2, NULL, NULL, NULL, 'F'),
(3, '1', '1', 'Operator 1', 111, 1, 3, NULL, NULL, NULL, 'F'),
(4, '2', '2', 'Operator 2', 111, 1, 3, NULL, NULL, NULL, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `boa`
--

CREATE TABLE IF NOT EXISTS `boa` (
  `id` bigint(20) NOT NULL auto_increment,
  `dt1` date default NULL,
  `dt2` date default NULL,
  `value` double default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `boa`
--


-- --------------------------------------------------------

--
-- Table structure for table `exchange_detaje`
--

CREATE TABLE IF NOT EXISTS `exchange_detaje` (
  `idd` bigint(20) NOT NULL auto_increment,
  `id_exchangekoke` varchar(250) character set latin1 collate latin1_general_ci default '',
  `id_mondebituar` bigint(20) default '0',
  `vleftadebituar` double default '0',
  `vleftadebituarjocash` double NOT NULL default '0',
  `vleftakredituar` double default '0',
  `kursi` double default NULL,
  `kursi_txt` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `kursi1` double default NULL,
  `kursi1_txt` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  PRIMARY KEY  (`idd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exchange_detaje`
--


-- --------------------------------------------------------

--
-- Table structure for table `exchange_ins`
--

CREATE TABLE IF NOT EXISTS `exchange_ins` (
  `id` bigint(20) NOT NULL auto_increment,
  `changeinsid` varchar(50) NOT NULL,
  `userinsid` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `changeinsid` (`changeinsid`,`userinsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exchange_ins`
--


-- --------------------------------------------------------

--
-- Table structure for table `exchange_koke`
--

CREATE TABLE IF NOT EXISTS `exchange_koke` (
  `unique_id` bigint(20) NOT NULL auto_increment,
  `id` varchar(250) character set latin1 collate latin1_general_ci NOT NULL,
  `id_trans` bigint(20) default '0',
  `date_trans` date default '0000-00-00',
  `tipiveprimit` varchar(5) character set latin1 collate latin1_general_ci default 'CHN',
  `menyrepagese` varchar(10) collate utf8_unicode_ci default 'CASH',
  `pershkrimi` varchar(100) character set latin1 collate latin1_general_ci default 'Veprim Kembimi Monetar',
  `id_llogfilial` bigint(20) default '0',
  `id_monkreditim` bigint(20) default '0',
  `id_klienti` bigint(20) default '0',
  `perqindjekomisioni` double default '0',
  `id_llogkomision` varchar(20) character set latin1 collate latin1_general_ci default '115',
  `vleftakomisionit` double default '0',
  `vlerakthyer` double default '0',
  `vleftapaguar` double default '0',
  `burimteardhura` varchar(255) collate utf8_unicode_ci default NULL,
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `datarregjistrimit` datetime default '0000-00-00 00:00:00',
  `calculate_id` bigint(20) NOT NULL,
  `chstatus` char(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`unique_id`),
  KEY `exchange_idx1` (`unique_id`,`id_monkreditim`,`chstatus`,`id_llogfilial`),
  KEY `exchange_idx2` (`unique_id`,`id_monkreditim`,`chstatus`,`tipiveprimit`,`id_llogfilial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exchange_koke`
--


-- --------------------------------------------------------

--
-- Table structure for table `filiali`
--

CREATE TABLE IF NOT EXISTS `filiali` (
  `id` bigint(20) NOT NULL auto_increment,
  `filiali` varchar(100) character set latin1 collate latin1_general_ci NOT NULL default '',
  `administrator` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `tipi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `kodllogari` varchar(30) collate utf8_unicode_ci NOT NULL,
  `tstatus` varchar(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `filiali`
--

INSERT INTO `filiali` (`id`, `filiali`, `administrator`, `tipi`, `kodllogari`, `tstatus`) VALUES
(1, 'Arka', 'Administrator', 'Arka', '111', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `hyrjedalje`
--

CREATE TABLE IF NOT EXISTS `hyrjedalje` (
  `unique_id` bigint(20) NOT NULL auto_increment,
  `id` varchar(250) character set latin1 collate latin1_general_ci NOT NULL,
  `id_trans` bigint(20) default '0',
  `id_llogari` varchar(30) collate utf8_unicode_ci default NULL,
  `id_llogfilial` bigint(20) default '0',
  `date_trans` date default '0000-00-00',
  `tipiveprimit` varchar(100) character set latin1 collate latin1_general_ci default 'VML',
  `pershkrimi` varchar(500) character set latin1 collate latin1_general_ci default 'Veprim Levizje Monetare me te Trete',
  `id_monedhe` bigint(20) default '0',
  `id_klienti` bigint(20) default '0',
  `drcr` varchar(10) character set latin1 collate latin1_general_ci default 'Kreditim',
  `vleftapaguar` double default '0',
  `rate_value` double default NULL,
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `datarregjistrimit` datetime default '0000-00-00 00:00:00',
  `calculate_id` bigint(20) NOT NULL,
  `chstatus` char(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`unique_id`),
  KEY `hyrjedalje_idx1` (`unique_id`,`id_monedhe`,`chstatus`,`tipiveprimit`),
  KEY `hyrjedalje_idx2` (`unique_id`,`id_monedhe`,`chstatus`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `hyrjedalje`
--


-- --------------------------------------------------------

--
-- Table structure for table `klienti`
--

CREATE TABLE IF NOT EXISTS `klienti` (
  `id` bigint(20) NOT NULL auto_increment,
  `emri` varchar(100) character set latin1 collate latin1_general_ci default '',
  `atesia` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `mbiemri` varchar(100) character set latin1 collate latin1_general_ci default '',
  `emriplote` varchar(100) character set latin1 collate latin1_general_ci default '',
  `emrikompanise` varchar(150) character set utf8 collate utf8_unicode_ci default NULL,
  `dob` varchar(10) character set latin1 collate latin1_general_ci default NULL,
  `gender` varchar(1) character set latin1 collate latin1_general_ci default NULL,
  `nationality` varchar(1) character set latin1 collate latin1_general_ci default NULL,
  `nationalitytxt` varchar(150) character set latin1 collate latin1_general_ci default NULL,
  `telefon` varchar(100) character set latin1 collate latin1_general_ci default '',
  `fax` varchar(100) character set latin1 collate latin1_general_ci default '',
  `email` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `adresa` longtext character set latin1 collate latin1_general_ci,
  `tipdokumenti` int(11) default NULL,
  `nrpashaporte` varchar(100) character set latin1 collate latin1_general_ci default '',
  `nipt` varchar(10) character set utf8 collate utf8_unicode_ci default NULL,
  `docname` varchar(250) character set latin1 collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `klienti_idx1` (`emri`),
  KEY `klienti_idx2` (`emri`,`mbiemri`),
  KEY `klienti_idx3` (`emriplote`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `klienti`
--

INSERT INTO `klienti` (`id`, `emri`, `atesia`, `mbiemri`, `emriplote`, `emrikompanise`, `dob`, `gender`, `nationality`, `nationalitytxt`, `telefon`, `fax`, `email`, `adresa`, `tipdokumenti`, `nrpashaporte`, `nipt`, `docname`) VALUES
(1, '  Klient', NULL, ' Rastesor', '  Klient  Rastesor', NULL, '--', 'M', '0', NULL, '-', '-', '-', '-', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kursi_detaje`
--

CREATE TABLE IF NOT EXISTS `kursi_detaje` (
  `id` bigint(20) NOT NULL auto_increment,
  `master_id` bigint(20) NOT NULL default '0',
  `monedha_id` bigint(20) NOT NULL,
  `kursiblerje` double NOT NULL default '0',
  `kursimesatar` double default '0',
  `kursishitje` double NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kursi_detaje`
--

INSERT INTO `kursi_detaje` (`id`, `master_id`, `monedha_id`, `kursiblerje`, `kursimesatar`, `kursishitje`) VALUES
(1, 1, 2, 100, 100.5, 101),
(2, 1, 3, 105.9, 61.3, 16.7),
(3, 1, 4, 109, 109.5, 110),
(4, 1, 5, 121.5, 122, 122.5);

-- --------------------------------------------------------

--
-- Table structure for table `kursi_eurusd`
--

CREATE TABLE IF NOT EXISTS `kursi_eurusd` (
  `id` bigint(20) NOT NULL auto_increment,
  `master_id` bigint(20) NOT NULL default '0',
  `monedha_id` bigint(20) NOT NULL,
  `kursiblerje` double NOT NULL default '0',
  `kursimesatar` double default '0',
  `kursishitje` double NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kursi_eurusd`
--


-- --------------------------------------------------------

--
-- Table structure for table `kursi_koka`
--

CREATE TABLE IF NOT EXISTS `kursi_koka` (
  `id` bigint(20) NOT NULL auto_increment,
  `id_llogfilial` bigint(20) default NULL,
  `date` date NOT NULL default '0000-00-00',
  `fraksion` int(11) NOT NULL default '0',
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kursi_koka`
--

INSERT INTO `kursi_koka` (`id`, `id_llogfilial`, `date`, `fraksion`, `perdoruesi`) VALUES
(1, 1, '2023-01-01', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `llogarite`
--

CREATE TABLE IF NOT EXISTS `llogarite` (
  `id` bigint(20) NOT NULL auto_increment,
  `llogaria` varchar(100) character set latin1 collate latin1_general_ci NOT NULL COMMENT 'Pershkrimi',
  `kodi` varchar(30) character set latin1 collate latin1_general_ci NOT NULL COMMENT 'Kodi',
  `tipi` varchar(30) character set latin1 collate latin1_general_ci NOT NULL COMMENT 'Aktive/Pasive',
  `veprimi` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT 'Debitim/Kreditim',
  `CHNVL` varchar(1) collate utf8_unicode_ci NOT NULL default 'F',
  `CHNCO` varchar(1) collate utf8_unicode_ci NOT NULL default 'F',
  `TRFVL` varchar(1) collate utf8_unicode_ci default 'F',
  `tstatus` varchar(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `llogarite`
--

INSERT INTO `llogarite` (`id`, `llogaria`, `kodi`, `tipi`, `veprimi`, `CHNVL`, `CHNCO`, `TRFVL`, `tstatus`) VALUES
(1, 'Arka', '111', 'Aktive', 'D/C', 'T', 'F', 'F', 'T'),
(2, 'xChange', '112', 'Aktive', 'D/C', 'F', 'F', NULL, 'T'),
(3, 'Banka Kombetare Tregtare', '113', 'Aktive', 'D/C', 'F', 'F', 'T', 'T'),
(4, 'Ak Invest', '114', 'Aktive', 'D/C', 'F', 'F', NULL, 'T'),
(5, 'Komision Kembimi Valutor', '115', 'Aktive', 'C', 'F', 'T', 'F', 'T'),
(6, 'Te ardhura nga Komisionet Moneygram', '114001', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(7, 'Te ardhura nga Komisionet per transferta te brendshme', '114002', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(8, 'Te ardhura nga Komisionet per gjobat e policise', '114003', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(9, 'Te ardhura nga Komisionet per arketimet e OSHEE', '114004', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(10, 'Te ardhura nga konvertimet', '111001', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(14, 'Shpenzime per pagat e punonjesve', '111003', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(13, 'Shpenzime per komisione bankare', '111002', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(15, 'Shpenzime per sigurimet shoqerore dhe shendetesore', '111004', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(16, 'Taksat e Bashkise', '111005', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(17, 'Shpenzime qiraje', '111006', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(18, 'Shpenzime Zyre (kancelari apo blerje te ndryshme per zyre)', '111007', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(19, 'Shpenzime Telefoni', '111008', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(20, 'Shpenzime Energji Elektrike', '111009', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(21, 'Shpenzime Uje', '111010', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(22, 'Te Ardhura nga Biletat e Avionit', '112001', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(23, ' Te Ardhura Anije Turistike', '112002', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(24, 'Shpenzime Security', '111011', 'Aktive', 'C', 'F', 'F', NULL, 'T'),
(25, 'Te Ardhura Qira Ditore', '112003', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(26, 'Komisione per sherbime me te trete(10%)', '112004', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(28, 'Komisione per Qira', '116001', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(29, 'Komision per Shitje', '116002', 'Pasive', 'D', 'F', 'F', NULL, 'T'),
(30, 'Kembim Valute me te trete', '111012', 'Aktive', 'C', 'T', 'T', NULL, 'T');

-- --------------------------------------------------------

--
-- Table structure for table `monedha`
--

CREATE TABLE IF NOT EXISTS `monedha` (
  `id` bigint(20) NOT NULL auto_increment,
  `monedha` varchar(4) character set latin1 collate latin1_general_ci NOT NULL default '',
  `simboli` varchar(10) character set latin1 collate latin1_general_ci default NULL,
  `mon_vendi` char(1) character set latin1 collate latin1_general_ci default 'J',
  `kursi_min` double default NULL,
  `kursi_max` double default NULL,
  `pershkrimi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `boaorder` int(11) default NULL,
  `taborder` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `monedha`
--

INSERT INTO `monedha` (`id`, `monedha`, `simboli`, `mon_vendi`, `kursi_min`, `kursi_max`, `pershkrimi`, `boaorder`, `taborder`) VALUES
(1, 'LEK', 'L', 'P', 1, 1, 'Leku Shqiptar', 0, NULL),
(2, 'USD', '$', 'J', 1, 300, 'US Dollar', 1, 1),
(3, 'EUR', '€', 'J', 1, 300, 'Europian EURO', 2, 2),
(4, 'CHF', 'CHF', 'J', 1, 300, 'Franga Zviceriane', 3, 3),
(5, 'GBP', 'GBP', 'J', 1, 300, 'Paund Britanik', 4, 4),
(6, 'DKK', 'DKK', 'J', 1, 300, 'Krona Daneze', 5, 5),
(7, 'NOK', 'NOK', 'J', 1, 300, 'Krona Norvegjeze', 6, 6),
(8, 'SEK', 'SEK', 'J', 1, 300, 'Krona Suedeze', 7, 7),
(9, 'CAD', 'CAD', 'J', 1, 300, 'Dollar Kanadez', 8, 8),
(10, 'AUD', 'AUD', 'J', 1, 300, 'Dollar Australian', 9, 9),
(11, 'MKD', 'MKD', 'J', 1, 300, 'Dinar Maqedonas', 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `openbalance`
--

CREATE TABLE IF NOT EXISTS `openbalance` (
  `id` bigint(20) NOT NULL auto_increment,
  `date_trans` date default '0000-00-00',
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `id_llogfilial` bigint(20) default NULL,
  `monedha_id` bigint(20) default NULL,
  `vleftakredituar` double default NULL,
  `rate_value` double default NULL,
  `datarregjistrimit` datetime default '0000-00-00 00:00:00',
  `chstatus` char(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`id`),
  KEY `openbal_idx1` (`id`,`monedha_id`,`chstatus`,`id_llogfilial`),
  KEY `openbal_idx2` (`id`,`monedha_id`,`chstatus`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `openbalance`
--


-- --------------------------------------------------------

--
-- Table structure for table `openbalance_detaje`
--

CREATE TABLE IF NOT EXISTS `openbalance_detaje` (
  `id` bigint(20) NOT NULL auto_increment,
  `master_id` bigint(20) NOT NULL default '0',
  `monedha_id` bigint(20) NOT NULL,
  `vleftakredituar` double default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `openbalance_detaje`
--


-- --------------------------------------------------------

--
-- Table structure for table `openbalance_koka`
--

CREATE TABLE IF NOT EXISTS `openbalance_koka` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` date default '0000-00-00',
  `perdoruesi` varchar(100) collate latin1_general_ci default NULL,
  `datarregjistrimit` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `openbalance_koka`
--


-- --------------------------------------------------------

--
-- Table structure for table `opencloseday`
--

CREATE TABLE IF NOT EXISTS `opencloseday` (
  `id` int(11) NOT NULL auto_increment,
  `opdate` date default NULL,
  `opstatus` char(1) character set latin1 collate latin1_general_ci default 'C' COMMENT 'C - Close; O - Open',
  `opuser` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `opencloseday`
--

INSERT INTO `opencloseday` (`id`, `opdate`, `opstatus`, `opuser`) VALUES
(1, '2023-01-01', 'O', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prerjemonedhe`
--

CREATE TABLE IF NOT EXISTS `prerjemonedhe` (
  `id` bigint(20) NOT NULL auto_increment,
  `id_monedha` bigint(20) NOT NULL default '0',
  `prerja` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `prerjemonedhe`
--


-- --------------------------------------------------------

--
-- Table structure for table `systembalance`
--

CREATE TABLE IF NOT EXISTS `systembalance` (
  `id` bigint(20) NOT NULL auto_increment,
  `date_trans` date default '0000-00-00',
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `id_llogfilial` bigint(20) default NULL,
  `id_chn` bigint(20) default NULL,
  `id_hd` bigint(20) default NULL,
  `id_opb` bigint(20) default NULL,
  `LEK` double default NULL,
  `USD` double default NULL,
  `EUR` double default NULL,
  `CHF` double default NULL,
  `GBP` double default NULL,
  `DKK` double default NULL,
  `NOK` double default NULL,
  `SEK` double default NULL,
  `CAD` double default NULL,
  `AUD` double default NULL,
  `MKD` double default NULL,
  `LEKRATE` double default NULL,
  `USDRATE` double default NULL,
  `EURRATE` double default NULL,
  `CHFRATE` double default NULL,
  `GBPRATE` double default NULL,
  `DKKRATE` double default NULL,
  `NOKRATE` double default NULL,
  `SEKRATE` double default NULL,
  `CADRATE` double default NULL,
  `AUDRATE` double default NULL,
  `MKDRATE` double default NULL,
  `datarregjistrimit` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `systembalance`
--

INSERT INTO `systembalance` (`id`, `date_trans`, `perdoruesi`, `id_llogfilial`, `id_chn`, `id_hd`, `id_opb`, `LEK`, `USD`, `EUR`, `CHF`, `GBP`, `DKK`, `NOK`, `SEK`, `CAD`, `AUD`, `MKD`, `LEKRATE`, `USDRATE`, `EURRATE`, `CHFRATE`, `GBPRATE`, `DKKRATE`, `NOKRATE`, `SEKRATE`, `CADRATE`, `AUDRATE`, `MKDRATE`, `datarregjistrimit`) VALUES
(1, '2023-01-01', 'admin', 1, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2023-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `systembalance_hist`
--

CREATE TABLE IF NOT EXISTS `systembalance_hist` (
  `id` bigint(20) NOT NULL auto_increment,
  `date_trans` date default '0000-00-00',
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `id_llogfilial` bigint(20) default NULL,
  `id_chn` bigint(20) default NULL,
  `id_hd` bigint(20) default NULL,
  `id_opb` bigint(20) default NULL,
  `LEK` double default NULL,
  `USD` double default NULL,
  `EUR` double default NULL,
  `CHF` double default NULL,
  `GBP` double default NULL,
  `DKK` double default NULL,
  `NOK` double default NULL,
  `SEK` double default NULL,
  `CAD` double default NULL,
  `AUD` double default NULL,
  `MKD` double default NULL,
  `LEKRATE` double default NULL,
  `USDRATE` double default NULL,
  `EURRATE` double default NULL,
  `CHFRATE` double default NULL,
  `GBPRATE` double default NULL,
  `DKKRATE` double default NULL,
  `NOKRATE` double default NULL,
  `SEKRATE` double default NULL,
  `CADRATE` double default NULL,
  `AUDRATE` double default NULL,
  `MKDRATE` double default NULL,
  `datarregjistrimit` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `systembalance_hist`
--

INSERT INTO `systembalance_hist` (`id`, `date_trans`, `perdoruesi`, `id_llogfilial`, `id_chn`, `id_hd`, `id_opb`, `LEK`, `USD`, `EUR`, `CHF`, `GBP`, `DKK`, `NOK`, `SEK`, `CAD`, `AUD`, `MKD`, `LEKRATE`, `USDRATE`, `EURRATE`, `CHFRATE`, `GBPRATE`, `DKKRATE`, `NOKRATE`, `SEKRATE`, `CADRATE`, `AUDRATE`, `MKDRATE`, `datarregjistrimit`) VALUES
(1, '2023-01-01', 'admin', 1, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2023-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblalltransactions`
--

CREATE TABLE IF NOT EXISTS `tblalltransactions` (
  `unique_id` bigint(20) NOT NULL auto_increment,
  `id_veprimi` varchar(250) collate utf8_unicode_ci default NULL,
  `date_trans` date default '0000-00-00',
  `tipiveprimit` varchar(5) character set latin1 collate latin1_general_ci default NULL,
  `pershkrimi` varchar(250) character set latin1 collate latin1_general_ci default NULL,
  `id_filiali` bigint(20) default NULL,
  `id_llogari` varchar(30) collate utf8_unicode_ci default NULL,
  `id_monedhe` bigint(20) default NULL,
  `id_klienti` bigint(20) default NULL,
  `vleradebituar` double default '0',
  `vlerakredituar` double default '0',
  `kursi` double default NULL,
  `perdoruesi` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `datarregjistrimit` datetime default '0000-00-00 00:00:00',
  `chstatus` char(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`unique_id`),
  KEY `exchange_idx1` (`unique_id`,`id_monedhe`,`chstatus`,`id_filiali`),
  KEY `exchange_idx2` (`unique_id`,`id_monedhe`,`chstatus`,`tipiveprimit`,`id_filiali`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tblalltransactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `id` bigint(20) NOT NULL auto_increment,
  `description` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `tstatus` varchar(1) character set latin1 collate latin1_general_ci default 'T',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `description`, `tstatus`) VALUES
(1, 'Admin. Kryesor', 'T'),
(2, 'Admin. Dege', 'T'),
(3, 'Operator', 'T');
