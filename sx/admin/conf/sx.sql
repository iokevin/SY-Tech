-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 20 日 22:26
-- 服务器版本: 5.1.63
-- PHP 版本: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sxdf__db`
--
CREATE DATABASE `sxdf__db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sxdf__db`;

-- --------------------------------------------------------

--
-- 表的结构 `adm_accounts`
--

CREATE TABLE IF NOT EXISTS `adm_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `leixing` int(11) DEFAULT NULL,
  `liuyan` text,
  `huifu` text,
  `zhuangtai` tinyint(2) unsigned DEFAULT '0',
  `time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1221 ;

--
-- 转存表中的数据 `adm_accounts`
--

INSERT INTO `adm_accounts` (`id`, `username`, `leixing`, `liuyan`, `huifu`, `zhuangtai`, `time`) VALUES
(1220, 'nicko', 1, '开户行：农业银行\r<br>姓名：李娟\r<br>帐号：655558515669858962<br>结算金额:652元<br>结算ID号是:<a href=''/apply/more?id=1229''>1229</a>', NULL, 0, 1395221675),
(1219, 'SASA', 1, '开户行：飞\r<br>姓名：&nbsp;飞\r<br>帐号：6222222222222<br>结算金额:172.88元<br>结算ID号是:<a href=''/apply/more?id=1228''>1228</a>', NULL, 0, 1395221665),
(24, 'imok', 1, '开户行：工行\r<br>姓名：陈冲\r<br>帐号：123654789652<br>结算金额:566元<br>结算ID号是:<a href=''/apply/more?id=26''>26</a>', NULL, 1, 1395111648),
(1218, 'ok', 1, '开户行：工行\r<br>姓名：\r<br>帐号：<br>结算金额:911.96元<br>结算ID号是:<a href=''/apply/more?id=1007''>1007</a>', NULL, 0, 1395154941);

-- --------------------------------------------------------

--
-- 表的结构 `adm_admin`
--

CREATE TABLE IF NOT EXISTS `adm_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` tinyint(4) DEFAULT '1',
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL,
  `login_ip` varchar(15) DEFAULT NULL,
  `lock` tinyint(3) DEFAULT '0',
  `xingming` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `adm_admin`
--



-- --------------------------------------------------------

--
-- 表的结构 `adm_banner`
--

CREATE TABLE IF NOT EXISTS `adm_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_show` tinyint(1) DEFAULT '1',
  `adddate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `adm_banner`
--


-- --------------------------------------------------------

--
-- 表的结构 `adm_group`
--

CREATE TABLE IF NOT EXISTS `adm_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `power_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `adm_group`
--

INSERT INTO `adm_group` (`id`, `name`, `power_value`) VALUES
(1, '超级管理员', '-1'),
(2, '管理员', '63,64,65,66,67,68,69,70,71,72,73'),
(5, '订单管理员', '1,8,9,10,14,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,138,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,167,168,169,170,171,172,173,174,176,177,179,81,82,83,84,85,86,87,88,89'),
(7, '发货管理员', '1,8,9,10,14,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,138,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,167,168,169,170,171,172,173,174,176,177,179,180,181,182,183,184,185,186,81,82,83,84,85,86,87,180'),
(8, '客服管理', '1,8,9,10,14,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,138,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,167,168,169,170,171,172,173,174,176,177,179,180,181,182,183,184,185,186,81,82,83,84,85,86,87,180,162,163,164,165'),
(9, '管理员', '1,8,9,10,14,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,138,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,167,168,169,170,171,172,173,174,176,177,179,180,181,182,183,184,185,186,81,82,83,84,85,86,87,180,162,163,164,165,11,12,13');

-- --------------------------------------------------------

--
-- 表的结构 `adm_history`
--

CREATE TABLE IF NOT EXISTS `adm_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `money` decimal(10,2) DEFAULT '0.00',
  `dingdanid` varchar(255) DEFAULT NULL,
  `beizhu` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1230 ;

--
-- 转存表中的数据 `adm_history`
--

INSERT INTO `adm_history` (`id`, `userid`, `money`, `dingdanid`, `beizhu`, `time`) VALUES
(1229, 524, 652.00, '5370|', '结算的订单编号|5370|<br>结算合计：652', 1395221675),
(23, 513, 858.42, '14|16|17|', '结算的订单编号|14|16|17|<br>结算合计：858.42', 1378865562),
(1228, 523, 172.88, '5371|', '结算的订单编号|5371|<br>结算合计：172.88', 1395221665),
(25, 513, 769.80, '523|524|', '结算的订单编号|523|524|<br>结算合计：769.8', 1386053410),
(26, 521, 566.00, '532|', '结算的订单编号|532|<br>结算合计：566', 1395111648),
(1007, 522, 911.96, '5369|', '结算的订单编号|5369|<br>结算合计：911.96', 1395154941);

-- --------------------------------------------------------

--
-- 表的结构 `adm_link`
--

CREATE TABLE IF NOT EXISTS `adm_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `adddate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `adm_link`
--

INSERT INTO `adm_link` (`id`, `name`, `pic`, `url`, `info`, `adddate`) VALUES
(1, '品牌名', '图片', '品牌URL', '信息', '2013-04-01 16:19:32'),
(2, '品牌1', '', '品牌url', '', '2013-04-01 16:28:46');

-- --------------------------------------------------------

--
-- 表的结构 `adm_log`
--

CREATE TABLE IF NOT EXISTS `adm_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT '0',
  `time` int(11) DEFAULT NULL,
  `leixing` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=797 ;

--
-- 转存表中的数据 `adm_log`
--

INSERT INTO `adm_log` (`id`, `user`, `ip`, `time`, `leixing`, `address`) VALUES
(796, 'iokevin', '183.3.95.81', 1395309618, '用户登录', '广东省广州市电信'),
(795, 'lanbo', '183.3.95.81', 1395309047, '管理登录', '广东省广州市电信'),
(794, 'lanbo', '117.136.31.191', 1395291547, '管理登录', '广东省移动(全省通用)'),
(793, 'kevin', '183.3.95.243', 1395287496, '管理登录', '广东省广州市电信'),
(792, 'kevin', '183.3.95.243', 1395279908, '管理登录', '广东省广州市电信'),
(791, 'lanbo', '113.65.214.162', 1395235230, '管理登录', '广东省广州市电信'),
(790, 'kevin', '113.65.214.162', 1395235206, '管理登录', '广东省广州市电信'),
(789, 'fahuo', '113.65.214.162', 1395235099, '管理登录', '广东省广州市电信'),
(788, 'zhangmin', '113.65.214.162', 1395235034, '管理登录', '广东省广州市电信'),
(787, 'ouyuan', '113.65.214.162', 1395234940, '管理登录', '广东省广州市电信'),
(786, 'kevin', '113.65.214.162', 1395234901, '管理登录', '广东省广州市电信'),
(785, 'kevin', '113.65.214.162', 1395234561, '管理登录', '广东省广州市电信'),
(784, 'fahuo', '113.65.214.162', 1395234236, '管理登录', '广东省广州市电信'),
(783, 'fahuo', '113.65.214.162', 1395234183, '管理登录', '广东省广州市电信'),
(782, 'kevin', '113.65.214.162', 1395234148, '管理登录', '广东省广州市电信'),
(781, 'fahuo', '113.65.214.162', 1395234093, '管理登录', '广东省广州市电信'),
(780, 'fahuo', '113.65.214.162', 1395234054, '管理登录', '广东省广州市电信'),
(779, 'fahuo', '113.65.214.162', 1395233107, '管理登录', '广东省广州市电信'),
(778, 'fahuo', '113.65.214.162', 1395232229, '管理登录', '广东省广州市电信'),
(777, 'fahuo', '113.65.214.162', 1395232200, '管理登录', '广东省广州市电信'),
(776, 'kevin', '113.65.214.162', 1395231830, '管理登录', '广东省广州市电信'),
(775, 'kevin', '113.65.214.162', 1395230508, '管理登录', '广东省广州市电信'),
(774, 'lanbo', '183.3.99.89', 1395223708, '管理登录', '广东省广州市电信'),
(773, 'kevin', '183.3.99.89', 1395223625, '管理登录', '广东省广州市电信'),
(772, 'iokevin', '183.3.99.89', 1395223602, '用户登录', '广东省广州市电信'),
(771, 'nicko', '183.3.99.89', 1395220943, '用户登录', '广东省广州市电信'),
(770, 'SASA', '183.3.99.89', 1395220893, '用户登录', '广东省广州市电信'),
(769, 'lanbo', '183.3.99.89', 1395220857, '管理登录', '广东省广州市电信'),
(768, 'kevin', '183.3.99.89', 1395205946, '管理登录', '广东省广州市电信'),
(726, 'admin', '183.3.77.1', 1394891557, '管理登录', '广东省广州市电信'),
(727, 'iokevin', '183.3.49.184', 1394901777, '用户登录', '广东省广州市电信'),
(728, 'iokevin', '183.3.49.184', 1394908438, '用户登录', '广东省广州市电信'),
(729, 'iokevin', '183.3.56.242', 1394950123, '用户登录', '广东省广州市电信'),
(730, 'iokevin', '183.3.56.242', 1394954059, '用户登录', '广东省广州市电信'),
(731, 'admin', '183.3.56.242', 1394955364, '管理登录', '广东省广州市电信'),
(732, 'iokevin', '183.3.55.151', 1394989183, '用户登录', '广东省广州市电信'),
(733, 'admin', '183.3.98.163', 1395027716, '管理登录', '广东省广州市电信'),
(734, 'admin', '183.3.98.163', 1395028014, '管理登录', '广东省广州市电信'),
(735, 'kevin', '183.3.98.163', 1395028040, '管理登录', '广东省广州市电信'),
(736, 'kevin', '183.3.98.163', 1395047341, '管理登录', '广东省广州市电信'),
(737, 'iokevin', '183.3.98.163', 1395048270, '用户登录', '广东省广州市电信'),
(738, 'kevin', '14.145.30.133', 1395065367, '管理登录', '广东省广州市电信'),
(739, 'lanbo', '14.145.30.133', 1395065468, '管理登录', '广东省广州市电信'),
(740, 'lanbo', '14.145.30.133', 1395065475, '管理登录', '广东省广州市电信'),
(741, 'imok', '14.145.30.133', 1395065572, '用户登录', '广东省广州市电信'),
(742, 'imok', '119.147.225.152', 1395105417, '用户登录', '广东省电信'),
(743, 'kevin', '183.3.97.165', 1395118912, '管理登录', '广东省广州市电信'),
(744, 'lanbo', '117.136.40.28', 1395119020, '管理登录', '中国移动'),
(745, 'test', '183.3.97.165', 1395119113, '管理登录', '广东省广州市电信'),
(746, 'lanbo', '117.136.40.28', 1395119547, '管理登录', '中国移动'),
(747, 'imok', '117.136.40.28', 1395119887, '用户登录', '中国移动'),
(748, 'kevin', '183.3.97.165', 1395120303, '管理登录', '广东省广州市电信'),
(749, 'admin', '183.3.97.165', 1395128577, '管理登录', '广东省广州市电信'),
(750, 'iokevin', '183.3.97.165', 1395129105, '用户登录', '广东省广州市电信'),
(751, 'lanbo', '183.3.97.165', 1395134717, '管理登录', '广东省广州市电信'),
(752, 'kevin', '183.3.97.165', 1395143877, '管理登录', '广东省广州市电信'),
(753, 'imok', '183.3.97.165', 1395147509, '用户登录', '广东省广州市电信'),
(754, 'lanbo', '183.3.97.165', 1395148380, '管理登录', '广东省广州市电信'),
(755, 'kevin', '183.3.97.165', 1395149941, '管理登录', '广东省广州市电信'),
(756, 'iokevin', '183.3.97.165', 1395152586, '用户登录', '广东省广州市电信'),
(757, 'iokevin', '183.3.97.165', 1395152735, '用户登录', '广东省广州市电信'),
(758, 'imok', '183.3.97.165', 1395154069, '用户登录', '广东省广州市电信'),
(759, 'ok', '183.3.97.165', 1395154809, '用户登录', '广东省广州市电信'),
(760, 'admin', '183.3.97.165', 1395155378, '管理登录', '广东省广州市电信'),
(761, 'iokevin', '183.3.75.203', 1395165011, '用户登录', '广东省广州市电信'),
(762, 'iokevin', '183.3.99.89', 1395191888, '用户登录', '广东省广州市电信'),
(763, 'iokevin', '183.3.99.89', 1395191889, '用户登录', '广东省广州市电信'),
(764, 'admin', '183.3.99.89', 1395192244, '管理登录', '广东省广州市电信'),
(765, 'kevin', '183.3.99.89', 1395200408, '管理登录', '广东省广州市电信'),
(766, 'kevin', '183.3.99.89', 1395202846, '管理登录', '广东省广州市电信'),
(767, 'kevin', '183.3.99.89', 1395203937, '管理登录', '广东省广州市电信');

-- --------------------------------------------------------

--
-- 表的结构 `adm_model`
--

CREATE TABLE IF NOT EXISTS `adm_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `mark` varchar(20) DEFAULT NULL,
  `list_name` varchar(50) DEFAULT NULL,
  `list_url` varchar(50) DEFAULT NULL,
  `add_name` varchar(50) DEFAULT NULL,
  `add_url` varchar(50) DEFAULT NULL,
  `edit_name` varchar(50) DEFAULT NULL,
  `edit_url` varchar(50) DEFAULT NULL,
  `del_url` varchar(50) DEFAULT NULL,
  `add_content_name` varchar(50) DEFAULT NULL,
  `add_content_url` varchar(50) DEFAULT NULL,
  `edit_content_name` varchar(50) DEFAULT NULL,
  `edit_content_url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `adm_model`
--

INSERT INTO `adm_model` (`id`, `name`, `mark`, `list_name`, `list_url`, `add_name`, `add_url`, `edit_name`, `edit_url`, `del_url`, `add_content_name`, `add_content_url`, `edit_content_name`, `edit_content_url`) VALUES
(1, '文章模块', 'article', '文章列表', '/article/index', '添加列表', '/article_channel/add', '设置', '/article_channel/edit', '/article_channel/del', '添加文章', '/article/add', '编辑文章', '/article/edit'),
(2, '单页模块', 'page', '', '', '添加单页', '/singlepage/add', '编辑', '/singlepage/edit', '/singlepage/del', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `adm_my`
--

CREATE TABLE IF NOT EXISTS `adm_my` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `wangwang` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `adm_my`
--

INSERT INTO `adm_my` (`id`, `name`, `email`, `qq`, `wangwang`, `phone`, `fax`, `address`) VALUES
(1, '111', '22', '33', '44', '55', '66', '77');

-- --------------------------------------------------------

--
-- 表的结构 `adm_order`
--

CREATE TABLE IF NOT EXISTS `adm_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chanpin` varchar(255) NOT NULL DEFAULT '',
  `shouhuoren` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `youbian` varchar(255) NOT NULL,
  `dianhua` varchar(255) NOT NULL,
  `daishoukuan` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dsshouxufei` decimal(10,2) DEFAULT '0.00',
  `qitafei` decimal(10,2) DEFAULT '0.00',
  `wuliu` varchar(20) DEFAULT NULL,
  `isjiesuan` tinyint(2) DEFAULT NULL,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(11) DEFAULT NULL,
  `wuliudanhao` varchar(20) DEFAULT NULL,
  `alicod` varchar(30) NOT NULL,
  `fahuotime` varchar(20) DEFAULT NULL,
  `pifajia` decimal(10,2) DEFAULT '0.00',
  `isfahuo` tinyint(2) DEFAULT NULL,
  `youfei` decimal(10,2) DEFAULT '0.00',
  `jiesuanid` int(11) DEFAULT '0',
  `beizhu` varchar(255) DEFAULT NULL,
  `yingli` decimal(10,2) DEFAULT '0.00',
  `canbao` tinyint(1) unsigned DEFAULT '0',
  `duanxin` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5372 ;

--
-- 转存表中的数据 `adm_order`
--

INSERT INTO `adm_order` (`id`, `chanpin`, `shouhuoren`, `address`, `youbian`, `dianhua`, `daishoukuan`, `dsshouxufei`, `qitafei`, `wuliu`, `isjiesuan`, `addtime`, `userid`, `wuliudanhao`, `alicod`, `fahuotime`, `pifajia`, `isfahuo`, `youfei`, `jiesuanid`, `beizhu`, `yingli`, `canbao`, `duanxin`) VALUES
(5370, '减肥咖啡3盒', '陈娟', '福建省福州市大在西路32号', '', 'da9fJzsesG02kUdzjpXYrI/eQw4neQmyblNM3jH8Z/Fo9AuwpJqiYZI8Dxyv', 1000.00, 50.00, 14.00, '顺丰快递', 1, '2014-03-19 17:24:43', 524, '1234567890', '', '2014-03-19', 250.00, 3, 34.00, 1229, '商品名称:&nbsp;网购商品\r<br>售后电话:&nbsp;\r<br>公司名称:&nbsp;\r<br>备注信息:&nbsp;送货前请先电话联系，谢谢！', 652.00, 0, 1),
(5371, 'GH', 'G', 'HGH', '', 'ce6fMYztWF+oFR7nVs5n4Tt/IGpd/uioYPgf2r1zrV3SXu9gB/nzvhaWDZrzQj4', 252.00, 12.60, 6.52, '顺丰快递', 1, '2014-03-19 17:25:49', 523, '123456789', '', '2014-03-19', 35.00, 3, 25.00, 1228, '商品名称:&nbsp;网购商品\r<br>售后电话:&nbsp;\r<br>公司名称:&nbsp;\r<br>TGH备注信息:&nbsp;送货前请先电话联系，谢谢！', 172.88, 0, 1),
(6, 'apple五袋', '匿名', '广州市天河区兴科路', '451254', '6b84QKrLa0v4YMsBAzm7MJc9PlE1owbwcwh5n2uqJOfnpYbPzxUd', 2300.00, 5.00, 0.00, 'EMS快递', 1, '2013-06-07 10:14:31', 513, 'EW367193624CS', '', '', 99.00, 2, 20.00, 18, '', 2000.00, 1, 1),
(9, 'apple五袋', '匿名', '北京市天河区兴科路', '451254', '65b7aqLoICDrzB4Rshlm9xh+T7WAG+JqngsCbSJJUtv2xkpE', 2300.00, 5.00, 0.00, 'EMS快递', 1, '2013-06-07 11:27:20', 513, 'EW387193624CS', '', '2013-06-07', 99.00, 3, 20.00, 8, '备注1', 2000.00, 1, 1),
(10, '喝过的咖啡', '匿名2', '广州市越秀区八旗二马路11号拜高商务大厦', '451254', 'ea45tnrh9RRwIRpSYbNg2/czLTPWO71unMY3avy2r87uSGjeL532rjCpbhovHJ23', 2300.00, 5.00, 0.00, 'EMS快递', 0, '2013-06-07 11:38:04', 513, 'EW397193624CS', '', '2013-06-08', 99.00, 2, 20.00, 2, '陈述事实', 2000.00, 1, 1),
(518, 'apple五袋', '匿名', '广州市天河区兴科路', '451254', '7800G30ROpeyA6jj/xHE51uo706Y6ibPPJOS2TYbENakJBS3Q9SWxdFdhGLP9nSF', 2300.00, 5.00, 0.00, 'EMS快递', 1, '2013-06-07 11:27:12', 513, 'EW357193624CS', '', '2013-06-07', 99.00, 2, 20.00, 18, '备注', 2000.00, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `adm_resource`
--

CREATE TABLE IF NOT EXISTS `adm_resource` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `operate` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=187 ;

--
-- 转存表中的数据 `adm_resource`
--

INSERT INTO `adm_resource` (`id`, `pid`, `operate`, `name`) VALUES
(1, 0, 'admin', ''),
(2, 1, 'index', ''),
(3, 1, 'edit', ''),
(4, 1, 'log', ''),
(5, 1, 'reset', ''),
(6, 1, 'group', ''),
(7, 1, 'del', ''),
(8, 1, 'initModel', ''),
(9, 1, 'view', ''),
(10, 0, 'apply', ''),
(11, 10, 'index', ''),
(12, 10, 'shenqing', ''),
(13, 10, 'history', ''),
(14, 10, 'more', ''),
(15, 10, 'del', ''),
(16, 10, 'initModel', ''),
(17, 10, 'view', ''),
(18, 0, 'article', ''),
(19, 18, 'index', ''),
(20, 18, 'add', ''),
(21, 18, 'edit', ''),
(22, 18, 'del', ''),
(23, 18, 'dels', ''),
(24, 18, 'getCat', ''),
(25, 18, 'model_id', ''),
(26, 18, 'initModel', ''),
(27, 18, 'view', ''),
(28, 0, 'article_channel', ''),
(29, 28, 'add', ''),
(30, 28, 'edit', ''),
(31, 28, 'del', ''),
(32, 28, 'getCat', ''),
(33, 28, 'initModel', ''),
(34, 28, 'view', ''),
(35, 0, 'banner', ''),
(36, 35, 'index', ''),
(37, 35, 'edit', ''),
(38, 35, 'del', ''),
(39, 35, 'initModel', ''),
(40, 35, 'view', ''),
(41, 0, 'channel', ''),
(42, 41, 'index', ''),
(43, 41, 'getCat', ''),
(44, 41, 'initModel', ''),
(45, 41, 'view', ''),
(46, 0, 'clear', ''),
(47, 46, 'index', ''),
(48, 46, 'clearcache', ''),
(49, 46, 'cleartpl', ''),
(50, 46, 'clearhtml', ''),
(51, 46, 'initModel', ''),
(52, 46, 'view', ''),
(53, 0, 'common', ''),
(54, 53, 'initModel', ''),
(55, 53, 'view', ''),
(56, 0, 'guestbook', ''),
(57, 56, 'index', ''),
(58, 56, 'see', ''),
(59, 56, 'del', ''),
(60, 56, 'dels', ''),
(61, 56, 'initModel', ''),
(62, 56, 'view', ''),
(63, 0, 'index', ''),
(64, 63, 'index', ''),
(65, 63, 'login', ''),
(66, 63, 'welcome', ''),
(67, 63, 'lang', ''),
(68, 63, 'logout', ''),
(69, 63, 'verify', ''),
(70, 63, 'initModel', ''),
(71, 63, 'view', ''),
(72, 0, 'link', ''),
(73, 72, 'index', ''),
(74, 72, 'add', ''),
(75, 72, 'edit', ''),
(76, 72, 'del', ''),
(77, 72, 'dels', ''),
(78, 72, 'initModel', ''),
(79, 72, 'view', ''),
(80, 0, 'manage', ''),
(81, 80, 'index', ''),
(82, 80, 'add', ''),
(83, 80, 'edit', ''),
(84, 80, 'today', ''),
(85, 80, 'stdput', ''),
(86, 80, 'sets', ''),
(87, 80, 'excel', ''),
(88, 80, 'del', ''),
(89, 80, 'dels', ''),
(90, 80, 'initModel', ''),
(91, 80, 'view', ''),
(92, 0, 'menu', ''),
(93, 92, 'index', ''),
(94, 92, 'my', ''),
(95, 92, 'webset', ''),
(96, 92, 'editor', ''),
(97, 92, 'content', ''),
(98, 92, 'channel', ''),
(99, 92, 'creathtml', ''),
(100, 92, 'manage', ''),
(101, 92, 'user', ''),
(102, 92, 'apply', ''),
(103, 92, 'admin', ''),
(104, 92, 'other', ''),
(105, 92, 'initModel', ''),
(106, 92, 'view', ''),
(107, 0, 'my', ''),
(108, 107, 'index', ''),
(109, 107, 'xedit', ''),
(110, 107, 'initModel', ''),
(111, 107, 'view', ''),
(112, 0, 'photo', ''),
(113, 112, 'index', ''),
(114, 112, 'add', ''),
(115, 112, 'edit', ''),
(116, 112, 'del', ''),
(117, 112, 'dels', ''),
(118, 112, 'getCat', ''),
(119, 112, 'model_id', ''),
(120, 112, 'initModel', ''),
(121, 112, 'view', ''),
(122, 0, 'photo_channel', ''),
(123, 122, 'add', ''),
(124, 122, 'edit', ''),
(125, 122, 'del', ''),
(126, 122, 'getCat', ''),
(127, 122, 'initModel', ''),
(128, 122, 'view', ''),
(129, 0, 'plugin', ''),
(130, 129, 'add', ''),
(131, 129, 'edit', ''),
(132, 129, 'del', ''),
(133, 129, 'getCat', ''),
(134, 129, 'initModel', ''),
(135, 129, 'view', ''),
(136, 0, 'scrap', ''),
(137, 136, 'index', ''),
(138, 136, 'info', ''),
(139, 136, 'add', ''),
(140, 136, 'edit', ''),
(141, 136, 'del', ''),
(142, 136, 'dels', ''),
(143, 136, 'initModel', ''),
(144, 136, 'view', ''),
(145, 0, 'sellweb', ''),
(146, 145, 'index', ''),
(147, 145, 'add', ''),
(148, 145, 'edit', ''),
(149, 145, 'del', ''),
(150, 145, 'dels', ''),
(151, 145, '_text', ''),
(152, 145, 'initModel', ''),
(153, 145, 'view', ''),
(154, 0, 'singlepage', ''),
(155, 154, 'add', ''),
(156, 154, 'edit', ''),
(157, 154, 'del', ''),
(158, 154, 'getCat', ''),
(159, 154, 'initModel', ''),
(160, 154, 'view', ''),
(161, 0, 'user', ''),
(162, 161, 'index', ''),
(163, 161, 'edit', ''),
(164, 161, 'add', ''),
(165, 161, 'verify', ''),
(166, 161, 'del', ''),
(167, 161, 'initModel', ''),
(168, 161, 'view', ''),
(169, 0, 'webset', ''),
(170, 169, 'index', ''),
(171, 169, 'initModel', ''),
(172, 169, 'view', ''),
(173, 1, 'dellog', ''),
(174, 0, 'other', ''),
(175, 174, 'sql', ''),
(176, 174, 'initModel', ''),
(177, 174, 'view', ''),
(178, 174, 'recover', ''),
(179, 174, 'del', ''),
(180, 80, 'dayin', ''),
(181, 63, 'kuai', ''),
(182, 63, 'more', ''),
(183, 80, 'kuaidi100', ''),
(184, 80, 'ajax_Calculate', ''),
(185, 161, 'viewdd', ''),
(186, 80, 'ajax_VipCalculate', '');

-- --------------------------------------------------------

--
-- 表的结构 `adm_scrap`
--

CREATE TABLE IF NOT EXISTS `adm_scrap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `adm_scrap`
--

INSERT INTO `adm_scrap` (`id`, `sign`, `title`, `content`) VALUES
(2, 'about', '首页简介', '&lt;p&gt;\r\n	顺心代发货平台即将上线！\r\n&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `adm_user`
--

CREATE TABLE IF NOT EXISTS `adm_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `xingming` varchar(50) DEFAULT NULL,
  `xingbie` int(11) DEFAULT NULL,
  `dianhua` varchar(50) DEFAULT NULL,
  `qq` varchar(50) DEFAULT NULL,
  `dizhi` varchar(50) DEFAULT NULL,
  `yinhang` longtext,
  `qita` longtext,
  `dengji` varchar(50) DEFAULT NULL,
  `jh` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=526 ;

--
-- 转存表中的数据 `adm_user`
--

INSERT INTO `adm_user` (`id`, `username`, `password`, `xingming`, `xingbie`, `dianhua`, `qq`, `dizhi`, `yinhang`, `qita`, `dengji`, `jh`) VALUES
(513, 'iokevin', '965eb72c92a549dd', 'kevin', 0, '', '222222225', '', '开户行：ooooooo\r<br>姓名：kkkkkkkkk\r<br>帐号：4343338888888888444', 'sdfsdsdf', '20', 2),
(525, '780035400', '31b6726de3a78840', '', 0, '18682179140', '780035400', '广东', '开户行：支付宝\r<br>姓名：何连山\r<br>帐号：363593570@qq.com', '', '20', 1),
(524, 'nicko', '49ba59abbe56e057', 'yhl', 1, '13580459571', '278262084', '广州市越秀区磊福路95号', '开户行：农业银行\r<br>姓名：李娟\r<br>帐号：655558515669858962', '', '20', 0),
(521, 'imok', '36b9db245ac460dc', 'ok', 0, '13422234775', '179880111', '阳江', '开户行：工商银行\r<br>姓名：登攀\r<br>帐号：1234567890', '', '20', 2),
(523, 'SASA', 'df6942683e7b1317', 'GH', 0, '18512315912', '225878952', '番禺', '开户行：飞\r<br>姓名：&nbsp;飞\r<br>帐号：6222222222222', '', '20', 0);

-- --------------------------------------------------------

--
-- 表的结构 `adm_zh_channel`
--

CREATE TABLE IF NOT EXISTS `adm_zh_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL,
  `mid` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `pinyin` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tpl_list` varchar(50) DEFAULT NULL,
  `tpl_content` varchar(50) DEFAULT NULL,
  `ord` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `adm_zh_channel`
--

INSERT INTO `adm_zh_channel` (`id`, `pid`, `mid`, `name`, `pinyin`, `keywords`, `description`, `pic`, `url`, `tpl_list`, `tpl_content`, `ord`) VALUES
(1, 0, 1, '走进阳冠', 'zoujinyangguan', '', '', '', '', 'list/index', 'content/index', 0),
(2, 0, 1, '公司动态', 'gongsidongtai', '', '', '', '', 'list/index', 'content/index', 0),
(3, 0, 1, '产品展示', 'chanpinzhanshi', '', '', '', '', 'list/index', 'content/index', 0),
(4, 0, 1, '销售网络', 'xiaoshouwangluo', '', '', '', '', 'list/index', 'content/index', 0),
(5, 0, 1, '联系我们', 'lianxiwomen', '', '', '', '', 'list/index', 'content/index', 0),
(6, 1, 2, '公司介绍', 'gongsijieshao', '', '', '/yg/upload/image/20130409/20130409095340_93600.jpg', '', 'single/index', '', 0),
(7, 1, 2, '品牌文化', 'pinpaiwenhua', '', '', '', '', 'single/index', '', 0),
(8, 2, 1, '公司新闻', 'gongsixinwen', '', '', '', '', 'list/index', 'content/index', 0),
(9, 2, 1, '行业动态', 'xingyedongtai', '', '', '', '', 'list/index', 'content/index', 0),
(18, 3, 1, '成人帽', 'chengrenmao', '', '', '', '', 'list/pic', 'content/index', 0),
(19, 3, 1, '中童帽', 'zhongtongmao', '', '', '', '', 'list/pic', 'content/index', 0),
(20, 3, 1, '婴儿帽', 'yingermao', '', '', '', '', 'list/pic', 'content/index', 0),
(28, 4, 2, '销售网络', 'xiaoshouwangluo', '', '', '', '', 'sellweb/index', '', 0),
(27, 4, 2, '招商加盟', 'zhaoshangjiameng', '', '', '', '', 'single/index', '', 0),
(25, 5, 2, '联系方式', 'lianxifangshi', '', '', '', '', 'single/index', '', 0),
(26, 5, 2, '在线留言', 'zaixianliuyan', '', '', '', '', 'guest/index', '', 0),
(29, 0, 1, '测试列表1111', 'ceshiliebiao1111', '', '', '', '', 'list/index', 'content/index', 0),
(30, 29, 2, '测试单页', 'ceshidanye', '', '', '', '', 'single/index', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `adm_zh_channel_data`
--

CREATE TABLE IF NOT EXISTS `adm_zh_channel_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL DEFAULT '0',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `pid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章栏目分类' AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `adm_zh_channel_data`
--

INSERT INTO `adm_zh_channel_data` (`id`, `cid`, `content`) VALUES
(8, 6, '&lt;strong&gt;测试&lt;/strong&gt;'),
(9, 7, '&lt;strong&gt;测试赛&lt;/strong&gt;'),
(17, 25, '联系'),
(18, 26, ''),
(19, 27, '&lt;strong&gt;招商加盟&lt;/strong&gt;'),
(20, 28, ''),
(21, 30, '');

-- --------------------------------------------------------

--
-- 表的结构 `adm_zh_content`
--

CREATE TABLE IF NOT EXISTS `adm_zh_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `mid` int(10) unsigned DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `edittime` int(10) unsigned DEFAULT NULL,
  `addtime` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `adm_zh_content`
--

INSERT INTO `adm_zh_content` (`id`, `cid`, `title`, `mid`, `keywords`, `description`, `pic`, `content`, `author`, `edittime`, `addtime`, `status`) VALUES
(13, 8, '12312', 1, '', '', '', '12312312', '', 1365604219, 1365604219, 1);

-- --------------------------------------------------------

--
-- 表的结构 `adm_zh_guestbook`
--

CREATE TABLE IF NOT EXISTS `adm_zh_guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `content` text,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `adm_zh_guestbook`
--


-- --------------------------------------------------------

--
-- 表的结构 `adm_zh_scrap`
--

CREATE TABLE IF NOT EXISTS `adm_zh_scrap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `adm_zh_scrap`
--

INSERT INTO `adm_zh_scrap` (`id`, `sign`, `title`, `content`) VALUES
(1, 'about1', '首页简介1', '关于1');

-- --------------------------------------------------------

--
-- 表的结构 `adm_zh_sellweb`
--

CREATE TABLE IF NOT EXISTS `adm_zh_sellweb` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `pinyin` varchar(100) DEFAULT NULL,
  `info` text,
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `adm_zh_sellweb`
--

INSERT INTO `adm_zh_sellweb` (`id`, `title`, `name`, `pinyin`, `info`, `addtime`) VALUES
(3, '', '广东', 'guangdong', '电话<br>地址', '2013-04-10 14:06:55'),
(4, '', '四川', 'sichuan', '网点名--------<br>电话---------<br>联系人&nbsp;&nbsp;&nbsp;------', '2013-04-10 14:08:03');
