
Code to refactor
=================
1) app/Http/Controllers/BookingController.php
2) app/Repository/BookingRepository.php

Code to write tests (optional)
=====================
3) App/Helpers/TeHelper.php method willExpireAt
4) App/Repository/UserRepository.php, method createOrUpdate


----------------------------Sarmad's Notes on Refactoring-----------
Over all the coe is ok few things that can improve the performance and readability are listed below, Most of them are for Repository as controller looked ok apart form few tweeks.

1) Use of Eloquent Relationships and there helper methods ( I not knew ho the models are setup so i havent change things in terms of queries but the use of Eloquent relational function could he reduced the code and increased the performance)
    example function for this are getAll(), bookingExpireNoAccepted().

2) Methods are too long they should be divided into sub functions I did that with store() method extracted two fucntions (populateJobData(),  validateCustomerData (), bookingExpireNoAccepted()).

3) After extracting the functions from large methods they should moved to a helper class or a service to keep our repository class clean and precised in our case ( populateJobData(),  validateCustomerData (), getArr(), extracted(), getStr())

4) Missing return type declarations for the functions.

5) conditions are not using strict comparison ( ===, !==)

6) early return statements should be used to avoid unnecessary checks and DB calls I did that in getUsersJobs() function.

7) Fetchng data from env file directly is not a good practice, we should use config files.

8) there are a lot of code duplication should be checked and extracted to a function. I have added Todo commonets on duplicate codes.

9) getAll() can be changed similar to bookingExpireNoAccepted().


----------------------------Sarmad's Notes on test cases -----------

1) AppTests class contains:
    1.1) testWillExpireAt(): a unit test for willExpireAt Methods I have tried to explain everything via comments.
    1.2) testCreateOrUpdateUser():  a unit test inserting a record to user table and the validating if the record exists or not.