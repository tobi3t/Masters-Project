CREATE TABLE streaks (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  streak_start_date DATE NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);