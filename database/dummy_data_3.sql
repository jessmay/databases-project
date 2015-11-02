-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: database_project_db
-- ------------------------------------------------------
-- Server version	5.6.27-log

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
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Social'),(2,'Fundraiser'),(3,'Tech Talk'),(4,'Academic'),(5,'Concert');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,5,1,'2015-11-02','I went last year and it was tons of fun! Definitely check out Light Up UCF if you can!'),(2,11,1,'2015-11-02','So hyped! Can\'t wait until they finish setting it up! The food and the ice skating is definitely a plus.'),(3,17,1,'2015-11-02','Great annual event! Have to wait through the long lines unfortunately.');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,2,NULL,1,'2015-12-25 17:00:00','Light Up UCF',3,'peyton.jeter@ucf.edu','4078236363','What is Light Up UCF?\r\n\r\nLight Up UCF is Orlando\'s most affordable holiday tradition, offering a free holiday light show, free outdoor Holiday Film Festival, and Orlando\'s largest outdoor skating rink! For the 2015 season, Light Up UCF is offering all the favorite rides and attractions, including the Blizzard! Come early and skate late! \r\n\r\nParking is FREE and ice skating tickets are just $12! Tickets can be purchased at the CFE Arena Box Office or in advance online.\r\n\r\nFor more information, check out: http://www.lightupucf.com/ ',1),(2,2,NULL,4,'2016-01-27 10:00:00','Spring Career Expo',1,'career@ucf.edu','4078232361','Don\'t miss the UCF\'s Spring 2016 Career Expo!\r\n\r\nThe Career Expo gives students and alumni the chance to meet with employers face-to-face to discuss career opportunities. \r\n\r\nBring lots of resumes so you can network and even interview onsite. Representatives from corporations of all industries and sizes participate in the Career Expo. It usually attracts well over 200 employers and over 1,800 student and alumni seeking full-time, professional positions. \r\n\r\nFor more information, check out: http://events.ucf.edu/event/144879/spring-career-expo/ ',1),(3,5,1,1,'2016-01-13 12:00:00','4EVER KNIGHTS Reunite!',2,'4EVERKNIGHTS@ucfalumni.com','4078821262','Students Today, Knights Forever.\r\n\r\n4EVER KNIGHTS (4EK) Is the largest student organization on campus. It\'s your ticket to exclusive events, discounts on and off campus, and leadership opportunities. The 4EVER KNIGHTS student alumni association are the traditions keepers and serve as the bridge between students and the alumni association. Through programs, benefits and services, 4EK provides the resources and opportunities for students to excel at UCF.\r\n\r\nSo come and reunite at the start of this upcoming Spring semester! Come and meet some of your fellow alumni\'s and get some more discounts to stock up for the semester! There will be free food and swag!',1),(4,11,2,2,'2015-11-21 08:00:00','Gingerbread 5k',2,'weecs@ucf.edu','4078236028','Women in Electrical Engineering and Computer Science (WEECS) is a student organization at the University of Central Florida. WEECS exists to foster community among women in the field of computing. We aim to bring more women into the field and to do all that we can to provide them with the resources they need to be successful.\r\n\r\nCome join us for a morning run to help contribute to the fundraiser for women in computing for other countries! Free shirts and snacks will be provided!',1),(5,17,3,5,'2015-12-05 15:00:00','Blue Man Group Concert!',2,'honors@ucf.edu','4078232076','Honors Congress is the official student organization for the Burnett Honors College.\r\n\r\nWe put on a variety of events to get our members involved on campus and in the local community. These include events with an emphasis on: academics, volunteering, fundraising, and even just socializing with your fellow honors students. \r\n\r\nAnd just before we part for winter break, come join us to see the Blue Man Group perform LIVE! We will be gathering outside of the front entrance of the Burnett Honors College starting at 2 PM! Buses depart at 3 PM, so don\'t be late for this awesome event!',1);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event_location`
--

LOCK TABLES `event_location` WRITE;
/*!40000 ALTER TABLE `event_location` DISABLE KEYS */;
INSERT INTO `event_location` VALUES (1,2),(2,3),(3,4),(4,5),(5,6);
/*!40000 ALTER TABLE `event_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event_user`
--

LOCK TABLES `event_user` WRITE;
/*!40000 ALTER TABLE `event_user` DISABLE KEYS */;
INSERT INTO `event_user` VALUES (1,2),(2,2),(1,5),(3,5),(1,11),(4,11),(1,17),(5,17);
/*!40000 ALTER TABLE `event_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'Orlando, FL',28.6024274,-81.2000599),(2,'CFE Arena at 12777 Gemini Blvd N, Orlando, FL 32816',28.607225,-81.1973669),(3,'CFE Arena at 12777 Gemini Blvd N, Orlando, FL 32816',28.607225,-81.1973669),(4,'201 at Student Union at 12715 Pegasus Dr, Orlando, FL 32816',28.601923,-81.2005395),(5,'Bright House Networks Stadium at 4465 Knights Victory Way, Orlando, FL 32816',28.6082727,-81.1926631),(6,'Burnett Honors College at 12778 Aquarius Agora Dr, Orlando, FL 32816',28.602326,-81.2020018);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `picture`
--

LOCK TABLES `picture` WRITE;
/*!40000 ALTER TABLE `picture` DISABLE KEYS */;
INSERT INTO `picture` VALUES (1,'https://lh3.googleusercontent.com/-XaqFLJsRmcs/AAAAAAAAAAI/AAAAAAAAAAA/utWAr70SUJI/s0-c-k-no-ns/photo.jpg');
/*!40000 ALTER TABLE `picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
INSERT INTO `rating` VALUES (1,5,1,5),(2,11,1,5),(3,17,1,4);
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rso`
--

LOCK TABLES `rso` WRITE;
/*!40000 ALTER TABLE `rso` DISABLE KEYS */;
INSERT INTO `rso` VALUES (1,5,'4EVER KNIGHTS (4EK)'),(2,11,'Women in EECS (WEECS)'),(3,17,'Honors Congress');
/*!40000 ALTER TABLE `rso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rso_user`
--

LOCK TABLES `rso_user` WRITE;
/*!40000 ALTER TABLE `rso_user` DISABLE KEYS */;
INSERT INTO `rso_user` VALUES (1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(3,17),(3,18),(3,19),(3,20),(3,21),(3,22);
/*!40000 ALTER TABLE `rso_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university`
--

LOCK TABLES `university` WRITE;
/*!40000 ALTER TABLE `university` DISABLE KEYS */;
INSERT INTO `university` VALUES (1,1,'Default University',NULL,0),(2,2,'University of Central Florida (UCF)','This is UCF\r\n\r\nThe University of Central Florida, founded in 1963, is the second-largest university in the nation. Located in Orlando, Florida, UCF and its 13 colleges provide opportunities to 61,000 students, offering 210 degree programs from UCF’s main campus, hospitality campus, health sciences campus and its 10 regional locations.\r\n\r\nUCF was ranked as one of the nation’s “Most Innovative” universities in the 2016 U.S. News & World Report’s Best Colleges rankings. Last year, Kiplinger’s and The Princeton Review ranked UCF as one of the nation’s best values for a college education.\r\n\r\nUCF, Florida’s largest university, promotes a diverse and inclusive environment. Students come from 50 states and 148 countries. Study abroad programs allow students to study and conduct research with 98 institutions in 36 countries. Students at UCF have been recognized throughout the world and include recipients of the Rhodes, Mellon and Goldwater scholarships.\r\n\r\nIn 2014, UCF enrolled 79 freshman National Merit Scholars for an overall enrollment of 275 National Merit Scholars. Both school records. Last year, UCF enrolled more National Merit Scholars and awarded more degrees than any other Florida university.\r\n\r\nUCF is an academic, partnership and research leader in numerous fields, such as optics, modeling and simulation, engineering and computer science, business administration, education, the sciences including biomedical sciences, hospitality management and digital media.\r\n\r\nIn 2013-14, UCF professors received $145.6 million in research funding and have accrued more than $1.1 billion in external grants during the past decade. Distinctive programs extend learning beyond the classroom and include leadership programs, cooperative education, mentorships, internships, service learning and paid research positions.\r\n\r\nUCF is one of 25 public universities with the Carnegie Foundation’s highest designation in two categories: community engagement and very high research activity.',60810);
/*!40000 ALTER TABLE `university` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_event`
--

LOCK TABLES `university_event` WRITE;
/*!40000 ALTER TABLE `university_event` DISABLE KEYS */;
INSERT INTO `university_event` VALUES (2,1),(2,2),(2,3),(2,4),(2,5);
/*!40000 ALTER TABLE `university_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_location`
--

LOCK TABLES `university_location` WRITE;
/*!40000 ALTER TABLE `university_location` DISABLE KEYS */;
INSERT INTO `university_location` VALUES (2,1);
/*!40000 ALTER TABLE `university_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_picture`
--

LOCK TABLES `university_picture` WRITE;
/*!40000 ALTER TABLE `university_picture` DISABLE KEYS */;
INSERT INTO `university_picture` VALUES (1,2);
/*!40000 ALTER TABLE `university_picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_rso`
--

LOCK TABLES `university_rso` WRITE;
/*!40000 ALTER TABLE `university_rso` DISABLE KEYS */;
INSERT INTO `university_rso` VALUES (2,1),(2,2),(2,3);
/*!40000 ALTER TABLE `university_rso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,1,'Bobby','Tables',NULL,1),(2,'hitt.john@knights.ucf.edu',2,'John','Hitt','$2y$10$QVQrgUCQ3xVIfdcDs9kKM.DYlVuQv.LjBlUnKo2.OCRBeT6ZNHnwK',3),(3,'woods.olive@knights.ucf.edu',2,'Olive','Woods','$2y$10$L/IkXHV6/yxN0UZ5glUDxOGXr0YRZ5PBZ3m1VtmAH2Fx1yNzKR8q2',1),(4,'simmons.harvey@knights.ucf.edu',2,'Harvey','Simmons','$2y$10$lIJaJ.X5U8.sx5tumAtPm.n422.1FzIR/fCDB4yf/jwIXFWJDvqLu',1),(5,'gomez.andrew@knights.ucf.edu',2,'Andrew','Gomez','$2y$10$b48mIqEDT1B/m4HXsNw3yOYBlMH0LF4pJx98WPA/HqKagVaaptDsa',2),(6,'spencer.raymond@knights.ucf.edu',2,'Raymond','Spencer','$2y$10$c/qsyJrb6dv5m66W51Dr.O598jqwlNWERvHfZxN8FkYrkyRzAdJtu',1),(7,'garner.bertha@knights.ucf.edu',2,'Bertha','Garner','$2y$10$dtDHrt/iNNqs/XttF/7xU.VgDCaLfPdJ4sNJOeFNoaSl/eq9KPI02',1),(8,'ballard.rebecca@knights.ucf.edu',2,'Rebecca','Ballard','$2y$10$LY42g9D9oqg5ggqdWbLRUOSSCn3jj3SQqvWBtLCcolqMV4cgGfsMq',1),(9,'parks.jeffery@knights.ucf.edu',2,'Jeffery','Parks','$2y$10$Pe2gRqJ76QeC9UaWJb0BQO8N3LFGxgeZmDyoY1uw1pUlDSTE0IcK6',1),(10,'daniel.dexter@knights.ucf.edu',2,'Dexter','Daniel','$2y$10$P1sxa3hUPub5m6F9jXPJQuV2t3qFH49J1QPvaBNrgcs87w8pITBSq',1),(11,'bryan.sophie@knights.ucf.edu',2,'Sophie','Bryan','$2y$10$AlbjxqJZkMCCmbyxMvNvbepaM.cUPaRHaGtx7KQe76wrJfx9D.yy2',2),(12,'hopkins.elsa@knights.ucf.edu',2,'Elsa','Hopkins','$2y$10$Tw9R/w/fYf2bkGcd1xNNQ.yZI6Bze9/HSw69/GL1HCSP0m53OYQta',1),(13,'holland.ellen@knights.ucf.edu',2,'Ellen','Holland','$2y$10$3dtWboysbBWP2/V3JRUCjusLnABvap4ymCpkhM7xAj4wT9HcETLzW',1),(14,'myers.lynda@knights.ucf.edu',2,'Lynda','Myers','$2y$10$UaITJAcpJTjb/NSgasHN3ujzuW6Re7sxRg6/la1rplPVmOwGsuFee',1),(15,'nguyen.susie@knights.ucf.edu',2,'Susie','Nguyen','$2y$10$GVe3PXodPjtNsi34m010hOwVyO9WWp6UYNdbgOtMjyuuF8I8FwGeW',1),(16,'pearson.beverly@knights.ucf.edu',2,'Beverly','Pearson','$2y$10$5G7zNagL1HNv23k61pKKq.Ym3GlMFI1W3EuQa/cPv2/8lbLtqKK9i',1),(17,'kim.mary@knights.ucf.edu',2,'Mary','Kim','$2y$10$ZDNhTL3EZTOO/kQwSy.iiueQdb5IKi4DvWyRA59z/zZV7RMZfnKV6',2),(18,'thornton.al@knights.ucf.edu',2,'Al','Thornton','$2y$10$S883cPJGtUrpjxvN2wsxcugGzcjG/5s1OoBHkxfX6kzpCLSFWX9Mi',1),(19,'hicks.marcos@knights.ucf.edu',2,'Marcos','Hicks','$2y$10$jia/3pmn/O6xMLWasv9P6.4X9Gy4FlrF/neVjCnsULndJjnl9YFU6',1),(20,'thompson.kevin@knights.ucf.edu',2,'Kevin','Thompson','$2y$10$7x4XGc8l/XUTt4UI4w8saen/j6ci9ZdbA49PHp4Bi3nGow5sYZweG',1),(21,'simmons.sara@knights.ucf.edu',2,'Sara','Simmons','$2y$10$CiOl0aCiBwleaHki2mnWfOYNDpum2NqGf.qBDll6b04vOtX2ASqlq',1),(22,'hall.paula@knights.ucf.edu',2,'Paula','Hall','$2y$10$IwmP93V0fHoVydxsx31uqOgtGHtWKnjuZ/qmGiER6IewKdg2Lcqpy',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-02 17:24:44
