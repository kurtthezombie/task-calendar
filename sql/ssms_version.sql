USE [TASKCALENDAR_GR3]

CREATE TABLE user_info (
	user_idn INT PRIMARY KEY NOT NULL,
	user_email VARCHAR(25) NOT NULL,
	user_password VARCHAR(100) NOT NULL,
	user_fname VARCHAR(25) NOT NULL,
	user_lname VARCHAR(15) NOT NULL,
	date_created DATETIME NOT NULL DEFAULT GETDATE()
)

CREATE TABLE task (
	task_id INT PRIMARY KEY NOT NULL,
	task_title VARCHAR(50) NOT NULL,
	task_description VARCHAR(255) DEFAULT NULL,
	task_startdate DATETIME NOT NULL,
	task_duedatetime DATETIME DEFAULT NULL,
	task_status VARCHAR(5) DEFAULT 'todo' NOT NULL ,
	task_reminder TINYINT DEFAULT 0 NOT NULL ,
	task_date_created DATE DEFAULT GETDATE() NOT NULL,
	task_user_id INT REFERENCES user_info(user_idn)
)