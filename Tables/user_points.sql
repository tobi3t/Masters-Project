CREATE TABLE user_points (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  points INT,
  score INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
