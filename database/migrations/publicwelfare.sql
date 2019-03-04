-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2018-12-20 20:55:01
-- 服务器版本： 5.7.23
-- PHP 版本： 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `publicwelfare`
--

-- --------------------------------------------------------

--
-- 表的结构 `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `A_Number1` int(10) NOT NULL,
  `A_Theme` text NOT NULL,
  `A_Namet` text NOT NULL,
  `A_Purpose` text NOT NULL,
  `A_Meaning` text NOT NULL,
  `A_Object` text NOT NULL,
  `A_Time` date NOT NULL,
  `A_Place` text NOT NULL,
  `A_Organizer` text NOT NULL,
  `A_Prepare` text NOT NULL,
  `A_Pay` text NOT NULL,
  `A_Budget` text NOT NULL,
  `S_Number` int(10) NOT NULL,
  `C_Commont` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `activity`
--

INSERT INTO `activity` (`A_Number1`, `A_Theme`, `A_Namet`, `A_Purpose`, `A_Meaning`, `A_Object`, `A_Time`, `A_Place`, `A_Organizer`, `A_Prepare`, `A_Pay`, `A_Budget`, `S_Number`, `C_Commont`) VALUES
(1, '扬志愿精神树和谐之风展绿城之翼构卫生城市', '保护碧水蓝天，创建环保益阳', '通过组织青年志愿者的活动来改善当地周边环境\r\n通过青年志愿者宣传提高和增强广大群众的环保意识、环保知识\r\n', '唤起社会公民环保意识，用实际行动保护我们共有的家园', '成功报名义工', '2018-12-05', '广州越秀公园', '艺术与设计学院', '着手准备展板、横幅等宣传媒介以及当天现场活动所需材料', '活动期间请各位义工要注意安全，看见乱扔垃圾的市民且误与之争吵，要好言相劝', '展板：30*10=300元　　\r\n横幅：70*1＝70元　　\r\n饮用水：35*3=105元　　医疗用品：55元\r\n', 1, -1);

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `A_Number` int(8) NOT NULL,
  `A_Password` text NOT NULL,
  `A_Name` text NOT NULL,
  `A_Sex` int(1) NOT NULL,
  `A_BornDate` date NOT NULL,
  `A_Marriage` tinyint(1) NOT NULL,
  `A_PoliticsVisage` text NOT NULL,
  `A_SchoolAge` text NOT NULL,
  `A_Address` text NOT NULL,
  `A_Telephone` int(15) NOT NULL,
  `A_Email` text NOT NULL,
  PRIMARY KEY (`A_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`A_Number`, `A_Password`, `A_Name`, `A_Sex`, `A_BornDate`, `A_Marriage`, `A_PoliticsVisage`, `A_SchoolAge`, `A_Address`, `A_Telephone`, `A_Email`) VALUES
(1, 'xy061208ab', '欧阳长征', 1, '1986-10-01', 1, '党员', '本科', '北京胡同50号', 62537485, 'cz86@sina.com');

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `M_Number` int(8) NOT NULL,
  `M_Approval` int(1) NOT NULL,
  `M_Content` text NOT NULL,
  `M_ReleaseDate` date NOT NULL,
  `V_Number` int(8) NOT NULL,
  PRIMARY KEY (`M_Number`),
  KEY `volunteer` (`V_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`M_Number`, `M_Approval`, `M_Content`, `M_ReleaseDate`, `V_Number`) VALUES
(1, 1, '参加活动很开心', '2018-04-22', 1);

-- --------------------------------------------------------

--
-- 表的结构 `organizer`
--

DROP TABLE IF EXISTS `organizer`;
CREATE TABLE IF NOT EXISTS `organizer` (
  `O_Number` int(10) NOT NULL,
  `O_Name` text NOT NULL,
  `O_Head` text NOT NULL,
  `O_Address` text NOT NULL,
  `O_Telephone` int(15) NOT NULL,
  `O_Email` text NOT NULL,
  PRIMARY KEY (`O_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `organizer`
--

INSERT INTO `organizer` (`O_Number`, `O_Name`, `O_Head`, `O_Address`, `O_Telephone`, `O_Email`) VALUES
(1, '艺术与设计学院', '欧阳长征', '广东工业大学', 12345678, 'cz86@sina.com');

-- --------------------------------------------------------

--
-- 表的结构 `recipient`
--

DROP TABLE IF EXISTS `recipient`;
CREATE TABLE IF NOT EXISTS `recipient` (
  `R_Number` int(8) NOT NULL,
  `R_Name` text NOT NULL,
  `R_Sex` int(2) NOT NULL,
  `R_BornDate` date NOT NULL,
  `R_Address` text NOT NULL,
  `R_Telephone` int(15) NOT NULL,
  `R_Email` text NOT NULL,
  `R_Code` text NOT NULL,
  `R_Situation` text NOT NULL,
  `S_Number` int(10) NOT NULL,
  PRIMARY KEY (`R_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `recipient`
--

INSERT INTO `recipient` (`R_Number`, `R_Name`, `R_Sex`, `R_BornDate`, `R_Address`, `R_Telephone`, `R_Email`, `R_Code`, `R_Situation`, `S_Number`) VALUES
(1, '欧阳长征', 1, '1986-10-01', '北京胡同50号', 62537485, 'cz86@sina.com', '100000', '贫困', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sponsor`
--

DROP TABLE IF EXISTS `sponsor`;
CREATE TABLE IF NOT EXISTS `sponsor` (
  `S_Number` int(8) NOT NULL,
  `S_Units` text NOT NULL,
  `S_Password` text NOT NULL,
  `S_Name` text NOT NULL,
  `S_Address` text NOT NULL,
  `S_Telephone` int(15) NOT NULL,
  `S_Email` text NOT NULL,
  `S_Code` int(15) NOT NULL,
  `A_Number` int(10) NOT NULL,
  `R_Number` int(10) NOT NULL,
  PRIMARY KEY (`S_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sponsor`
--

INSERT INTO `sponsor` (`S_Number`, `S_Units`, `S_Password`, `S_Name`, `S_Address`, `S_Telephone`, `S_Email`, `S_Code`, `A_Number`, `R_Number`) VALUES
(1, '北京邮政局', 'xy061208ab', '欧阳长征', '北京胡同50号', 62537485, 'cz86@sina.com', 100000, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `training`
--

DROP TABLE IF EXISTS `training`;
CREATE TABLE IF NOT EXISTS `training` (
  `T_Number` int(8) NOT NULL,
  `T_Object` text NOT NULL,
  `T_Volunteers` text NOT NULL,
  `T_Organization` text NOT NULL,
  `T_Purpose` text NOT NULL,
  `T_Content` text NOT NULL,
  `T_Size` int(8) NOT NULL,
  `T_Way` text NOT NULL,
  PRIMARY KEY (`T_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `training`
--

INSERT INTO `training` (`T_Number`, `T_Object`, `T_Volunteers`, `T_Organization`, `T_Purpose`, `T_Content`, `T_Size`, `T_Way`) VALUES
(1, '灾区群众', '黄花岗社区志愿者', '黄花岗社区志愿者组织', '使志愿者具备志愿服务必需的知识技能，具备较强的服务意识、服务精神和服务能力', '志愿服务理念培训、志愿服务礼仪培训、应急救援、志愿者自护、医疗常识培训', 20, '在线授课、实地观摩、个案研究');

-- --------------------------------------------------------

--
-- 表的结构 `volunteer`
--

DROP TABLE IF EXISTS `volunteer`;
CREATE TABLE IF NOT EXISTS `volunteer` (
  `V_Number` int(8) NOT NULL COMMENT '义工编号',
  `V_Password` text NOT NULL COMMENT '登陆密码',
  `V_Name` text NOT NULL COMMENT '姓名',
  `V_Sex` int(1) NOT NULL COMMENT '性别',
  `V_BornDate` date NOT NULL COMMENT '出生日期',
  `V_Address` text NOT NULL COMMENT '住址',
  `V_Telephone` int(20) NOT NULL COMMENT '联系电话',
  `V_Email` text NOT NULL COMMENT '电子邮箱',
  `V_Code` text NOT NULL COMMENT '邮政编码',
  `V_Level` int(4) NOT NULL COMMENT '等级',
  `A_Number` int(4) NOT NULL COMMENT '参与活动',
  `V_Attendance` float NOT NULL DEFAULT '0',
  `V_Pass` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`V_Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `volunteer`
--

INSERT INTO `volunteer` (`V_Number`, `V_Password`, `V_Name`, `V_Sex`, `V_BornDate`, `V_Address`, `V_Telephone`, `V_Email`, `V_Code`, `V_Level`, `A_Number`, `V_Attendance`, `V_Pass`) VALUES
(1, 'xy061208ab', '欧阳长征', 1, '1986-10-01', '北京胡同50号', 62537485, 'cz86@sina.com', '100000', 1, 1, 0, 0);
