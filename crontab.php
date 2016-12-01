<?php

//设置crontab定时执行脚本程序，让其定时执行
//*/5****/wampstack/php  /data/localhost/crontab.php  (开启命令：每5分钟执行一次crontab.php文件)
//想获取movie表中的6条数据

require_once './Cache.php';
require_once './DB.php';

$sql = "select m_id,m_title,m_intro from kant_movie where m_year >= 2015 and m_area = '美国' order by m_id limit 8";

try {
        $dbConnect = DB::getInstance()->mysqliConnect();
    } catch (Exception $e) {
        return file_put_contents('./logs/'.date('y-m-d').'.txt', $e->getMessage());
    }
    $result = $dbConnect->query($sql);
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    
    $cache = new Cache();
    if($rows) {
        $cache->cacheData("cron_cache",$rows, 100);
    }else{
         file_put_contents('./logs/'.date('y-m-d').'.php', "没有相关数据");
    }return;


