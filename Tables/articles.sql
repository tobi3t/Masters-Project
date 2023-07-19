CREATE TABLE articles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  article_title VARCHAR(255),
  date_uploaded DATE DEFAULT CURRENT_DATE,
  article_body TEXT,
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);