-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
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
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,5,NULL,4,'2015-11-05 10:00:00','Career Expo',3,'poole.christine@knights.ucf.edu','5079831428','Held in the fall and spring, this event provides the opportunity for employers to discuss internship, career, and employment opportunities with UCF students and alumni.',1),(2,5,1,1,'2015-12-08 11:00:00','SGA Donut Party',2,'poole.christine@knights.ucf.edu','5079831428','Come celebrate the end of the semester with donuts and coffee!\r\n\r\nFeel free to bring your friends too!',1),(3,3,4,1,'2015-12-16 17:00:00','End of Semester Party!',2,'sanchez.andre@knights.ucf.edu','3214059284','Woo! Fall of 2015 will be over soon! Let\'s party our hearts out with some bowling and drinks!',1);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event_location`
--

LOCK TABLES `event_location` WRITE;
/*!40000 ALTER TABLE `event_location` DISABLE KEYS */;
INSERT INTO `event_location` VALUES (1,6),(2,7),(3,8);
/*!40000 ALTER TABLE `event_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `event_user`
--

LOCK TABLES `event_user` WRITE;
/*!40000 ALTER TABLE `event_user` DISABLE KEYS */;
INSERT INTO `event_user` VALUES (1,2),(3,3),(1,5),(2,5);
/*!40000 ALTER TABLE `event_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'Orlando, FL',28.6024274,-81.2000599),(2,'Winter Park, FL',28.5918723,-81.3484843),(3,'Gainesville, FL',29.6725729,-82.2993977),(4,'Cambridge, MA',42.360091,-71.09416),(5,'Berkeley, CA',37.8718992,-122.2585399),(6,'UCF Arena at 12777 Gemini Blvd N, Orlando, FL 32816',28.607225,-81.1973669),(7,'Dunkin Donuts at 4210 W Plaza Dr, Orlando, FL 32816',28.6067442,-81.1986039),(8,'Boardwalk Bowl at 10749 E Colonial Dr, Orlando, FL 32817',28.5711331,-81.2288802);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `picture`
--

LOCK TABLES `picture` WRITE;
/*!40000 ALTER TABLE `picture` DISABLE KEYS */;
INSERT INTO `picture` VALUES (1,'https://s-media-cache-ak0.pinimg.com/236x/dc/9d/4b/dc9d4bf8e5a043004f953e9ac25dbcbd.jpg'),(2,'https://s3.graphiq.com/sites/default/files/10/media/images/t2/Rollins_College_220181.jpg'),(3,'https://upload.wikimedia.org/wikipedia/en/thumb/1/12/Florida_Gators_logo.svg/470px-Florida_Gators_logo.svg.png'),(4,'http://www.mit.edu/~gil/images/mit_logo.gif'),(5,'https://lh6.googleusercontent.com/-5Lnp5Lj9rVQ/AAAAAAAAAAI/AAAAAAAAAAA/Is-ShbaCZVI/s0-c-k-no-ns/photo.jpg');
/*!40000 ALTER TABLE `picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rso`
--

LOCK TABLES `rso` WRITE;
/*!40000 ALTER TABLE `rso` DISABLE KEYS */;
INSERT INTO `rso` VALUES (1,5,'Student Government Association (SGA)'),(2,5,'Burnett Honors College SGA'),(3,5,'Office of Student Involvement (OSI)'),(4,3,'Fraternity & Sorority Life');
/*!40000 ALTER TABLE `rso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rso_user`
--

LOCK TABLES `rso_user` WRITE;
/*!40000 ALTER TABLE `rso_user` DISABLE KEYS */;
INSERT INTO `rso_user` VALUES (1,3),(2,3),(3,3),(4,3),(1,4),(2,4),(3,4),(1,5),(2,5),(3,5),(4,5),(1,6),(4,6),(1,7),(3,7),(1,8),(3,8),(4,8),(2,9),(4,9),(2,10),(3,10),(2,11),(4,11);
/*!40000 ALTER TABLE `rso_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university`
--

LOCK TABLES `university` WRITE;
/*!40000 ALTER TABLE `university` DISABLE KEYS */;
INSERT INTO `university` VALUES (1,1,'Default University',NULL,0),(2,2,'University of Central Florida','The University of Central Florida, founded in 1963, is the second-largest university in the nation. Located in Orlando, Florida, UCF and its 13 colleges provide opportunities to 61,000 students, offering 210 degree programs from UCF’s main campus, hospitality campus, health sciences campus and its 10 regional locations.\r\n\r\nUCF was ranked as one of the nation’s “Most Innovative” universities in the 2016 U.S. News & World Report’s Best Colleges rankings. Last year, Kiplinger’s and The Princeton Review ranked UCF as one of the nation’s best values for a college education.\r\n\r\nUCF, Florida’s largest university, promotes a diverse and inclusive environment. Students come from 50 states and 148 countries. Study abroad programs allow students to study and conduct research with 98 institutions in 36 countries. Students at UCF have been recognized throughout the world and include recipients of the Rhodes, Mellon and Goldwater scholarships.\r\n\r\nIn 2014, UCF enrolled 79 freshman National Merit Scholars for an overall enrollment of 275 National Merit Scholars. Both school records. Last year, UCF enrolled more National Merit Scholars and awarded more degrees than any other Florida university.\r\n\r\nUCF is an academic, partnership and research leader in numerous fields, such as optics, modeling and simulation, engineering and computer science, business administration, education, the sciences including biomedical sciences, hospitality management and digital media.\r\n\r\nIn 2013-14, UCF professors received $145.6 million in research funding and have accrued more than $1.1 billion in external grants during the past decade. Distinctive programs extend learning beyond the classroom and include leadership programs, cooperative education, mentorships, internships, service learning and paid research positions.\r\n\r\nUCF is one of 25 public universities with the Carnegie Foundation’s highest designation in two categories: community engagement and very high research activity.',60810),(3,12,'Rollins College','The perfect blend\r\nChallenging coursework, engaging service and international opportunities, and nearly 100 student-led organizations and clubs create a rich living and learning environment ripe for you to find your passion and potential.\r\n\r\nEngage in a wide range of ideas and perspectives\r\nA Rollins education challenges you to step outside of your intellectual comfort zone—explore new ideas, reconcile seemingly irreconcilable perspectives, read critically, and write reflectively. In the process, you’ll attain a deeper understanding of the world and your place in it.\r\n\r\nMake a difference\r\nAt Rollins, you won’t serve the community for the mere purpose of adding a line to your resume—you’ll connect your education and your passions to the needs of the world.\r\n\r\nDid we mention location?\r\nLocated along the banks of Lake Virginia in Central Florida, our beautiful campus encourages you to take advantage of Florida’s natural beauty and Orlando’s vibrant metropolis.',11896),(4,18,'University of Florida','UF has a long history of established programs in international education, research and service. It is one of only 17 public, land-grant universities that belongs to the Association of American Universities.\r\n\r\nHistory\r\n\r\nIn 1853, the state-funded East Florida Seminary took over the Kingsbury Academy in Ocala. The seminary moved to Gainesville in the 1860s and later was consolidated with the state’s land-grant Florida Agricultural College, then in Lake City. In 1905, by legislative action, the college became a university and was moved to Gainesville. Classes first met with 102 students on the present site on Sept. 26, 1906. UF officially opened its doors to women in 1947. With more than 50,000 students, UF is now one of the largest universities in the nation.\r\n\r\nFacilities\r\n\r\nUF has a 2,000-acre campus and more than 900 buildings (including 170 with classrooms and laboratories). The northeast corner of campus is listed as a Historic District on the National Register of Historic Places. The UF residence halls have a total capacity of some 7,500 students and the five family housing villages house more than 1,000 married and graduate students.\r\n\r\nUF’s extensive capital improvement program has resulted in facilities ideal for 21st century academics and research, including the Health Professions, Nursing and Pharmacy Building; the Cancer and Genetics Research Center; the new Biomedical Sciences Building; and William R. Hough Hall, which houses the Hough Graduate School of Business. Overall, the university’s current facilities have a book value of more than $1 billion and a replacement value of $2 billion.',52019),(5,25,'Massachusetts Institute of Technology (MIT)','The mission of MIT is to advance knowledge and educate students in science, technology and other areas of scholarship that will best serve the nation and the world in the 21st century — whether the focus is cancer, energy, economics or literature.',12079),(6,32,'University of California, Berkeley (UC Berkeley)','The University of California was founded in 1868, born out of a vision in the State Constitution of a university that would \"contribute even more than California\'s gold to the glory and happiness of advancing generations.\"',30578);
/*!40000 ALTER TABLE `university` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_event`
--

LOCK TABLES `university_event` WRITE;
/*!40000 ALTER TABLE `university_event` DISABLE KEYS */;
INSERT INTO `university_event` VALUES (2,1),(2,2),(2,3);
/*!40000 ALTER TABLE `university_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_location`
--

LOCK TABLES `university_location` WRITE;
/*!40000 ALTER TABLE `university_location` DISABLE KEYS */;
INSERT INTO `university_location` VALUES (2,1),(3,2),(4,3),(5,4),(6,5);
/*!40000 ALTER TABLE `university_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_picture`
--

LOCK TABLES `university_picture` WRITE;
/*!40000 ALTER TABLE `university_picture` DISABLE KEYS */;
INSERT INTO `university_picture` VALUES (1,2),(2,3),(3,4),(4,5),(5,6);
/*!40000 ALTER TABLE `university_picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `university_rso`
--

LOCK TABLES `university_rso` WRITE;
/*!40000 ALTER TABLE `university_rso` DISABLE KEYS */;
INSERT INTO `university_rso` VALUES (2,1),(2,2),(2,3),(2,4);
/*!40000 ALTER TABLE `university_rso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,1,'Bobby','Tables',NULL,1),(2,'hitt.john@knights.ucf.edu',2,'John','Hitt','$2y$10$hUmdBYJP8VUWV6qV9.dnhe3miebJ88v1SgMb5nC/ECE7cwdiQB1wq',3),(3,'sanchez.andre@knights.ucf.edu',2,'Andre','Sanchez','$2y$10$FcKM4581mkLnUTeNENLRlO.dHvHDS68FOynYS/wBfJfzZHzZvsyzi',2),(4,'stanley.betty@knights.ucf.edu',2,'Betty','Stanley','$2y$10$lIE2mIWRew/jniTjO2NUHeAVCEdsOKgTa0L858.EaH6XxykCHfMhi',1),(5,'poole.christine@knights.ucf.edu',2,'Christine','Poole','$2y$10$nPkOwhtMrftBUAQsTfAwS.Q0FRXRF3LgNB0DIGE53tLxYXGhiOU5G',2),(6,'sparks.earl@knights.ucf.edu',2,'Earl','Sparks','$2y$10$usrNdXHzlvTn2CYYP6PWMefS9qa7K4i7/qPDcI99C148kKXcWHJwm',1),(7,'baldwin.jerald@knights.ucf.edu',2,'Jerald','Baldwin','$2y$10$s3M9XVFXdfBm2P/3UO7pIuLCd1kfWshwvQXRqsn4GTQ0LkxHrYO26',1),(8,'carroll.jerry@knights.ucf.edu',2,'Jerry','Carroll','$2y$10$L.ZO5mmBGh90BpqfUT7n7uVL70KwGtqonWT3HDM8zsKgV6p.IqZGK',1),(9,'barber.ronald@knights.ucf.edu',2,'Ronald','Barber','$2y$10$mpvJo3rSfTtDXNKaPD1Y9.wB/gBS5v9TmPLyBXyYl2gU0pc1Vlf7i',1),(10,'elliott.susie@knights.ucf.edu',2,'Susie','Elliott','$2y$10$DgyrRUoIbPhjfEaB2ZQv/ePYD/9xcwwu1r9zOLhnWPQaDnLmXmT7O',1),(11,'baldwin.tricia@knights.ucf.edu',2,'Tricia','Baldwin','$2y$10$b9LOkZnhwcJ0vIxJzy7yquzOv/GGdk1QDgWFNmGyM1opIFn8VkiKO',1),(12,'cornwell.grant@rollins.edu',3,'Grant','Cornwell','$2y$10$.BdqaSHRdc1iN/Pj6CDssu8MPKlAr7K3ZIqE60vyiWkuWzlZMcjHG',3),(13,'gonzales.alfred@rollins.edu',3,'Alfred','Gonzales','$2y$10$JV/Dgqz1FPp7CtqRswgkv.4I79gKxGBCgWPO7YntwNxhlhkPcV6mK',1),(14,'tate.corey@rollins.edu',3,'Corey','Tate','$2y$10$Fcw9tm0ZnqGjbjnj3Y.zS.r3bEowAwUItbWtdyB5UGoo8AkBOGlGK',1),(15,'payne.lorena@rollins.edu',3,'Lorena','Payne','$2y$10$0BeQyDg0skM0bFtPXnkvQe2jJ.E4DoZIO2GM1PTfFbp5RsDHbXhdK',1),(16,'barrett.malcolm@rollins.edu',3,'Malcolm','Barrett','$2y$10$k1sJGcGQ1wq8y2E2aUFA9uUB2BQ2T79ViQR9DCilLYqId6g24qU/K',1),(17,'bridges.sophie@rollins.edu',3,'Sophie','Bridges','$2y$10$N1xNHRpY5d46TarJe9msduLGc6JcT2pRLaciMcfA8V.SrqNDsVSK.',1),(18,'fuchs.kent@uf.edu',4,'Kent','Fuchs','$2y$10$1pA5gVOQXUkLVEEg43L7nOk208muFJMVUVkN9FNilBJdfp4May2a2',3),(19,'higgins.ada@uf.edu',4,'Ada','Higgins','$2y$10$ayFGNFDFK9e8ved6qlQ8GO5auZWOr4hhU7BdSqb/Dpem.774TRjfG',1),(20,'watts.debbie@uf.edu',4,'Debbie','Watts','$2y$10$T3A3nucTu9/acVPArTpI0.zstgtpsK3bTpOkAN8qlv20I/tJ8WKEG',1),(21,'willis.rachael@uf.edu',4,'Rachael','Willis','$2y$10$vYRG6HNeqDey1PYzawodOuPJLj3ZiWUrcQcbkPXhw/BUUeijjPwTG',1),(22,'hunt.roy@uf.edu',4,'Roy','Hunt','$2y$10$evrp.mLw2TdPdQclIz3KYODzps.fJz2oZa8wS4R3WpzzR6bYuTRlm',1),(23,'austin.suzanne@uf.edu',4,'Suzanne','Austin','$2y$10$z3jxy9ZbI3bTSCrcs82EIeZU/9/G9GNgoz.B3Sxv5nC1zy7g9nEee',1),(24,'beck.toni@uf.edu',4,'Toni','Beck','$2y$10$/gccrkDou8iZ74G2XzQs0OwKl5uJo0nPfT7JIlJLFD0a5/lVJUNzO',1),(25,'reif.rafael@mit.edu',5,'Rafael','Reif','$2y$10$MeQCKz6SjZCdB3ac8Z9B7eyEYynZUHrCqCjpIVWkzQl9OlgIWxMxm',3),(26,'stevens.bryant@mit.edu',5,'Bryant','Stevens','$2y$10$X.JfVX6Banfq.OqNYIu5DO32Dc3TKryR3cwCxPWZJsMWnj2wX3YEa',1),(27,'higgins.candace@mit.edu',5,'Candace','Higgins','$2y$10$j5uBrVj.Vg36A3cPYCUps.7cnK.K3ZI3GPOHSOARwuz/A.tnfZnfy',1),(28,'griffin.kimberly@mit.edu',5,'Kimberly','Griffin','$2y$10$71PPHzobFrBjQ9IofXhZYu1AjnXfH4CYA9z/9TrsaNwWNJEHVeij.',1),(29,'hines.mario@mit.edu',5,'Mario','Hines','$2y$10$ylOp6TrdzSjhqx78Hf/9v.0/8Td4CY8jvblEfrY6j.0Iw9.bYuCWa',1),(30,'patrick.scott@mit.edu',5,'Scott','Patrick','$2y$10$IrBLrje2Vg.UR1cYduWUWeFkUna1n6s.8vMMuZNP/FEpF.NlBzGf.',1),(31,'banks.wilfred@mit.edu',5,'Wilfred','Banks','$2y$10$1g3mVInp8rF30Q343IL9uOjEq1j2AAHqJ5wzOk5YARWYKq7j.xR.a',1),(32,'dirks.nicholas@ucb.edu',6,'Nicholas','Dirks','$2y$10$NJtMFXiNW5eZxqeJi6Rabe51DlwTva2l.5w7pm7pDaODLQiRzP.o6',3),(33,'cannon.becky@ucb.edu',6,'Becky','Cannon','$2y$10$VD9rXxcUz2UymaemB1U32O36USCb25HLwWZdGpH85mVJzx.oG13FK',1),(34,'smith.eric@ucb.edu',6,'Eric','Smith','$2y$10$VxsdX7qKFogAiBHrM.Fbwe3uymD5TUoZVmxW.5kKDgThpWXoY8ZZW',1),(35,'west.herbert@ucb.edu',6,'Herbert','West','$2y$10$vbmNdXv/0QfwjzFJA1A.A.KaBfJUvBpz0RG32kzU4.N0Y7/xC/aHC',1),(36,'abbott.james@ucb.edu',6,'James','Abbott','$2y$10$JX8JzZTpoEORW8UF2DfWbuSffOZ.Jf2tWRIO.x7m260IJCSw/nD82',1),(37,'hale.kyle@ucb.edu',6,'Kyle','Hale','$2y$10$BvlE.miLOW/jlo7DsUrLyekZKAhr4LApaBhjRUZhW4tgRdIzPrpha',1),(38,'bass.phil@ucb.edu',6,'Phil','Bass','$2y$10$ttuFrosJtPH9wybzZDBmGuKgEgCU27bOg9z9RCcTwlAXC.lluQ9xm',1);
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

-- Dump completed on 2015-10-30 21:41:11