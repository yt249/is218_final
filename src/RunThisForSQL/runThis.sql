
-- change the db name to yours
USE `SpringBreak`;

CREATE TABLE IF NOT EXISTS 218Task(
                    taskid INT NOT NULL AUTO_INCREMENT,
                    userName VARCHAR(255) NOT NULL,
                    title VARCHAR(255) NOT NULL,
                    descr VARCHAR(255) NOT NULL,
                    dueDate DATETIME NOT NULL,
                    urgency VARCHAR(20) NOT NULL,
                    completed BOOLEAN NOT NULL,
                    PRIMARY KEY (taskid)
                    );

CREATE TABLE IF NOT EXISTS 218User(
                    firstName VARCHAR(255) NOT NULL PRIMARY KEY,
                    lastName VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    userName VARCHAR(255) NOT NULL,
                    pass VARCHAR(255) NOT NULL,
                    PRIMARY KEY (email)
                    );

