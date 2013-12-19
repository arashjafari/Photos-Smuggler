<?php

    class PSMailer {
        
        private $message = '';
        
        private function getHTML($url,$timeout)
        {
           $ch = curl_init($url); // initialize curl with given url
           curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
           curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
           curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
           curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
           return @curl_exec($ch);
        }
        
        private function sentEmail($from, $to, $subject, $message){    
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";  
            $headers .= "To: <$to>\r\n";
            $headers .= "From: <$from>\r\n";  
            return mail($to, $subject, $message, $headers);
        }
        
        public function send($url, $email)
        {
            if(!is_callable('curl_init')) {
                $this->message =  'Cannot use a cURL transport when curl_init() is not available.';
                return false;
            }
        
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
              $this->message = 'Invalid email format.';
              return false;
            } else if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)){
                $this->message = 'Invalid URL.';
                return false;
            } 
            
            $Html = $this->getHTML($url, 30); 
            if ($this->sentEmail($email, $email, "Photos Smuggler - $url", $Html)) {  
                $this->message = 'Your web page has been sent.';
                return true;
            } else {
                $this->message = 'Failed to sending email.';
                return false;
            }
        }
        
        public function get_message() 
        {
            return $this->message;
        }
    }
?>