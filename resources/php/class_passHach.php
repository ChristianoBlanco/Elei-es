<?php
class PassHash {
  
  // blowfish
  private static $algo = "$2a";
    
  // parâmetro de custo
  private static $cost = '$10';
    
  // criada, principalmente, para uso interno
  public static function unique_salt()
  {
  return substr(sha1(mt_rand()), 0, 22);
  }
    
  // isso será usado para gerar o hash
  public static function hash($password)
  {
  return crypt($password,
  self::$algo .
  self::$cost .
  '$' . self::unique_salt());
  }

  // essa será usada para comparar a senha em relação ao hash
public static function check_password($hash, $password)
{
$full_salt = substr($hash, 0, 29);
  
$new_hash = crypt($password, $full_salt);
  
return ($hash === $new_hash);
}
}

  ?>