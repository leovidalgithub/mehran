<?php
/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * 
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";

        // REMOVE THIS FROM HERE - MUST BE PASSED AS SERVER ENVIRONMENT VARIABLE
        $secret_key = 'You are gonna make it';
        $secret_iv = 'Who reads this when it comes';
        // REMOVE THIS FROM HERE - MUST BE PASSED AS SERVER ENVIRONMENT VARIABLE

        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

// $plain_txt = "This is my plain text";
// $encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
// $decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
?>
