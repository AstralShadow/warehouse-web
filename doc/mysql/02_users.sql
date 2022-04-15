USE 2022_04_c_sharp_competition;

CREATE TABLE Users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    
    username NVARCHAR(255) NOT NULL,
    pwd BINARY(60) NOT NULL,

    token CHAR(42) UNIQUE

);
