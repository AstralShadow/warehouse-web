CREATE DATABASE 2022_04_c_sharp_competition;

CREATE USER 'c_sharp_competition'@'localhost'
    IDENTIFIED BY '94b53710-fc61-43d0-b43b-abc091b59b6c';

GRANT ALL PRIVILEGES ON 2022_04_c_sharp_competition.*
    TO 'c_sharp_competition'@'localhost';

FLUSH PRIVILEGES;

USE 2022_04_c_sharp_competition;
