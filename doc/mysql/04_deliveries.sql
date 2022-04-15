USE 2022_04_c_sharp_competition;

CREATE TABLE Deliveries(
    id INT PRIMARY KEY AUTO_INCREMENT,

    name NVARCHAR(255) NOT NULL,

    unit_type NVARCHAR(255) NOT NULL,
    unit_price FLOAT NOT NULL,

    quantity INT NOT NULL,

    deliver TEXT NOT NULL,
    date DATE NOT NULL
);

