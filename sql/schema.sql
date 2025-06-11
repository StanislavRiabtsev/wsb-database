create table customer (
    customerid serial primary key,
    firstname varchar(100),
    lastname varchar(100),
    email varchar(150) unique,
    phone varchar(20),
    address text
);

create table category (
    categoryid serial primary key,
    categoryname varchar(100)
);

create table supplier (
    supplierid serial primary key,
    suppliername varchar(150),
    contactname varchar(100),
    phone varchar(20)
);

create table product (
    productid serial primary key,
    name varchar(150),
    description text,
    price decimal(10, 2),
    stockquantity int,
    categoryid int references category(categoryid),
    supplierid int references supplier(supplierid)
);

create table orders (
    orderid serial primary key,
    orderdate date not null default current_date,
    customerid int references customer(customerid),
    totalamount decimal(10, 2)
);

create table orderitem (
    orderitemid serial primary key,
    orderid int references orders(orderid) on delete cascade,
    productid int references product(productid),
    quantity int,
    unitprice decimal(10, 2)
);

insert into customer (firstname, lastname, email, phone, address)
values ('Test', 'User', 'test@example.com', '123456789', 'Test Street');

insert into category (categoryname) values ('Default');

insert into supplier (suppliername, contactname, phone)
values ('Default', 'Supplier Contact', '111-222-333');

insert into product (name, description, price, stockquantity, categoryid, supplierid)
values 
('Product A', 'Desc A', 10.00, 100, 1, 1),
('Product B', 'Desc B', 20.00, 50, 1, 1);
