<?php

include 'simpleimage.class.php';
include 'instagram.class.php';

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $pass = $_POST['pass'];
    
    $photo = $_FILES['photo'];
    $username = $name;   // your username 'codemize4u'
    $password = $pass;   // your password 'AAA123'
    
    $filename = $photo['name'];   // your sample photo
    $caption = " #tag test.....";   // your caption

    $product_image= getcwd().'/' . $filename;
    $square = getcwd().'/' . $filename;
    $image = new SimpleImage(); 
    $image->load($product_image); 
    $image->resize(268,268); 						
    $image->save($square, IMAGETYPE_JPEG);  
    unset($image);

    $insta = new instagram();
    $response = $insta->Login($username, $password);

    if(strpos($response[1], "Sorry")) {
        echo "Request failed, there's a chance that this proxy/ip is blocked";
        print_r($response);
        exit();
    }         
    if(empty($response[1])) {
        echo "Empty response received from the server while trying to login";
        print_r($response);	
        exit();	
    }

    $insta->Post($square, $caption);

}
?>

<form method="post" action="instagram_autopost.php"  enctype="multipart/form-data">
   username : <input type="text" name="name" id="name" /> <br/>
   password : <input type="password" name="pass" id="pass" /> <br/>
   photo    : <input type="file" name="photo" id="photo" class="form-control"><br/>
    <input type="submit" name="submit" value="send" class="btn btn-primary" />
</form>


