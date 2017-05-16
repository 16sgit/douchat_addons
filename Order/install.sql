/*
Navicat MySQL Data Transfer

Source Server         : web
Source Server Version : 50173
Source Host           : 119.29.68.201:3306
Source Database       : wei

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2017-05-15 16:05:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dc_order_data
-- ----------------------------
DROP TABLE IF EXISTS `dc_order_data`;
CREATE TABLE `dc_order_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `content` text,
  `truename` varchar(255) DEFAULT NULL,
  `qqnumber` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `mpid` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `reply_time` int(11) DEFAULT NULL,
  `reply_content` text,
  `status` tinyint(4) DEFAULT '1',
  `reply_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
