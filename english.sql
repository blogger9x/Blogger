/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : english

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-01-03 17:32:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for new_words
-- ----------------------------
DROP TABLE IF EXISTS `new_words`;
CREATE TABLE `new_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sentence` varchar(255) DEFAULT NULL,
  `spelling` varchar(255) DEFAULT NULL,
  `translate` varchar(255) DEFAULT NULL,
  `sound` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of new_words
-- ----------------------------
INSERT INTO `new_words` VALUES ('56', 'hello1', 'hello1', 'hello1', null);
INSERT INTO `new_words` VALUES ('57', 'hello2', 'hello2', 'hello1', null);
INSERT INTO `new_words` VALUES ('58', 'hello3', 'hello3', 'hello3', null);
INSERT INTO `new_words` VALUES ('59', 'hello4', 'hello4', 'hello4', null);
INSERT INTO `new_words` VALUES ('60', 'hello5', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('61', 'hello6', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('62', 'hello7', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('63', 'hello8', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('64', 'hello9', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('65', 'hello10', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('66', 'hello11', 'hello5', 'hello5', null);
INSERT INTO `new_words` VALUES ('67', 'hello12', 'hello5', 'hello5', null);
