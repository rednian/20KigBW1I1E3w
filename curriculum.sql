/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : curriculum

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2016-09-16 17:07:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for block_section
-- ----------------------------
DROP TABLE IF EXISTS `block_section`;
CREATE TABLE `block_section` (
  `bs_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_code` varchar(11) DEFAULT NULL,
  `activation` varchar(11) NOT NULL,
  `description` text,
  `year_lvl` varchar(255) DEFAULT NULL,
  `semister` varchar(255) DEFAULT NULL,
  `sy` varchar(255) DEFAULT NULL,
  `pl_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of block_section
-- ----------------------------
INSERT INTO `block_section` VALUES ('10', 'CS001', 'open', '', 'First Year', 'First Semester', '2016-2017', '1');
INSERT INTO `block_section` VALUES ('11', 'BSIT1-A', 'close', '', 'First Year', 'First Semester', '2016-2017', '2');
INSERT INTO `block_section` VALUES ('12', 'BEB3I', 'open', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'First Year', 'First Semester', '2016-2017', '0');

-- ----------------------------
-- Table structure for curr_codelist
-- ----------------------------
DROP TABLE IF EXISTS `curr_codelist`;
CREATE TABLE `curr_codelist` (
  `cur_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_code` varchar(255) DEFAULT NULL,
  `pl_id` int(11) DEFAULT NULL,
  `eff_sy` varchar(255) DEFAULT NULL,
  `eff_sem` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of curr_codelist
-- ----------------------------
INSERT INTO `curr_codelist` VALUES ('25', 'BSCS-1617-SEM1', '1', '2016-2017', '1st Semester', 'active');
INSERT INTO `curr_codelist` VALUES ('26', 'BSIT-1617-SEM1', '2', '2016-2017', '1st Semester', 'active');
INSERT INTO `curr_codelist` VALUES ('27', 'BSCS-1617-SEM2', '1', '2016-2017', '2nd Semester', 'active');
INSERT INTO `curr_codelist` VALUES ('28', 'BSIT-1617-SEM2', '2', '2016-2017', '2nd Semester', 'active');

-- ----------------------------
-- Table structure for cur_subject
-- ----------------------------
DROP TABLE IF EXISTS `cur_subject`;
CREATE TABLE `cur_subject` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `subj_id` int(11) DEFAULT NULL,
  `ys_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cs_id`),
  KEY `ys_id` (`ys_id`),
  CONSTRAINT `cur_subject_ibfk_1` FOREIGN KEY (`ys_id`) REFERENCES `year_sem` (`ys_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cur_subject
-- ----------------------------
INSERT INTO `cur_subject` VALUES ('124', '2', '10');
INSERT INTO `cur_subject` VALUES ('125', '3', '10');
INSERT INTO `cur_subject` VALUES ('126', '4', '11');
INSERT INTO `cur_subject` VALUES ('127', '5', '12');
INSERT INTO `cur_subject` VALUES ('132', '3', '1');
INSERT INTO `cur_subject` VALUES ('133', '2', '1');
INSERT INTO `cur_subject` VALUES ('134', '4', '7');
INSERT INTO `cur_subject` VALUES ('135', '5', '8');
INSERT INTO `cur_subject` VALUES ('136', '6', '9');

-- ----------------------------
-- Table structure for other_sched
-- ----------------------------
DROP TABLE IF EXISTS `other_sched`;
CREATE TABLE `other_sched` (
  `os_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_name` varchar(255) DEFAULT NULL,
  `time_span` varchar(255) DEFAULT NULL,
  `time_unit` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`os_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of other_sched
-- ----------------------------
INSERT INTO `other_sched` VALUES ('5', 'Research', '5', 'hour', 'Sample description');

-- ----------------------------
-- Table structure for plotted_time
-- ----------------------------
DROP TABLE IF EXISTS `plotted_time`;
CREATE TABLE `plotted_time` (
  `pt_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(255) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pt_id`),
  KEY `st_id` (`st_id`),
  CONSTRAINT `plotted_time_ibfk_1` FOREIGN KEY (`st_id`) REFERENCES `sched_time` (`st_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of plotted_time
-- ----------------------------
INSERT INTO `plotted_time` VALUES ('147', '07:30 AM', '8');
INSERT INTO `plotted_time` VALUES ('148', '08:00 AM', '8');
INSERT INTO `plotted_time` VALUES ('149', '08:30 AM', '8');
INSERT INTO `plotted_time` VALUES ('150', '09:00 AM', '8');
INSERT INTO `plotted_time` VALUES ('151', '09:30 AM', '8');
INSERT INTO `plotted_time` VALUES ('152', '10:00 AM', '8');
INSERT INTO `plotted_time` VALUES ('153', '10:30 AM', '8');
INSERT INTO `plotted_time` VALUES ('154', '11:00 AM', '8');
INSERT INTO `plotted_time` VALUES ('155', '11:30 AM', '8');
INSERT INTO `plotted_time` VALUES ('156', '12:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('157', '12:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('158', '01:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('159', '01:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('160', '02:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('161', '02:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('162', '03:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('163', '03:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('164', '04:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('165', '04:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('166', '05:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('167', '05:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('168', '06:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('169', '06:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('170', '07:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('171', '07:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('172', '08:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('173', '08:30 PM', '8');
INSERT INTO `plotted_time` VALUES ('174', '09:00 PM', '8');
INSERT INTO `plotted_time` VALUES ('175', '09:30 PM', '8');

-- ----------------------------
-- Table structure for pre_requisite
-- ----------------------------
DROP TABLE IF EXISTS `pre_requisite`;
CREATE TABLE `pre_requisite` (
  `prr_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_id` int(11) DEFAULT NULL,
  `subj_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`prr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pre_requisite
-- ----------------------------
INSERT INTO `pre_requisite` VALUES ('1', '116', '2');
INSERT INTO `pre_requisite` VALUES ('2', '121', '2');
INSERT INTO `pre_requisite` VALUES ('3', '121', '2');
INSERT INTO `pre_requisite` VALUES ('4', '122', '2');
INSERT INTO `pre_requisite` VALUES ('5', '122', '3');
INSERT INTO `pre_requisite` VALUES ('6', '123', '5');
INSERT INTO `pre_requisite` VALUES ('7', '126', '2');
INSERT INTO `pre_requisite` VALUES ('8', '126', '2');
INSERT INTO `pre_requisite` VALUES ('9', '126', '2');
INSERT INTO `pre_requisite` VALUES ('10', '127', '2');
INSERT INTO `pre_requisite` VALUES ('11', '127', '3');
INSERT INTO `pre_requisite` VALUES ('12', '127', '2');
INSERT INTO `pre_requisite` VALUES ('13', '127', '3');
INSERT INTO `pre_requisite` VALUES ('14', '130', '2');
INSERT INTO `pre_requisite` VALUES ('15', '131', '2');
INSERT INTO `pre_requisite` VALUES ('16', '131', '3');
INSERT INTO `pre_requisite` VALUES ('17', '134', '2');
INSERT INTO `pre_requisite` VALUES ('18', '134', '2');
INSERT INTO `pre_requisite` VALUES ('19', '135', '2');
INSERT INTO `pre_requisite` VALUES ('20', '135', '3');
INSERT INTO `pre_requisite` VALUES ('21', '135', '2');
INSERT INTO `pre_requisite` VALUES ('22', '135', '3');
INSERT INTO `pre_requisite` VALUES ('23', '136', '5');

-- ----------------------------
-- Table structure for room_list
-- ----------------------------
DROP TABLE IF EXISTS `room_list`;
CREATE TABLE `room_list` (
  `rl_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_code` varchar(255) DEFAULT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `desc` text,
  PRIMARY KEY (`rl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of room_list
-- ----------------------------
INSERT INTO `room_list` VALUES ('7', 'CL1', 'Computer Lab 1', '60', '', 'Laboratory', 'Fully air conditioned room');
INSERT INTO `room_list` VALUES ('8', 'ER1', 'Extension Room 1', '60', null, 'Lecture', 'Fully air conditioned room');
INSERT INTO `room_list` VALUES ('9', 'ER2', 'Extension Room 2', '60', '', 'Lecture', '');
INSERT INTO `room_list` VALUES ('10', 'CL2', 'Computer Lab 2', '60', null, 'Laboratory', null);

-- ----------------------------
-- Table structure for sched_day
-- ----------------------------
DROP TABLE IF EXISTS `sched_day`;
CREATE TABLE `sched_day` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(255) DEFAULT NULL,
  `composition` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sched_day
-- ----------------------------
INSERT INTO `sched_day` VALUES ('2', 'Mon', 'Monday');
INSERT INTO `sched_day` VALUES ('3', 'Tue', 'Tuesday');
INSERT INTO `sched_day` VALUES ('4', 'Wed', 'Wednesday');
INSERT INTO `sched_day` VALUES ('5', 'Thu', 'Thursday');
INSERT INTO `sched_day` VALUES ('6', 'Fri', 'Friday');
INSERT INTO `sched_day` VALUES ('7', 'Sat', 'Saturday');
INSERT INTO `sched_day` VALUES ('8', 'Sun', 'Sunday');

-- ----------------------------
-- Table structure for sched_subj
-- ----------------------------
DROP TABLE IF EXISTS `sched_subj`;
CREATE TABLE `sched_subj` (
  `ss_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_lvl` varchar(255) DEFAULT NULL,
  `sy` varchar(255) DEFAULT NULL,
  `sem` varchar(255) DEFAULT NULL,
  `subj_id` int(11) DEFAULT NULL,
  `sd_id` int(11) DEFAULT NULL,
  `rl_id` int(11) DEFAULT NULL,
  `avs_status` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `bs_id` int(11) DEFAULT NULL,
  `time_start` varchar(255) DEFAULT NULL,
  `time_end` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ss_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sched_subj
-- ----------------------------
INSERT INTO `sched_subj` VALUES ('61', 'First Year', '2016-2017', 'First Semester', '2', '2', '8', 'active', 'BTN-2012-0213', '10', '08:00:00', '09:00:00');
INSERT INTO `sched_subj` VALUES ('62', 'First Year', '2016-2017', 'First Semester', '2', '3', '7', 'active', 'BTN-2012-0213', '10', '07:30:00', '09:00:00');
INSERT INTO `sched_subj` VALUES ('63', 'First Year', '2016-2017', 'First Semester', '3', '3', '8', 'active', '', '10', '09:00:00', '10:00:00');
INSERT INTO `sched_subj` VALUES ('64', 'First Year', '2016-2017', 'First Semester', '3', '2', '7', 'active', '', '10', '09:00:00', '10:30:00');
INSERT INTO `sched_subj` VALUES ('65', 'First Year', '2016-2017', 'First Semester', '2', '2', '8', 'active', '', '11', '10:30:00', '11:30:00');
INSERT INTO `sched_subj` VALUES ('66', 'First Year', '2016-2017', 'First Semester', '2', '2', '7', 'active', '', '11', '11:30:00', '13:00:00');
INSERT INTO `sched_subj` VALUES ('67', 'First Year', '2016-2017', 'First Semester', '3', '3', '8', 'active', '', '11', '10:30:00', '11:30:00');
INSERT INTO `sched_subj` VALUES ('68', 'First Year', '2016-2017', 'First Semester', '3', '4', '7', 'active', '', '11', '07:30:00', '09:00:00');
INSERT INTO `sched_subj` VALUES ('69', 'First Year', '2016-2017', 'First Semester', '2', '4', '8', 'active', null, '12', '07:30:00', '08:30:00');
INSERT INTO `sched_subj` VALUES ('70', 'First Year', '2016-2017', 'First Semester', '2', '5', '7', 'active', null, '12', '07:30:00', '09:00:00');
INSERT INTO `sched_subj` VALUES ('71', 'First Year', '2016-2017', 'First Semester', '3', '6', '8', 'active', '', '12', '07:30:00', '08:30:00');
INSERT INTO `sched_subj` VALUES ('72', 'First Year', '2016-2017', 'First Semester', '3', '4', '7', 'active', '', '12', '09:00:00', '10:30:00');
INSERT INTO `sched_subj` VALUES ('73', 'First Year', '2016-2017', 'First Semester', '2', '2', '8', 'active', null, '12', '09:00:00', '10:00:00');
INSERT INTO `sched_subj` VALUES ('74', 'First Year', '2016-2017', 'First Semester', '3', '3', '8', 'active', '', '12', '07:30:00', '08:30:00');
INSERT INTO `sched_subj` VALUES ('75', 'First Year', '2016-2017', 'First Semester', '3', '2', '7', 'active', '', '12', '07:30:00', '09:00:00');
INSERT INTO `sched_subj` VALUES ('76', 'First Year', '2016-2017', 'First Semester', '2', '6', '7', 'active', null, '12', '09:00:00', '10:30:00');

-- ----------------------------
-- Table structure for sched_time
-- ----------------------------
DROP TABLE IF EXISTS `sched_time`;
CREATE TABLE `sched_time` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `interval` varchar(255) DEFAULT NULL,
  `time_start` varchar(255) DEFAULT NULL,
  `time_end` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sched_time
-- ----------------------------
INSERT INTO `sched_time` VALUES ('8', '30', '07:30', '21:30');

-- ----------------------------
-- Table structure for split_no_per_week
-- ----------------------------
DROP TABLE IF EXISTS `split_no_per_week`;
CREATE TABLE `split_no_per_week` (
  `snpw_id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `subj_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`snpw_id`),
  KEY `subj_id` (`subj_id`),
  CONSTRAINT `split_no_per_week_ibfk_1` FOREIGN KEY (`subj_id`) REFERENCES `subject` (`subj_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of split_no_per_week
-- ----------------------------
INSERT INTO `split_no_per_week` VALUES ('2', '2', '2');
INSERT INTO `split_no_per_week` VALUES ('3', '2', '3');
INSERT INTO `split_no_per_week` VALUES ('4', '2', '4');
INSERT INTO `split_no_per_week` VALUES ('5', '2', '5');
INSERT INTO `split_no_per_week` VALUES ('6', '2', '6');

-- ----------------------------
-- Table structure for stud_load_cap_set
-- ----------------------------
DROP TABLE IF EXISTS `stud_load_cap_set`;
CREATE TABLE `stud_load_cap_set` (
  `slcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_type` varchar(255) DEFAULT NULL,
  `unit_capacity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`slcs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stud_load_cap_set
-- ----------------------------
INSERT INTO `stud_load_cap_set` VALUES ('6', 'Full Time Student', '25');
INSERT INTO `stud_load_cap_set` VALUES ('10', 'Working Student', '18');

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `subj_id` int(11) NOT NULL AUTO_INCREMENT,
  `subj_code` varchar(255) DEFAULT NULL,
  `subj_name` varchar(255) DEFAULT NULL,
  `subj_desc` text,
  `lec_unit` varchar(255) DEFAULT NULL,
  `lab_unit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`subj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES ('2', 'PROG1', 'Programming 1', 'fads', '2', '3');
INSERT INTO `subject` VALUES ('3', 'InTech', 'Internet Technologies', 'fdsalkfj', '2', '3');
INSERT INTO `subject` VALUES ('4', 'PROG2', 'Programming 2', 'fsadfa', '2', '3');
INSERT INTO `subject` VALUES ('5', 'DBMS1', 'Database Management 1', '321321', '2', '3');
INSERT INTO `subject` VALUES ('6', 'DBMS2', 'Database Management 2', 'fdasf', '2', '3');

-- ----------------------------
-- Table structure for tutorial
-- ----------------------------
DROP TABLE IF EXISTS `tutorial`;
CREATE TABLE `tutorial` (
  `tut_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_capacity` varchar(255) DEFAULT NULL,
  `ss_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tut_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tutorial
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_fname` varchar(255) DEFAULT NULL,
  `user_lname` varchar(255) DEFAULT NULL,
  `user_mname` varchar(255) DEFAULT NULL,
  `user_department` varchar(255) DEFAULT NULL,
  `user_position` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'junell', 'kN2NNR6/<1yep7zj5TE9se></1yep7zj5TE9se><e5Fh9></e5Fh9>5CNIgHP39gwUC2VqXeRta8ONNEqaZq58d9W//ifhTGIqp9ZJTQRKZno/8vw==', 'Junell', 'Bojocan', null, 'ITE Deparment', 'ITE - Dean', 'active', 'default.png');
INSERT INTO `user` VALUES ('14', 'chris', 'hkN33Gy/ssSYur7uh/W1CXcvnmrIH3Io9WjwKpFSuGTQ7Jl7apxP18P8YK9hG+0N/kqXerkH/Fp6CXk42IBZWQ==', 'Chris', 'Olivo', '', 'Engtech Global Solutions Inc.', 'Programmer', 'active', 'default.png');

-- ----------------------------
-- Table structure for year_sem
-- ----------------------------
DROP TABLE IF EXISTS `year_sem`;
CREATE TABLE `year_sem` (
  `ys_id` int(11) NOT NULL AUTO_INCREMENT,
  `cur_id` int(11) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `semister` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ys_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of year_sem
-- ----------------------------
INSERT INTO `year_sem` VALUES ('1', '25', 'First Year', 'First Semester');
INSERT INTO `year_sem` VALUES ('7', '25', 'First Year', 'Second Semester');
INSERT INTO `year_sem` VALUES ('8', '25', 'Second Year', 'First Semester');
INSERT INTO `year_sem` VALUES ('9', '25', 'Second Year', 'Second Semester');
INSERT INTO `year_sem` VALUES ('10', '26', 'First Year', 'First Semester');
INSERT INTO `year_sem` VALUES ('11', '26', 'First Year', 'Second Semester');
INSERT INTO `year_sem` VALUES ('12', '26', 'Second Year', 'First Semester');
INSERT INTO `year_sem` VALUES ('13', '26', 'Second Year', 'Second Semester');

-- ----------------------------
-- View structure for instructor
-- ----------------------------
DROP VIEW IF EXISTS `instructor`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `instructor` AS SELECT
hrms.employees.employee_id,
hrms.employees.employee_fname,
hrms.employees.employee_mname,
hrms.employees.employee_lname,
hrms.employees.employee_ext,
hrms.departments.department_name
FROM
hrms.employees ,
hrms.departments,
hrms.employment
WHERE hrms.employees.employee_id = hrms.employment.employee_id
AND hrms.employment.department_id = hrms.departments.department_id ;

-- ----------------------------
-- View structure for program_list
-- ----------------------------
DROP VIEW IF EXISTS `program_list`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `program_list` AS SELECT
sis.program_list.pl_id,
sis.program_list.prog_code,
sis.program_list.prog_abv,
sis.program_list.prog_name,
sis.program_list.prog_desc,
sis.program_list.`level`,
sis.program_list.major,
sis.program_list.dep_id,
sis.depertment.dep_name,
sis.depertment.dep_desc
FROM
sis.depertment
INNER JOIN sis.program_list ON sis.program_list.dep_id = sis.depertment.dep_id ;

-- ----------------------------
-- View structure for subject_enrolled
-- ----------------------------
DROP VIEW IF EXISTS `subject_enrolled`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `subject_enrolled` AS SELECT
sis.subject_enrolled.se_id,
sis.subject_enrolled.sem,
sis.subject_enrolled.sch_year,
sis.subject_enrolled.ss_id,
sis.subject_enrolled.ssi_id,
sis.subject_enrolled.ts_id
FROM
sis.subject_enrolled ;
