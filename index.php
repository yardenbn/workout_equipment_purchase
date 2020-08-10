<?php
    require_once 'functions_library.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Work It - דף הבית</title>

        <link rel="stylesheet" type="text/css" href="style/indexStyle.css">
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    </head>
    <body>      

        <?php require_once 'menu.php'; ?>
        <div class="general_wrap">
       
<!-- motivation picture section: -->       
        <section id="pic_slide_wrapp">
            
                <img class="pic_slide" src="images/workoutwallpaper1.jpg"  alt="woman Boxing poster">
                <img class="pic_slide" src="images/manRoppes.jpg"  alt="man rope training poster">
                <img class="pic_slide" src="images/womanWeightLifting.jpg"  alt="woman weightlifting poster">
                <img class="pic_slide" src="images/manArms.jpg"  alt="man arms workout poster">
                
                <div id="motivation_quote"> <i class='fas'>&#xf44b;</i> <span>WORKOUT</span> <i class='fas'>&#xf44b;</i> <span>SWEAT</span> <i class='fas'>&#xf44b;</i> <span>WIPE</span> <i class='fas'>&#xf44b;</i> <span id="last_span">REPEAT</span> <i class='fas'>&#xf44b;</i></div>
    <span id="workout_point"></span>                   
        </section>
<!-- workouts to do section: -->
<hr>
        <section id="workouts">
            <h2>אימונים ביתיים</h2>
            <span id="equipment_point"></span>
                <div class="workoutTypes">
                  <iframe src="https://www.youtube.com/embed/1skBf6h2ksI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>   
                  <div class="container">
                      <h3>אימון HIIT</h3>
                      <span class="workout_description">
                          אימון המאופיין באינטנסיביות שלו בשילוב הפוגה קצרה של מנוחה בין תרגיל אחד לשני. 
                         הסיבה להצלחתו של אימון זה היא תרומתו לשריפת שומנים ולחיזוק השרירים בזמן קצר ביחס לאימון אירובי קלאסי בחדר הכושר. מלבד שריפת קלוריות במהלך האימון עצמו, מתרחשת שריפת שומן גבוהה גם במהלך מספר שעות לאחר האימון כתוצאה מתהליך התאוששות שהגוף נדרש לו כתוצאה מהאימון.
                      </span>
                  </div>
                </div>

                <div class="workoutTypes">
                  <iframe  src="https://www.youtube.com/embed/T6IepoaCnSw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>            
                  <div class="container">
                      <h3>אימון יוגה</h3>
                      <span class="workout_description">   
אימון המתרכז בחיבור בין הגוף והנפש. היוגה עובדת בעיקר על גמישות וכוח סיבולת, מחזקת את האיזון, היציבה וקלות התנועה. באימון זה העבודה מתפזרת על כל שרירי הגוף, דבר המונע פגיעה פוטנציאלית בקבוצת שרירים ספציפית בשל אימון יתר. אימון היוגה נחלק לסוגים שונים המתאימים גם לאלו המחפשים להתחטב ולשרוף קלוריות (על ידי הגברת קצב חילוף החומרים) וגם לאלו המחפשים את האיזון הנפשי.                       </span>
                  </div>
                </div>

                <div class="workoutTypes">
                  <iframe  src="https://www.youtube.com/embed/sYRss_6gSFU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  <div class="container">
                      <h3>אימון TRX</h3>
                      <span class="workout_description">אימון רצועות המבוסס על משקל גופו של המתאמן. הרצועה מאפשרת עבודה ממוקדת על כל שריר וכן גם שליטה על העומס המופעל עליו אשר תלויה במשקל הגוף, סוג התרגיל, מספר הסטים וכן הלאה. אימון ה-TRX מורכב ממגוון תרגילים אפקטיביים המפתחים בין היתר סיבולת של השרירים, גמישות, איזון, כוח מירבי, סיבולת לב ריאה, יציבות, קורדינציה ושרירי ליבה.      
                      </span>
                  </div>
                </div>
            
        </section>
<hr>
<!-- equipment to buy section: -->        
        <section id="equipment">
            <h2>ציוד מקצועי</h2>
            <form method="post" action="shopping_cart.php">
                <?php
                    $all_items = get_all_equipment();
                    
                    foreach ($all_items as $item)
                    {   
                        if ($item['stock_amount'] == 0) // checking the state of the item stock
                            {
                                $disabled = "disabled";
                                $stock_massage = "<span> - <span>אזל המלאי</span> </span>";
                            }
                        else
                            {
                                $disabled = "";
                                $stock_massage = "";
                            }
                            
                        echo "<div class='item'>";

                        echo    "<div id='item_description'>"
                                    ."<img id='item_img' src='images/{$item['item_image']}' alt='{$item['item_name']}' />"
                                    ."<div id='item_title'>"
                                        ."<p> {$item['item_name']} $stock_massage </p>"
                                    ."</div>"
                                ."</div>";

                        echo    "<div id='item_details'>"
                                    ."<div id='price'>"
                                        ."<span> {$item['price']} &#8362;</span>"
                                    ."</div>"
                                    ."<div id='quantity'> "                 
                                        ."<input type='number' name='choosen_quantity_{$item['item_code']}' min='0' max='{$item['stock_amount']}' step='1' ";
                                        //check if its the first time the user chooses item or he already filled in the cart
                                        if(isset($_SESSION)&& isset($_SESSION['cart']))
                                        {
                                            if(array_key_exists($item['item_code'],$_SESSION['cart']))
                                            {
                                                echo "value='{$_SESSION['cart'][$item['item_code']]}'";
                                            }
                                            else
                                            {
                                                echo "value='0'";
                                            }
                                        }
                                        else
                                        {
                                            echo "value='0'";
                                        }
                        echo            " size='3' $disabled >"
                                    ."</div>"
                                ."</div>";

                        echo "</div>";
                       
                    }
                ?>
                
                <div id="button_wrapper">                  
                    <input type="submit" id="buy_button" value="הוסף לסל קניות">
                </div>
           </form> 
        </section>

        
<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("pic_slide");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        myIndex++;
        if (myIndex > x.length) {myIndex = 1}    
        x[myIndex-1].style.display = "block";  
        setTimeout(carousel, 4000); 
    }
</script>

    </div>
    </body>
</html>
