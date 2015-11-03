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
INSERT INTO `comment` VALUES (1,5,1,'2015-11-02','I went last year and it was tons of fun! Definitely check out Light Up UCF if you can!'),(2,11,1,'2015-11-02','So hyped! Can\'t wait until they finish setting it up! The food and the ice skating is definitely a plus.'),(3,17,1,'2015-11-02','Great annual event! Have to wait through the long lines unfortunately.'),(4,27,7,'2015-11-03','I attended last year and this event was a great opportunity to network and land yourself an interview!'),(5,33,7,'2015-11-03','These workshops give a lot of advice on preparing you for an interview, but are a bit too general for my liking as it is geared towards all majors.');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,2,NULL,1,'2015-12-25 17:00:00','Light Up UCF',3,'peyton.jeter@ucf.edu','4078236363','What is Light Up UCF?\r\n\r\nLight Up UCF is Orlando\'s most affordable holiday tradition, offering a free holiday light show, free outdoor Holiday Film Festival, and Orlando\'s largest outdoor skating rink! For the 2015 season, Light Up UCF is offering all the favorite rides and attractions, including the Blizzard! Come early and skate late! \r\n\r\nParking is FREE and ice skating tickets are just $12! Tickets can be purchased at the CFE Arena Box Office or in advance online.\r\n\r\nFor more information, check out: http://www.lightupucf.com/ ',1),(2,2,NULL,4,'2016-01-27 10:00:00','Spring Career Expo',1,'career@ucf.edu','4078232361','Don\'t miss the UCF\'s Spring 2016 Career Expo!\r\n\r\nThe Career Expo gives students and alumni the chance to meet with employers face-to-face to discuss career opportunities. \r\n\r\nBring lots of resumes so you can network and even interview onsite. Representatives from corporations of all industries and sizes participate in the Career Expo. It usually attracts well over 200 employers and over 1,800 student and alumni seeking full-time, professional positions. \r\n\r\nFor more information, check out: http://events.ucf.edu/event/144879/spring-career-expo/ ',1),(3,5,1,1,'2016-01-13 12:00:00','4EVER KNIGHTS Reunite!',2,'4EVERKNIGHTS@ucfalumni.com','4078821262','Students Today, Knights Forever.\r\n\r\n4EVER KNIGHTS (4EK) Is the largest student organization on campus. It\'s your ticket to exclusive events, discounts on and off campus, and leadership opportunities. The 4EVER KNIGHTS student alumni association are the traditions keepers and serve as the bridge between students and the alumni association. Through programs, benefits and services, 4EK provides the resources and opportunities for students to excel at UCF.\r\n\r\nSo come and reunite at the start of this upcoming Spring semester! Come and meet some of your fellow alumni\'s and get some more discounts to stock up for the semester! There will be free food and swag!',1),(4,11,2,2,'2015-11-21 08:00:00','Gingerbread 5k',2,'weecs@ucf.edu','4078236028','Women in Electrical Engineering and Computer Science (WEECS) is a student organization at the University of Central Florida. WEECS exists to foster community among women in the field of computing. We aim to bring more women into the field and to do all that we can to provide them with the resources they need to be successful.\r\n\r\nCome join us for a morning run to help contribute to the fundraiser for women in computing for other countries! Free shirts and snacks will be provided!',1),(5,17,3,5,'2015-12-05 15:00:00','Blue Man Group Concert!',2,'honors@ucf.edu','4078232076','Honors Congress is the official student organization for the Burnett Honors College.\r\n\r\nWe put on a variety of events to get our members involved on campus and in the local community. These include events with an emphasis on: academics, volunteering, fundraising, and even just socializing with your fellow honors students. \r\n\r\nAnd just before we part for winter break, come join us to see the Blue Man Group perform LIVE! We will be gathering outside of the front entrance of the Burnett Honors College starting at 2 PM! Buses depart at 3 PM, so don\'t be late for this awesome event!',1),(6,23,NULL,1,'2015-11-20 11:00:00','Campus Tour',3,'infocenter-www@MIT.EDU','6172534795','Student Led Campus Tours are approximately 90 minutes long and provide insight into the life of Undergraduate Students at MIT. The tours are geared toward prospective students, but can be enjoyed by everyone. \r\n\r\nPlease note that campus tours do not visit laboratories, living groups or buildings under construction. \r\n\r\nGroups over 10 people need to make special reservations by filling out the request form on : http://web.mit.edu/institute-events/events/tour.html\r\n\r\nWeb site: http://www.mitadmissions.org/topics/youmit/campus_tours_info_sessions\r\n/index.shtml',1),(7,23,NULL,4,'2015-12-02 15:00:00','Career Connect: Interviewing',1,'career@mit.edu','6172531614','This workshop emphasizes practical tips to consider in preparation for job interviews. It gives participants an opportunity to learn what to do, as well as what not to do, during an interview and leads them through all expected stages of an interview process.\r\n\r\nSpeaker: Bori Stoyanova',1),(8,27,4,4,'2016-02-01 16:00:00','Private Board Spring Elections',2,'asa-exec@mit.edu','6172530294','The Association of Student Activities (ASA) is a joint committee of both the Undergraduate Association (UA) and the Graduate Student Council (GSC). The ASA Executive Board advocates on behalf of student groups to gain resources for student groups\' benefit, allocates resources among student groups, and arbitrates among student groups and any other involved parties. In general, the ASA oversees student group activity and is the governing body of students groups on the MIT campus.\r\n\r\nAlong with the start of Spring semester also brings our traditional semester elections. Come join to participate and elect to determine the new positions of your fellow ASA members.',1),(9,33,5,3,'2015-12-07 17:00:00','Data Science-Big Data Meet Up',2,'gecd@mit.edu','6172532049','Join us for a Meet Up with alums and representatives working in Data Science-Big Data, and learn about jobs and careers in this rapidly growing field. Here\'s your chance to ask about the work, career paths, skills needed, trends in the field, and whatever else you would like to know.\r\n\r\nLight refreshments will be served. ',1),(10,33,6,1,'2015-12-16 15:00:00','End of Semester Party!',2,'fraternity-life@mit.edu','6172535294','Celebrate the end of another hard-working semester with a party! Feel free to bring your friends along too!\r\n\r\nThere will be a BBQ and grill set up as well as the fields to run around in! Bring any food to share!',1);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event_location`
--

LOCK TABLES `event_location` WRITE;
/*!40000 ALTER TABLE `event_location` DISABLE KEYS */;
INSERT INTO `event_location` VALUES (1,2),(2,3),(3,4),(4,5),(5,6),(6,8),(7,9),(8,10),(9,11),(10,12);
/*!40000 ALTER TABLE `event_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event_user`
--

LOCK TABLES `event_user` WRITE;
/*!40000 ALTER TABLE `event_user` DISABLE KEYS */;
INSERT INTO `event_user` VALUES (1,2),(2,2),(1,5),(3,5),(1,11),(4,11),(1,17),(5,17),(6,23),(7,23),(7,27),(8,27),(7,33),(9,33),(10,33);
/*!40000 ALTER TABLE `event_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'Orlando, FL',28.6024274,-81.2000599),(2,'CFE Arena at 12777 Gemini Blvd N, Orlando, FL 32816',28.607225,-81.1973669),(3,'CFE Arena at 12777 Gemini Blvd N, Orlando, FL 32816',28.607225,-81.1973669),(4,'201 at Student Union at 12715 Pegasus Dr, Orlando, FL 32816',28.601923,-81.2005395),(5,'Bright House Networks Stadium at 4465 Knights Victory Way, Orlando, FL 32816',28.6082727,-81.1926631),(6,'Burnett Honors College at 12778 Aquarius Agora Dr, Orlando, FL 32816',28.602326,-81.2020018),(7,'Cambridge, MA',42.360091,-71.09416),(8,'MIT Libraries at 77 Massachusetts Ave, Cambridge, MA 02139',42.359155,-71.0930576),(9,'Eastgate Penthouse at 60 Wadsworth St, Cambridge, MA 02142',42.3617465,-71.0839963),(10,'Walcott at East Campus at 3 Ames St, Cambridge, MA 02142',42.3603747,-71.0882217),(11,'105 at School of Engineering at 77 Massachusetts Ave #1, Cambridge, MA 02139',42.359155,-71.0930576),(12,'Jack Barry AstroTurf Field at 120 Vassar St,W35, Cambridge, MA 02139',42.3585867,-71.0964565);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `picture`
--

LOCK TABLES `picture` WRITE;
/*!40000 ALTER TABLE `picture` DISABLE KEYS */;
INSERT INTO `picture` VALUES (1,'https://lh3.googleusercontent.com/-XaqFLJsRmcs/AAAAAAAAAAI/AAAAAAAAAAA/utWAr70SUJI/s0-c-k-no-ns/photo.jpg'),(2,'https://lh6.googleusercontent.com/-HXcwA8OCaSU/AAAAAAAAAAI/AAAAAAAAAAA/RZnbzZK7m1M/s0-c-k-no-ns/photo.jpg');
/*!40000 ALTER TABLE `picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
INSERT INTO `rating` VALUES (1,5,1,5),(2,11,1,5),(3,17,1,4),(4,27,7,5),(5,33,7,4);
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rso`
--

LOCK TABLES `rso` WRITE;
/*!40000 ALTER TABLE `rso` DISABLE KEYS */;
INSERT INTO `rso` VALUES (1,5,'4EVER KNIGHTS (4EK)'),(2,11,'Women in EECS (WEECS)'),(3,17,'Honors Congress'),(4,27,'Association of Student Activities (ASA)'),(5,33,'IEEE/ACM@MIT'),(6,33,'Epsilon Theta Fraternity');
/*!40000 ALTER TABLE `rso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rso_user`
--

LOCK TABLES `rso_user` WRITE;
/*!40000 ALTER TABLE `rso_user` DISABLE KEYS */;
INSERT INTO `rso_user` VALUES (1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(3,17),(3,18),(3,19),(3,20),(3,21),(3,22),(4,27),(4,28),(4,29),(4,30),(4,31),(4,32),(5,33),(6,33),(5,34),(5,35),(5,36),(5,37),(5,38),(6,39),(6,40),(6,41),(6,42),(6,43);
/*!40000 ALTER TABLE `rso_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university`
--

LOCK TABLES `university` WRITE;
/*!40000 ALTER TABLE `university` DISABLE KEYS */;
INSERT INTO `university` VALUES (1,1,'Default University',NULL,0),(2,2,'University of Central Florida (UCF)','This is UCF\r\n\r\nThe University of Central Florida, founded in 1963, is the second-largest university in the nation. Located in Orlando, Florida, UCF and its 13 colleges provide opportunities to 61,000 students, offering 210 degree programs from UCF’s main campus, hospitality campus, health sciences campus and its 10 regional locations.\r\n\r\nUCF was ranked as one of the nation’s “Most Innovative” universities in the 2016 U.S. News & World Report’s Best Colleges rankings. Last year, Kiplinger’s and The Princeton Review ranked UCF as one of the nation’s best values for a college education.\r\n\r\nUCF, Florida’s largest university, promotes a diverse and inclusive environment. Students come from 50 states and 148 countries. Study abroad programs allow students to study and conduct research with 98 institutions in 36 countries. Students at UCF have been recognized throughout the world and include recipients of the Rhodes, Mellon and Goldwater scholarships.\r\n\r\nIn 2014, UCF enrolled 79 freshman National Merit Scholars for an overall enrollment of 275 National Merit Scholars. Both school records. Last year, UCF enrolled more National Merit Scholars and awarded more degrees than any other Florida university.\r\n\r\nUCF is an academic, partnership and research leader in numerous fields, such as optics, modeling and simulation, engineering and computer science, business administration, education, the sciences including biomedical sciences, hospitality management and digital media.\r\n\r\nIn 2013-14, UCF professors received $145.6 million in research funding and have accrued more than $1.1 billion in external grants during the past decade. Distinctive programs extend learning beyond the classroom and include leadership programs, cooperative education, mentorships, internships, service learning and paid research positions.\r\n\r\nUCF is one of 25 public universities with the Carnegie Foundation’s highest designation in two categories: community engagement and very high research activity.',60810),(3,23,'Massachusetts Institute of Technology (MIT)','The mission of MIT is to advance knowledge and educate students in science, technology and other areas of scholarship that will best serve the nation and the world in the 21st century — whether the focus is cancer, energy, economics or literature.\r\n\r\nThe Institute is committed to generating, disseminating, and preserving knowledge, and to working with others to bring this knowledge to bear on the world\'s great challenges. MIT is dedicated to providing its students with an education that combines rigorous academic study and the excitement of discovery with the support and intellectual stimulation of a diverse campus community. We seek to develop in each member of the MIT community the ability and passion to work wisely, creatively, and effectively for the betterment of humankind.',11319);
/*!40000 ALTER TABLE `university` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_event`
--

LOCK TABLES `university_event` WRITE;
/*!40000 ALTER TABLE `university_event` DISABLE KEYS */;
INSERT INTO `university_event` VALUES (2,1),(2,2),(2,3),(2,4),(2,5),(1,6),(3,7),(3,8),(3,9),(3,10);
/*!40000 ALTER TABLE `university_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_location`
--

LOCK TABLES `university_location` WRITE;
/*!40000 ALTER TABLE `university_location` DISABLE KEYS */;
INSERT INTO `university_location` VALUES (2,1),(3,7);
/*!40000 ALTER TABLE `university_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_picture`
--

LOCK TABLES `university_picture` WRITE;
/*!40000 ALTER TABLE `university_picture` DISABLE KEYS */;
INSERT INTO `university_picture` VALUES (1,2),(2,3);
/*!40000 ALTER TABLE `university_picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_rso`
--

LOCK TABLES `university_rso` WRITE;
/*!40000 ALTER TABLE `university_rso` DISABLE KEYS */;
INSERT INTO `university_rso` VALUES (2,1),(2,2),(2,3),(3,4),(3,5),(3,6);
/*!40000 ALTER TABLE `university_rso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,1,'Bobby','Tables',NULL,1),(2,'hitt.john@knights.ucf.edu',2,'John','Hitt','$2y$10$QVQrgUCQ3xVIfdcDs9kKM.DYlVuQv.LjBlUnKo2.OCRBeT6ZNHnwK',3),(3,'woods.olive@knights.ucf.edu',2,'Olive','Woods','$2y$10$L/IkXHV6/yxN0UZ5glUDxOGXr0YRZ5PBZ3m1VtmAH2Fx1yNzKR8q2',1),(4,'simmons.harvey@knights.ucf.edu',2,'Harvey','Simmons','$2y$10$lIJaJ.X5U8.sx5tumAtPm.n422.1FzIR/fCDB4yf/jwIXFWJDvqLu',1),(5,'gomez.andrew@knights.ucf.edu',2,'Andrew','Gomez','$2y$10$b48mIqEDT1B/m4HXsNw3yOYBlMH0LF4pJx98WPA/HqKagVaaptDsa',2),(6,'spencer.raymond@knights.ucf.edu',2,'Raymond','Spencer','$2y$10$c/qsyJrb6dv5m66W51Dr.O598jqwlNWERvHfZxN8FkYrkyRzAdJtu',1),(7,'garner.bertha@knights.ucf.edu',2,'Bertha','Garner','$2y$10$dtDHrt/iNNqs/XttF/7xU.VgDCaLfPdJ4sNJOeFNoaSl/eq9KPI02',1),(8,'ballard.rebecca@knights.ucf.edu',2,'Rebecca','Ballard','$2y$10$LY42g9D9oqg5ggqdWbLRUOSSCn3jj3SQqvWBtLCcolqMV4cgGfsMq',1),(9,'parks.jeffery@knights.ucf.edu',2,'Jeffery','Parks','$2y$10$Pe2gRqJ76QeC9UaWJb0BQO8N3LFGxgeZmDyoY1uw1pUlDSTE0IcK6',1),(10,'daniel.dexter@knights.ucf.edu',2,'Dexter','Daniel','$2y$10$P1sxa3hUPub5m6F9jXPJQuV2t3qFH49J1QPvaBNrgcs87w8pITBSq',1),(11,'bryan.sophie@knights.ucf.edu',2,'Sophie','Bryan','$2y$10$AlbjxqJZkMCCmbyxMvNvbepaM.cUPaRHaGtx7KQe76wrJfx9D.yy2',2),(12,'hopkins.elsa@knights.ucf.edu',2,'Elsa','Hopkins','$2y$10$Tw9R/w/fYf2bkGcd1xNNQ.yZI6Bze9/HSw69/GL1HCSP0m53OYQta',1),(13,'holland.ellen@knights.ucf.edu',2,'Ellen','Holland','$2y$10$3dtWboysbBWP2/V3JRUCjusLnABvap4ymCpkhM7xAj4wT9HcETLzW',1),(14,'myers.lynda@knights.ucf.edu',2,'Lynda','Myers','$2y$10$UaITJAcpJTjb/NSgasHN3ujzuW6Re7sxRg6/la1rplPVmOwGsuFee',1),(15,'nguyen.susie@knights.ucf.edu',2,'Susie','Nguyen','$2y$10$GVe3PXodPjtNsi34m010hOwVyO9WWp6UYNdbgOtMjyuuF8I8FwGeW',1),(16,'pearson.beverly@knights.ucf.edu',2,'Beverly','Pearson','$2y$10$5G7zNagL1HNv23k61pKKq.Ym3GlMFI1W3EuQa/cPv2/8lbLtqKK9i',1),(17,'kim.mary@knights.ucf.edu',2,'Mary','Kim','$2y$10$ZDNhTL3EZTOO/kQwSy.iiueQdb5IKi4DvWyRA59z/zZV7RMZfnKV6',2),(18,'thornton.al@knights.ucf.edu',2,'Al','Thornton','$2y$10$S883cPJGtUrpjxvN2wsxcugGzcjG/5s1OoBHkxfX6kzpCLSFWX9Mi',1),(19,'hicks.marcos@knights.ucf.edu',2,'Marcos','Hicks','$2y$10$jia/3pmn/O6xMLWasv9P6.4X9Gy4FlrF/neVjCnsULndJjnl9YFU6',1),(20,'thompson.kevin@knights.ucf.edu',2,'Kevin','Thompson','$2y$10$7x4XGc8l/XUTt4UI4w8saen/j6ci9ZdbA49PHp4Bi3nGow5sYZweG',1),(21,'simmons.sara@knights.ucf.edu',2,'Sara','Simmons','$2y$10$CiOl0aCiBwleaHki2mnWfOYNDpum2NqGf.qBDll6b04vOtX2ASqlq',1),(22,'hall.paula@knights.ucf.edu',2,'Paula','Hall','$2y$10$IwmP93V0fHoVydxsx31uqOgtGHtWKnjuZ/qmGiER6IewKdg2Lcqpy',1),(23,'reif.rafael@mit.edu',3,'Rafael','Reif','$2y$10$IwnVVM7eQh0tPkrJ8tMR..ai8TIRG9RbpKiDBX3r/9b0fHkPJaVc6',3),(24,'doyle.kendra@mit.edu',3,'Kendra','Doyle','$2y$10$gMab7BF3HWCeoBrvVifHBeCTuBx8pS2hLwXH/TnKH.yhA33u4USme',1),(25,'farmer.anne@mit.edu',3,'Anne','Farmer','$2y$10$IJqE6qUdlrzFVaG6uRQjvemGTSWnUDhCC3l7m4ZwmIqoUCY6ZFG56',1),(26,'owen.dale@mit.edu',3,'Dale','Owen','$2y$10$ZnH8ruzMHmIDAK4WGKo9qeuXE9IVDPzaLnrSyNm77oxZ8.C/qQDyG',1),(27,'tran.bridget@mit.edu',3,'Bridget','Tran','$2y$10$9LR7l5Z8wl26xTdo.et3wuWyjuQym8O/8G6lk4ec6DfXEia7vfHoK',2),(28,'crawford.april@mit.edu',3,'April','Crawford','$2y$10$yQbhCaLbZfXmSQ/bEkAbuOdVWcCW1Q.JP5XhkBeE/yOs5dejcDO92',1),(29,'barnett.jared@mit.edu',3,'Jared','Barnett','$2y$10$IZE2lck4V9yeVdDXysAuZueiYwxvP7SY7WPYb4fXfcHRPeRRJwGD6',1),(30,'holland.nathaniel@mit.edu',3,'Nathaniel','Holland','$2y$10$GtEd7NMv1BfEh0byVYvBM.v6wbWRiy3FBzhEnrWnf43zDc7UJJKUW',1),(31,'hernandez.tom@mit.edu',3,'Tom','Hernandez','$2y$10$0OQhQp.w49nzR3WbQnyRq.m5J5w5g1.TTW/kO7on3jjd5Xr3frrB6',1),(32,'cohen.diana@mit.edu',3,'Diana','Cohen','$2y$10$NcktWJ78MxRZ0t3HCtY8yef0TvOU4xHhqENc9mBxmAsvrUSp3sK3a',1),(33,'parker.allen@mit.edu',3,'Allen','Parker','$2y$10$cqUsi2vseyGalwsHIiq8DuuKMVR7G7QY5eSg3y4QU9PLGkgagxTxy',2),(34,'reid.carolyn@mit.edu',3,'Carolyn','Reid','$2y$10$ExEeZguqdrhHkZxY42UYqOwIQhPyJ1qMcuEH7g03sWU2wpzp3cDOK',1),(35,'wolfe.angel@mit.edu',3,'Angel','Wolfe','$2y$10$2HqJ..UmrXy9GoBVzTGCUep5FWJrg81.2s.Fe.EeOjd6hFOlrSNXy',1),(36,'gibbs.peter@mit.edu',3,'Peter','Gibbs','$2y$10$QG0Z9YsNkMvConIYFAquYetvh2mLA2o.6QMtya9LDiMhwDGYHDi..',1),(37,'allison.teri@mit.edu',3,'Teri','Allison','$2y$10$Ng82yaIAA2DdRprlvd6d5.U1.PZtDwHEAaZqaW7gNhHXxmE1WdNTi',1),(38,'doyle.jeffrey@mit.edu',3,'Jeffrey','Doyle','$2y$10$tAN2UO9oVx3PPMCzysK7guOfDwvT.CQmcwZb3U.e1Dg.wEV1zR6v.',1),(39,'figueroa.pete@mit.edu',3,'Pete','Figueroa','$2y$10$Z45OOTF/3U8.9.jgid7wqeQWhyXwu3GI593Hg0lepKXnZN/i.1hr2',1),(40,'schwartz.lydia@mit.edu',3,'Lydia','Schwartz','$2y$10$c4pElmqxZiMdzMWHU3YnHObJZY0ABtqCIHGSttrfWFeymDXDgD.ra',1),(41,'burns.max@mit.edu',3,'Max','Burns','$2y$10$chrD.io9aEa.y.v2a2UTEOuko3Cd4QKB4CGlrx9kuYy3fKOo1U9xG',1),(42,'flores.krystal@mit.edu',3,'Krystal','Flores','$2y$10$Kxry/IhDADBOJGFkz7nDmOleANHv4l4o4KdvnTKnXdwvovV6nEUcW',1),(43,'francis.carlos@mit.edu',3,'Carlos','Francis','$2y$10$B5ZXtZ.OmGeZzj82FwsPnu6KmVZSkcIwhGaIuVvGLzF.wW1JOTmLu',1);
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

-- Dump completed on 2015-11-03 13:39:47
