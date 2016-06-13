# Host: localhost  (Version: 5.6.17)
# Date: 2016-03-20 01:05:03
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "b_uprecord"
#

DROP TABLE IF EXISTS `b_uprecord`;
CREATE TABLE `b_uprecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usernumber` int(11) NOT NULL DEFAULT '0' COMMENT '交款人编号',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '交款人用户名',
  `applytime` varchar(10) NOT NULL DEFAULT '' COMMENT '申请升级时间',
  `postime` varchar(10) NOT NULL DEFAULT '' COMMENT '其上级收款时间',
  `shouldmoney` int(6) NOT NULL DEFAULT '0' COMMENT '升级会员应付金额',
  `currentlevel` int(1) NOT NULL DEFAULT '0' COMMENT '升级会员当前等级',
  `isrece` int(1) NOT NULL DEFAULT '0' COMMENT '是否收款',
  `upid` int(11) NOT NULL DEFAULT '0',
  `upusername` varchar(20) NOT NULL,
  `upnumber` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

#
# Data for table "b_uprecord"
#


#
# Structure for table "b_user"
#

DROP TABLE IF EXISTS `b_user`;
CREATE TABLE `b_user` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `usernumber` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `repersonnumber` int(10) NOT NULL DEFAULT '0' COMMENT '推荐人编号',
  `level` varchar(5) NOT NULL DEFAULT '0' COMMENT '会员级别',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '一级密码',
  `phonenumber` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号码',
  `weixin` varchar(32) NOT NULL DEFAULT '' COMMENT '微信',
  `zhifubao` varchar(32) NOT NULL DEFAULT '' COMMENT '支付宝',
  `email` varchar(20) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '会员状态 1为正式会员 ',
  `createtime` varchar(10) NOT NULL DEFAULT '' COMMENT '创建时间',
  `lasttime` varchar(10) NOT NULL DEFAULT '' COMMENT '最后登录时间',
  `lastip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登陆ip',
  `islock` int(1) NOT NULL DEFAULT '0' COMMENT '是否锁定'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "b_user"
#

INSERT INTO `b_user` VALUES (1,0,200000,'众惠一号',999999,'3','z123456','18666937383','jj18676937383','18888888888','88888888@qq.com','88888888',1,'1458403200','1458403200','127.0.0.1',0),(2,1,214112,'融汇',200000,'3','z123456','18003822198','18003822198','18888888888','88888888@qq.com','88888888',1,'1458403300','1458403300','127.0.0.1',0),(3,1,256465,'大爱无疆1',200000,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458403400','1458403400','127.0.0.1',0),(4,1,354464,'大爱无疆2',200000,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458403500','1458403500','127.0.0.1',0),(5,2,365465,'大爱无疆3',214112,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458403600','1458403600','127.0.0.1',0),(6,3,465765,'大爱无疆4',256465,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458403700','1458403700','127.0.0.1',0),(7,4,345754,'大爱无疆5',354464,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458403800','1458403800','127.0.0.1',0),(8,2,456676,'大爱无疆6',214112,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458403900','1458403900','127.0.0.1',0),(9,3,254464,'大爱无疆7',256465,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458404000','1458404000','127.0.0.1',0),(10,4,365745,'大爱无疆8',354464,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458404100','1458404100','127.0.0.1',0),(11,2,256654,'大爱无疆9',214112,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458404200','1458404200','127.0.0.1',0),(12,3,579879,'大爱无疆10',256465,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458404300','1458404300','127.0.0.1',0),(13,4,257655,'大爱无疆11',354464,'3','z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888',1,'1458404400','1458404400','127.0.0.1',0);

#
# Structure for table "c_uprecord"
#

DROP TABLE IF EXISTS `c_uprecord`;
CREATE TABLE `c_uprecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usernumber` int(11) NOT NULL DEFAULT '0' COMMENT '交款人编号',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '交款人用户名',
  `applytime` varchar(10) NOT NULL DEFAULT '' COMMENT '申请升级时间',
  `postime` varchar(10) NOT NULL DEFAULT '' COMMENT '其上级收款时间',
  `shouldmoney` int(6) NOT NULL DEFAULT '0' COMMENT '升级会员应付金额',
  `currentlevel` int(1) NOT NULL DEFAULT '0' COMMENT '升级会员当前等级',
  `isrece` int(1) NOT NULL DEFAULT '0' COMMENT '是否收款',
  `upid` int(11) NOT NULL DEFAULT '0',
  `upusername` varchar(20) NOT NULL,
  `upnumber` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "c_uprecord"
#


#
# Structure for table "c_user"
#

DROP TABLE IF EXISTS `c_user`;
CREATE TABLE `c_user` (
  `id` int(10) unsigned NOT NULL COMMENT 'id',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `usernumber` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `repersonnumber` int(10) NOT NULL DEFAULT '0' COMMENT '推荐人编号',
  `level` varchar(5) NOT NULL DEFAULT '0' COMMENT '会员级别',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '一级密码',
  `phonenumber` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号码',
  `weixin` varchar(32) NOT NULL DEFAULT '' COMMENT '微信',
  `zhifubao` varchar(32) NOT NULL DEFAULT '' COMMENT '支付宝',
  `email` varchar(20) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '会员状态 1为正式会员 ',
  `createtime` varchar(10) NOT NULL DEFAULT '' COMMENT '创建时间',
  `lasttime` varchar(10) NOT NULL DEFAULT '' COMMENT '最后登录时间',
  `lastip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登陆ip',
  `islock` int(1) NOT NULL DEFAULT '0' COMMENT '是否锁定'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "c_user"
#


#
# Structure for table "r_adminuser"
#

DROP TABLE IF EXISTS `r_adminuser`;
CREATE TABLE `r_adminuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `isdel` int(1) NOT NULL DEFAULT '0',
  `lasttime` varchar(10) NOT NULL DEFAULT '',
  `lastip` varchar(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "r_adminuser"
#

INSERT INTO `r_adminuser` VALUES (1,'admin','0192023a7bbd73250516f069df18b500',0,'1458277690','127.0.0.1');

#
# Structure for table "r_system"
#

DROP TABLE IF EXISTS `r_system`;
CREATE TABLE `r_system` (
  `id` int(11) NOT NULL,
  `rule` text,
  `notice` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "r_system"
#

INSERT INTO `r_system` VALUES (1,'啊当时发生的发是的发','测试公告啊撒旦法时代发多少发');

#
# Structure for table "r_uprecord"
#

DROP TABLE IF EXISTS `r_uprecord`;
CREATE TABLE `r_uprecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usernumber` int(11) NOT NULL DEFAULT '0' COMMENT '交款人编号',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '交款人用户名',
  `upnumber` int(11) NOT NULL DEFAULT '0',
  `upusername` varchar(20) NOT NULL,
  `isrece` int(1) NOT NULL DEFAULT '0' COMMENT '是否收款',
  `upid` int(11) NOT NULL DEFAULT '0',
  `applytime` varchar(10) NOT NULL DEFAULT '' COMMENT '申请升级时间',
  `postime` varchar(10) NOT NULL DEFAULT '' COMMENT '其上级收款时间',
  `shouldmoney` int(6) NOT NULL DEFAULT '0' COMMENT '升级会员应付金额',
  `currentlevel` int(1) NOT NULL DEFAULT '0' COMMENT '升级会员当前等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

#
# Data for table "r_uprecord"
#


#
# Structure for table "r_user"
#

DROP TABLE IF EXISTS `r_user`;
CREATE TABLE `r_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `usernumber` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `level` int(1) NOT NULL DEFAULT '0' COMMENT '会员级别',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '会员状态 1为正式会员 ',
  `repersonnumber` int(10) NOT NULL DEFAULT '0' COMMENT '推荐人编号',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '一级密码',
  `phonenumber` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号码',
  `weixin` varchar(32) NOT NULL DEFAULT '' COMMENT '微信',
  `zhifubao` varchar(32) NOT NULL DEFAULT '' COMMENT '支付宝',
  `email` varchar(20) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `createtime` varchar(10) NOT NULL DEFAULT '' COMMENT '创建时间',
  `lasttime` varchar(10) NOT NULL DEFAULT '' COMMENT '最后登录时间',
  `lastip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登陆ip',
  `islock` int(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;

#
# Data for table "r_user"
#

INSERT INTO `r_user` VALUES (1,0,100000,'大爱无疆8',2,1,999999,'z123456','17737783711','17737783711','123456789','123456789@qq.com','123456789','1458403200','1458404417','0.0.0.0',0),(133,1,152429,'大爱无疆9',2,1,100000,'z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888','1458405050','1458405134','0.0.0.0',0),(134,1,144873,'大爱无疆10',2,1,100000,'z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888','1458405079','1458405360','0.0.0.0',0),(135,1,193121,'大爱无疆11',2,1,100000,'z123456','17737783711','17737783711','18888888888','88888888@qq.com','88888888','1458405094','1458405582','0.0.0.0',0),(136,133,206722,'老邢',0,1,152429,'z123456','13203873558','15515733898','18888888888','88888888@qq.com','88888888','1458405205','1458405205','0.0.0.0',0),(137,133,539942,'新开',0,1,152429,'z123456','13253389808','13253389808','18888888888','88888888@qq.com','88888888','1458405249','1458405249','0.0.0.0',0),(138,133,212012,'余江平',0,1,152429,'z123456','18037855776','18037855776','18888888888','88888888@qq.com','88888888','1458405331','1458405331','0.0.0.0',0),(139,134,446176,'德军',0,1,144873,'z123456','13938277818','K2845995687','18888888888','88888888@qq.com','88888888','1458405424','1458405424','0.0.0.0',0),(140,134,136597,'芯语',0,1,144873,'z123456','18638911645','18638911645','18888888888','88888888@qq.com','88888888','1458405498','1458405498','0.0.0.0',0),(141,134,202040,'永不放弃',0,1,144873,'z123456','15538762883','15538762883','18888888888','88888888@qq.com','88888888','1458405564','1458405564','0.0.0.0',0),(142,135,997897,'呆呆',0,1,193121,'z123456','13253898930','394770556','18888888888','88888888@qq.com','88888888','1458405629','1458405629','0.0.0.0',0),(143,135,112024,'东方',0,1,193121,'z123456','13783715301','13783715301','18888888888','88888888@qq.com','88888888','1458405774','1458405774','0.0.0.0',0),(144,135,186777,'李显昇',0,1,193121,'z123456','15638853988','15638853988','18888888888','88888888@qq.com','88888888','1458405808','1458405808','0.0.0.0',0);
