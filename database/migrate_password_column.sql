-- Run this once on a database created before passwords were hashed.
--
-- A password hash is about 60 characters, and an old doctor.password column
-- (often VARCHAR(20) or similar) cannot hold one. Until this is run, the app
-- keeps working but refuses to create accounts or change passwords, rather than
-- storing a truncated hash that nobody could ever sign in with.
--
-- Existing plain-text passwords keep working: each one is replaced with a hash
-- the next time that doctor signs in.
USE mydata;
ALTER TABLE doctor MODIFY password VARCHAR(255) NOT NULL;
