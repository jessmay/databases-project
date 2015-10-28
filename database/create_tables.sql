SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS RSO (
    RSO_id   INTEGER NOT NULL AUTO_INCREMENT,
    Admin_id INTEGER NOT NULL,
    Name     CHAR(50),
    PRIMARY KEY (RSO_id),
    FOREIGN KEY (Admin_id) REFERENCES User (User_id)
);

CREATE TABLE IF NOT EXISTS University (
    University_id INTEGER NOT NULL AUTO_INCREMENT,
    SuperAdmin_id INTEGER NOT NULL DEFAULT 1,
    Name          CHAR(50),
    Description   CHAR(160),
    Student_count INTEGER NOT NULL DEFAULT 0,
    PRIMARY KEY (University_id),
    FOREIGN KEY (SuperAdmin_id) REFERENCES User (User_id),
    UNIQUE      (Name)
);

INSERT INTO University (University_id, Name) 
       VALUES (1, 'Default University');

CREATE TABLE IF NOT EXISTS User (
    User_id       INTEGER NOT NULL AUTO_INCREMENT,
    Email         CHAR(50),
    University_id INTEGER NOT NULL DEFAULT 1,
    First_name    CHAR(50),
    Last_name     CHAR(50),
    Password_hash CHAR(255),
    Type          INTEGER NOT NULL DEFAULT 1,
    PRIMARY KEY (User_id),
    FOREIGN KEY (University_id) REFERENCES University (University_id),
    UNIQUE      (Email)
);

INSERT INTO User (User_id, University_id, First_name, Last_name) 
       VALUES (1, 1, 'Bobby', 'Tables');

CREATE TABLE IF NOT EXISTS Picture (
    Picture_id INTEGER NOT NULL AUTO_INCREMENT,
    Url        CHAR(200),
    PRIMARY KEY (Picture_id)
);

CREATE TABLE IF NOT EXISTS Rating (
    Rating_id INTEGER NOT NULL AUTO_INCREMENT,
    User_id   INTEGER NOT NULL,
    Event_id  INTEGER NOT NULL,
    Rating    INTEGER,
    PRIMARY KEY (Rating_id),
    FOREIGN KEY (User_id) REFERENCES User (User_id),
    FOREIGN KEY (Event_id) REFERENCES Event (Event_id)
);

CREATE TABLE IF NOT EXISTS Comment (
    Comment_id INTEGER NOT NULL AUTO_INCREMENT,
    User_id    INTEGER NOT NULL,
    Event_id   INTEGER NOT NULL,
    Date       DATE,
    Message    CHAR(160),
    PRIMARY KEY (Comment_id),
    FOREIGN KEY (User_id) REFERENCES User (User_id),
    FOREIGN KEY (Event_id) REFERENCES Event (Event_id)
);

CREATE TABLE IF NOT EXISTS Event (
    Event_id      INTEGER NOT NULL AUTO_INCREMENT,
    Admin_id      INTEGER NOT NULL,
    Category_id   INTEGER NOT NULL,
    Date_time     DATETIME,
    Name          CHAR(50),
    Type          INTEGER NOT NULL,
    Contact_email CHAR(50),
    Contact_phone CHAR(11),
    Description   CHAR(160),
    Approved      BOOL,
    PRIMARY KEY (Event_id),
    FOREIGN KEY (Admin_id) REFERENCES User (User_id),
    FOREIGN KEY (Category_id) REFERENCES Category (Category_id)
);

CREATE TABLE IF NOT EXISTS Category (
    Category_id INTEGER NOT NULL AUTO_INCREMENT,
    Name        CHAR(50),
    PRIMARY KEY (Category_id)
);

CREATE TABLE IF NOT EXISTS Location (
    Location_id INTEGER NOT NULL AUTO_INCREMENT,
    Name        CHAR(120),
    Latitude    DOUBLE,
    Longitude   DOUBLE,
    PRIMARY KEY (Location_id)
);

CREATE TABLE IF NOT EXISTS RSO_user (
    RSO_id  INTEGER NOT NULL,
    User_id INTEGER NOT NULL,
    PRIMARY KEY (RSO_id, User_id),
    FOREIGN KEY (RSO_id) REFERENCES RSO (RSO_id),
    FOREIGN KEY (User_id) REFERENCES User (User_id)
);

CREATE TABLE IF NOT EXISTS university_location (
    University_id INTEGER NOT NULL,
    Location_id   INTEGER NOT NULL,
    PRIMARY KEY (University_id, Location_id),
    FOREIGN KEY (University_id) REFERENCES University (University_id),
    FOREIGN KEY (Location_id) REFERENCES Location (Location_id)
);

CREATE TABLE IF NOT EXISTS event_user (
    Event_id INTEGER NOT NULL,
    User_id  INTEGER NOT NULL,
    PRIMARY KEY (Event_id, User_id),
    FOREIGN KEY (Event_id) REFERENCES Event (Event_id),
    FOREIGN KEY (User_id) REFERENCES User (User_id)
);

CREATE TABLE IF NOT EXISTS event_location (
    Event_id    INTEGER NOT NULL,
    Location_id INTEGER NOT NULL,
    PRIMARY KEY (Event_id, Location_id),
    FOREIGN KEY (Event_id) REFERENCES Event (Event_id),
    FOREIGN KEY (Location_id) REFERENCES Location (Location_id)
);

CREATE TABLE IF NOT EXISTS university_picture (
    Picture_id    INTEGER NOT NULL,
    University_id INTEGER NOT NULL,
    PRIMARY KEY (Picture_id, University_id),
    FOREIGN KEY (Picture_id) REFERENCES Picture (Picture_id),
    FOREIGN KEY (University_id) REFERENCES University (University_id)
);

CREATE TABLE IF NOT EXISTS university_RSO (
    University_id INTEGER NOT NULL,
    RSO_id        INTEGER NOT NULL,
    PRIMARY KEY (University_id, RSO_id),
    FOREIGN KEY (University_id) REFERENCES University (University_id),
    FOREIGN KEY (RSO_id) REFERENCES RSO (RSO_id)
);

CREATE TABLE IF NOT EXISTS university_event (
    University_id INTEGER NOT NULL,
    Event_id      INTEGER NOT NULL,
    PRIMARY KEY (University_id, Event_id),
    FOREIGN KEY (University_id) REFERENCES University (University_id),
    FOREIGN KEY (Event_id) REFERENCES Event (Event_id)
);

SET FOREIGN_KEY_CHECKS = 1;