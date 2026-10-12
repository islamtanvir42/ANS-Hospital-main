-- ANS Hospital Management System - doctor-side module
--
-- This schema was reconstructed from the columns the PHP code reads and writes.
-- The original database export was not kept with the project, so if you still
-- have it, prefer that one. The password column is VARCHAR(255) because it holds
-- a password hash.

CREATE DATABASE IF NOT EXISTS mydata CHARACTER SET utf8mb4;
USE mydata;

CREATE TABLE IF NOT EXISTS doctor (
    doctorID INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(80)  NOT NULL,
    email    VARCHAR(100) NOT NULL,
    mobile   VARCHAR(15)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender   VARCHAR(10)  NOT NULL
);

CREATE TABLE IF NOT EXISTS patient (
    patient_ID   INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(80),
    gender       VARCHAR(10),
    patient_age  INT,
    mobile_no    VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS salary (
    doctorID        INT,
    view_salary     VARCHAR(40),
    current_balance DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS fee_followup (
    followupID   INT AUTO_INCREMENT PRIMARY KEY,
    doctorID     INT,
    fee          DECIMAL(8,2),
    followup_fee DECIMAL(8,2)
);

CREATE TABLE IF NOT EXISTS patient_record (
    record_id   INT AUTO_INCREMENT PRIMARY KEY,
    test_result VARCHAR(120),
    plans       VARCHAR(160)
);
