# Telly

Meet Telly, our video browsing app focused on enhancing education and engagement among students.

Telly is a PHP/MySQL web app that provides various features such as:

* User Accounts & Login.
* User interface view to display embedded videos (iframes).
* User comment and rating forms for input.
* An updated user comment and rating display feed.
* Inter-application navigation view for intuitive user browsing.

### Getting started with the database

The following are code samples we used to initialize the Telly Database.

```
CREATE TABLE Users ( uid INTEGER NOT NULL AUTO_INCREMENT,
                     username VARCHAR(20),
                     user_password VARCHAR(100),
                     major VARCHAR(20),
                     PRIMARY KEY (uid))
```

```
CREATE TABLE Videos ( vid INTEGER NOT NULL AUTO_INCREMENT,
                      uid INTEGER NOT NULL,
                      videoname VARCHAR(30),
                      videolink VARCHAR(100),
                      PRIMARY KEY (vid),
                      FOREIGN KEY (uid) REFERENCES Users(uid))
```

```
CREATE TABLE Ratings ( rid INTEGER NOT NULL AUTO_INCREMENT,
                       vid INTEGER NOT NULL,
                       uid INTEGER,
                       rating INTEGER,
                       PRIMARY KEY (rid),
                       FOREIGN KEY (vid) REFERENCES Videos(vid),
                       FOREIGN KEY (uid) REFERENCES Users(uid))
```

```
CREATE TABLE Comments ( cid INTEGER NOT NULL AUTO_INCREMENT,
                        vid INTEGER,
                        uid INTEGER,
                        theComment VARCHAR(140),
                        PRIMARY KEY (cid),
                        FOREIGN KEY (vid) REFERENCES Videos(vid),
                        FOREIGN KEY (uid) REFERENCES Users(uid))

CREATE TABLE Keywords (kid INTEGER NOT NULL AUTO_INCREMENT,
                       vid INTEGER NOT NULL,
                       uid INTEGER,
                       keyword1 VARCHAR(10),
                       keyword2 VARCHAR(10),
                       keyword3 VARCHAR(10),
                       PRIMARY KEY (kid),
                       FOREIGN KEY (vid) REFERENCES Videos(vid),
                       FOREIGN KEY (uid) REFERENCES Users(uid))
