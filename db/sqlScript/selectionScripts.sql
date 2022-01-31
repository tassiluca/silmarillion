/*Inserimento di un user, il primo attributo è una sequence automatica, l'ho omessa nella query*/
INSERT INTO `Users`(`Username`, `Password`, `Salt`, `Name`, `Surname`, `DateBirth`, `Mail`, `IsActive`) 
VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')

/*Inserimento di un seller*/
INSERT INTO `Sellers`(`UserId`) VALUES ('[value-1]')

/*Inserimento news, occorre l'inerimento/presenza di un seller*/
INSERT INTO `News`( `Title`, `Description`, `Img`, `UserId`) VALUES ('Marvel','Sconto sui fumetti della Marvel','marvel-text.jpeg','1')
INSERT INTO `News`( `Title`, `Description`, `Img`, `UserId`) VALUES ('Marvel_Wall','Wallpaper marvel','marv.png','1')


/*PRODUCTS AND COMICS*/
INSERT INTO `Publisher`( `Name`, `ImgLogo`) VALUES ('FeltrinelliComics','FeltrinelliComics.svg')
INSERT INTO `Publisher`( `Name`, `ImgLogo`) VALUES ('MarvelComics','MarvelComics.png')

/*category name DEVE essere in minuscolo, se si vuole mostrare in home una categoria occore specificarlo in index.php*/
INSERT INTO `Categories`(`Name`, `Description`) VALUES ('hero','Superhero that make world better and save people')

/*quando si inserisce un prodotto occorre inserire prima Products poi Comics indicando il codice prodotto*/
INSERT INTO `Products`(`Price`, `Description`, `CoverImg`, `CategoryName`) 
VALUES ('15','The Amazing Spider-Man è una serie a fumetti edita negli Stati uniti dalla Marvel ','spiderman001.jpeg','hero')

INSERT INTO `Comics`(`Title`, `Author`, `Lang`, `PublishDate`, `ISBN`, `ProductId`, `PublisherId`)
 VALUES ('Amazing-Spiderman','StanLee','Italiano','2020-01-31','9781302922887','2','2')


----------------------------------------------------------------------------------------
-- QUERY USATE PER TESTARE LE REVIEWS, IN SEQUENZA: Users -> Customers -> Reviews
-- Dump dei dati per la tabella `Users`
--
INSERT INTO `Users` (`UserId`, `Username`, `Password`, `Salt`, `Name`, `Surname`, `DateBirth`, `Mail`, `IsActive`) VALUES
(1, 'paolo90', 'pippo', '23r234fr8f348gu3hrg3', 'Teo]', 'viola', '2008-07-04', 'teoviola@gmail.com', 1),
(2, 'GuidoLaVespa00', 'passsFranco', 'fwegfwrg877wg', 'Franco', 'Rossi', '1998-07-20', 'franco@gmail.com', 1),
(3, 'GirolaMO89', 'pascc99?', 'nini8hr8fwef8', 'Giacomo', 'Girolami', '1956-04-12', 'girolamano@gmail.com', 1);

--
-- Dump dei dati per la tabella `Customers`
--
INSERT INTO `Customers` (`UserId`) VALUES
(2),
(3);

/*REVIEWS */
INSERT INTO `Reviews`( `Vote`, `Description`, `UserId`) VALUES 
('4','Ottimo sito per affidabilità e cordialità della assistenza, consiglio davvero ','2'),
('3','Ottimo sito per affidabilità e cordialità della assistenza, consiglio davvero ','2'),
('2','Ottimo sito per affidabilità e cordialità della assistenza, consiglio davvero ','2'),
('1','Ottimo sito per affidabilità e cordialità della assistenza, consiglio davvero ','2'),
('0','Ottimo sito per affidabilità e cordialità della assistenza, consiglio davvero ','2'),
('5','Ottimo sito per affidabilità e cordialità della assistenza, consiglio davvero ','3');
----------------------------------------------------------------------------------------
