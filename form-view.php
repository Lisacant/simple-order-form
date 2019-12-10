<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container"> 
<!-- how to switch between the pages -->
    <h1>Order <?php if($is_food){
            echo "food";
        }else{
            echo "drinks";
        } 
        
        ?> in restaurant "The Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>



    <?php 
    // Initialize variables to null. 
    $email = $street = $streetNumber = $city = $delivery = $zipcode = ""; 
    $emailErr = $streetErr = $streetNumberErr = $cityErr = $deliveryErr = $zipcodeErr = "";
        $formValidation= true;

        // On submitting form below function will execute.

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = ($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Email is required";
                $formValidation = false;
            }
            $street = ($_POST["street"]);
            if (empty($street)) {
                $streetErr = "Street is required";
                $formValidation= false;
            }
            $streetNumber = ($_POST["streetnumber"]);
            if(empty($streetNumber)) {
                $streetNumberErr = "Street number is required";
                $formValidation = false;
            }
            else if(!filter_var($streetNumber, FILTER_VALIDATE_INT)) {
                $streetNumberErr = "Street number must be numbers";
                $formValidation = false;
            }
            $city = ($_POST["city"]);
            if (empty($city)) {
                $cityErr = "City is required";
                $formValidation= false;
            }
            $zipcode = ($_POST["zipcode"]);
            if(empty($zipcode)) {
                $zipcodeErr = "Zipcode is required";
                $formValidation= false;
            }
            $delivery = ($_POST["delivery"]);
            if(empty($delivery)) {
                $deliveryErr = "Delivery method is required";
                $formValidation= false;
            }
            else if(!filter_var($zipcode, FILTER_VALIDATE_INT)) {
                $zipcodeErr = "Zipcode must be numbers";
                $formValidation = false;
            }
        }
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if($formValidation) {
                    ?> <p class="msgReceived">Your order has been received!</p> <?php
                } else {
                    ?> <p class="msgNotGood">There is something wrong with your order :( </p> <?php
                }
            }            
        ?>

    <form action="index.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" value="<?php echo $email ?>" class="form-control"/>
                <span class="error"> * required field. <?php echo $emailErr; ?> </span>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" value="<?php echo $street ?>" class="form-control">
                    <span class="error"> * required field.  <?php echo $streetErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" value="<?php echo $streetNumber ?>" class="form-control">
                    <span class="error"> * required field <?php echo $streetNumberErr; ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo $city ?>"  class="form-control">
                    <span class="error"> * required field <?php echo $cityErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode ?>" class="form-control">
                    <span class="error"> * required field  <?php echo $zipcodeErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="delivery">Choose your preference of delivery: (we are working with drones!)</label>
                    <?php
 
//Delivery options. A list of allowed options.
$deliveryOptions = array(
    'normal',
    'express',
);
 
//Empty array by default.
$delivery = array();
 
//If the POST var "delivery" is a valid array.
if(!empty($_POST['delivery']) && is_array($_POST['delivery'])){
    //Loop through the array of checkbox values.
    foreach($_POST['delivery'] as $deliveryO){
        //Make sure that this option is a valid one.
        if(in_array($deliveryO, $deliveryOptions)){
            //Add the selected options to our $delivery array.
            $delivery[] = $deliveryO;
        }
        
    }
}

?>
    <label>
        Normal (2 hours)
        <input type="radio" name="delivery" value="normal">
    </label>
    <label>
        Express (45 minutes)
        <input type="radio" name="delivery" value="express">
    </label>
    <br>
    <span class="error"> * required field</span> 

                </div>
            </div>
        </fieldset>
     
        <br>

        <fieldset>
            <legend>Products</legend>

            
            <?php                      
                
            foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?> </label><br />
            <?php endforeach; ?>
        </fieldset>
        <br>
        <button type="submit" select name="submit" name = "products" class="btn btn-primary">Order!</button>
        
    </form>
    <?php
if(isset($_POST['submit'])){
$selected_val = $_POST['delivery'];  // Storing Selected Value In Variable
echo "You have selected ". " " .$selected_val ." as delivery time ";  // Displaying Selected Value
}
?>

<?php
if(isset($_POST['submit'])){
if(!empty($_POST['products'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['products']);
echo "and  have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
foreach($_POST["products"] as $key => $val) {
    $names = $products[$key];
echo "<p>".$names["name"]."</p>";
};
}
}
?>

    <footer>You already ordered <strong>&euro; <?php echo $names['price'] ?></strong> in food and drinks.</footer>

    <?php 
if(isset($_POST['submit'])){
$msg = "Thank you for your order! You ordered" .$names;
mail($_POST['email'],"My subject",$msg);
echo "order received! You should get an e-mail very soon";
    }
?>
</div>

<style>
    footer {
        text-align: center;
    }

    .error {
        color: red;
    }

    .msgReceived {
        color: green;
        border-radius: 1rem;
  text-align: center;
  border-bottom: 1px solid #eee;
    }

    .msgNotGood {
 color: red;
border-radius: 1rem;
  text-align: center;
  border-bottom: 1px solid #eee;
    }
</style>
</body>
</html>