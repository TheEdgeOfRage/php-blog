/*
 * init.sql
 * Copyright (C) 2020 pavle <pavle.portic@tilda.center>
 *
 * Distributed under terms of the BSD 3-Clause license.
 */

-- vim:et

CREATE DATABASE IF NOT EXISTS blog;

CREATE TABLE IF NOT EXISTS users (
	`id` int PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(255) NOT NULL UNIQUE,
	`email` varchar(255) NOT NULL UNIQUE,
	`password` varchar(255) NOT NULL,
	`name` varchar(255) NOT NULL,
	`valid` boolean DEFAULT 0,
	`key` varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS posts (
	`post_id` int AUTO_INCREMENT,
	`title` varchar(1024) NOT NULL,
	`text` blob NOT NULL,
	`date` varchar(255) NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (post_id),
	FOREIGN KEY (user_id) REFERENCES users(id)
);
