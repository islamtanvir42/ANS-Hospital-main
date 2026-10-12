# ANS Hospital Management System — doctor-side module

A web-based hospital management system built as a **pair project at AIUB**. This repository holds
**my half: the doctor's side** — everything a doctor sees once they have an account. The other half
of the system was built by my project partner and is not in this repository.

Written in plain PHP and MySQL, organised as MVC, with no framework.

## What it does

- **Doctor registration** with validation in the browser (JavaScript) and again on the server:
  full name, a valid email, an 11-digit phone number, a password of at least four characters that
  mixes letters and numbers, a matching confirmation, and a chosen gender. Duplicate phone numbers
  and emails are refused.
- **Sign-in and sessions.** Every page behind the login sends visitors without a session back to the
  sign-in page. Logout ends the session.
- **Dashboard** linking to each part of the doctor's workspace.
- **Patient list**, read from the `patient` table.
- **Account**: the signed-in doctor's own salary and current balance.
- **Fee and follow-up** list with a working filter by follow-up ID and/or doctor ID.
- **Patient records**: test results and treatment plans.
- **Profile**, **update profile** and **change password** (the current password is required).
- **Forgot password**: tells the doctor to contact an administrator (see below).

## Tech

PHP 8 · MySQL / MariaDB (`mysqli`, prepared statements) · JavaScript · HTML. No build step.

## Project structure

```
Tanvir/mvc/
├── model/         database access and shared helpers
│   ├── database_connection.php   connection settings
│   ├── data.php                  queries: login, profile, lists, password changes
│   ├── db.php                    creating a doctor account
│   └── helpers.php               escaping, one-shot messages, login guard, password rules
├── controllers/   what each form submits to
├── views/         the pages, plus js/ for the browser-side checks
database/
├── schema.sql                    tables (see the note below)
├── sample_data.sql               made-up data for trying the app
└── migrate_password_column.sql   one-off upgrade for older databases
```

## Running it locally

1. Install [XAMPP](https://www.apachefriends.org/) (or any PHP 8 + MySQL/MariaDB setup) and start Apache and MySQL.
2. Import the database. In phpMyAdmin, or from the command line:

   ```bash
   mysql -u root < database/schema.sql
   mysql -u root < database/sample_data.sql   # optional demo data
   ```

3. Copy the `Tanvir/mvc` folder into `htdocs` and open
   `http://localhost/mvc/views/login.php`.
   Without XAMPP you can also run `php -S localhost:8000 -t Tanvir/mvc` and open
   `http://localhost:8000/views/login.php`.
4. With the sample data you can sign in as **01700000001** with password **demo1234**.

The database connection defaults to `root` with no password on `localhost`, database `mydata`.
To use something else, set `ANS_DB_HOST`, `ANS_DB_USER`, `ANS_DB_PASS` and `ANS_DB_NAME`, or edit
`Tanvir/mvc/model/database_connection.php`.

> **About the schema.** `database/schema.sql` was **reconstructed from the columns the code reads
> and writes**. The original database export was not kept with the project. If you have the
> original, use that and only apply the password-column change below.

## Upgrading an existing database

Passwords are now stored as hashes (`password_hash`), which are about 60 characters long. A database
created before that change usually has a shorter `doctor.password` column. Run this once:

```bash
mysql -u root < database/migrate_password_column.sql
```

Until you do, the app still works, but it refuses to create accounts or change passwords, rather than
storing a truncated hash that could never be used to sign in. Existing plain-text passwords keep
working and are replaced by a hash the next time that doctor signs in.

## Security

Done:

- Passwords are hashed, never shown, and never printed back — not on the profile page, not by "forgot password".
- All queries use prepared statements. Everything printed from the database or from user input is
  HTML-escaped.
- The session id is renewed on sign-in. Pages and form handlers behind the login check the session.
- Changing a password needs the current password and only ever changes the signed-in doctor's own.
- A doctor can only see their own salary and balance.

Not done (this is coursework, and these are the honest gaps):

- **No CSRF protection** on the forms and **no rate limiting** on sign-in attempts.
- **Password recovery is manual.** There is no email service, so "forgot password" only tells the
  doctor to contact an administrator. A real version would send a time-limited reset link.
- The password rule is a minimum of four characters with a letter and a number — weak by modern standards.
- There is a single kind of user. There are no roles.

## Files that are not used

`views/regis.php`, `views/resgis.php`, `views/log.html`, `views/views.php` (empty) and
`controllers/regis action.php` are early drafts that nothing links to. The background image on the
registration page, `views/res.jpg`, is a stock photo with a visible watermark; replace it with an
image you have the right to use.
