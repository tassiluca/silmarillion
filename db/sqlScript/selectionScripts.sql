/*Inserimento di un user*/
INSERT INTO `Users`(`UserId`, `Username`, `Password`, `Salt`, `Name`, `Surname`, `DateBirth`, `Mail`, `IsActive`) 
VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')

/*Inserimento di un seller*/
INSERT INTO `Sellers`(`UserId`) VALUES ('[value-1]')

/*Inserimento news, occorre l'inerimento/presenza di un seller*/
INSERT INTO `News`( `Title`, `Description`, `Img`, `UserId`) VALUES ('Marvel','Sconto sui fumetti della Marvel','marvel-text.jpeg','1')