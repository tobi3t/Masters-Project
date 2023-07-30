CREATE TABLE goals (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  details TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);