CREATE TABLE quiz (
  question_id INT AUTO_INCREMENT PRIMARY KEY,
  question_text VARCHAR(255),
  option1 VARCHAR(255),
  option2 VARCHAR(255),
  option3 VARCHAR(255),
  option4 VARCHAR(255),
  correct_option INT,
  admin_id INT,
  FOREIGN KEY (admin_id) REFERENCES users(id)
);
