SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO University VALUES(2, 2, 'University of Central Florida', 'Great school, 10/10.', 60000);
INSERT INTO University VALUES(3, 4, 'Lame State School', 'Sort of okay, not really notable.', 20000);
INSERT INTO University VALUES(4, 6, 'Backup College', 'You should have started applying earlier.', 5000);
INSERT INTO University VALUES(5, 11, 'Community College', 'Get that AA before college.', 1000);
INSERT INTO University VALUES(6, 9, 'Smart School', 'Only the smartest of students attend.', 5);

INSERT INTO User VALUES(2, 'bob@example.com', 3, 'Robert', 'Example',
'$2y$10$oN3BkMddhlkBaa7jOQmFduubpOJgXoq3.kLpXy15ve/1PX3jk1sTu', 1);
INSERT INTO User VALUES(3, 'bernard@knights.ucf.edu', 2, 'Bernard', 'Bernard',
'$2y$10$C0bvDBzLjqsxv4uxebT7dehrCYZjxNdBbRA4Z8RTDhrA2NUu0FN8K', 1);
INSERT INTO User VALUES(4, 'john@lamestateschool.edu', 3, 'John', 'Lafawn',
'$2y$10$8UbN6cFEKHPWmW93mJD8ouQsSKVoW6scpwVASRZgxdB82S9ftpk2y', 1);
INSERT INTO User VALUES(5, 'benny@lamestateschool.edu', 3, 'Benny', 'Smith',
'$2y$10$pgfgHhRVIACGd1lQmqQ8ceDUpWAvm6/u3z4FM3sH5hZBLIDq/kDti', 1);
INSERT INTO User VALUES(6, 'george@backup.edu', 4, 'Georgie', 'Porgie',
'$2y$10$1Nm.7.YBipvMq4HnLIDg/OiWUgIB5oJ7e00MKJN4CbnWxQOp6eYxS', 1);
INSERT INTO User VALUES(7, 'sasha@backup.edu', 4, 'Sasha', 'Westly',
'$2y$10$H88/MnjgGlwxqa8gOYEI1Oq4ThQFVDFEgArcqtKqtIcrFmnfKG7w6', 1);
INSERT INTO User VALUES(8, 'linda@backup.edu', 4, 'Linda', 'Moore',
'$2y$10$B51RHbNQtcFJfrWl7FqSRemWn/uInI7.nl/udW2POQttG1f0pLore', 1);
INSERT INTO User VALUES(9, 'erica@smartschool.com', 6, 'Erica', 'Smith',
'$2y$10$g9Nm0FqFA2CvVgkKC21YkuWzZlfcy/0YdFS8VmZpHwfG5qSIZbWSu', 1);
INSERT INTO User VALUES(10, 'monica@backup.edu', 4, 'Monica', 'Saver',
'$2y$10$LL39QSAZzrwwJ5kg2DVjRep6S2RI6zfQjmoyh6EOTKiNOHpEo7a3S', 1);
INSERT INTO User VALUES(11, 'gretchen@community.edu', 5, 'Gretchen', 'Matilda',
'$2y$10$EBU9q8C2kVrGvw6fPNTyxerHbsI67dAqe0XRnSWFR1VBBdFnksUDG', 1);
INSERT INTO User VALUES(12, 'almost@backup.edu', 4, 'Almost', 'Madeit',
'$2y$10$oC2xfHARUsELUX/5x0N81OJrvZ5G2Ix0ZgmWMIYdZjCltO8vpG4te', 1);

INSERT INTO Event VALUES(1, 2, 1, '2015-11-12 10:00:00', 'Donut Party', 1, 'john@dunkindonuts.com',
'5551235678', 'A party. With donuts.', 1);
INSERT INTO Event VALUES(2, 3, 3, '2015-12-01 09:00:00', 'PHP Talk', 3, 'zend@php.net',
'5550101111', 'A talk about PHP.', 1);
INSERT INTO Event VALUES(3, 1, 5, '2015-12-31 14:00:00', 'Pokemon Concert', 3, 'pika@chu.com',
'5552324242', 'Music and things.', 1);
INSERT INTO Event VALUES(4, 5, 2, '2015-12-15 19:00:00', 'Stand-up Comedy', 3, 'guy@2funny.com',
'5558675309', 'Come laugh and support a great cause.', 1);
INSERT INTO Event VALUES(5, 4, 4, '2015-12-08 12:00:00', 'Study Abroad Basics', 2, 'backupcountry@backup.edu',
'5552324242', 'Study in a different country if Backup College fails.', 0);
INSERT INTO Event VALUES(6, 2, 1, '2015-10-31 18:00:00', 'Halloween Party', 2, 'bob@example.com',
'5552324242', 'Celebrate Halloween and meet club members', 0);

INSERT INTO RSO VALUES(1, 1, 'Some RSO');
INSERT INTO RSO VALUES(2, 2, 'Another RSO');
INSERT INTO RSO VALUES(3, 3, 'Third RSO');

INSERT INTO Location VALUES(1, 'Dominos', 28.598877, -81.203687);
INSERT INTO Location VALUES(2, 'Orlando International Airport', 28.40329, -81.333023);
INSERT INTO Location VALUES(3, 'Disney Store', 28.428083, -81.341791);
INSERT INTO Location VALUES(4, 'UCF Student Union', 28.598877, -81.203687);

INSERT INTO Category VALUES(1, 'Social');
INSERT INTO Category VALUES(2, 'Fundraiser');
INSERT INTO Category VALUES(3, 'Tech Talk');
INSERT INTO Category VALUES(4, 'Academic');
INSERT INTO Category VALUES(5, 'Concert');

SET FOREIGN_KEY_CHECKS = 1;