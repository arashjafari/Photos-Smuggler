<?php 
    include_once 'src/psmailer.php';
    $message = "";
    $psmailer = new PSMailer();
    if(isset($_POST['btnSend']) && isset($_POST['url']) && isset($_POST['email'])){
        $url = $_POST['url'];
        $email = $_POST['email'];
        $res = $psmailer->send($url,$email);
        if($res){
            $message = '<span class="alert_succ">' . $psmailer->get_message() . '</span>';
        }else{
            $message = '<span class="alert_err">' . $psmailer->get_message() . '</span>';
        }
    }
?><!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Photos Smuggler</title> 
    <meta name="viewport" content="width=device-width">
    <meta name="Keywords" content="Extacting,Photos,Images">
    <meta name="Description" content="Extacting content and images from a (blocked) webpage and send it to your email.">
    <style type="text/css">
        body {
            background-color: #8F2041;
            color: #FF905E;
            font-family: helvetica;
            text-align: center;
            text-transform: uppercase;
        }
        h1 {
            margin: 3px 3px 10px;
            font-weight: lighter !important;
            color: rgb(82, 14, 36);
            font-size: 72px;
        }
        #contents {
            height: 210px;
            margin: 80px auto;
            padding: 10px 15px;
            text-align: center;
            width: 800px;
        }
        .Rows {
            margin: 5px 0;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .alert_succ,.alert_err { 
            margin-top: 9px;
            padding: 5px;
            display: block;
        }
        .alert_succ {
            border: 1px solid #A3E879;
            color: #A3E879;
        }
        .alert_err {
            border: 1px solid #E8E079;
            color: #E8E079; 
        }
        input[type="text"] {
            border: 3px solid #FF905E;
            margin-bottom: 5px;
            padding: 4px;
            width: 400px;
        }
        input[type="text"]:focus {
            width: 430px;
            padding: 5px;
            transition: width 100ms linear 0s, padding 100ms linear 0s;
        }
        #btnSend {
            background-color: rgba(0, 0, 0, 0);
            border: 3px solid #FF905E;
            color: #FF905E;
            font-size: 0.9em;
            margin-top: 10px;
            padding: 5px 10px;
        }
        #btnSend:hover, #btnSend:focus {
            background-color: #FF905E;
            color: #8F2041;
            cursor: pointer;
            transition: background-color 300ms linear 0s, color 300ms linear 0s;
        }
        #btnSend::-moz-focus-inner {
          border: 0;
        }
        .description{
            margin-top: 80px;
            font-size: 1.4em;
        }
    </style>
</head>
<body>
    <div id="contents">   
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>Photos Smuggler</h1>
            <p class="description">Extacting content and images from a (blocked) webpage and send it to your email.</p> 
            <div class="Rows">
                <input type="text" name="url" id="url" placeholder="URL" size="70" />
            </div>
            <div class="Rows">
                <input type="text" name="email" id="email" size="30" placeholder="Email address" />
            </div>
            <div class="Rows">
                <input type="submit" name="btnSend" id="btnSend" value="Send Email" />
                <?php if($message!="") echo "<br />$message"; ?>
            </div>
        </form> 
    </div>
</body>
</html>