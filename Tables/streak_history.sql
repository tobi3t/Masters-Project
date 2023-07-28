CREATE TABLE streak_history (
  id INT PRIMARY KEY AUTO_INCREMENT,
  streak_duration INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);


