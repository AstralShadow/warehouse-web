USE 2022_04_c_sharp_competition;

CREATE TABLE Deliveries(
    id INT PRIMARY KEY AUTO_INCREMENT,

    name NVARCHAR(255) NOT NULL,

    unit_type NVARCHAR(255) NOT NULL,
    unit_price FLOAT NOT NULL,

    quantity INT NOT NULL,


    # No limit placed on deliver name length
    #  due to it looking absurd when I
    #  calculate multi-bit characters from unicode and
    #  the fact that people might want to write full
    #  company name and maybe even some side notes

    deliver TEXT NOT NULL,
    date DATE NOT NULL
);

