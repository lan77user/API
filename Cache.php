<?php

//    需求：生成缓存，获取缓存，删除缓存(这是静态缓存的一个类)
class Cache {
    
    private $_dir;
    const EXT = '.php';
    public function __construct() {
//        在当前目录下新建一个cache目录，用来存放缓存数据
        $this->_dir = dirname(__FILE__) . "/cache/";
    }
    
    
    /**
     * 
     * @param type $key  文件名
     * @param type $val  缓存数据
     * @param type $cacheTime  缓存失效时间,0代表永久生效
     * 
     */
    public function cacheData($key,$val = '',$cacheTime = 0){
//        拼装文件名
        $filename = $this->_dir  . $key . self::EXT;
        
        /********************写入缓存************************/
//        如果数据缓存有值，就是不为空，那就将value值写入缓存
        if($val !== ''){
            
//            如果没有传入$val的值，就删除这个文件
            if(is_null($val)) {
                return @unlink($filename);
            }

            $dir = dirname($filename);    //获得当前文件的目录名
            if (!is_dir($dir)) {
                mkdir($dir,0777);
            }
//      处理一下cacheTime过期时间,以10进制输出，最长11位，如果不满11位前面补0
            $cacheTime = sprintf('%011d', $cacheTime);
            return file_put_contents($filename, $cacheTime . json_encode($val));
        }
        
        
        /************************获取缓存*************************/
//        判断文件是否存在，如果存在就可以获取缓存啦，如果不存在就返回false
        if(!is_file($filename)){
            return false;
        }
//            不加true是返回对象形式
            $content = file_get_contents($filename);  //获取缓存文件的全部内容
            $cacheTime =ltrim(substr($content, 0,11),'0');  //获取缓存时间
            $val = substr($content, 11);     //获取缓存内容

            if($cacheTime != 0 && $cacheTime + filemtime($filename) < time()) {
                unlink($filename);
                echo "缓存已过期！";
                return false;
            }
//            if() {
            return  json_decode(file_get_contents($filename),TRUE);
//            }
    }
}

$arr = array(
 	'id' => 1,
 	'name' => 'haha',
        'type' => array(4,5,6), 
 );
//$cache = new Cache();
//$cache->cacheData("haha_cache");
//var_dump($cache->cacheData("haha_cache",$arr, 10));



