CREATE TABLE resources (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  article_id INT,
  point_earned INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (article_id) REFERENCES articles(id)
);