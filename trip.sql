CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    given VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    location VARCHAR(255),w
    images TEXT,
    created_at DATETIME NOT NULL,
    INDEX (user_id)
);