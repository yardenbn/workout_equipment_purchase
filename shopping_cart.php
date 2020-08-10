<?php
    require_once 'functions_library.php';
    
    $empty_cart = $full_cart = "hidden";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST) && isset($_SESSION))
        {
            $_SESSION['cart'] =[];           
            foreach ($_POST as $key => $value) {
                if($value > 0)
                {
                    //extracts the item id from the key
                    $x = explode("_", $key);
                    $item_code = $x[2];
                    
                    $_SESSION['cart'][$item_code] = $value;
                }
            }
            
            // checking if items were selected and the cart is empty or not
            if(empty($_SESSION['cart']))
            {
                $empty_cart = "";
            }
            else
            {
                $full_cart = "";
            }
            
        }       
    }
    else // method = GET
    {
        if(isset($_SESSION['cart']))
            {
                if(isset($_GET['remove']) && is_numeric($_GET['remove']))
                {
                    unset($_SESSION['cart'][$_GET['remove']]);                   
                }
                elseif (isset($_GET['action']) && $_GET['action']=='update') 
                {
                    $code = $_GET['code'];
                    $_SESSION['cart'][$_GET['code']] = $_GET['quantity'];
                }
                
                //checking if the updated data sent in this page contains any items that have 0 in their updated quantity
                foreach ($_SESSION['cart'] as $itemCode => $quantity) 
                {
                    if($quantity == 0)
                    {
                        unset($_SESSION['cart'][$itemCode]);
                    }
                }
                
                if(empty($_SESSION['cart']))
                {
                    $empty_cart = ""; 
                }
                else
                {
                    $full_cart = "";
                }
            }
        else
            {
                $empty_cart = "";
            }
        
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Work It - סל קניות</title>        
        <link rel="stylesheet" type="text/css" href="style/cartStyle.css">
    </head>
    <body>
        
        <?php require_once 'menu.php'; ?>
        
        <section class="general_wrap">
            <div id="empety_cart" <?= $empty_cart?> >
                <h2>סל הקניות שלך ריק</h2>
                <a href="index.php#equipment_point">לחץ כאן כדי למלא אותו</a>
                <img src="images/emptyCart.gif">               
            </div>
            
            <div id="full_cart" <?= $full_cart?>>
              
              <h2>סל קניות</h2>             
              <table border="0">

                    <thead>
                        <td></td> <td>פריט</td> <td>מחיר</td> <td>כמות</td> <td>סכום ביניים</td> <td></td>
                    </thead>

                    <tbody>
                    
                        <?php
                            foreach ($_SESSION['cart'] as $item_code => $quantity) 
                            {
                                $item_details = get_item_by_code($item_code);
                                if($item_details > 0)
                                {
                                    echo "<tr>"
                                            ."<td> <img id='itemIMG' src='images/{$item_details['item_image']}'>"
                                            ."<td>{$item_details['item_name']}</td> "
                                            ."<td>{$item_details['price']} &#8362;</td>"
                                            ."<td>"
                                                    ."<form method='get' action=''>"
                                                    ."<input type='hidden' name='code' value='{$item_code}' />"
                                                    ."<input type='hidden' name='action' value='update' />"
                                                    ."<input type='number' min='0' max='{$item_details['stock_amount']}' step='1' name='quantity' value='{$quantity}' size='3' onChange='this.form.submit()'/>"
                                                    ."</form>"
                                            . "</td>";
                                            $sumed_up_payment = number_format($quantity * $item_details['price'],2);
                                    echo    "<td> $sumed_up_payment &#8362;</td>"
                                            ."<td><a href='shopping_cart.php?remove={$item_code}' id='btnRemove' title='הסר פריט'>&#10007;</a></td>"
                                        ."</tr>";
                                }
                                

                            }
                        ?>
                    </tbody>
              </table>
              <div id="back_to_shop"><a href="index.php#equipment_point">&laquo; חזרה להמשך קניות</a></div>
              <div id="total_pay_details">
                  
                  <h3>סיכום הזמנה</h3>
                  <hr class="sep-2">
                  <div>
                      <span class="description">סך הכל לא כולל משלוח</span>
                      <?php $totPayment = (isset($_SESSION)&& isset($_SESSION['cart'])) ? cartTotalPay($_SESSION['cart']):0; ?>
                      <span class="price_outcome"><?= $totPayment ?> &#8362;</span>
                  </div>
                  <div>
                      <span class="description">משלוח</span>
                      <span class="price_outcome">20 &#8362;</span>
                  </div>
                  <hr class="sep-2">
                  <div>
                      <span class="description"><b>סך הכל לתשלום</b></span>
                      <span class="price_outcome"><b><?= number_format($totPayment+20,2); ?> &#8362;</b></span>
                  </div>
                  <form action="payment.php" method="get"> 
                      <input type="submit" id="btnPayment" value="מעבר לתשלום &raquo;" >
                  </form>
                  
              </div>
              
            </div>
            
        </section>
        
    </body>
</html>
