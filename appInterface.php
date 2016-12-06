    <?php

    //接口文件：获取部分电影信息
    //请求地址为：localhost/API/appInterface.php?page=1&pagesize=12
    require_once './response.php';
    require_once './DB.php';
    require_once './Cache.php';

    $cache = new Cache();
    
    //首先先获取crontab里面的缓存数据
    $data = $cache->cacheData("cron_cache");
    if ($data) {
        return Response::show(200, "首页数据获取成功", $data);
    } else {
        return Response::show(401, "首页数据获取失败");
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $pagesize = isset($_GET['pagesize']) ? $_GET['pagesize'] : 6;


    //如果page不是数字，那么就返回错误的信息。
    if (!is_numeric($page) || !is_numeric($pagesize)) {
        return Response::show(401, "数据不合法");
    }
    $offset = ($page - 1) * $pagesize;
    $sql = "select m_id,m_title,m_intro from kant_movie where m_year >= 2015 order by m_id limit $offset,$pagesize";

    $rows = array();

    //如果缓存文件不存在，才从数据库读取数据，并生成缓存文件。否则读取缓存文件的数据
    if (!$rows = $cache->cacheData("cache_$page-$pagesize")) {
        try {
            $dbConnect = DB::getInstance()->mysqliConnect();
        } catch (Exception $e) {
//            return $e->getMessage();//不要这样返回错误信息，因为这是和客户端进行接口通信的，这样很有可能把信息暴露出来
            return Response::show(403, '数据库连接失败');
        }
        $result = $dbConnect->query($sql);
    //循环数组遍历
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    //生成缓存文件
        if ($rows) {
            $cache->cacheData("cache_$page-$pagesize", $rows, 1200);
        }
    }

    
    
    if ($rows) {
        return Response::show(200, "首页数据获取成功", $rows);
    } else {
        return Response::show(401, "首页数据获取失败");
    }




    ////PDO方式连接
    $dbConnect = DB::getInstance()->pdoConnect();
    //获取数据
    $result = $dbConnect->query($sql);
    var_dump($result);
    $rows = array();
    foreach ($result as $rows) {
    //    print_r($rows);
    }
    if($rows) {
        return Response::show(200,"首页数据获取成功",$rows);
    }else {
        return Response::show(401,"首页数据获取失败");
    }


