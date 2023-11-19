# CMPE138-180-Project
**Ran with Xampp


**init_data.sql contains the queries used to create the databases;

**Idea is that database admin username and password is hardcoded in the database (set by the company sort of idea) 
Admin Account:
Username=Admin
Password=Password


**Might have issues if password is too long when hashed since RegPassword is only varchar(100)

**Changed ER with the idea that Data Entry Employee now has a new relationship through Assists/Handles with License Requestor as well

**Going in as a database admin is how you can initialize accounts for driving school, employees, external agencies (Using "Go To Registration Admin Page")

**Users will usually follow the pattern of logging in through home page, being shown the corresponding home page to of their role (HomePage for ComplianceAgent is different for HomePage for DMV "Customers" like LicenseRequestor/CurrentDriver/VehicleRegistrationRequestor), then going into various functions (insert/view/update/delete) and being able to back out to their HomePage

**tables can also be accessed through mySQL utilizing the database hosting link utilizing AWS link providede in the project report alongside with the username and password

