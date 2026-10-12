-- Made-up sample data for trying the app. No real people.
-- Demo sign-in: phone 01700000001, password demo1234 (stored as a hash).
USE mydata;

INSERT INTO doctor (fullname, email, mobile, password, gender) VALUES
  ('Dr. Sample Doctor',  'sample.doctor@example.com',  '01700000001', '$2y$12$tUwNg0h6y4ts50jS8X8WCeTPRbLtooOvZNb.Yd0oW8ws.RCV0KFga', 'male'),
  ('Dr. Test Physician', 'test.physician@example.com', '01700000002', '$2y$12$tUwNg0h6y4ts50jS8X8WCeTPRbLtooOvZNb.Yd0oW8ws.RCV0KFga', 'female');

INSERT INTO patient (patient_name, gender, patient_age, mobile_no) VALUES
  ('Patient A', 'Female', 34, '01800000011'),
  ('Patient B', 'Male',   52, '01800000012'),
  ('Patient C', 'Male',    8, '01800000013'),
  ('Patient D', 'Female', 67, '01800000014'),
  ('Patient E', 'Female', 29, '01800000015'),
  ('Patient F', 'Male',   41, '01800000016');

INSERT INTO salary (doctorID, view_salary, current_balance) VALUES
  (1, 'Monthly', 48500.00),
  (2, 'Monthly', 51200.00);

INSERT INTO fee_followup (doctorID, fee, followup_fee) VALUES
  (1,  800.00, 400.00),
  (1, 1000.00, 500.00),
  (2,  900.00, 450.00),
  (2, 1200.00, 600.00);

INSERT INTO patient_record (test_result, plans) VALUES
  ('Blood pressure: elevated', 'Low-salt diet, review in 2 weeks'),
  ('Fasting glucose: normal',  'Routine check in 6 months'),
  ('Chest X-ray: clear',       'No treatment needed'),
  ('Cholesterol: borderline',  'Diet changes, repeat test in 3 months');
