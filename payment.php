<?php
    require_once 'functions_library.php';
    
    $cust_before_check = "";
    $cust_after_check = "hidden";
    $payment_success = "hidden";
    $empty_cart = "hidden";
    $full_cart = "";
    $payment_details = "";
    $btnTXT = "בדיקה";
    $btnAction = "check";
    $errID = "";
    $errorMSG = [];
    $userId = "";
    $fName = $lName = $email = $phone = $city = $street = $houseNum = $cardNum = $cvv = "";
    $expYear = $expMonth = "";
    $fnErr = $lnErr = $ctErr = $strErr = ""; 
    $phnErr = "";
    $crdnumErr  = $cvvErr = "";
    $errorShown = "hidden";
    $greetingMSG = "";
    $updatedDetailsMSG = "";   
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if($_POST['action'] == "check")
        {
            
            $userId = trim(filter_input(INPUT_POST,"user_id",FILTER_SANITIZE_SPECIAL_CHARS));
            if(empty($userId))
            {
                $errID = "<div class='errorMSG'>אנא הזן תעודת זהות</div>";
            }
            elseif(!preg_match("/[0-9]{9}/",$userId))
            {
                $errID = "<div class='errorMSG'>יש להזין תעודת זהות כולל ספרת ביקורת</div>";
            }
            else
            {
                $cust_before_check = "hidden";
                $cust_after_check = "";
                if(user_id_exist($userId) > 0)
                {
                    $customerDetails = get_user_details ($userId);
                    if($customerDetails != FALSE)
                    {
                        $greetingMSG = "<div id='greeting'><i>היי {$customerDetails ['first_name']}, שמחים לראות שחזרת אלינו!</i></div>";
                        
                        $fName =  $customerDetails ['first_name'];     
                        $lName = $customerDetails ['last_name'];
                        $email = $customerDetails ['email'];
                        $phone = $customerDetails ['phone'];
                        $city = $customerDetails ['city'];
                        $street = $customerDetails ['street'];
                        $houseNum = $customerDetails ['house_num'];
                    }   
                }
                else
                {                   
                    $greetingMSG = "<div id='greeting'><i>ברוך הבא! אנא הזן את הפרטים להלן לצורך ביצוע הרכישה</i></div>";
                }
                $_SESSION['userID'] = $userId;
                $btnTXT = "סיים רכישה";
                $btnAction = "submit";
            }
            
        }
        elseif($_POST['action'] == "submit")
        {
            $cust_before_check = "hidden";
            $cust_after_check = "";
            $btnTXT = "סיים רכישה";
            $btnAction = "submit";
            
            $fName = trim(filter_input(INPUT_POST,"first_name",FILTER_SANITIZE_SPECIAL_CHARS));       
            $lName = trim(filter_input(INPUT_POST,"last_name",FILTER_SANITIZE_SPECIAL_CHARS));
            $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS));
            $phone = trim(filter_input(INPUT_POST,"phone",FILTER_SANITIZE_SPECIAL_CHARS));
            $city = trim(filter_input(INPUT_POST,"city",FILTER_SANITIZE_SPECIAL_CHARS));
            $street = trim(filter_input(INPUT_POST,"street",FILTER_SANITIZE_SPECIAL_CHARS));
            $houseNum = trim(filter_input(INPUT_POST,"house_num",FILTER_SANITIZE_SPECIAL_CHARS));
            $cardNum = trim(filter_input(INPUT_POST,"card_num",FILTER_SANITIZE_SPECIAL_CHARS));
            $expYear = trim(filter_input(INPUT_POST,"exp_year",FILTER_SANITIZE_SPECIAL_CHARS));
            $expMonth = trim(filter_input(INPUT_POST,"exp_month",FILTER_SANITIZE_SPECIAL_CHARS));
            $cvv = trim(filter_input(INPUT_POST,"cvv",FILTER_SANITIZE_SPECIAL_CHARS));


            $errMSG = [];
            $onlyTXTpattern = '([0-9]|[!@#$%^&*(),.?:{}|<>])';
            $phnPattern = "/[0][5][0|2|3|4|5|9][0-9]{7}/";
            $cardNumPattern = '/^4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}$/';
            $cvvPattern = "/^[0-9]{3,4}$/";

            //checking and collecting for errors
            if(empty($fName) || empty($lName) || empty($email) || empty($phone) || empty($city) || empty($street) || empty($houseNum) || empty($cardNum) || empty($expYear) || empty($expMonth) || empty($cvv))
            {
                array_push($errorMSG, "יש למלא את כל הפרטים");
            }

            if(preg_match($onlyTXTpattern,$fName) || preg_match($onlyTXTpattern,$lName) || preg_match($onlyTXTpattern,$city) || preg_match($onlyTXTpattern,$street) )
            {
                array_push($errorMSG,"ערך לא תקין באחד או יותר מהשדות הבאים: שם פרטי, שם משפחה, עיר ו/או רחוב. אנא וודא כי מוזן תוכן טקסטואלי בלבד");
                $fnErr = preg_match($onlyTXTpattern,$fName) ? "style='color:red'":""; 
                $lnErr = preg_match($onlyTXTpattern,$lName) ? "style='color:red'":"";
                $ctErr = preg_match($onlyTXTpattern,$city) ? "style='color:red'":"";
                $strErr = preg_match($onlyTXTpattern,$street) ? "style='color:red'":"";
            }
            if(!preg_match($phnPattern, $phone))
            {
                array_push($errorMSG,"מספר הטלפון הנייד אינו תקין. אנא וודא כי הוא תואם לפורמט 05XXXXXXXX");
                $phnErr = "style='color:red'";
            }
            if(!preg_match($cardNumPattern, $cardNum))
            {
                array_push($errorMSG,"מכבדים כרטיסי אשראי של ויזה, מאסטרקארד ואמריקן אקספרס בלבד. אנא וודא כי המספר שהזנת תקין ותואם לפורמט הכרטיס.");
                $crdnumErr = "style='color:red'";
            }
            if(!preg_match($cvvPattern, $cvv))
            {
                array_push($errorMSG,"קוד אימות כרטיס חייב לכלול בין 3 ל-4 ספרות");
                $cvvErr = "style='color:red'";
            }

            //checking if the errors array is full or not: if full shows errors, else continues with the payment
            if(!empty($errorMSG))
            {
                $errorShown = "";    
            }
            else
            { 
                $custID = (int)$_SESSION['userID'];
                if(user_id_exist($_SESSION['userID'])>0)
                {
                    //----user exsist----/
                    $custDetails = get_user_details ($_SESSION['userID']);
                    // checking if the details changed
                    if($fName!=$custDetails['first_name'] || $lName != $custDetails ['last_name'] || $email != $custDetails ['email'] || $phone != "0".$custDetails ['phone']
                        || $city != $custDetails ['city'] || $street != $custDetails ['street'] || $houseNum != $custDetails ['house_num'] )
                    {
                        //----there is a change----// 
                        // updating the customer details in the DB
                        $updatedCustDetails = update_user_details ($custID, $fName,$lName,$email,$phone,$city,$street,$houseNum);

                        $actionResult = ($updatedCustDetails != FALSE) ? "success": "failure";
                        $updatedDetailsMSG = ($actionResult == "success") ? "<p>לא שכחנו גם לעדכן את הפרטים...</p>" : "<p>משהו השתבש עם עדכון הפרטים במערכת</p>";
                    }
                    else
                    {
                       $actionResult =  "success";
                    }
                    //getting the customer Auto Increment id that was generated - if there was a change in details or there isn't    
                    $customer_AI_Id = get_userAI_ID ($_SESSION['userID']);
                }
                else
                {
                    //----user dosen't exist----// 
                    //adding the customer details to the DB
                    $customer_AI_Id = add_new_customer ($custID,$fName,$lName,$email,$street,$houseNum,$city,$phone);                       
                    
                    $actionResult = ($customer_AI_Id != FALSE) ? "success": "failure";
                }
                

                //checking that adding/updating the customer to/in the DB went right 
                //& adding the order general details to the DB
                if($actionResult == "success")
                {
                    $totalPayment = (isset($_SESSION)&& isset($_SESSION['cart'])) ? cartTotalPay($_SESSION['cart']):0;
                    $orderDate = date('Y-m-d');
                    $new_orderId = add_new_order($customer_AI_Id,$totalPayment, $orderDate);

                    //checking that adding the order general details to the DB went right 
                    //& adding the detailed items to the DB 
                    if($new_orderId != FALSE)
                    {
                        if(isset($_SESSION) && isset($_SESSION['cart']))
                        {
                            foreach ($_SESSION['cart'] as $item_code => $quantity)
                            {
                                $succeess = add_new_order_items ($item_code,$quantity,$new_orderId);
                                //checking that adding the item to the order went right 
                                //& updating the stock amount of the item
                                if($succeess != FALSE)
                                {
                                    $itemUpdated = update_item_stock ($item_code,$quantity);
                                    if($itemUpdated != FALSE)
                                    {
                                        //showing the massege that the payment succeeded
                                        $payment_success = "";
                                        $payment_details = "hidden";
                                        session_unset();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    else // Method: GET
    {
        if(!isset($_SESSION['cart']) || empty($_SESSION['cart']))
        {
            $full_cart = "hidden";
            $empty_cart = "";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Work It - קופה</title>

        <link rel="stylesheet" type="text/css" href="style/paymentStyle.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        

    </head>
    <body>
        <?php require_once 'menu.php'; ?>
        <div class="general_wrap">
             <div id="empety_cart" <?= $empty_cart?> >
                <h2>סל הקניות שלך ריק</h2>
                <a href="index.php#equipment_point">לחץ כאן כדי למלא אותו</a>
                <img src="images/emptyCart.gif">
                
            </div>
            
            <div id="full_cart" <?=$full_cart?>>
                <h2>קופה</h2>
                <div id="back_to_cart"><a href="shopping_cart.php">&laquo; חזרה לעגלת הקניות</a></div>
                <form id="payment_shipment_details" method="post" action=""> 
                    
                <div <?=$payment_details?>>  
                    <div id="cust_before_check" <?=$cust_before_check?>>
                        <h4>רכישה ראשונה?</h4>
                        <label> הזן תעודת זהות:
                                <br>
                                <input id="user_id" name="user_id" type="text" maxlength="9" value="<?=$userId?>">
                        </label>
                        <?=$errID?>
                        <br><br>
                    </div>
                    <div id="cust_after_check" <?=$cust_after_check?>>
                        <div id="customer_details">
                            <?=$greetingMSG?>
                            <div class="errorMSG" <?=$errorShown?>>
                                <?php
                                    if(isset($errorMSG))
                                    {
                                        echo "<ul>";
                                        for($i=0;$i<count($errorMSG);$i++)
                                        {
                                            echo "<li>$errorMSG[$i]</li>";
                                        }
                                        echo "</ul>";
                                    }
                                ?>
                            </div>
                            <h4><i style='font-size:24px' class='far'>&#xf2bb;</i>  פרטי משלוח</h4>
                            <div id="personal_details">
                                <label> שם פרטי
                                    <br>
                                    <input id="first_name" name="first_name" type="text" min="2" maxlength="20" value="<?=$fName?>" <?=$fnErr?>>
                                </label>
                                <br><br>
                                <label> שם משפחה
                                    <br>
                                    <input id="last_name" name="last_name" type="text" min="2" maxlength="20"  value="<?=$lName?>" <?=$lnErr?>>
                                </label>
                                <br><br>
                                <label> כתובת דואר אלקטרוני
                                    <br>
                                    <input id="email" name="email" type="email" maxlength="30"  value="<?=$email?>">
                                </label>
                                <br><br>
                                <label> טלפון נייד
                                    <br>
                                    <input id="phone" name="phone" type="tel" maxlength="10"  value="<?=$phone?>" <?=$phnErr?>>
                                </label>
                                <br><br>
                            </div>
                            <div id="shipment_details"> 
                                <label> עיר
                                    <br>
                                    <input id="city" name="city" type="text" min="3"  maxlength="30"  value="<?=$city?>" <?=$ctErr?>>
                                </label>
                                <br><br>
                                <label> רחוב
                                    <br>
                                    <input id="street" name="street" type="text" min="2" maxlength="30"  value="<?=$street?>" <?=$strErr?>>
                                </label>
                                <br><br>
                                <label> מספר בית
                                    <br>
                                    <input id="house_num" name="house_num" type="number"  size="3" maxlength="3" min="1" value="<?=$houseNum?>">
                                </label>
                            </div>
                        </div>



                        <div id="payment_details">
                            <h4><i style="font-size:24px" class="fa">&#xf09d;</i>   פרטי תשלום</h4>
                            <div id="card_number">
                                <label> מספר כרטיס
                                    <br>
                                    <input id="card_num" name="card_num" type="tel"  maxlength="16" value="<?=$cardNum?>" <?=$crdnumErr?>>
                                    <br>
                                    <i class="fa fa-cc-visa" style="font-size:20px"></i>
                                    <i class="fa fa-cc-amex" style="font-size:20px"></i>
                                    <i class="fa fa-cc-mastercard" style="font-size:20px"></i>
                                </label>
                                <br><br>
                                <label> קוד אימות כרטיס (cvv)
                                    <br>
                                    <input id="cvv" name="cvv" type="text" size="4"  value="<?=$cvv?>" <?=$cvvErr?>>
                                </label>
                                <br><br>
                            </div>
                            <div id="card_details">
                               <label> תוקף
                                    <br>
                                    <select id="year" name="exp_year" >
                                        <option value="2021" <?= $expYear=="2021" ? "selected":"" ?> >2021</option>
                                        <option value="2022" <?= $expYear=="2022" ? "selected":"" ?> >2022</option>
                                        <option value="2023" <?= $expYear=="2023" ? "selected":"" ?> >2023</option>
                                        <option value="2024" <?= $expYear=="2024" ? "selected":"" ?> >2024</option>
                                        <option value="2025" <?= $expYear=="2025" ? "selected":"" ?> >2025</option>
                                        <option value="2026" <?= $expYear=="2026" ? "selected":"" ?> >2026</option>
                                    </select>
                                    <select id="month" name="exp_month" >
                                        <option value="01" <?= $expMonth=="01" ? "selected":"" ?> >ינואר</option>
                                        <option value="02" <?= $expMonth=="02" ? "selected":"" ?> >פברואר</option>
                                        <option value="03" <?= $expMonth=="03" ? "selected":"" ?> >מרץ</option>
                                        <option value="04" <?= $expMonth=="04" ? "selected":"" ?> >אפריל</option>
                                        <option value="05" <?= $expMonth=="05" ? "selected":"" ?> >מאי</option>
                                        <option value="06" <?= $expMonth=="06" ? "selected":"" ?> >יוני</option>
                                        <option value="07" <?= $expMonth=="07" ? "selected":"" ?> >יולי</option>
                                        <option value="08" <?= $expMonth=="08" ? "selected":"" ?> >אוגוסט</option>
                                        <option value="09" <?= $expMonth=="09" ? "selected":"" ?> >ספטמבר</option>
                                        <option value="10" <?= $expMonth=="10" ? "selected":"" ?> >אוקטובר</option>
                                        <option value="11" <?= $expMonth=="11" ? "selected":"" ?> >נובמבר</option>
                                        <option value="12" <?= $expMonth=="12" ? "selected":"" ?> >דצמבר</option>
                                    </select>

                                </label>
                                <br><br>
                            </div>

                        </div>    

                    </div>
                    <button type="submit" name="action" value="<?=$btnAction?>"> <?=$btnTXT?> </button>
                </div> 

                 <div id="payment_success"  <?=$payment_success?>> <!--will appeare when the payment will updated succesfully-->
                     <img src="images/success.gif">
                    <h4> התשלום בוצע בהצלחה !</h4>  
                    <?=$updatedDetailsMSG?>
                    <a href="index.php#equipment_point" id="contine_shop"><i style='font-size:15px' class='fas'>&#xf217;</i> אני רוצה להמשיך לקנות</a>
                 </div>
                </form>
                
                <?php
                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart']))
                    {
                        echo "<div id='order_sum'>
                                <table border='0' id='items'>
                                    <thead>
                                        <td></td> <td>פריט</td> <td>מחיר</td> <td>כמות</td> <td>סכום ביניים</td> 
                                    </thead>  
                                    <tbody>";
                                        foreach ($_SESSION['cart'] as $item_code => $quantity) 
                                                {
                                                    $item_details = get_item_by_code($item_code);
                                                    if($item_details > 0)
                                                    {
                                                        echo "<tr>"
                                                                ."<td> <img id='equipIMG' src='images/{$item_details['item_image']}'>"
                                                                ."<td>{$item_details['item_name']}</td> "
                                                                ."<td>{$item_details['price']} &#8362;</td>"
                                                                ."<td>$quantity</td>";
                                                                $sumed_up_payment = number_format($quantity * $item_details['price'],2);
                                                        echo    "<td> $sumed_up_payment &#8362;</td>"
                                                            ."</tr>";


                                                    }
                                                }
                                                $totalPay = (isset($_SESSION)&& isset($_SESSION['cart'])) ? cartTotalPay($_SESSION['cart']):0;                           
                                                $pay_with_delivery = number_format($totalPay+20,2);
                                                echo "<tr class='sum_lines'> <td colspan='4'><strong>סך ביניים</strong></td> <td><strong>$totalPay &#8362;</strong></td> </tr>"
                                                     ."<tr class='sum_lines'> <td colspan='4'>משלוח</td> <td>20 &#8362;</td> </tr>"
                                                     ."<tr class='sum_lines' id='final_payment'> <td colspan='4'><strong>סך הכל</strong></td> <td><strong>$pay_with_delivery &#8362;</strong></td> </tr>";
                        echo        "</tbody>
                                </table>
                             </div>";                    
                    }
                ?>
                 
            </div>
        </div>
               
    </body>
</html>
