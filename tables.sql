-- Users table
CREATE TABLE users(
    id INT UNSIGNED AUTO_INCREMENT,
	username VARCHAR(35) NOT NULL UNIQUE,
    email VARCHAR(70) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    is_blocked TINYINT(1) NOT NULL DEFAULT 0,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    profile_pic VARCHAR(100) NULL DEFAULT "profile-none.png", 
    
    PRIMARY KEY(id)

    
);

-- Category table
CREATE TABLE categories(
    id INT UNSIGNED AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY(id)
);

-- Businesses table
CREATE TABLE businesses(
    id INT UNSIGNED AUTO_INCREMENT,
	business_name VARCHAR(100) NOT NULL UNIQUE,
    business_category  INT UNSIGNED,
    email VARCHAR(70) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    contact VARCHAR(100) NOT NULL,
    opening_hours TEXT NOT NULL,
    about TEXT NOT NULL,
    picture VARCHAR(100) NULL DEFAULT "profile-none.png", 
    
    is_blocked TINYINT(1) NOT NULL DEFAULT 0,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,

    
    PRIMARY KEY(id),
    FOREIGN KEY(business_category) REFERENCES categories(id)
    
);

-- Reviews 
CREATE TABLE reviews(
    id INT UNSIGNED AUTO_INCREMENT,
	user_comment VARCHAR(255) NULL,
    user_id INT UNSIGNED,
    business_id INT UNSIGNED,
    rating INT NOT NULL,
    business_reply VARCHAR(255) NULL,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    reply_date DATETIME NULL DEFAULT NULL,
    
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(business_id) REFERENCES businesses(id)
);



-- Bookmark
CREATE TABLE bookmarks(
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED,
    business_id INT UNSIGNED,
    bookmark_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(business_id) REFERENCES businesses(id)
);