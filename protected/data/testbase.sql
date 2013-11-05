/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : testbase

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-06 01:08:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `process`
-- ----------------------------
DROP TABLE IF EXISTS `process`;
CREATE TABLE `process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `timestart` int(11) DEFAULT NULL,
  `timestate` int(11) DEFAULT NULL,
  `timeexec` int(11) NOT NULL,
  `status` smallint(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `iduseredit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of process
-- ----------------------------
INSERT INTO `process` VALUES ('12', '1', '1383666768', null, '20', '6', '8', null);
INSERT INTO `process` VALUES ('13', '2', '1383385968', null, '10', '6', '9', null);
INSERT INTO `process` VALUES ('14', 'zzz', '1383635009', null, '12', '6', '10', null);
INSERT INTO `process` VALUES ('15', 'zzz', null, null, '12', null, null, null);
INSERT INTO `process` VALUES ('16', 'tgyh', null, null, '5', null, null, null);
INSERT INTO `process` VALUES ('26', 'gggggggggg', '1383671656', null, '15', '6', '12', null);
INSERT INTO `process` VALUES ('27', 'yhyyy', '1383681390', null, '25', '6', '8', null);


-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `isadmin` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('8', 'taur', 'c4ca4238a0b923820dcc509a6f75849b', '1');
INSERT INTO `users` VALUES ('9', 'q', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `users` VALUES ('10', 'qqq', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `users` VALUES ('11', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1');
INSERT INTO `users` VALUES ('12', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '0');
