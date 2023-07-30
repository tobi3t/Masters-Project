CREATE TABLE chat_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


ALTER TABLE chat_messages
ADD COLUMN category_id INT,
ADD FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE;
