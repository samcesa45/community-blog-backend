<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Support\Facades\Schema;

class AppBaseController extends Controller 
{
  

  public function sendResponse($result, $message)
  {
    return Response::json(self::makeResponse($message,$result));
  }

  public function sendError($error,$code = 404)
  {
    return  Response::json(self::makeError($error), $code);
  }

  public function sendSuccess($message)
  {
    return Response::json([
      'success' => true,
      'message' => $message
    ],200);
  }

  public static function makeResponse($message,$data)
  {
    return [
      'success' => true,
      'data' => $data,
      'message' => $message,
    ];
  }

  public static function makeError($message, array $data) 
  {
    $res = [
        'success' => false,
        'message'=> $message,
    ];

    if(!empty($data)) {
       $res['data'] = $data;
    }

    return $res;
  }

}