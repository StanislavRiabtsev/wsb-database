CREATE OR REPLACE FUNCTION add_order_with_items(
    customer_id INT,
    items JSON
)
RETURNS VOID AS $$
DECLARE
    order_id INT;
    total DECIMAL(10,2) := 0;
    item JSON;
    pid INT;
    qty INT;
    product_price DECIMAL(10,2);
BEGIN
    INSERT INTO "Order"(CustomerID, TotalAmount)
    VALUES (customer_id, 0)
    RETURNING OrderID INTO order_id;

    FOR item IN SELECT * FROM json_array_elements(items)
    LOOP
        pid := (item->>'ProductID')::INT;
        qty := (item->>'Quantity')::INT;
        SELECT Product.Price INTO product_price FROM Product WHERE ProductID = pid;

        IF product_price IS NULL THEN
            RAISE EXCEPTION 'Produkt % nie istnieje', pid;
        END IF;

        INSERT INTO OrderItem(OrderID, ProductID, Quantity, UnitPrice)
        VALUES (order_id, pid, qty, product_price);

        UPDATE Product
        SET StockQuantity = StockQuantity - qty
        WHERE ProductID = pid;

        total := total + (product_price * qty);
    END LOOP;

    UPDATE "Order" SET TotalAmount = total WHERE OrderID = order_id;
END;
$$ LANGUAGE plpgsql;
