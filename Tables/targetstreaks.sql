CREATE TABLE target_streaks (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  target_streak INT NOT NULL,
  record_date DATE NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);