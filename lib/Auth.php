<?php
namespace Lib;

class Auth {

	public function __construct() {}

	public static function urlsafeB64Encode($input) {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
  }
  public static function urlSafeB64Decode($input){   
      return base64_decode(str_replace(array('-', '_'), array('+', '/'), $input));
  }
  public static function encode(array $payload, string $key, string $alg = 'SHA256')
  {
      $key = md5($key);
      $jwt = self::urlsafeB64Encode(json_encode(['typ' => 'JWT', 'alg' => $alg])) . '.' . self::urlsafeB64Encode(json_encode($payload));
      return $jwt . '.' . self::signature($jwt, $key, $alg);
  }
  public static function signature(string $input, string $key, string $alg)
  {
      return hash_hmac($alg, $input, $key);
  }

  public static function decode(string $jwt, string $key)
  {
      $tokens = explode('.', $jwt);
      $key    = md5($key);
      if (count($tokens) != 3)
          return false;
      list($header64, $payload64, $sign) = $tokens;
      $header = json_decode(self::urlsafeB64Decode($header64), true);
      if (empty($header['alg']))
          return false;
      if (self::signature($header64 . '.' . $payload64, $key, $header['alg']) !== $sign)
          return false;
      $payload = json_decode(self::urlsafeB64Decode($payload64), true);
      $time = $_SERVER['REQUEST_TIME'];
      if (isset($payload['iat']) && $payload['iat'] > $time)
          return false;
      if (isset($payload['exp']) && $payload['exp'] < $time)
          return false;
      return $payload;
  }
}


// $payload=[
//     'iss' => 'jindanlicai.com', //签发者
//     'iat' => $_SERVER['REQUEST_TIME'], //什么时候签发的
//     'exp' => $_SERVER['REQUEST_TIME'] + 7200, //过期时间
     
//     'uid'=> 946418
// ];
// $salt = 'test1';
// header("Authorization: Bearer ".JWT::encode($payload, $salt));
// var_dump(JWT::decode(substr($_SERVER['HTTP_AUTHORIZATION'], 7), $salt));