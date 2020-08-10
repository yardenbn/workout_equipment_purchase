<?php

require_once 'DB_connection.php';

// ---------------------------------- //
// --------- db functions ----------- //
// ---------------------------------- //
function get_all_equipment()
{
    try 
    {
        global $db;
        $cmd="SELECT * "
           . "FROM equipment";
        $qry=$db->prepare($cmd);
        $qry->execute();
        $result=$qry->fetchAll(PDO::FETCH_ASSOC); 
        return $result; 
    } 
    catch (PDOException $ex)
    {
        echo "db select items problem! ".$ex->GetMessage();
        exit;
    }
    
}

function get_item_by_code ($item_code)
{
   try 
    {
        global $db;
        $cmd="SELECT * "
           . "FROM equipment "
           . "WHERE item_code=:item_code";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':item_code',$item_code);
        $qry->execute();
        $result=$qry->fetch(PDO::FETCH_ASSOC); 
        return $result; 
    } 
    catch (PDOException $ex)
    {
        echo "db select item problem! ".$ex->GetMessage();
        exit;
    } 
}

function user_id_exist ($userId)
{
   try 
    {
        global $db;
        $cmd="SELECT count(*) "
           . "FROM customers "
           . "WHERE cust_personalID=:userId";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':userId',$userId);
        $qry->execute();
        $result=$qry->fetch(PDO::FETCH_ASSOC); 
        return $result['count(*)']; 
    } 
    catch (PDOException $ex)
    {
        echo "db count user id problem! ".$ex->GetMessage();
        exit;
    } 
}

function get_user_details ($userID)
{
   try 
    {
        global $db;
        $cmd="SELECT * "
           . "FROM customers "
           . "WHERE cust_personalID=:userID";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':userID',$userID);
        $qry->execute();
        $result=$qry->fetch(PDO::FETCH_ASSOC); 
        return $result; 
    } 
    catch (PDOException $ex)
    {
        echo "db select customer problem! ".$ex->GetMessage();
        exit;
    } 
}

function update_user_details ($userId, $fname,$lname,$email,$phone,$city,$street,$houseNum)
{
   try 
    {
        global $db;
        $cmd="UPDATE customers "
           . "SET first_name=:fname, last_name=:lname, email=:email, street=:street, house_num=:houseNum, city=:city, phone=:phone "
           . "WHERE cust_personalID = :userId";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':userId',$userId);
        $qry->bindValue(':fname',$fname);
        $qry->bindValue(':lname',$lname);
        $qry->bindValue(':email',$email);
        $qry->bindValue(':phone',$phone);
        $qry->bindValue(':city',$city);
        $qry->bindValue(':street',$street);
        $qry->bindValue(':houseNum',$houseNum);
        $qry->execute();
        $itemUpdated=$qry->rowCount(); 
        return $itemUpdated; 
    } 
    catch (PDOException $ex)
    {
        echo "db updating user details problem! ".$ex->GetMessage();
        exit;
    } 
}

function get_userAI_ID ($userId)
{
   try 
    {
        global $db;
        $cmd="SELECT customer_id "
           . "FROM customers "
           . "WHERE cust_personalID=:userId";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':userId',$userId);
        $qry->execute();
        $result=$qry->fetch(PDO::FETCH_ASSOC); 
        return $result ['customer_id']; 
    } 
    catch (PDOException $ex)
    {
        echo "db select user AI id problem! ".$ex->GetMessage();
        exit;
    } 
}

function add_new_customer ($userId,$fName,$lName,$email,$street,$houseNum,$city,$phone)
{
   try 
    {
        global $db;
        $cmd="INSERT INTO customers (cust_personalID,first_name,last_name,email,street,house_num,city,phone) "
           . "VALUES (:userId,:fName,:lName,:email,:street,:houseNum,:city,:phone)";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':userId',$userId);
        $qry->bindValue(':fName',$fName);
        $qry->bindValue(':lName',$lName);
        $qry->bindValue(':email',$email);
        $qry->bindValue(':phone',$phone);
        $qry->bindValue(':city',$city);
        $qry->bindValue(':street',$street);
        $qry->bindValue(':houseNum',$houseNum);
        $qry->execute();
        $customerId=$db->lastInsertId(); 
        return $customerId; 
    } 
    catch (PDOException $ex)
    {
        echo "db adding customer problem! ".$ex->GetMessage();
        exit;
    } 
}

function get_max_orderId()
{
    try 
    {
        global $db;
        $cmd = "SELECT MAX(order_id) "
               ."FROM orders";
        $qry=$db->prepare($cmd);
        $result=$qry->fetch(PDO::FETCH_ASSOC);
        if($result == "")
        {
            return 0;
        }
        else
        {
           return $result; 
        }       
    } 
    catch (PDOException $ex) 
    {
        echo "db select order id problem! ".$ex->GetMessage();
        exit;
    }
}

function add_new_order ( $customerOrdered,$totalPay, $orderDate)
{
   try 
    {
        global $db;
        $cmd="INSERT INTO orders (ordered_by,total_pay,date_ordered) "
           . "VALUES (:customerOrdered,:totalPay,:orderDate)";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':customerOrdered',$customerOrdered);
        $qry->bindValue(':totalPay',$totalPay);
        $qry->bindValue(':orderDate',$orderDate);
        $qry->execute();
        $newOrderId=$db->lastInsertId(); 
        return $newOrderId; 
    } 
    catch (PDOException $ex)
    {
        echo "db adding order problem! ".$ex->GetMessage();
        exit;
    } 
}

function add_new_order_items ($item_ordered,$quantity,$order_num)
{
   try 
    {
        global $db;
        $cmd="INSERT INTO ordered_items (equip,amount,order_num) "
           . "VALUES (:item_ordered,:quantity,:order_num)";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':item_ordered',$item_ordered);
        $qry->bindValue(':quantity',$quantity);
        $qry->bindValue(':order_num',$order_num);
        $qry->execute();
        $new_item_orderedID=$db->lastInsertId(); 
        return $new_item_orderedID; 
    } 
    catch (PDOException $ex)
    {
        echo "db adding item to order problem! ".$ex->GetMessage();
        exit;
    } 
}

function update_item_stock ($item_code,$quantity_bought)
{
   try 
    {
        global $db;
        $cmd="UPDATE equipment "
           . "SET stock_amount = stock_amount - :quantity_bought "
           . "WHERE item_code = :item_code";
        $qry=$db->prepare($cmd);
        $qry->bindValue(':item_code',$item_code);
        $qry->bindValue(':quantity_bought',$quantity_bought);
        $qry->execute();
        $itemUpdated=$qry->rowCount(); 
        return $itemUpdated; 
    } 
    catch (PDOException $ex)
    {
        echo "db updating item stock problem! ".$ex->GetMessage();
        exit;
    } 
}

// ---------------------------------- //
// ------- general functions -------- //
// ---------------------------------- //

function cartTotalPay($cart)
{
    $totalPayment = 0;
    foreach ($cart as $item_code => $quantity) //מעבר על הסשן שנשלח שבנוי כך שהמפתח הוא הקוד של הפריט והערך הוא הכמות לקנייה
    {
        $item_details = get_item_by_code($item_code); //הוצאת נתונים על הפריט לפי קוד
        $sumed_up_payment_per_item = number_format($quantity * $item_details['price'],2); //הוצאת המחיר של הפריט מתוך הנתונים לעיל והכפלה שלו בכמות לקנייה
        $totalPayment += $sumed_up_payment_per_item; //הוספה של התוצאה על הפריט הנבדק לסך הכל הכללי של מחיר לתשלום
    }
    return number_format($totalPayment,2);
}