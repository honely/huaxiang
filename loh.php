---------------------------------------------------------------
[ 2020-07-07T13:52:24+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.027057s][吞吐率：36.96req/s] [内存消耗：2,849.21kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000423s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000968s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000290s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000641s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000295s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:25+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041265s][吞吐率：24.23req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000416s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000968s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000282s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000648s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000385s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000628s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000541s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000658s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000349s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000189s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000433s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:27+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041350s][吞吐率：24.18req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000426s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000919s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000274s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000695s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000382s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000612s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000474s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000229s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000650s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000252s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:29+08:00 ] 172.31.0.173 123.139.92.38 POST /api/cate/getcity
[ info ] wx.huaxiangxiaobao.com/api/cate/getcity [运行时间：0.025768s][吞吐率：38.81req/s] [内存消耗：2,665.83kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'cate',
2 => 'getcity',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '2',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
)
[ info ] [ RUN ] app\api\controller\Cate->getCity[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Cate.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000432s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_cate` [ RunTime:0.001802s ]
[ sql ] [ SQL ] SELECT `id`,`name`,`pid`,`oseq` FROM `tk_cate` WHERE  (  pid = 0 ) ORDER BY oseq asc [ RunTime:0.000471s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:29+08:00 ] 172.31.0.173 123.139.92.38 GET /api/cate/getTags?type=1
[ info ] wx.huaxiangxiaobao.com/api/cate/getTags?type=1 [运行时间：0.023846s][吞吐率：41.94req/s] [内存消耗：2,662.05kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'cate',
2 => 'getTags',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
'content-length' => '',
)
[ info ] [ PARAM ] array (
'type' => '1',
)
[ info ] [ RUN ] app\api\controller\Cate->getTags[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Cate.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000422s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_tags` [ RunTime:0.000826s ]
[ sql ] [ SQL ] SELECT `name` FROM `xcx_tags` WHERE  `type` = 1 [ RunTime:0.000279s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:29+08:00 ] 172.31.0.173 123.139.92.38 POST /api/cate/getcity
[ info ] wx.huaxiangxiaobao.com/api/cate/getcity [运行时间：0.023518s][吞吐率：42.52req/s] [内存消耗：2,670.72kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'cate',
2 => 'getcity',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'cid' => 27,
)
[ info ] [ RUN ] app\api\controller\Cate->getCity[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Cate.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000371s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_cate` [ RunTime:0.000809s ]
[ sql ] [ SQL ] SELECT `id`,`name`,`pid`,`oseq` FROM `tk_cate` WHERE  (  pid = 27 and type = 2 ) ORDER BY oseq asc [ RunTime:0.000538s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:29+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014265s][吞吐率：70.10req/s] [内存消耗：1,706.59kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '243',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000378s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001139s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001904s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000697s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:29'  WHERE  `id` = 59 [ RunTime:0.000333s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:29+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getarea
[ info ] wx.huaxiangxiaobao.com/api/house/getarea [运行时间：0.026927s][吞吐率：37.14req/s] [内存消耗：2,813.17kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getarea',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '20',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'city' => '墨尔本',
)
[ info ] [ RUN ] app\api\controller\House->getArea[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000370s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001120s ]
[ sql ] [ SQL ] SELECT `area` FROM `tk_houses` WHERE  `city` = '墨尔本'  AND (  area != '' ) GROUP BY `area` [ RunTime:0.002353s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:33+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.035689s][吞吐率：28.02req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000413s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000930s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000305s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000651s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000426s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000610s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000491s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:34+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.027623s][吞吐率：36.20req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000443s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001006s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000315s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000700s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000293s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:35+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041769s][吞吐率：23.94req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000445s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000997s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000282s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000669s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000387s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000229s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000618s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000481s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000740s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000460s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000242s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000563s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:35+08:00 ] 172.31.0.173 103.138.53.91 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.090064s][吞吐率：11.10req/s] [内存消耗：2,931.86kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,zh-TW;q=0.6',
'cookie' => 'PHPSESSID=91tcimbv76snu11c0vou8rlui7; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086920; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086920; Hm_lpvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086951; Hm_lpvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086951',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000410s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000864s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 3 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 3 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 41 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 41 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000403s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000746s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000249s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000628s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 6  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000525s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 7  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 8  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000431s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 9  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000327s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000193s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 13  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 15  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 16  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 17  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 18  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 22  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 23  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 24  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000468s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 25  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 29  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 32  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 34  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 36  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 37  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 38  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 42  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 43  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000460s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 44  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 45  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000437s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 47  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000429s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000232s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 48  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 66  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 67  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 72  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 73  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 74  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 81  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 83  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 85  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 88  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 92  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 106  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 108  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 113  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 164  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 166  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 193  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 196  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 205  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 207  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000230s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 211  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000224s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 212  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 216  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 229  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000434s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 233  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 234  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 235  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 238  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 245  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 251  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:35+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014267s][吞吐率：70.09req/s] [内存消耗：1,706.60kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '245',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '3+',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000397s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001175s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001815s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000671s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:35'  WHERE  `id` = 59 [ RunTime:0.000323s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:37+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041473s][吞吐率：24.11req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000457s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000951s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000277s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000650s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000392s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000627s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000619s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000471s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000647s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000232s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000246s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000463s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000186s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:38+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014957s][吞吐率：66.86req/s] [内存消耗：1,706.60kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '245',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '3+',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000406s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001201s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.001756s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000824s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:38'  WHERE  `id` = 59 [ RunTime:0.000334s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:43+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.035800s][吞吐率：27.93req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000392s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000934s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000287s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000642s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000336s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000239s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000674s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000485s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000459s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:43+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015089s][吞吐率：66.27req/s] [内存消耗：1,706.49kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '247',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '3+',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '3+',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：3+
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet > 3 and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000387s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001263s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet > 3 and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001794s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000704s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:43'  WHERE  `id` = 59 [ RunTime:0.000330s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:44+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026557s][吞吐率：37.65req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000424s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000972s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000284s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000642s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000280s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:45+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041732s][吞吐率：23.96req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000431s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000970s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000297s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000654s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000419s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000226s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000600s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000498s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000657s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000529s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:47+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041167s][吞吐率：24.29req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000429s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000938s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000281s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000650s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000382s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000193s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000194s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000617s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000475s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000338s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000194s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000644s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000328s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000437s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:49+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015297s][吞吐率：65.37req/s] [内存消耗：1,706.60kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '245',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '3+',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：3+
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000425s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001184s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001844s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000680s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:49'  WHERE  `id` = 59 [ RunTime:0.000327s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:50+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014798s][吞吐率：67.58req/s] [内存消耗：1,706.60kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '245',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '3+',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：3+
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000440s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001218s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.001805s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000710s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:50'  WHERE  `id` = 59 [ RunTime:0.000327s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:51+08:00 ] 172.31.0.173 103.138.53.91 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.089408s][吞吐率：11.18req/s] [内存消耗：2,931.86kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,zh-TW;q=0.6',
'cookie' => 'PHPSESSID=91tcimbv76snu11c0vou8rlui7; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086920; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086920; Hm_lpvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086951; Hm_lpvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086951',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000429s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000826s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 3 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 3 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 41 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 41 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000454s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000745s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000237s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000641s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 6  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000488s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 7  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000463s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 8  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000483s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 9  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 13  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 15  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000487s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 16  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 17  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 18  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 22  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 23  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 24  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 25  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 29  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 32  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 34  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 36  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 37  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000427s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 38  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 42  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000469s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 43  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 44  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 45  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000467s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 47  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000538s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 48  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 66  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000432s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 67  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 72  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000192s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 73  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 74  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 81  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000224s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 83  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 85  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 88  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 92  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000432s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 106  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 108  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000465s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 113  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 164  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 166  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000460s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 193  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 196  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 205  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 207  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 211  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000192s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 212  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 216  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 229  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 233  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 234  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 235  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 238  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 245  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 251  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:52+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014889s][吞吐率：67.16req/s] [内存消耗：1,706.60kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '245',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '3+',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：3+
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000426s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001215s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.001764s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000747s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:52'  WHERE  `id` = 59 [ RunTime:0.000359s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:53+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.035963s][吞吐率：27.81req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000414s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000970s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000354s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000624s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000331s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000244s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000649s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000477s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000483s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000493s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:53+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014663s][吞吐率：68.20req/s] [内存消耗：1,706.60kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '245',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '3+',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：3+
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000425s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001239s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.001781s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000700s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:53'  WHERE  `id` = 59 [ RunTime:0.000349s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:52:54+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026752s][吞吐率：37.38req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000410s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001009s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000293s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000616s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000277s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:55+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041645s][吞吐率：24.01req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000419s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000967s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000282s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000673s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000408s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000337s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000601s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000493s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000253s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000683s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000434s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:57+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041607s][吞吐率：24.03req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000418s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001018s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000279s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000654s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000397s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000620s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000485s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000457s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000673s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000247s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000431s ]
---------------------------------------------------------------
[ 2020-07-07T13:52:58+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015441s][吞吐率：64.76req/s] [内存消耗：1,706.51kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '246',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '3',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '3+',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：3+
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet = 3 and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000426s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001215s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet = 3 and car > 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001761s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000709s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:52:58'  WHERE  `id` = 59 [ RunTime:0.000338s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:03+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.036185s][吞吐率：27.64req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000426s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001059s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000275s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000636s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000339s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000661s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000497s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000464s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000370s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:04+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026585s][吞吐率：37.62req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000468s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000981s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000297s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000611s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000272s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:05+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041717s][吞吐率：23.97req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000417s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000920s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000288s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000616s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000389s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000653s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000477s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000259s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000462s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000667s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000224s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000476s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:05+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014484s][吞吐率：69.04req/s] [内存消耗：1,706.59kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '244',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '3',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet = 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000422s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001163s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet = 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001838s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000663s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:05'  WHERE  `id` = 59 [ RunTime:0.000312s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:06+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015191s][吞吐率：65.83req/s] [内存消耗：1,706.59kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '244',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '3',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet = 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000389s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001195s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and toilet = 3 )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.001894s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000808s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:06'  WHERE  `id` = 59 [ RunTime:0.000331s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:07+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041847s][吞吐率：23.90req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000387s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000922s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000291s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000680s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000404s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000612s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000474s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000255s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000195s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000722s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000226s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000194s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:08+08:00 ] 172.31.0.173 103.138.53.91 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.092213s][吞吐率：10.84req/s] [内存消耗：2,931.86kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,zh-TW;q=0.6',
'cookie' => 'PHPSESSID=91tcimbv76snu11c0vou8rlui7; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086920; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086920; Hm_lpvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086951; Hm_lpvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086951',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000373s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000844s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 3 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 3 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 41 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 41 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000520s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000761s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000256s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000711s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 6  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000541s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 7  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000540s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 8  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 9  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000625s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 13  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000459s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000259s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 15  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 16  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 17  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 18  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000236s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 22  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000473s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 23  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000465s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 24  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000468s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 25  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000474s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 29  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000497s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 32  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000484s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 34  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 36  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000465s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 37  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 38  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000467s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 42  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 43  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000434s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000237s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 44  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 45  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000476s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 47  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 48  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 66  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 67  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 72  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 73  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 74  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000239s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 81  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000195s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 83  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000462s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 85  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 88  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 92  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 106  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 108  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 113  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 164  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 166  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000226s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 193  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 196  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000434s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 205  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 207  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 211  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 212  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 216  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000471s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 229  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 233  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 234  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 235  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 238  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 245  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 251  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:13+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015335s][吞吐率：65.21req/s] [内存消耗：1,706.59kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '243',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000475s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001167s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001939s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000672s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:13'  WHERE  `id` = 59 [ RunTime:0.000333s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:13+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.036229s][吞吐率：27.60req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000386s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000950s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000281s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000634s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000359s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000635s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000551s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000608s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000457s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:13+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014455s][吞吐率：69.18req/s] [内存消耗：1,706.59kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '243',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '',
'maxtime' => '',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000386s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001166s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.001934s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000649s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:13'  WHERE  `id` = 59 [ RunTime:0.000300s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:14+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026346s][吞吐率：37.96req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000418s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000943s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000292s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000648s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000293s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:15+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.042021s][吞吐率：23.80req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000409s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000927s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000282s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000655s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000402s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000615s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000510s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000239s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000467s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000675s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000320s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000457s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:17+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041774s][吞吐率：23.94req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000408s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000977s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000328s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000658s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000232s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000595s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000474s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000192s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000667s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000234s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000476s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000226s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000193s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:21+08:00 ] 172.31.0.173 49.184.210.89 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.061839s][吞吐率：16.17req/s] [内存消耗：2,859.49kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'zh-CN,zh;q=0.9',
'cookie' => 'Hm_lvt_70546d661cadce41b9173a040b7f077e=1592872267,1592872515; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1592872267,1592872515,1593565695; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1592872267,1592872515,1593565695; PHPSESSID=5oh66q694te5s2hab4u95peji4',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000409s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000866s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 2 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 2 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 58 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 58 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000386s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000767s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000247s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000626s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000505s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 20  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000556s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 41  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 69  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000469s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 100  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 152  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 156  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000472s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 165  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000541s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 167  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 170  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000471s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 177  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 178  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000226s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 183  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 184  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 186  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 187  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 194  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 202  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000519s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 204  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 206  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000486s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 222  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000433s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 224  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000434s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 226  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 231  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000432s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 236  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 242  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 248  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 249  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000433s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000242s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 58 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 2 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:23+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.036583s][吞吐率：27.34req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000414s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001003s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000381s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000639s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000378s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000627s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000471s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000487s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000309s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:24+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026864s][吞吐率：37.22req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000450s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000951s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000291s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000669s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000291s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:25+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041413s][吞吐率：24.15req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000444s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000977s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000283s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000639s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000391s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000606s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000638s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000337s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000658s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000235s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:27+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041388s][吞吐率：24.16req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000419s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000933s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000273s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000632s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000386s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000609s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000509s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000738s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:28+08:00 ] 172.31.0.173 103.138.53.91 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.090641s][吞吐率：11.03req/s] [内存消耗：2,931.86kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,zh-TW;q=0.6',
'cookie' => 'PHPSESSID=91tcimbv76snu11c0vou8rlui7; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086920; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086920; Hm_lpvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086951; Hm_lpvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086951',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000395s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000813s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 3 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 3 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 41 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 41 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000396s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000767s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000251s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000751s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 6  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000482s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000243s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 7  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 8  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 9  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 13  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 15  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000492s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 16  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 17  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000496s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000195s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 18  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000437s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 22  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000459s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 23  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 24  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 25  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 29  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 32  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000471s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 34  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 36  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000469s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000233s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 37  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000479s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 38  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 42  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 43  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 44  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 45  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 47  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 48  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 66  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 67  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000467s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 72  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 73  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 74  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000463s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 81  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 83  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 85  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 88  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000498s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 92  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000480s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 106  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 108  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 113  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 164  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 166  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 193  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000234s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 196  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000475s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000223s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 205  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000538s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 207  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 211  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 212  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 216  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 229  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 233  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 234  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000432s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000226s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 235  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 238  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 245  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000459s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 251  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:30+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015334s][吞吐率：65.22req/s] [内存消耗：1,706.77kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '263',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 0,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '2020-07-07',
'maxtime' => '2020-08-07',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 入住时间最小值：2020-07-07入住时间最大值2020-08-07
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码0
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and ((live_date >= '2020-07-07' and live_date  <= '2020-08-07')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' )) )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000485s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001241s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and ((live_date >= '2020-07-07' and live_date  <= '2020-08-07')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' )) )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 0,10 [ RunTime:0.001960s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000674s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:30'  WHERE  `id` = 59 [ RunTime:0.000326s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:32+08:00 ] 172.31.0.173 123.139.92.38 POST //api/colt/getCollect
[ info ] wx.huaxiangxiaobao.com//api/colt/getCollect [运行时间：0.037285s][吞吐率：26.82req/s] [内存消耗：3,114.62kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'colt',
2 => 'getCollect',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '19',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'type' => 1,
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Colt->getCollect[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Colt.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000463s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_collect` [ RunTime:0.001091s ]
[ sql ] [ SQL ] SELECT `xcx_collect`.*,`tk_houses`.`title`,`tk_houses`.`price`,`tk_houses`.`images`,`tk_houses`.`tags`,`tk_houses`.`home` FROM `xcx_collect` INNER JOIN `tk_houses` `tk_houses` ON `xcx_collect`.`cl_house_id`=`tk_houses`.`id` WHERE  (  cl_user_id = 59 and cl_type = 1 ) ORDER BY cl_addtime desc LIMIT 0,10 [ RunTime:0.000599s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:32+08:00 ] 172.31.0.173 123.139.92.38 POST /api/banner/getBan
[ info ] wx.huaxiangxiaobao.com/api/banner/getBan [运行时间：0.036372s][吞吐率：27.49req/s] [内存消耗：3,087.06kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'banner',
2 => 'getBan',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'type' => 2,
)
[ info ] [ RUN ] app\api\controller\Banner->getBan[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Banner.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000325s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_banner` [ RunTime:0.000928s ]
[ sql ] [ SQL ] SELECT `b_id`,`b_title`,`b_cover` FROM `xcx_banner` WHERE  (  b_status = 1 and b_class = 2 ) ORDER BY b_order desc,b_update_time desc LIMIT 0,12 [ RunTime:0.000337s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:32+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/houseDetail
[ info ] wx.huaxiangxiaobao.com/api/house/houseDetail [运行时间：0.036412s][吞吐率：27.46req/s] [内存消耗：3,526.20kb] [文件加载：46]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'houseDetail',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '21',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'id' => '797',
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\House->houseDetail[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ CACHE ] INIT File
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000425s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001182s ]
[ sql ] [ SQL ] SELECT * FROM `tk_houses` WHERE  `id` = 797 LIMIT 1 [ RunTime:0.000566s ]
[ sql ] [ SQL ] SELECT * FROM `tk_houses` WHERE  `id` = 797 LIMIT 1 [ RunTime:0.000381s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000656s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 1427 LIMIT 1 [ RunTime:0.000234s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 1427 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_view_history` [ RunTime:0.000585s ]
[ sql ] [ SQL ] DELETE FROM `xcx_view_history`    WHERE  `vh_userid` = 59  AND `vh_house_id` = 797  AND `vh_type` = 1 [ RunTime:0.000996s ]
[ sql ] [ SQL ] UPDATE `tk_houses`  SET `view`=view+1  WHERE  `id` = 797 [ RunTime:0.000288s ]
[ sql ] [ SQL ] INSERT INTO `xcx_view_history` (`vh_userid` , `vh_house_id` , `vh_type` , `vh_add_time`) VALUES (59 , 797 , 1 , '2020-07-07 13:53:32') [ RunTime:0.000263s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:33+08:00 ] 172.31.0.173 123.139.92.38 POST //api/user/getShare
[ info ] wx.huaxiangxiaobao.com//api/user/getShare [运行时间：0.600046s][吞吐率：1.67req/s] [内存消耗：1,850.07kb] [文件加载：33]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'user',
2 => 'getShare',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '21',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'id' => '797',
'type' => 1,
)
[ info ] [ RUN ] app\api\controller\User->getShare[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/User.php ]
[ info ] [ LOG ] INIT File
[ error ] [8]未定义数组索引: errcode[/www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/User.php:433]
---------------------------------------------------------------
[ 2020-07-07T13:53:33+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.036175s][吞吐率：27.64req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000380s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000973s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000363s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000654s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000333s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000238s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000611s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000495s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000469s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000460s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:34+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026583s][吞吐率：37.62req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000416s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001007s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000310s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000648s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000286s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:35+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041730s][吞吐率：23.96req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000431s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000950s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000312s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000640s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000411s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000617s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000515s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000742s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000335s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000193s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000476s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000193s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000473s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:37+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041292s][吞吐率：24.22req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000428s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000961s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000313s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000654s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000399s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000615s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000593s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000465s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000652s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:38+08:00 ] 172.31.0.173 123.139.92.38 POST //api/colt/getCollect
[ info ] wx.huaxiangxiaobao.com//api/colt/getCollect [运行时间：0.038087s][吞吐率：26.26req/s] [内存消耗：3,114.62kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'colt',
2 => 'getCollect',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '19',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'type' => 1,
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Colt->getCollect[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Colt.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000501s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_collect` [ RunTime:0.001165s ]
[ sql ] [ SQL ] SELECT `xcx_collect`.*,`tk_houses`.`title`,`tk_houses`.`price`,`tk_houses`.`images`,`tk_houses`.`tags`,`tk_houses`.`home` FROM `xcx_collect` INNER JOIN `tk_houses` `tk_houses` ON `xcx_collect`.`cl_house_id`=`tk_houses`.`id` WHERE  (  cl_user_id = 59 and cl_type = 1 ) ORDER BY cl_addtime desc LIMIT 0,10 [ RunTime:0.000590s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:38+08:00 ] 172.31.0.173 123.139.92.38 POST /api/banner/getBan
[ info ] wx.huaxiangxiaobao.com/api/banner/getBan [运行时间：0.037128s][吞吐率：26.93req/s] [内存消耗：3,087.06kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'banner',
2 => 'getBan',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'type' => 2,
)
[ info ] [ RUN ] app\api\controller\Banner->getBan[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Banner.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000485s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_banner` [ RunTime:0.000966s ]
[ sql ] [ SQL ] SELECT `b_id`,`b_title`,`b_cover` FROM `xcx_banner` WHERE  (  b_status = 1 and b_class = 2 ) ORDER BY b_order desc,b_update_time desc LIMIT 0,12 [ RunTime:0.000432s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:38+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/houseDetail
[ info ] wx.huaxiangxiaobao.com/api/house/houseDetail [运行时间：0.035485s][吞吐率：28.18req/s] [内存消耗：3,528.85kb] [文件加载：46]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'houseDetail',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '21',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'id' => '657',
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\House->houseDetail[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ CACHE ] INIT File
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000433s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001189s ]
[ sql ] [ SQL ] SELECT * FROM `tk_houses` WHERE  `id` = 657 LIMIT 1 [ RunTime:0.000567s ]
[ sql ] [ SQL ] SELECT * FROM `tk_houses` WHERE  `id` = 657 LIMIT 1 [ RunTime:0.000383s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000693s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 35 LIMIT 1 [ RunTime:0.000245s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 35 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_view_history` [ RunTime:0.000562s ]
[ sql ] [ SQL ] DELETE FROM `xcx_view_history`    WHERE  `vh_userid` = 59  AND `vh_house_id` = 657  AND `vh_type` = 1 [ RunTime:0.001074s ]
[ sql ] [ SQL ] UPDATE `tk_houses`  SET `view`=view+1  WHERE  `id` = 657 [ RunTime:0.000291s ]
[ sql ] [ SQL ] INSERT INTO `xcx_view_history` (`vh_userid` , `vh_house_id` , `vh_type` , `vh_add_time`) VALUES (59 , 657 , 1 , '2020-07-07 13:53:38') [ RunTime:0.000233s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:38+08:00 ] 172.31.0.173 123.139.92.38 POST //api/user/getShare
[ info ] wx.huaxiangxiaobao.com//api/user/getShare [运行时间：0.541093s][吞吐率：1.85req/s] [内存消耗：1,851.61kb] [文件加载：33]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'user',
2 => 'getShare',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '21',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'id' => '657',
'type' => 1,
)
[ info ] [ RUN ] app\api\controller\User->getShare[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/User.php ]
[ info ] [ LOG ] INIT File
[ error ] [8]未定义数组索引: errcode[/www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/User.php:433]
---------------------------------------------------------------
[ 2020-07-07T13:53:43+08:00 ] 172.31.0.173 103.138.53.91 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.089717s][吞吐率：11.15req/s] [内存消耗：2,931.86kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,zh-TW;q=0.6',
'cookie' => 'PHPSESSID=91tcimbv76snu11c0vou8rlui7; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086920; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086920; Hm_lpvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086951; Hm_lpvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086951',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000403s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000860s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 3 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 3 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 41 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 41 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000396s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000744s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000260s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000643s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 6  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000492s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 7  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 8  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 9  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 13  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000472s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 15  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 16  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000437s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 17  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000484s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 18  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 22  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 23  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000463s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 24  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 25  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 29  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 32  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 34  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 36  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 37  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000431s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 38  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 42  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000490s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 43  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 44  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 45  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 47  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 48  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000251s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 66  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 67  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 72  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 73  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000461s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 74  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000460s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 81  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000433s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 83  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 85  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 88  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000427s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000230s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 92  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 106  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000438s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 108  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 113  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 164  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 166  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000437s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 193  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 196  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000432s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 205  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 207  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 211  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 212  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000463s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000234s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 216  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000441s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 229  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000457s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 233  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000454s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 234  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 235  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000431s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000221s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 238  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 245  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 251  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:43+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.036739s][吞吐率：27.22req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000404s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000986s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000281s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000655s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000356s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000253s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000682s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000474s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000469s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000535s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:44+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.026755s][吞吐率：37.38req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000416s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000977s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000285s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000636s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000287s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:45+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.042152s][吞吐率：23.72req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000393s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000964s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000266s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000663s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000388s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000233s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000253s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000629s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000650s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000464s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000238s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000234s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000436s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:45+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.015641s][吞吐率：63.93req/s] [内存消耗：1,706.77kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '263',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 1,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '2020-07-07',
'maxtime' => '2020-08-07',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 入住时间最小值：2020-07-07入住时间最大值2020-08-07
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码1
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and ((live_date >= '2020-07-07' and live_date  <= '2020-08-07')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' )) )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000426s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001204s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and ((live_date >= '2020-07-07' and live_date  <= '2020-08-07')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' )) )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 10,10 [ RunTime:0.002027s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000699s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:45'  WHERE  `id` = 59 [ RunTime:0.000325s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:47+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041935s][吞吐率：23.85req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000373s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000912s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000277s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000637s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000394s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000607s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000496s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000195s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000220s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000543s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000658s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000233s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000213s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000224s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000473s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000555s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:49+08:00 ] 172.31.0.173 123.139.92.38 POST /api/house/getlist
[ info ] wx.huaxiangxiaobao.com/api/house/getlist [运行时间：0.014824s][吞吐率：67.46req/s] [内存消耗：1,706.77kb] [文件加载：29]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'house',
2 => 'getlist',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '263',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'page' => 2,
'keys' => '',
'city' => '墨尔本',
'school' => '',
'area' => '',
'minprice' => '',
'maxprice' => '',
'house_room' => '',
'sex' => '',
'pet' => '',
'type' => '',
'tags' => '',
'toilet' => '',
'house_type' => '',
'lease_term' => '',
'order' => '0',
'uid' => 59,
'mintime' => '2020-07-07',
'maxtime' => '2020-08-07',
'car' => '',
)
[ info ] [ RUN ] app\api\controller\House->getList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/House.php ]
[ info ] 获取房源参数lease_term：
[ info ] 租房价格最大值：
[ info ] 租房价格最小值：
[ info ] 入住时间最小值：2020-07-07入住时间最大值2020-08-07
[ info ] 卧室house_room：
[ info ] 车位car：
[ info ] 前端用户：59进行了翻页，当前页码2
[ info ] [ DB ] INIT mysql
[ info ] 房源列表读取Sql：SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and ((live_date >= '2020-07-07' and live_date  <= '2020-08-07')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' )) )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 20,10
[ sql ] [ DB ] CONNECT:[ UseTime:0.000437s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_houses` [ RunTime:0.001184s ]
[ sql ] [ SQL ] SELECT `id`,`type`,`title`,`house_room`,`area`,`images`,`price`,`toilet`,`furniture`,`home`,`school`,`address`,`tj`,`top`,`mdate`,`tags`,`live_date`,`car`,`thumnail` FROM `tk_houses` WHERE  (  status = 1 and is_del = 1 and city = '墨尔本' and ((live_date >= '2020-07-07' and live_date  <= '2020-08-07')  or ( live_date = '0100-01-01' or live_date = '0000-00-00' )) )  AND `is_del` = 1 ORDER BY top desc,cdate desc LIMIT 20,10 [ RunTime:0.002108s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000704s ]
[ sql ] [ SQL ] UPDATE `tk_user`  SET `mdate`='2020-07-07 13:53:49'  WHERE  `id` = 59 [ RunTime:0.000337s ]
[ info ] [ CACHE ] INIT File
---------------------------------------------------------------
[ 2020-07-07T13:53:53+08:00 ] 172.31.0.173 123.139.92.38 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.036818s][吞吐率：27.16req/s] [内存消耗：3,312.34kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000429s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000972s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000305s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000629s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) [ RunTime:0.000357s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000233s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000644s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000604s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000462s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:54+08:00 ] 172.31.0.173 59.102.57.22 POST //api/msg/unread
[ info ] wx.huaxiangxiaobao.com//api/msg/unread [运行时间：0.025817s][吞吐率：38.73req/s] [内存消耗：2,849.20kb] [文件加载：39]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '12',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; PCT-AL10 Build/HUAWEIPCT-AL10; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/3169 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand0 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/17/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 1421,
)
[ info ] [ RUN ] app\api\controller\Msg->unRead[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000415s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000982s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '1421' LIMIT 1 [ RunTime:0.000283s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000652s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 1421 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 1421 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000276s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:55+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.042893s][吞吐率：23.31req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000427s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.001791s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000279s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000632s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000396s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000627s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000508s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000233s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000196s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000469s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000734s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000643s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:56+08:00 ] 172.31.0.173 103.138.53.91 POST /xcx/index/unread.html
[ info ] wx.huaxiangxiaobao.com/xcx/index/unread.html [运行时间：0.091750s][吞吐率：10.90req/s] [内存消耗：2,931.86kb] [文件加载：40]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'xcx',
1 => 'index',
2 => 'unread',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'content-length' => '0',
'accept' => 'application/json, text/javascript, */*; q=0.01',
'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
'x-requested-with' => 'XMLHttpRequest',
'origin' => 'https://wx.huaxiangxiaobao.com',
'sec-fetch-site' => 'same-origin',
'sec-fetch-mode' => 'cors',
'sec-fetch-dest' => 'empty',
'referer' => 'https://wx.huaxiangxiaobao.com/xcx/index/index.html',
'accept-encoding' => 'gzip, deflate, br',
'accept-language' => 'en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7,zh-TW;q=0.6',
'cookie' => 'PHPSESSID=91tcimbv76snu11c0vou8rlui7; Hm_lvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086920; Hm_lvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086920; Hm_lpvt_8008ab7480dfd17fd4ea2feeeab7da62=1594086951; Hm_lpvt_c5dc69a454dfe9eda1cc61b3eb2a6c2a=1594086951',
'content-type' => '',
)
[ info ] [ PARAM ] array (
)
[ info ] [ SESSION ] INIT array (
'id' => '',
'var_session_id' => '',
'prefix' => 'think',
'type' => '',
'auto_start' => true,
)
[ info ] [ RUN ] app\xcx\controller\Index->unread[ /www/wwwroot/wx.huaxiangxiaobao.com/application/xcx/controller/Index.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000436s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000856s ]
[ sql ] [ SQL ] SELECT `mp_id` FROM `xcx_msg_person` WHERE  (  (mp_u_id = 3 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 3 and mp_ultype = 2 and  mp_isable = 1) or (mp_u_id = 41 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 41 and mp_ultype = 1 and  mp_isable = 1) ) [ RunTime:0.000416s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000825s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000236s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000635s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 6  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000491s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 7  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 8  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 9  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000473s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000307s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 10  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 13  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 15  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000198s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 16  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000499s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000208s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 17  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000193s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 18  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 22  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 23  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 24  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000229s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 25  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000457s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 29  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000466s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 32  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 34  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000478s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000218s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 36  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000442s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 37  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 38  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 42  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 43  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000486s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 44  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000443s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 45  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 47  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000467s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000225s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 48  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 66  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000453s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 67  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000228s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 72  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000205s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 73  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 74  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000468s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000201s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 81  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000451s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000210s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 83  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 85  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000203s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 88  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000458s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 92  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000450s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 106  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000434s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 108  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 113  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000478s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000197s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 164  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 166  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000452s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 193  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000448s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000214s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 196  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000496s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000444s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 205  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000440s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 207  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 211  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000446s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 212  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000229s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 216  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 229  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000463s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000216s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 233  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000206s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 234  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000219s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 235  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000449s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000204s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 238  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000445s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 245  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000457s ]
[ sql ] [ SQL ] SELECT `ad_wechat` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000217s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 251  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 41 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 3 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000447s ]
---------------------------------------------------------------
[ 2020-07-07T13:53:57+08:00 ] 172.31.0.173 123.139.92.38 POST /api/msg/getMsgList
[ info ] wx.huaxiangxiaobao.com/api/msg/getMsgList [运行时间：0.041611s][吞吐率：24.03req/s] [内存消耗：3,335.94kb] [文件加载：41]
[ info ] [ LANG ] /www/wwwroot/wx.huaxiangxiaobao.com/thinkphp/lang/zh-cn.php
[ info ] [ ROUTE ] array (
'type' => 'module',
'module' =>
array (
0 => 'api',
1 => 'msg',
2 => 'getMsgList',
),
)
[ info ] [ HEADER ] array (
'host' => 'wx.huaxiangxiaobao.com',
'connection' => 'keep-alive',
'content-length' => '10',
'charset' => 'utf-8',
'user-agent' => 'Mozilla/5.0 (Linux; Android 10; ELE-AL00 Build/HUAWEIELE-AL00; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2469 MMWEBSDK/200601 Mobile Safari/537.36 MMWEBID/7414 MicroMessenger/7.0.16.1700(0x27001039) Process/appbrand2 WeChat/arm64 NetType/WIFI Language/zh_CN ABI/arm64',
'content-type' => 'application/json',
'accept-encoding' => 'gzip,compress,br,deflate',
'referer' => 'https://servicewechat.com/wx45426a13290ecb64/0/page-frame.html',
)
[ info ] [ PARAM ] array (
'uid' => 59,
)
[ info ] [ RUN ] app\api\controller\Msg->getMsgList[ /www/wwwroot/wx.huaxiangxiaobao.com/application/api/controller/Msg.php ]
[ info ] [ DB ] INIT mysql
[ info ] [ LOG ] INIT File
[ sql ] [ DB ] CONNECT:[ UseTime:0.000413s ] mysql:host=127.0.0.1;port=3306;dbname=wx_huaxiangxiaob;charset=utf8mb4
[ sql ] [ SQL ] SHOW COLUMNS FROM `super_admin` [ RunTime:0.000942s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000279s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_person` [ RunTime:0.000649s ]
[ sql ] [ SQL ] SELECT * FROM `xcx_msg_person` WHERE  (  (mp_u_id = 59 and mp_utype = 1 and mp_isable = 1) or (mp_ul_id = 59 and mp_ultype = 1 and  mp_isable = 1) or (mp_u_id = 1 and mp_utype = 2 and mp_isable = 1) or (mp_ul_id = 1 and mp_ultype = 2 and  mp_isable = 1) ) ORDER BY mp_mod_time desc [ RunTime:0.000435s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000227s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 46 LIMIT 1 [ RunTime:0.000194s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000212s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `xcx_msg_content` [ RunTime:0.000599s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 140  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000470s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000222s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 3 LIMIT 1 [ RunTime:0.000202s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000200s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 199  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000455s ]
[ sql ] [ SQL ] SHOW COLUMNS FROM `tk_user` [ RunTime:0.000680s ]
[ sql ] [ SQL ] SELECT `nickname` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000232s ]
[ sql ] [ SQL ] SELECT `avaurl` FROM `tk_user` WHERE  `id` = 58 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000211s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 250  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000427s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000209s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 2 LIMIT 1 [ RunTime:0.000231s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000207s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 172  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000456s ]
[ sql ] [ SQL ] SELECT `ad_realname` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000215s ]
[ sql ] [ SQL ] SELECT `ad_img` FROM `super_admin` WHERE  `ad_id` = 51 LIMIT 1 [ RunTime:0.000194s ]
[ sql ] [ SQL ] SELECT `ad_id` FROM `super_admin` WHERE  `ad_wechat` = '59' LIMIT 1 [ RunTime:0.000199s ]
[ sql ] [ SQL ] SELECT COUNT(xcx_msg_id) AS tp_count FROM `xcx_msg_content` WHERE  `xcx_msg_mp_id` = 155  AND `xcx_msg_isread` = 2  AND `xcx_msg_isable` = 1  AND (  ( xcx_msg_uid != 59 and xcx_msg_u_type = 1 ) or ( xcx_msg_uid != 1 and  xcx_msg_u_type = 2 ) ) LIMIT 1 [ RunTime:0.000439s ]

