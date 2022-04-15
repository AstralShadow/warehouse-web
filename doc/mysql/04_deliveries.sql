USE 2022_04_c_sharp_competition;

CREATE TABLE Deliveries(
    id INT PRIMARY KEY AUTO_INCREMENT,

    name NVARCHAR(255) NOT NULL,

    unit_type NVARCHAR(255) NOT NULL,
    unit_price INT NOT NULL, # Working in pennies

    quantity INT NOT NULL DEFAULT 1,

    deliver NVARCHAR(255) NOT NULL,
    end_date DATE NOT NULL
);

