<?php

//封装返回数据的类
class Response {

// $arr = array(
// 	'id' => 1,
// 	'name' => 'haha'
// );
// echo json_encode($arr);
    
    
//    public static function xml() {
//        // header("Content-type:text/xml");
//        $xml = "<?xml version='1.0' encoding='UTF-8'/>";
//        $xml .= "<root>\n";
//        $xml .= "<code>200</code>\n";
//        $xml .= "<message>返回数据成功</message>\n";
//        $xml .= "<data>\n";
//        $xml .= "<id>1</id>\n";
//        $xml .= "<name>haha</name>\n";
//        $xml .= "</data>\n";
//        $xml .= "</root>";
//        echo $xml;
//    }
    
    
    /**
     * 综合两种方式输出json或者xml数据
     * @param type $code
     * @param type $message
     * @param type $data
     */
   public static function show($code, $message = '',$data = array(),$type=''){
       if(!is_numeric($code)){
           return '';
       }
       $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'type' => $type,
        );
       $type = isset($_GET['format']) ? $_GET['format'] : 'json';
       if($type == "json"){
           self::json($code, $message, $data);
           exit;
       }else if($type == "xml"){
           self::xmlEncode($code, $message,$data);
           exit;
       }else if($type == "array"){
           var_dump($result);
       }else {
           
       }
   }


   /**
     * 按照json数据输出通信数据
     * @param type $code
     * @param type $message
     * @param type $data
     */
    public static function json($code, $message = '',$data = array()){
        if(!is_numeric($code)){
            return "";
        }
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data,
        );
        echo json_encode($result);
    }

    
    
    /**
     * 把传进来的数据按xml形式输出
     * @param type $code
     * @param type $message
     * @param type $data
     * @return string
     */
    public static function xmlEncode($code,$message,$data = array()){
        if(!is_numeric($code)) {
            return "";
         }
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data,
        );
        header("Content-Type:text/xml");
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<root>\n";
        $xml .= self::xmltoEncode($result) . "\n";
        $xml .= "</root>";
        echo $xml;
    }
    
    
//    解析$result数组，把它拼装成xml数据，返回给它
    public static function xmlToEncode($data) {
        $xml = $attr = "";
        foreach ($data as $key => $val) {
            if(is_numeric($key)){
                $attr = "id='{$key}'"; 
                $key = "item";
            }
            $xml .= "<{$key} {$attr}>";
            $xml .= is_array($val) ? self::xmlToEncode($val) : $val;
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }

}
$arr = array(
 	'id' => 1,
 	'name' => 'haha',
        'type' => array(4,5,6), 
 );
//Response::show(200,'succuess',$arr);
