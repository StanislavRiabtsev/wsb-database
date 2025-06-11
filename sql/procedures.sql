create or replace function add_order_with_items(
    customer_id int,
    items json
)
returns void as $$
declare
    order_id int;
    total decimal(10,2) := 0;
    item json;
    pid int;
    qty int;
    product_price decimal(10,2);
begin
    insert into orders(customerid, totalamount)
    values (customer_id, 0)
    returning orderid into order_id;

    for item in select * from json_array_elements(items)
    loop
        pid := (item->>'productid')::int;
        qty := (item->>'quantity')::int;

        select price into product_price from product where productid = pid;

        if product_price is null then
            raise exception 'Product % does not exist', pid;
        end if;

        insert into orderitem(orderid, productid, quantity, unitprice)
        values (order_id, pid, qty, product_price);

        update product
        set stockquantity = stockquantity - qty
        where productid = pid;

        total := total + (product_price * qty);
    end loop;

    update orders
    set totalamount = total
    where orderid = order_id;
end;
$$ language plpgsql;
