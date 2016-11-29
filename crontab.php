<?php

//设置crontab定时任务，让其定时执行

//想获取movie表中的10条数据

require_once './response.php';
require_once './DB.php';

$offset = ($page - 1) * $pagesize;
$sql = "select m_id,m_title,m_intro from kant_movie where m_year >= 2015 and m_area = '美国' order by m_id limit $offset,$pagesize";