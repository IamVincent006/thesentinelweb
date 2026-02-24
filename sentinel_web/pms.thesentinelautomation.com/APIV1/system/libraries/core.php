<?php
class Core {
	
    public static function safe_extract($array) {
        foreach ($array as $key => $value) {
            if (mb_strpos($key, "GLOBALS") === 0
                    || mb_strpos($key, "_SERVER") === 0
                    || mb_strpos($key, "_GET") === 0
                    || mb_strpos($key, "_POST") === 0
                    || mb_strpos($key, "_FILES") === 0
                    || mb_strpos($key, "_COOKIE") === 0
                    || mb_strpos($key, "_SESSION") === 0
                    || mb_strpos($key, "_REQUEST") === 0
                    || mb_strpos($key, "_ENV") === 0
            ) {
                continue;
            }

            $GLOBALS[$key] = $value;
        }
    }

    public function encrypt_decrypt($key,$action, $string)
    {
    	$key = hash('sha512',$key);
    	$output = false;
    	
    	$encrypt_method = "AES-256-CBC";
    	$secret_key = $key;
    	$secret_iv = md5(md5($key));
    
    	$key = hash('sha256', $secret_key);  	
    	$iv  = substr(hash('sha256', $secret_iv), 0, 16);
    	
    	if( $action == 'encrypt' ) {
    		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    		$output = base64_encode($output);
    	}
    	else if( $action == 'decrypt' ){
    		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    	}
    	
    	return $output;
    }
    
    public function display_result_json($status,$message,$response) {
        
        $resultArray  =  array('status' => $status, 'message' =>  $message, 'response' =>  $response);
        
        return json_encode($resultArray);
        
    }
    
    public function generate_random_string($length=10)  {
        
        $string = '';
        $characters = "123456789ABCDEFHJKLMNPRTVWXYZ";
        
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }
        
        return $string;
        
    }

}

?>
