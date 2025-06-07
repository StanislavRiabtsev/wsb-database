CREATE TABLE Customer (
    CustomerID SERIAL PRIMARY KEY,
    FirstName VARCHAR(100),
    LastName VARCHAR(100),
    Email VARCHAR(150) UNIQUE,
    Phone VARCHAR(20),
    Address TEXT
);

CREATE TABLE Category (
    CategoryID SERIAL PRIMARY KEY,
    CategoryName VARCHAR(100)
);

CREATE TABLE Supplier (
    SupplierID SERIAL PRIMARY KEY,
    SupplierName VARCHAR(150),
    ContactName VARCHAR(100),
    Phone VARCHAR(20)
);

CREATE TABLE Product (
    ProductID SERIAL PRIMARY KEY,
    Name VARCHAR(150),
    Description TEXT,
    Price DECIMAL(10, 2),
    StockQuantity INT,
    CategoryID INT REFERENCES Category(CategoryID),
    SupplierID INT REFERENCES Supplier(SupplierID)
);

CREATE TABLE "Order" (
    OrderID SERIAL PRIMARY KEY,
    OrderDate DATE NOT NULL DEFAULT CURRENT_DATE,
    CustomerID INT REFERENCES Customer(CustomerID),
    TotalAmount DECIMAL(10, 2)
);

CREATE TABLE OrderItem (
    OrderItemID SERIAL PRIMARY KEY,
    OrderID INT REFERENCES "Order"(OrderID) ON DELETE CASCADE,
    ProductID INT REFERENCES Product(ProductID),
    Quantity INT,
    UnitPrice DECIMAL(10, 2)
);


INSERT INTO Customer (FirstName, LastName, Email, Phone, Address)
VALUES ('Test', 'User', 'test@example.com', '123456789', 'Test Street');

INSERT INTO Category (CategoryName) VALUES ('Default');
INSERT INTO Supplier (SupplierName, ContactName, Phone) VALUES ('Default', 'Supplier Contact', '111-222-333');

INSERT INTO Product (Name, Description, Price, StockQuantity, CategoryID, SupplierID)
VALUES
('Product A', 'Desc A', 10.00, 100, 1, 1),
('Product B', 'Desc B', 20.00, 50, 1, 1);