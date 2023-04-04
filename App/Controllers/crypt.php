<?php
require_once ('../App/Conf/key.php');
trait Crypt
{
    // datacrypt, pour crypter les liens et autres.
    public function datacrypt($data)
    {
        $first_key = base64_decode(KEYONE);
        $second_key = base64_decode(KEYTWO);   
   
        $method = "aes-256-cbc";   
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);
       
        $first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);   
        $output = base64_encode($iv.$first_encrypted);   
        $output = str_replace('+','[plus]',$output);
        return $output;        
    }

    // datadecrypt, pour le décryptage des liens et autres
    public function datadecrypt($input)
    {
        $input=str_replace('[plus]','+',$input);
        $first_key = base64_decode(KEYONE);
        $second_key = base64_decode(KEYTWO);           
        $mix = base64_decode($input);
       
        $method = "aes-256-cbc";   
        $iv_length = openssl_cipher_iv_length($method);
           
        $iv = substr($mix,0,$iv_length);
        $first_encrypted = substr($mix,$iv_length);
           
        $data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
       return $data;
    }
}