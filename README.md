# FinanceTracker

I made this project as a mini-project for my 4th semester.
It is a monthwise Tracking System where you can type in your income & expenses and get to see how much you still have as well as get a donut-chart for representing how much you have spent or have left.
Every transaction that is entered, gets displayed.
You have to create a few tables in a database phpmyadmin.

--TABLE userlogin ( Set ID to auto-increment ):

CREATE TABLE userlogin(
ID int,
name VARCHAR(128),
email VARCHAR(128),
password_hash VARCHAR(128)
);

--TABLE transactions

CREATE TABLE transactions(
ID INT,
month VARCHAR(20),
t_id FLOAT,
t_name VARCHAR(128),
t_amount FLOAT,
FOREIGN KEY (ID) REFERENCES userlogin (ID)
);
