-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.1              
-- * Generator date: Dec  4 2018              
-- * Generation date: Sun Jan 30 17:40:17 2022 
-- * LUN file: \\Mac\Home\Tecnologie Web\silmarillion\db\schemas\silmarillion.lun 
-- * Schema: silmarillion-Logic/1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database silmarillion;
use silmarillion;


-- Tables Section
-- _____________ 

create table Alerts (
     UserId int not null,
     ProductId int not null,
     constraint IDAlert primary key (ProductId, UserId));

create table Carts (
     ProductId int not null,
     UserId int not null,
     Quantity int not null,
     constraint IDCart primary key (ProductId, UserId));

create table Categories (
     Name varchar(50) not null,
     Description varchar(200) not null,
     constraint IDCategory primary key (Name));

create table Comics (
     Title varchar(50) not null,
     Author varchar(50) not null,
     Lang varchar(20) not null,
     PublishDate date not null,
     ISBN char(13) not null,
     ProductId int not null,
     PublisherId int not null,
     constraint IDComicBook primary key (ISBN),
     constraint IDComic unique (Title),
     constraint FKR_1_ID unique (ProductId));

create table Customers (
     UserId int not null,
     constraint FKR_1_ID primary key (UserId));

create table Favourites (
     UserId int not null,
     ProductId int not null,
     constraint IDFavourite primary key (ProductId, UserId));

create table Funkos (
     FunkoId int not null auto_increment,
     ProductId int not null,
     Name varchar(200) not null,
     constraint IDFunko primary key (FunkoId),
     constraint FKR_ID unique (ProductId));

create table LoginAttempts (
     UserId int not null,
     TimeLog varchar(30) not null,
     constraint IDLoginAttempts primary key (UserId, TimeLog));

create table LogOrderStatus (
     OrderStatus varchar(50) not null,
     OrderId int not null,
     StatusDate timestamp not null,
     constraint IDRelated primary key (OrderStatus, OrderId));

create table Messages (
     MessageId bigint not null auto_increment,
     MsgDate timestamp not null,
     Title varchar(30) not null,
     Description varchar(1000) not null,
     SenderUserId int not null,
     RecvUserId int not null,
     constraint IDMessage primary key (MessageId));

create table MethodHolders (
     MethodId int not null,
     UserId int not null,
     constraint IDHold primary key (MethodId, UserId));

create table News (
     NewsId int not null auto_increment,
     Title varchar(100) not null,
     Description varchar(500),
     Img varchar(100) not null,
     UserId int not null,
     constraint IDNews primary key (NewsId));

create table OrderDetails (
     CopyId int not null,
     OrderId int not null,
     constraint FKOrd_Pro_ID primary key (CopyId));

create table Orders (
     OrderId int not null auto_increment,
     Address varchar(150) not null,
     OrderDate timestamp not null,
     Price int not null,
     UserId int not null,
     constraint IDOrder primary key (OrderId));

create table OrderStatus (
     Name varchar(50) not null,
     constraint IDOrderStatus primary key (Name));

create table PaymentMethods (
     MethodId int not null auto_increment,
     Owner varchar(100),
     Number char(16),
     CVV char(3),
     ExpiringDate date,
     Mail varchar(200),
     constraint IDPaymentMethod primary key (MethodId),
     constraint IDPaymentMethod unique(Mail));

create table Payments (
     PayId int not null auto_increment,
     OrderId int not null,
     PayDate timestamp not null,
     MethodId int,
     constraint IDPaymentMethod primary key (PayId),
     constraint FKPaid_ID unique (OrderId));

create table ProductCopies (
     CopyId int not null auto_increment,
     ProductId int not null,
     constraint IDComicCopy primary key (CopyId));

create table Products (
     ProductId int not null auto_increment,
     Price int not null,
     DiscountedPrice int,
     Description varchar(1000) not null,
     CoverImg varchar(100) not null,
     CategoryName varchar(50) not null,
     constraint IDProduct primary key (ProductId));

create table Publisher (
     PublisherId int not null auto_increment,
     Name varchar(50) not null,
     ImgLogo varchar(100) not null,
     constraint IDPublisher primary key (PublisherId),
     constraint IDPublisher_1 unique (Name));

create table Reviews (
     ReviewId int not null auto_increment,
     Vote int not null,
     Description varchar(250),
     UserId int not null,
     constraint IDReview primary key (ReviewId));

create table Sellers (
     UserId int not null,
     constraint FKR_ID primary key (UserId));

create table Users (
     UserId int not null auto_increment,
     Username varchar(50) not null,
     Password char(128) not null,
     Salt char(128) not null,
     Name varchar(150) not null,
     Surname varchar(150) not null,
     DateBirth date not null,
     Mail varchar(100) not null,
     IsActive boolean not null,
     constraint IDUsers primary key (UserId),
     constraint IDUsers_1 unique (Username),
     constraint IDUsers_2 unique(Mail));


-- Constraints Section
-- ___________________ 

alter table Alerts add constraint FKAle_Pro
     foreign key (ProductId)
     references Products (ProductId);

alter table Alerts add constraint FKAle_Cus
     foreign key (UserId)
     references Customers (UserId);

alter table Carts add constraint FKCar_Cus
     foreign key (UserId)
     references Customers (UserId);

alter table Carts add constraint FKCar_Pro
     foreign key (ProductId)
     references Products (ProductId);

alter table Comics add constraint FKR_1_FK_0
     foreign key (ProductId)
     references Products (ProductId);

alter table Comics add constraint FKOf
     foreign key (PublisherId)
     references Publisher (PublisherId);

alter table Customers add constraint FKR_1_FK_1
     foreign key (UserId)
     references Users (UserId);

alter table Favourites add constraint FKFav_Pro
     foreign key (ProductId)
     references Products (ProductId);

alter table Favourites add constraint FKFav_Cus
     foreign key (UserId)
     references Customers (UserId);

alter table Funkos add constraint FKR_FK_0
     foreign key (ProductId)
     references Products (ProductId);

alter table LoginAttempts add constraint FKTryAccessCustomer
     foreign key (UserId)
     references Users (UserId);

alter table LogOrderStatus add constraint FKRel_Ord
     foreign key (OrderId)
     references Orders (OrderId);

alter table LogOrderStatus add constraint FKRel_Ord_1
     foreign key (OrderStatus)
     references OrderStatus (Name);

alter table Messages add constraint FKSend
     foreign key (SenderUserId)
     references Users (UserId);

alter table Messages add constraint FKReceive
     foreign key (RecvUserId)
     references Users (UserId);

alter table MethodHolders add constraint FKHol_Cus
     foreign key (UserId)
     references Customers (UserId);

alter table MethodHolders add constraint FKHol_Pay
     foreign key (MethodId)
     references PaymentMethods (MethodId);

alter table News add constraint FKCreate
     foreign key (UserId)
     references Sellers (UserId);

alter table OrderDetails add constraint FKOrd_Pro_FK
     foreign key (CopyId)
     references ProductCopies (CopyId);

alter table OrderDetails add constraint FKOrd_Ord
     foreign key (OrderId)
     references Orders (OrderId);

alter table Orders add constraint FKMake
     foreign key (UserId)
     references Customers (UserId);

alter table PaymentMethods add constraint GRPaymentMethod
     check((Owner is not null and Number is not null and CVV is not null and ExpiringDate is not null)
           or (Owner is null and Number is null and CVV is null and ExpiringDate is null)); 

alter table Payments add constraint FKPaid_FK
     foreign key (OrderId)
     references Orders (OrderId);

alter table Payments add constraint FKPaymentDetails
     foreign key (MethodId)
     references PaymentMethods (MethodId);

alter table ProductCopies add constraint FKIsCopyOf
     foreign key (ProductId)
     references Products (ProductId);

alter table Products add constraint FKHas
     foreign key (CategoryName)
     references Categories (Name);

alter table Reviews add constraint FKComplete
     foreign key (UserId)
     references Customers (UserId);

alter table Sellers add constraint FKR_FK_1
     foreign key (UserId)
     references Users (UserId);


-- Index Section
-- _____________ 

