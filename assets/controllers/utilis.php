<?php

namespace controllers\utilis;


use Dotenv\Dotenv;
use OpenSwoole\Http\Server;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;



class controller_utilis{
    public function __contruct(){

    }

    public function load_env(){
        $load_env = Dotenv::createImmutable(__DIR__);
        $load_env -> load();
        return $load_env;
    }


   public static function returnData ($status=false, $message=null, $data=null)
{
  
  if ($data == null) {

      $data = array();
  }
  $payload = array(
      'status' => $status,
      'message' => $message,
      'data' => $data
  );

  return json_encode($payload);

  foreach (get_defined_vars() as $var) {
  unset($var);
}



}

}