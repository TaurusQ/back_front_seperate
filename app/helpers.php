<?php

/**
 * 获取客户端 ip
 * @return array|false|null|string
 */
function get_client_ip()
{
    static $realip = NULL;
    if ($realip !== NULL) {
        return $realip;
    }
    //判断服务器是否允许$_SERVER
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        //不允许就使用getenv获取
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }

    return $realip;
}

function admin_log_record($user_id, $type, $table_name, $description, $content_data = '', $content_message = '')
{
    if (!$content_message) $content_message = $description;

    return app(App\Models\AdminLog::class)->storeLog([
        'user_id' => $user_id,
        'type' => $type,
        'table_name' => $table_name,
        'ip' => get_client_ip(),
        'description' => $description,
        'content' => [
            'data' => $content_data,
            'message' => $content_message,
        ],
    ]);
}

function pr($str)
{
    if (is_array($str) || is_object($str)) {
        echo '<pre>';
        print_r($str);
        echo '</pre>';
    } else {
        echo $str;
    }
    die;
}

/**
 * 格式化字节大小
 * @param number $size 字节数
 * @param string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '')
{
    if (!$size) return 0;
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}