-- create the tables for our assignments
DROP TABLE IF EXISTS assignment;

CREATE TABLE `assignment` (
 `assignmentid` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) DEFAULT NULL,
 `description` varchar(200) DEFAULT NULL,
 `difficulty` int(4) DEFAULT NULL,
 `deadline` datetime DEFAULT NULL,
 `Etc` varchar(200) DEFAULT NULL,
 `completion` int(10) NOT NULL,
 `deletion` int(3) DEFAULT NULL,
 PRIMARY KEY (`assignmentid`)
);



-- insert data into the tables

INSERT INTO assignment VALUES
  (1, "OpSys Project", "CPU Scheduling Simulation", 3, '2020-04-16 23:59:00', "Three late days remaining...", 0, 0),
  (2, "IntroITWS Lab", "PHP Lab", 2, '2020-04-18 23:59:00', "Uh Oh", 90, 0),
  (3, "WEB SCI Project", "Make a better Degreeworks", 1, '2020-04-25 23:59:00', "Aahhh! I haven't started!", 0, 0),
  (4, "IT&Society Paper", "Scrape data from Twitter and write 1700 words", 2, '2020-04-17 23:59:00', "Cooperate with group members", 25, 0),
  (5, "DataBase Interface", "Group project using postgres and python", 3, '2020-04-16 23:59:00', "Learn what a database is first...", 0, 0),
  (6, "Research Meeting", "Find a cure for COVID-19", 3, '2020-04-16 11:59:00', "Complete the research process before meeting", 0, 0);

