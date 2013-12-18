<?php
    function getHTML($url,$timeout)
    {
       $ch = curl_init($url); // initialize curl with given url
       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
       return @curl_exec($ch);
    }
    function sentEmail($from,$to,$subject,$message){    
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";  
        $headers .= "To: <$to>\r\n";
        $headers .= "From: <$from>\r\n";  
        mail($to, $subject, $message, $headers);
    }
    $message = "";
    if(isset($_POST['btnSend']) && isset($_POST['url']) && isset($_POST['email'])){
        $url = $_POST['url'];
        $email = $_POST['email'];
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) 
          $message = '<span class="alert_err">Invalid email format.</span>';
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) 
            $message = '<span class="alert_err">Invalid URL.</span>'; 
        if($message==""){
            $Html = getHTML($url,30); 
            sentEmail($email,$email,"Photos Smuggler - $url",$Html);  
            $message = '<span class="alert_succ">Your webpage has been sent.</span>'; 
        }    
    }
?><!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Photos Smuggler</title> 
    <meta name="viewport" content="width=device-width">
    <meta name="Keywords" content="Extacting,Photos,Images">
    <meta name="Description" content="Extacting images from a webpage and send it to your email.">
    <link rel="icon" href="/fav.ico" type="image/x-icon">
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="contents">   
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>Photos Smuggler</h1>
            <p style="margin-top: 80px; font-size: 1.4em;">Extacting images from a webpage and send it to your email</p> 
            <div class="Rows">
                <input type="text" name="url" id="url" placeholder="URL" size="70" />
            </div>
            <div class="Rows">
                <input type="text" name="email" id="email" size="30" placeholder="Email address" />
            </div>
            <div class="Rows">
                <input type="submit" name="btnSend" id="btnSend" value="Send Email" />
                <?php
                if(!is_callable('curl_init'))
                    echo '<br /><span class="alert_succ">Cannot use a cURL transport when curl_init() is not available.</span>';
                if($message!="") echo "<br />$message"; ?>
            </div>
        </form> 
    </div>
</body>
</html>