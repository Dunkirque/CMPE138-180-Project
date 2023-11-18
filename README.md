# CMPE138-180-Project
**Need to add some checking so that subclasses are properly distinct
**Or can just say that all subclasses can be multiple subclasses
**Resolution:
Just decide that the ER diagram showing LicenseRequestor,CurrentDriver,and VehicleRegRequestor is wrong and that it is not distinct and that anyone can be multiple at the same time.
However for Employee subclasses and External Agencies, an employee and external agency can only be one subclass 

**NEED to add error messsage when User tries to input an attribute that doesnt exist in a superclass. EX:
User creates Person with SSN 11 but goes to LicenseRequestor and inputs an SSN that isn't in the database like 1111 which creates a mysql error.

**Might need to add the ability to just see the subclass data lists without having to input a new input; currently u can see the overlapping information but not the subclass-specific info