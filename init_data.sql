-- init_data.sql
--SJSU CMPE 138 Fall 2023 Team 11

-- Create your database and switch to it
CREATE DATABASE IF NOT EXISTS Project;
USE Project;

Create table Person (
PersonLname varchar(50) NOT NULL,
PersonFname varchar(50) NOT NULL,
PersonSSN int primary key,
PersonDOB date NOT NULL);


create table DrivingSchool(
DSName varchar(50) primary key,
CertRegNumber int not null,
Manager varchar(50) not null
);

create table ExternalAgency(
EAName varchar(50) primary key,
EAType varchar(50) not null,
POC varchar(50) not null,
AdminInCharge varchar(50) not null);


create table Employee(
EmpSSN int primary key,
EmpLname varchar(50) not null,
EmpFname varchar(50) not null,
EmpNumber int not null
);


create table LicenseRequestor(
ApplicationNumber int primary key,
PersonSSN int unique,
foreign key (PersonSSN) references Person(PersonSSN)
);


create table CurrentDriver(
DLNumber int primary key,
InsurancePolicyNumber int not null,
DLExpDate date not null,
PersonSSN int unique,
foreign key (PersonSSN) references Person(PersonSSN)
);


create table VehicleRegRequestor(
VehicleNumber int primary key,
PersonSSN int unique,
foreign key (PersonSSN) references Person(PersonSSN)
);


create table GovAgencies(
CAGECode int primary key,
EAName varchar(50) unique,
foreign key (EAName) references ExternalAgency(EAName) 
);


create table LawAgencies(
EAName varchar(50) primary key,
foreign key (EAName) references ExternalAgency(EAName) 
);


create table VehicleManu(
VehicleManuCode int primary key,
EAName varchar(50) unique,
foreign key (EAName) references ExternalAgency(EAName) 
);



create table AdminEmp(
EmpSSN int primary key,
foreign key (EmpSSN) references Employee(EmpSSN)
);


create table ApplicationEmp(
EmpSSN int primary key,
foreign key (EmpSSN) references Employee(EmpSSN)
);


create table ComplianceAgent(
EmpSSN int primary key,
foreign key (EmpSSN) references Employee(EmpSSN)
);


create table Auditor(
EmpSSN int primary key,
foreign key (EmpSSN) references Employee(EmpSSN)
);


create table Inspector(
EmpSSN int primary key,
foreign key (EmpSSN) references Employee(EmpSSN)
);


create table DataEntryEmp(
EmpSSN int primary key,
foreign key (EmpSSN) references Employee(EmpSSN)
);



create table RegistrationAdminPage( 
    RegUsername varchar(50) primary key, RegPassword varchar(100) not null, RegRole ENUM('Person', 'DrivingSchool', 'Admin', 'ApplicationEmp', 'Auditor', 'ComplianceAgent', 'DataEntryEmp', 'Inspector', 'GovAgencies', 'LawAgencies', 'VehicleManu') not null);

