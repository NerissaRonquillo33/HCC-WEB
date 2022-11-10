<?php
include_once(dirname(__FILE__).'/../database/connector.php');

/* create database */
$mysqli = noDB();
if ($mysqli->query("CREATE DATABASE IF NOT EXISTS hcc")) {
	echo "Database hcc created successfully.<br />";
}

/* create table */
$mysqli = DB();
$sql = "CREATE TABLE IF NOT EXISTS users( ".
            "id INT NOT NULL AUTO_INCREMENT, ".
            "image LONGTEXT, ".
            "firstname VARCHAR(255) NOT NULL, ".
            "middlename VARCHAR(255) NOT NULL, ".
            "lastname VARCHAR(255) NOT NULL, ".
            "contact VARCHAR(20) NOT NULL, ".
            "gender VARCHAR(20) NOT NULL, ".
            "dob VARCHAR(255) NOT NULL, ".
            "age INTEGER NOT NULL, ".
            "course_id INTEGER NOT NULL, ".
            "username VARCHAR(255) NOT NULL UNIQUE, ".
            "password VARCHAR(255) NOT NULL, ".
            "token VARCHAR(255) NOT NULL UNIQUE, ".
            "role VARCHAR(20) NOT NULL DEFAULT 'user', ".
            "PRIMARY KEY ( id )); ".
            "INSERT INTO users(firstname,middlename,lastname,contact,gender,dob,age,course_id,username,password,token,role) VALUES('admin','admin','admin','admin','admin','admin',1,0,'admin','admin','na','admin');";
$sql .= "CREATE TABLE IF NOT EXISTS courses( ".
            "id INT NOT NULL AUTO_INCREMENT, ".
            "course_name_id INTEGER NOT NULL, ".
            "code VARCHAR(255) NOT NULL, ".
            "description VARCHAR(255) NOT NULL, ".
            "unit INTEGER NOT NULL, ".
            "semester INTEGER NOT NULL, ".
            "year INTEGER NOT NULL, ".
            "PRIMARY KEY ( id )); ";
$sql .= "CREATE TABLE IF NOT EXISTS courses_name( ".
            "id INT NOT NULL AUTO_INCREMENT, ".
            "title VARCHAR(255) NOT NULL UNIQUE, ".
            "PRIMARY KEY ( id )); ";
$sql .= "INSERT INTO courses_name(title) VALUES('BSCS'),('BSIT'),('BSBA'),('BSA'),('BSHRM'),('BSN'); ";
$sql .= "CREATE TABLE IF NOT EXISTS student_courses( ".
            "id INT NOT NULL AUTO_INCREMENT, ".
            "student_id INTEGER NOT NULL, ".
            "teacher_id INTEGER NOT NULL, ".
            "course_id INTEGER NOT NULL, ".
            "PRIMARY KEY ( id ),".
            "UNIQUE KEY cour_stud_id (course_id, student_id)); ";
$sql .= "CREATE TABLE IF NOT EXISTS schedules( ".
            "id INT NOT NULL AUTO_INCREMENT, ".
            "title VARCHAR(255) NOT NULL, ".
            "description VARCHAR(255) NOT NULL, ".
            "PRIMARY KEY ( id )); ";
if ($mysqli->multi_query($sql)) {
	echo "Table users, courses, student_courses, schedules created successfully.<br />";
}
