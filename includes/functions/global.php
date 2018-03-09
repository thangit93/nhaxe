<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/functions/global.php
 * @Createdate 08/14/2014, 03:44 PM
 * @Author Quang Chau Tran (quangchauvn@gmail.com), Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 */
$msl = new mysqli($_CFD['db_host'], $_CFD['db_user'], $_CFD['db_password'], '', $_CFD['db_port']);
$msl->set_charset("utf8");
$_B['con'] = new MysqliDb($msl);
function db_connect($mod = null) {
    global $_BC, $_B, $_L, $_CFD;
    if ($mod == null) {
        $dbm         = get_db_mod('root');
        $_CFD['mod'] = $dbm;
    } else {
        $dbm         = get_db_mod($mod);
        $_CFD['mod'] = $dbm;
    }
}
/**
 * @param  $mod
 * @return mixed
 */
function db_connect_mod($mod) {
    global $_CFD;
    $dbm         = get_db_mod($mod);
    $_CFD['mod'] = $dbm;

    return $dbm;
}
/**
 * @param $idw
 * @param $temp
 */
function set_temp_web($idw, $temp) {
    $web = new Model('web');
    $web->where('idw', $idw);
    $data = array('theme_id' => $temp);
    $web->update($data);
    echo 'SH 150';
}
/**
 * @param  $mod
 * @return mixed
 */
function get_db_mod($mod) {
    if ($mod == 'home' || $mod == 'dns' || $mod == 'sso' || $mod == 'information') {
        return false;
    }
    $file = DIR_MODULES . 'config_db.php';

    if (file_exists($file)) {
        include $file;
    } else {
        include DIR_CONFIG . 'config_db_mod.php';
    }

    return $dbm[$mod];
}
/**
 * @param $mes
 */
function show_error($mes) {
    die($mes);
}
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());

    return ((float) $usec + (float) $sec);
}
/**
 * @param $size
 */
function convert($size) {
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}
/**
 * @return mixed
 */
function curPageURL() {
    global $web;
    $pageURL = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    $curUrl['URI']                  = $_SERVER["REQUEST_URI"];
    $curUrl['URI_Not_dotExtension'] = str_replace($web['dotExtension'], '', $curUrl['URI']);
    $curUrl['fullLink']             = $pageURL;

    return $curUrl;
}
/****************TAGS**************/
/**
 * @param  $id
 * @return mixed
 */
function getTag($id) {
    $db  = db_connect_mod('feedback');
    $oBj = new Model('tags', $db);
    $oBj->where('id', $id);
    $oBj->where('tag', '', '!=');
    $result = $oBj->getOne(null, 'tag,alias');

    return $result;
}
function rewrite() {
    global $_B;
    $url = $_B['customurl'];

    $p = '/^([0-9a-zA-Z\_]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['mod'] = $matches[1][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod'] = $matches[1][0];
        $_GET['p']   = $matches[2][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['p']    = $matches[3][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9\_]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['id']   = $matches[3][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9\_]+)-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['id']   = $matches[3][0];
        $_GET['p']    = $matches[4][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['sub']  = $matches[3][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['sub']  = $matches[3][0];
        $_GET['p']    = $matches[4][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9\_]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['sub']  = $matches[3][0];
        $_GET['id']   = $matches[4][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9\_]+)-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {

        $_GET['mod']  = $matches[1][0];
        $_GET['page'] = $matches[2][0];
        $_GET['sub']  = $matches[3][0];
        $_GET['id']   = $matches[4][0];
        $_GET['p']    = $matches[5][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9]{0,2})$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['mod']   = $matches[1][0];
        $_GET['page']  = $matches[2][0];
        $_GET['sub']   = $matches[3][0];
        $_GET['limit'] = $matches[4][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9]{0,2})-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['mod']   = $matches[1][0];
        $_GET['page']  = $matches[2][0];
        $_GET['sub']   = $matches[3][0];
        $_GET['limit'] = $matches[4][0];
        $_GET['p']     = $matches[5][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9\_]+)-([0-9]{0,2})$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['mod']   = $matches[1][0];
        $_GET['page']  = $matches[2][0];
        $_GET['sub']   = $matches[3][0];
        $_GET['id']    = $matches[4][0];
        $_GET['limit'] = $matches[5][0];

        return true;
    }
    $p = '/^([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9a-zA-Z\_]+)-([0-9\_]+)-([0-9]{0,2})-p([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['mod']   = $matches[1][0];
        $_GET['page']  = $matches[2][0];
        $_GET['sub']   = $matches[3][0];
        $_GET['id']    = $matches[4][0];
        $_GET['limit'] = $matches[5][0];
        $_GET['p']     = $matches[6][0];

        return true;
    }
    $p = '/^api\/([a-zA-Z0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['api'] = $matches[1][0];

        return true;
    }
    $p = '/^api\/([a-zA-Z0-9]+)\/([0-9]+)$/';
    if (preg_match($p, $url, $matches, PREG_OFFSET_CAPTURE)) {
        $_GET['api'] = $matches[1][0];
        $_GET['id']  = $matches[2][0];

        return true;
    }

    return false;
}

function seoRewrite() {
    global $_B;
    /**sub-page-id
    sub = 1: View
    sub = 2: category
    page = module
     **/

    return true;
    if (isset($_GET['customurl'])) {
        $module  = $_GET['mod'];
        $sub     = $_GET['sub'];
        $modules = array(
            1 => array(
                'mod' => 'product',
                1     => array('page' => 'product', 'sub' => 'detail'),
                2     => array('page' => 'product', 'sub' => 'category'),
                3     => array('page' => 'product', 'sub' => 'brand'),
                4     => array('page' => 'product', 'sub' => 'auction'),
                5     => array('page' => 'product', 'sub' => 'auctionitem'),
                6     => array('page' => 'product', 'sub' => 'deal'),
                7     => array('page' => 'product', 'sub' => 'dealItem'),
            ),
            2 => array(
                'mod' => 'news',
                1     => array('page' => 'detail', 'sub' => 'view'),
                2     => array('page' => 'category', 'sub' => 'cat'),
            ),
            3 => array(
                'mod' => 'album',
                1     => array('page' => 'detail', 'sub' => 'view'),
                //2     => array('page' => 'album', 'sub' => null),
                2     => array('page' => 'category', 'sub' => null),
                3     => array('page' => 'category', 'sub' => 'album'),
            ),
            4 => array(
                'mod' => 'video',
                1     => array('page' => 'detail', 'sub' => 'view'),
                2     => array('page' => 'album', 'sub' => null),
            ),
            5 => array(
                'mod' => 'recruit',
                1     => array('page' => 'detail', 'sub' => 'view'),
                2     => array('page' => 'detail', 'sub' => 'profile'),
                3     => array('page' => 'home', 'sub' => 'recruit'),
            ),
            6 => array(
                'mod' => 'deal',
                1     => array('page' => 'detail', 'sub' => 'index'),
                2     => array('page' => 'category', 'sub' => 'index'),
            ),
            7 => array(
                'mod' => 'category',
                1     => array('page' => 'detail', 'sub' => 'view'),
                3     => array('page' => 'category', 'sub' => 'index'),
            ),
            8 => array(
                'mod' => 'info',
                1     => array('page' => 'detail', 'sub' => 'view'),
                //2     => array('page'=>'album','sub'=> null),
            ),
            9 => array(
                'mod' => 'video',
                1     => array('page' => 'detail', 'sub' => 'view'),
            ),
        );
        if (array_key_exists($module, $modules)) {
            $module       = $modules[$module];
            $_GET['mod']  = $module['mod'];
            $_GET['page'] = $module[$sub]['page'];
            $_GET['sub']  = $module[$sub]['sub'];

        } else {
            rewrite();
        }

    }
}
/**
 * @param  $domain
 * @return mixed
 */
function getWebNameByDomain($domain) { 
    if (substr($domain, -9) == '.nhaxe.vn') {
        $w = str_replace('.nhaxe.vn', '', $domain);

        return $w;
        // return $w;
    } 
    $webObj = new Model('web');
    $webObj->where('domain', '%,' . $domain . ',%', 'LIKE');
    $web = $webObj->getOne();

    if ($web != null) {
        return $web['s_name'];
    } else {
        return 'demo';
    }
}
/**
 * @return mixed
 */
function curDomain() {
    $domain = $_SERVER['HTTP_HOST'];
    //$domain = str_replace('www.', '', $domain);

    return $domain;
}
/**
 * @param  $key
 * @param  array   $vars
 * @return mixed
 */
function lang($key, $vars = array()) {
    global $_L;
    if (isset($_L[$key])) {
        if (!is_array($vars)) {
            $vars = explode(',', $vars);
        }
        $result = lang_replace($_L[$key], $vars);
    } else {
        $result = '{' . $key . '}';
    }

    return $result;
}
/**
 * @param  $text
 * @param  $vars
 * @return mixed
 */
function lang_replace($text, $vars) {
    global $_L;
    if ($vars) {
        foreach ($vars as $k => $v) {
            $rk   = $k + 1;
            $text = str_replace('\\' . $rk, $v, $text);
        }
    }
    $key = explode('%%', $text);
    if (count($key) > 2) {
        $key  = $key[1];
        $text = str_replace('%%' . $key . '%%', $_L[$key], $text);
    }

    return $text;
}
/**
 * color_hex2rgb()
 *
 * @param    mixed $hex
 * @return
 */
function color_hex2rgb($hex) {
    if (preg_match("/[^0-9ABCDEFabcdef]/", $hex[1])) {
        return $hex[0];
    }

    $color = $hex[1];
    $l     = strlen($color);
    if ($l != 3 && $l != 6) {
        return $hex[0];
    }

    $l = $l / 3;

    return "rgb(" . (hexdec(substr($color, 0, 1 * $l))) . ", " . (hexdec(substr($color, 1 * $l, 1 * $l))) . ", " . (hexdec(substr($color, 2 * $l, 1 * $l))) . ");";
}
/**
 * @param  $value
 * @return mixed
 */
function show_ss($value) {
    $tmp = $_SESSION[$value];
    unset($_SESSION[$value]);

    return $tmp;
}
/**
 * getIp()
 * @return $ip
 */
function getIp() {
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (validateIp($ip)) {
                    return $ip;
                }
            }
        }
    }

    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}
/**
 * @param $ip
 */
function validateIp($ip) {
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }

    return true;
}

/**
 * @param  $string
 * @param  $key
 * @return mixed
 */
function encode($string, $key) {
    $key    = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $hash   = '';
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        $j      = ($keyLen > 0) ? $keyLen : 0;
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }

    return $hash;
}

/**
 * @param  $string
 * @param  $key
 * @return mixed
 */
function decode($string, $key) {
    $key    = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $hash   = '';
    for ($i = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        $j      = ($keyLen > 0) ? $keyLen : 0;
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }

    return $hash;
}

/**
 * @param  $date
 * @return mixed
 */
function setDate($date) {
    $newDate = date("H:i:s d-m-Y", strtotime($date));

    return $newDate;
}

/**
 * @param  $memcache
 * @param  $rule
 * @param  null        $action
 * @return mixed
 */
function getMemcacheKeys($memcache, $rule = null, $action = null) {
    $list     = array();
    $allSlabs = $memcache->getExtendedStats('slabs');
    $items    = $memcache->getExtendedStats('items');
    foreach ($allSlabs as $server => $slabs) {
        foreach ($slabs AS $slabId => $slabMeta) {
            $cdump = $memcache->getExtendedStats('cachedump', (int) $slabId);
            foreach ($cdump AS $keys => $arrVal) {
                if (!is_array($arrVal)) {
                    continue;
                }

                foreach ($arrVal AS $k => $v) {
                    if ($action != null) {
                        $keyy[] = $k;
                    } elseif ($action == 'delete') {
                        if (preg_match($rule, $k)) {
                            $memcache->delete($k);
                            $keyy[] = $k;
                        } else {
                            $memcache->delete($k);
                        }
                    }
                }
            }
        }
    }
    asort($keyy);

    return $keyy;
}
/**
 * @param $flash
 * @param $width
 * @param $height
 */
function loadFlash($flash, $width, $height) {
    global $_B;

    return HTTP_STATIC . $flash;
}
/**
 * @param  $img
 * @param  $op
 * @param  $width
 * @param  null     $height
 * @param  null     $temp
 * @return mixed
 */
function loadImage($img, $op = 'resize', $width = null, $height = null, $temp = false) {
    global $_B, $web, $mod;

    $HTTP_STATIC        = $_B['upload_path'];
    $HTTP_STATIC_RESIZE = HTTP_STATIC_RESIZE;
    
    

    
    if ($op == 'resize' || $op == 'crop') {
        if ($width == false || $height == false) {
            // header("HTTP/1.0 404 Not Found");
            return false;
        } elseif ($img == '0' || empty($img)) {
            $thumb = $HTTP_STATIC . 'uploadv2/web/1/1/noimage.gif' . '&mode=' . $op . '&size=' . $width . 'x' . $height;
        } else {
            if ($temp == true) {
                $url   = $HTTP_STATIC . $img . '_' . $op . $width . 'x' . $height . '.jpg'; //.$typeImage;
                $thumb = 'src="' . $url . '" onerror="this.onerror=null;this.src=\'' . $HTTP_STATIC_RESIZE . $img . '&mode=' . $op . '&size=' . $width . 'x' . $height . '\'"';
            } else {
                $thumb = $HTTP_STATIC . $img;
            }
        }

        return $thumb;
    } else if ($op == 'none') {
        //Module Album sẽ ảnh hưởng bởi plugin
        if ($temp == false) {
            $thumb = $HTTP_STATIC . $img;
        } else {
            $thumb = 'src="' . $HTTP_STATIC . $img . '"';
        }

        return $thumb;
    }
}

/**
 * @param  $webs
 * @param  $mod
 * @param  $page
 * @param  $sub
 * @param  null    $id
 * @param  null    $alias
 * @param  null    $notRewrite
 * @param  null    $menu
 * @return mixed
 */
function linkUrl($webs, $mod, $page, $sub = null, $id = null, $alias = null, $notRewrite = null, $menu = false) {
    global $_B, $web;
    if (isset($web)) {
        $webs = $web;
    }
    if ($webs['ssl'] == true) {
        $url = 'https://';
    } else {
        $url = 'http://';
    }
    $seo_id = null;
    if (isset($id)) {
        $ids    = '-' . $id;
        $seo_id = explode('_', $id);
        $seo_id = (isset($seo_id[1])) ? $seo_id[1] : $seo_id[0];
    } else {
        $ids = null;
    }
    if ($sub != null) {
        $subs = '-' . $sub;
    } else {
        $subs = null;
    }
    if (!isset($webs['seo_url'])) {
        $seo_url = 1;
    } else {
        $seo_url = $webs['seo_url'];
    }

    $newUrl = "";
    if ($notRewrite != null) {
        $newUrl = $url . $webs['home'] . '/' . $mod . '-' . $page . $subs . $ids . strtolower($webs['dotExtension']);

        return $newUrl;
        exit();
    }
    if ($seo_url == 1) {
        $dataUrl = array(
            'mod'  => $mod,
            'page' => $page,
            'subs' => $subs,
            'ids'  => $ids,
        );
        switch ($mod) {
        case 'product':
            if ($page == 'product' && $sub == 'detail') {
                $newUrl = rewriteMod($mod, $webs, 'vi_product_basic', $seo_id, '1-1', $dataUrl, $alias, $menu);
            } else if ($page == 'product' && $sub == 'brand') {
                $newUrl = rewriteMod($mod, $webs, 'vi_brand', $seo_id, '3-1', $dataUrl, $alias, $menu);
            } else if ($page == 'product' && $sub == 'auction') {
                //Dau gia
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '4-1', $dataUrl, $alias, $menu);
            } else if ($page == 'product' && $sub == 'auctionItem') {
                //Dau gia
                $newUrl = rewriteMod($mod, $webs, 'vi_product_basic', $seo_id, '5-1', $dataUrl, $alias, $menu);
            } else if ($page == 'product' && $sub == 'deal') {
                //Deal
                $newUrl = rewriteMod($mod, $webs, 'vi_product_basic', $seo_id, '6-1', $dataUrl, $alias, $menu);
            } else if ($page == 'product' && $sub == 'dealItem') {
                //Deal
                $newUrl = rewriteMod($mod, $webs, 'vi_product_basic', $seo_id, '7-1', $dataUrl, $alias, $menu);
            } else if ($page == 'product' && $sub == 'category') {
                //Deal
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '2-1', $dataUrl, $alias, $menu);
            } else {
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '8-1', $dataUrl, $alias, $menu);
            }
            break;
        case 'news':
            if ($page == 'detail' && $sub == 'view') {
                $newUrl = rewriteMod($mod, $webs, 'vi_news', $seo_id, '1-2', $dataUrl, $alias, $menu);
            } else {
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '2-2', $dataUrl, $alias, $menu);
            }
            break;
        case 'album':
            if ($page == 'detail' && $sub == 'view') {
                $newUrl = rewriteMod($mod, $webs, 'vi_album', $seo_id, '1-3', $dataUrl, $alias, $menu);
            } elseif ($page == 'category' && $sub == 'album') {
                $newUrl = rewriteMod($mod, $webs, 'vi_album_category', $seo_id, '3-3', $dataUrl, $alias, $menu);
            } else {
                $newUrl = rewriteMod($mod, $webs, 'vi_album_category', $seo_id, '2-3', $dataUrl, $alias, $menu);
            }
            break;
        case 'recruit':
            if ($page == 'detail' && $sub == 'view') {
                $newUrl = rewriteMod($mod, $webs, 'vi_recruit', $seo_id, '1-5', $dataUrl, $alias, $menu);
            } elseif ($page == '' && $sub == '') {
                $newUrl = rewriteMod($mod, $webs, 'vi_recruit', $seo_id, '3-5', $dataUrl, $alias, $menu);
            }
            break;
        case 'deal': //6
            if ($page == 'detail' && $sub == 'index') {
                $newUrl = rewriteMod($webs, 'vi_basic', $seo_id, '1-6', $dataUrl, $alias, $menu);
            } else if ($page == 'category' && $sub == 'index') {
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '2-6', $dataUrl, $alias, $menu);
            }
            break;
        case 'category': //7
            if ($page == 'detail' && $sub == 'view') {
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '1-7', $dataUrl, $alias, $menu);
            } elseif ($page == '' && $sub == '') {
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '2-7', $dataUrl, $alias, $menu);
            }
            break;

        case 'info': //8
            if ($page == 'detail' && $sub == 'view') {
                $newUrl = rewriteMod($mod, $webs, 'vi_info', $seo_id, '1-8', $dataUrl, $alias, $menu);
            } elseif ($page == 'info' && $sub == '') {
                $newUrl = rewriteMod($mod, $webs, 'vi_info', $seo_id, '2-8', $dataUrl, $alias, $menu);
            } elseif ($page == '' && $sub == '') {
                $newUrl = rewriteMod($mod, $webs, 'vi_info', $seo_id, '2-8', $dataUrl, $alias, $menu);

            }
            break;
        case 'video': //9
            if ($page == 'detail' && $sub == 'view') {
                $newUrl = rewriteMod($mod, $webs, 'vi_video', $seo_id, '1-9', $dataUrl, $alias, $menu);

            } elseif ($page == 'category' && $sub == 'cat') {
                $newUrl = rewriteMod($mod, $webs, 'vi_category', $seo_id, '2-9', $dataUrl, $alias, $menu);
            }
            break;
        default:
            $newUrl = $url . $webs['home'] . '/' . $mod . '-' . $page . $subs . $ids . strtolower($webs['dotExtension']);
            break;
        }

    } else {
        $newUrl = $url . $webs['home'] . '/' . $mod . '-' . $page . $subs . $ids;
        $newUrl = explode('-', $newUrl);
        foreach ($newUrl as $k => $v) {
            if (trim($v) == '') {
                unset($newUrl[$k]);
            }
        }
        $newUrl = implode('-', $newUrl) . strtolower($webs['dotExtension']);
    }
    // if ($mod == 'product' && $page != 'shopfb' && $_B['r']->get_string('sitemap', 'GET') != 'product') {
    //     $newUrl .= '" onclick="analyticsClick(this)';
    // }
    $newUrl = str_replace('-.html', '.html', $newUrl);

    return $newUrl;
}
/**
 * @param  $mod
 * @param  $webs
 * @param  $table
 * @param  $id
 * @param  $type
 * @param  array    $dataUrl
 * @param  $alias
 * @param  null     $menu
 * @return mixed
 */
function rewriteMod($mod, $webs, $table, $id, $type, $dataUrl = array(), $alias = null, $menu = null) {
    global $web;
    if ($webs['ssl'] == true) {
        $url = 'https://';
    } else {
        $url = 'http://';
    }

    if(empty($webs['dotExtension'])){
        $webs['dotExtension'] = '.html';
    }

    if ($menu != null) {
        $db_mod = db_connect_mod($dataUrl['mod']);
        $model  = new Model($mod . '.' . $table, $db_mod);
        $model->where('id', $id);
        $p = $model->getOne(null, 'alias');
        if (!empty($p['alias'])) {
            $alias  = fixTitle($p['alias']) . '-' . $type . '-' . $id . $webs['dotExtension'];
            $newUrl = $url . $webs['home'] . '/' . $alias;
        } else {
            $mod    = ($dataUrl['mod'] == 'home') ? "" : strtolower($dataUrl['mod']);
            $newUrl = $url . $webs['home'] . '/' . $mod . '-' . strtolower($dataUrl['page']) . $dataUrl['subs'] . $dataUrl['ids'] . strtolower($webs['dotExtension']);
        }
    } else {

        if ($alias == '') {
            $alias = $web['s_name'] . '-website';
        }
        // $alias  = fixTitle($alias) . '-' . $type . '-' . $id . $webs['dotExtension'];
        // $newUrl = $url . $webs['home'] . '/' . $alias;
        // $mod    = ($dataUrl['mod'] == 'home') ? "" : strtolower($dataUrl['mod']);
        // $newUrl = $url . $webs['home'] . '/' . $mod . '-' . strtolower($dataUrl['page']) . $dataUrl['subs'] . $dataUrl['ids'] . strtolower($webs['dotExtension']);

        $alias = $alias . '-' . $type . '-' . $id . $webs['dotExtension'];
        $alias = str_replace('-.html', '.html', $alias);

        $newUrl = $url . $webs['home'] . '/' . $alias;
    }

    return $newUrl;
}
/**
 * @param  $limit
 * @param  $total
 * @param  $href
 * @param  null     $max_item
 * @return mixed
 */
function pagination($limit, $total, $href = null, $max_item = null) {
    global $_B;
    include_once DIR_CLASS . "pagination.php";
    if ($href == null) {
        $href = $_B['curUrl']['URI_Not_dotExtension'];
        $rule = '/-p[0-9]+$/';
        $href = preg_replace($rule, '', $href);
    }

    $pagination = new Pagination($href, $limit, $total, $max_item = 10);

    return $pagination->pagination;
}

/**
 * @param $date
 */
function date_to_timestamp($date) {
    $date = explode('-', $date);

    return mktime(0, 0, 0, (int) $date[1], (int) $date[0], (int) $date[2]);
}

function genCaptcha() {
    session_start();
    header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $ranStr              = getRandomWord();
    $_SESSION["captcha"] = strtolower($ranStr);
    $height              = 35; //CAPTCHA image height
    $width               = 150; //CAPTCHA image width
    $font_size           = 24;
    $image_p             = imagecreate($width, $height);
    $graybg              = imagecolorallocate($image_p, 245, 245, 245);
    $textcolor           = imagecolorallocate($image_p, 34, 34, 34);
    ob_clean();
    header('Content-Type: image/png');
    imagefttext($image_p, $font_size, -2, 15, 26, $textcolor, DIR_FUNS . 'mono.ttf', $ranStr);
    imagepng($image_p);
    imagedestroy($image_p);
}
/**
 * @param $cap
 */
function checkCaptcha($cap) {
    if ($_SESSION['captcha'] == strtolower($cap)) {
        return true;
    } else {
        return false;
    }

}
/**
 * @param $len
 */
function getRandomWord($len = 5) {
    $word = array_merge(range('0', '9'), range('a', 'z'));
    shuffle($word);

    return substr(implode($word), 0, $len);
}

function genQRcode() {
    global $web;
    echo "123";
    //echo file_get_contents('https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl='.$web['home_url'].'&choe=UTF-8');
    // ob_start();
    // include DIR_HELPER . 'phpqrcode/qrlib.php';
    // include DIR_HELPER . 'phpqrcode/qrconfig.php';
    // ob_start("callback");
    // ob_end_clean();
    // QRcode::png($web['home_url'], false, QR_ECLEVEL_L, 5);

}
/**
 * @param $data
 */
function genQRcodeProduct($data) {
    global $web, $_B;
    ob_start();
    include DIR_HELPER . 'phpqrcode/qrlib.php';
    include DIR_HELPER . 'phpqrcode/qrconfig.php';

    $addressLabel = 'Product';
    $addPrice     = $data['price'];
    // we building raw data
    $codeContents = 'BEGIN:VCARD' . "\n";
    $codeContents .= 'VERSION:2.1' . "\n";
    //$codeContents .= 'N:'.$sortName."\n";
    //$codeContents .= 'FN:'.$name."\n";
    //$codeContents .= 'ORG:'.$orgName."\n";

    // $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
    // //$codeContents .= 'TEL;HOME;VOICE:'.$phonePrivate."\n";
    // $codeContents .= 'TEL;TYPE=cell:'.$phoneCell."\n";

    $codeContents .= 'ORG:' . $data['name'] . "\n";
    //$codeContents .= 'EMAIL:'.$email."\n";
    $codeContents .= 'URL:' . $_B['curUrl'] . "\n";
    //$codeContents .= 'TEL;TYPE=cell:'.$i['phone']."\n";
    $codeContents .= 'ADR;TYPE=work;' .
        'LABEL="' . $addressLabel . '":'
        . $addPrice . ';'
        . "\n";
    //$codeContents .= 'PHOTO;JPEG;ENCODING=BASE64:'.base64_encode(file_get_contents($data['image']))."\n";
    $codeContents .= 'END:VCARD';

    // generating
    //QRcode::png($codeContents, $tempDir.'026.png', QR_ECLEVEL_L, 3);
    //QRcode::png($codeContents,false,QR_ECLEVEL_L, 2);
    ob_start("callback");
    // $debugLog = ob_get_contents();
    ob_end_clean();
    QRcode::png($data['url'], false, QR_ECLEVEL_L, 2);

}

/**
 * convertStdClassToArray($obj): Chuyển từ object về obj
 * @Createdate //, : [ AM]
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 */

function convertStdClassToArray($array) {
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = convertStdClassToArray($value);
            }
            if ($value instanceof stdClass) {
                $array[$key] = convertStdClassToArray((array) $value);
            }
        }
    }
    if ($array instanceof stdClass) {
        return convertStdClassToArray((array) $array);
    }

    return $array;
}

/**
 * @param  $data
 * @return mixed
 */
function sendMail($data, $from = 'noreply@webbnc.net', $reply = 'info@webbnc.net') {
    global $_B, $web;
    return false;
    //Setting config send mail
    $nbhMail['host'] = '';
    $nbhMail['port'] = 587;
    $nbhMail['user'] = '';
    $nbhMail['pass'] = '';
 

    $nbhMail['from']      = $from;
    $nbhMail['name_from'] = isset($data['shop_name']) ? $data['shop_name'] : $web['info']['business'];
    //$nbhMail['name_from']  = $web['info']['business'];
    $nbhMail['reply']      = $reply;
    $nbhMail['name_reply'] = 'Webbnc.vn';
    $nbhMail['altBody']    = 'Mail được gửi từ hệ thống mailbnc.vn';

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    require_once DIR_HELPER . 'PHPMailer52/PHPMailerAutoload.php';
    if (isset($data) && $data['type'] == 'SMTP') {
        //Create a new PHPMailer instance
        $mail          = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        //Tell PHPMailer to use SMTP
        if ($_B['mail_smtp'] == true) {
            $mail->isSMTP();
            $mail->SMTPSecure = "tls";
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = $data['debug'];
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            $mail->SMTPAuth    = true;
            //Set the hostname of the mail server
            $mail->Host = $nbhMail['host'];
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = $nbhMail['port'];
            //Whether to use SMTP authentication

            $mail->Username = $nbhMail['user'];
            $mail->Password = $nbhMail['pass'];
            if ($data['multi'] == true) {
                // SMTP connection will not close after each email sent, reduces SMTP overhead
                $mail->SMTPKeepAlive = true;
            }
        }

        //Set who the message is to be sent from
        $mail->setFrom($nbhMail['from'], $nbhMail['name_from']);
        //Set an alternative reply-to address
        $mail->addReplyTo($nbhMail['reply'], $nbhMail['name_reply']);
        //Cc mail
        if (isset($data['addCC'])) {
            $mail->addCC($data['addCC'][0], $data['addCC'][1]);
        }
        //Set the subject line
        $mail->Subject = $data['subject'];
        $mail->isHTML(true);
        $mail->Body = $data['content'];
        //Replace the plain text body with one created manually
        $mail->AltBody = $nbhMail['altBody'];
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        if ($data['multi'] == true) {
            foreach ($data['arrayAddAddress'] as $key => $value) {
                //Set who the message is to be sent to
                $mail->addAddress($key, $value);
                if (!$mail->send()) {
                    $result['message'] = "Emai:" . $key . "---" . $mail->ErrorInfo;
                    $result['status']  = false;
                } else {
                    $result['message'] = "Emai:" . $key . "---" . 'Send mail success !';
                    $result['status']  = true;
                }
            }
        } else {
            //Set who the message is to be sent to
            $mail->addAddress($data['addAddress'][0], $data['addAddress'][1]);
            //  if ($_COOKIE['sv']) {
            //     var_dump($mail);
            // }
            if (!$mail->send()) {
                $result['message'] = $mail->ErrorInfo;
                $result['status']  = false;
            } else {
                $result['message'] = 'Send mail success !';
                $result['status']  = true;
            }
        }

        return $result;

    }
}

/**
 * @param  $title
 * @param  $strtolower
 * @return mixed
 */
function fixTitle($title, $strtolower = true) {
    $title    = strtolower_utf8($title);
    $marTViet = array(' ', 'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă',
        'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ', 'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề'
        , 'ế', 'ệ', 'ể', 'ễ',
        'ì', 'í', 'ị', 'ỉ', 'ĩ',
        'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ'
        , 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
        'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
        'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
        'đ',
        'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă'
        , 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
        'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
        'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
        'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ'
        , 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
        'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
        'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
        'Đ', '?', "'", ',', '\'', '/', '&', ':');

    $marKoDau = array('-', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'
        , 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
        'i', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'
        , 'o', 'o', 'o', 'o', 'o',
        'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
        'y', 'y', 'y', 'y', 'y',
        'd',
        'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A'
        , 'A', 'A', 'A', 'A', 'A',
        'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
        'I', 'I', 'I', 'I', 'I',
        'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O'
        , 'O', 'O', 'O', 'O', 'O',
        'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
        'Y', 'Y', 'Y', 'Y', 'Y',
        'D', '', '', '', '', '', '', ':');
    $title = str_replace($marTViet, $marKoDau, $title);
    $title = preg_replace("/(\-)+/i", '-', $title);
    $title = preg_replace('/[^a-z\-_]/', '', $title);
    if ($strtolower == true) {
        return utf8_strtolower($title);
    } else {
        return $title;
    }
}
/**
 * @param $string
 */
function utf8_strtolower($string) {
    /**
     * @var mixed
     */
    static $upper_to_lower;

    if ($upper_to_lower == null) {
        $upper_to_lower = array(
            0x0041 => 0x0061,
            0x03A6 => 0x03C6,
            0x0162 => 0x0163,
            0x00C5 => 0x00E5,
            0x0042 => 0x0062,
            0x0139 => 0x013A,
            0x00C1 => 0x00E1,
            0x0141 => 0x0142,
            0x038E => 0x03CD,
            0x0100 => 0x0101,
            0x0490 => 0x0491,
            0x0394 => 0x03B4,
            0x015A => 0x015B,
            0x0044 => 0x0064,
            0x0393 => 0x03B3,
            0x00D4 => 0x00F4,
            0x042A => 0x044A,
            0x0419 => 0x0439,
            0x0112 => 0x0113,
            0x041C => 0x043C,
            0x015E => 0x015F,
            0x0143 => 0x0144,
            0x00CE => 0x00EE,
            0x040E => 0x045E,
            0x042F => 0x044F,
            0x039A => 0x03BA,
            0x0154 => 0x0155,
            0x0049 => 0x0069,
            0x0053 => 0x0073,
            0x1E1E => 0x1E1F,
            0x0134 => 0x0135,
            0x0427 => 0x0447,
            0x03A0 => 0x03C0,
            0x0418 => 0x0438,
            0x00D3 => 0x00F3,
            0x0420 => 0x0440,
            0x0404 => 0x0454,
            0x0415 => 0x0435,
            0x0429 => 0x0449,
            0x014A => 0x014B,
            0x0411 => 0x0431,
            0x0409 => 0x0459,
            0x1E02 => 0x1E03,
            0x00D6 => 0x00F6,
            0x00D9 => 0x00F9,
            0x004E => 0x006E,
            0x0401 => 0x0451,
            0x03A4 => 0x03C4,
            0x0423 => 0x0443,
            0x015C => 0x015D,
            0x0403 => 0x0453,
            0x03A8 => 0x03C8,
            0x0158 => 0x0159,
            0x0047 => 0x0067,
            0x00C4 => 0x00E4,
            0x0386 => 0x03AC,
            0x0389 => 0x03AE,
            0x0166 => 0x0167,
            0x039E => 0x03BE,
            0x0164 => 0x0165,
            0x0116 => 0x0117,
            0x0108 => 0x0109,
            0x0056 => 0x0076,
            0x00DE => 0x00FE,
            0x0156 => 0x0157,
            0x00DA => 0x00FA,
            0x1E60 => 0x1E61,
            0x1E82 => 0x1E83,
            0x00C2 => 0x00E2,
            0x0118 => 0x0119,
            0x0145 => 0x0146,
            0x0050 => 0x0070,
            0x0150 => 0x0151,
            0x042E => 0x044E,
            0x0128 => 0x0129,
            0x03A7 => 0x03C7,
            0x013D => 0x013E,
            0x0422 => 0x0442,
            0x005A => 0x007A,
            0x0428 => 0x0448,
            0x03A1 => 0x03C1,
            0x1E80 => 0x1E81,
            0x016C => 0x016D,
            0x00D5 => 0x00F5,
            0x0055 => 0x0075,
            0x0176 => 0x0177,
            0x00DC => 0x00FC,
            0x1E56 => 0x1E57,
            0x03A3 => 0x03C3,
            0x041A => 0x043A,
            0x004D => 0x006D,
            0x016A => 0x016B,
            0x0170 => 0x0171,
            0x0424 => 0x0444,
            0x00CC => 0x00EC,
            0x0168 => 0x0169,
            0x039F => 0x03BF,
            0x004B => 0x006B,
            0x00D2 => 0x00F2,
            0x00C0 => 0x00E0,
            0x0414 => 0x0434,
            0x03A9 => 0x03C9,
            0x1E6A => 0x1E6B,
            0x00C3 => 0x00E3,
            0x042D => 0x044D,
            0x0416 => 0x0436,
            0x01A0 => 0x01A1,
            0x010C => 0x010D,
            0x011C => 0x011D,
            0x00D0 => 0x00F0,
            0x013B => 0x013C,
            0x040F => 0x045F,
            0x040A => 0x045A,
            0x00C8 => 0x00E8,
            0x03A5 => 0x03C5,
            0x0046 => 0x0066,
            0x00DD => 0x00FD,
            0x0043 => 0x0063,
            0x021A => 0x021B,
            0x00CA => 0x00EA,
            0x0399 => 0x03B9,
            0x0179 => 0x017A,
            0x00CF => 0x00EF,
            0x01AF => 0x01B0,
            0x0045 => 0x0065,
            0x039B => 0x03BB,
            0x0398 => 0x03B8,
            0x039C => 0x03BC,
            0x040C => 0x045C,
            0x041F => 0x043F,
            0x042C => 0x044C,
            0x00DE => 0x00FE,
            0x00D0 => 0x00F0,
            0x1EF2 => 0x1EF3,
            0x0048 => 0x0068,
            0x00CB => 0x00EB,
            0x0110 => 0x0111,
            0x0413 => 0x0433,
            0x012E => 0x012F,
            0x00C6 => 0x00E6,
            0x0058 => 0x0078,
            0x0160 => 0x0161,
            0x016E => 0x016F,
            0x0391 => 0x03B1,
            0x0407 => 0x0457,
            0x0172 => 0x0173,
            0x0178 => 0x00FF,
            0x004F => 0x006F,
            0x041B => 0x043B,
            0x0395 => 0x03B5,
            0x0425 => 0x0445,
            0x0120 => 0x0121,
            0x017D => 0x017E,
            0x017B => 0x017C,
            0x0396 => 0x03B6,
            0x0392 => 0x03B2,
            0x0388 => 0x03AD,
            0x1E84 => 0x1E85,
            0x0174 => 0x0175,
            0x0051 => 0x0071,
            0x0417 => 0x0437,
            0x1E0A => 0x1E0B,
            0x0147 => 0x0148,
            0x0104 => 0x0105,
            0x0408 => 0x0458,
            0x014C => 0x014D,
            0x00CD => 0x00ED,
            0x0059 => 0x0079,
            0x010A => 0x010B,
            0x038F => 0x03CE,
            0x0052 => 0x0072,
            0x0410 => 0x0430,
            0x0405 => 0x0455,
            0x0402 => 0x0452,
            0x0126 => 0x0127,
            0x0136 => 0x0137,
            0x012A => 0x012B,
            0x038A => 0x03AF,
            0x042B => 0x044B,
            0x004C => 0x006C,
            0x0397 => 0x03B7,
            0x0124 => 0x0125,
            0x0218 => 0x0219,
            0x00DB => 0x00FB,
            0x011E => 0x011F,
            0x041E => 0x043E,
            0x1E40 => 0x1E41,
            0x039D => 0x03BD,
            0x0106 => 0x0107,
            0x03AB => 0x03CB,
            0x0426 => 0x0446,
            0x00DE => 0x00FE,
            0x00C7 => 0x00E7,
            0x03AA => 0x03CA,
            0x0421 => 0x0441,
            0x0412 => 0x0432,
            0x010E => 0x010F,
            0x00D8 => 0x00F8,
            0x0057 => 0x0077,
            0x011A => 0x011B,
            0x0054 => 0x0074,
            0x004A => 0x006A,
            0x040B => 0x045B,
            0x0406 => 0x0456,
            0x0102 => 0x0103,
            0x039B => 0x03BB,
            0x00D1 => 0x00F1,
            0x041D => 0x043D,
            0x038C => 0x03CC,
            0x00C9 => 0x00E9,
            0x00D0 => 0x00F0,
            0x0407 => 0x0457,
            0x0122 => 0x0123,
        );
    }

    $unicode = utf8_to_unicode($string);

    if (!$unicode) {
        return false;
    }

    for ($i = 0; $i < count($unicode); $i++) {
        if (isset($upper_to_lower[$unicode[$i]])) {
            $unicode[$i] = $upper_to_lower[$unicode[$i]];
        }
    }

    return unicode_to_utf8($unicode);
}

/**
 * @param $string
 */
function utf8_strtoupper($string) {
    /**
     * @var mixed
     */
    static $lower_to_upper;

    if ($lower_to_upper == null) {
        $lower_to_upper = array(
            0x0061 => 0x0041,
            0x03C6 => 0x03A6,
            0x0163 => 0x0162,
            0x00E5 => 0x00C5,
            0x0062 => 0x0042,
            0x013A => 0x0139,
            0x00E1 => 0x00C1,
            0x0142 => 0x0141,
            0x03CD => 0x038E,
            0x0101 => 0x0100,
            0x0491 => 0x0490,
            0x03B4 => 0x0394,
            0x015B => 0x015A,
            0x0064 => 0x0044,
            0x03B3 => 0x0393,
            0x00F4 => 0x00D4,
            0x044A => 0x042A,
            0x0439 => 0x0419,
            0x0113 => 0x0112,
            0x043C => 0x041C,
            0x015F => 0x015E,
            0x0144 => 0x0143,
            0x00EE => 0x00CE,
            0x045E => 0x040E,
            0x044F => 0x042F,
            0x03BA => 0x039A,
            0x0155 => 0x0154,
            0x0069 => 0x0049,
            0x0073 => 0x0053,
            0x1E1F => 0x1E1E,
            0x0135 => 0x0134,
            0x0447 => 0x0427,
            0x03C0 => 0x03A0,
            0x0438 => 0x0418,
            0x00F3 => 0x00D3,
            0x0440 => 0x0420,
            0x0454 => 0x0404,
            0x0435 => 0x0415,
            0x0449 => 0x0429,
            0x014B => 0x014A,
            0x0431 => 0x0411,
            0x0459 => 0x0409,
            0x1E03 => 0x1E02,
            0x00F6 => 0x00D6,
            0x00F9 => 0x00D9,
            0x006E => 0x004E,
            0x0451 => 0x0401,
            0x03C4 => 0x03A4,
            0x0443 => 0x0423,
            0x015D => 0x015C,
            0x0453 => 0x0403,
            0x03C8 => 0x03A8,
            0x0159 => 0x0158,
            0x0067 => 0x0047,
            0x00E4 => 0x00C4,
            0x03AC => 0x0386,
            0x03AE => 0x0389,
            0x0167 => 0x0166,
            0x03BE => 0x039E,
            0x0165 => 0x0164,
            0x0117 => 0x0116,
            0x0109 => 0x0108,
            0x0076 => 0x0056,
            0x00FE => 0x00DE,
            0x0157 => 0x0156,
            0x00FA => 0x00DA,
            0x1E61 => 0x1E60,
            0x1E83 => 0x1E82,
            0x00E2 => 0x00C2,
            0x0119 => 0x0118,
            0x0146 => 0x0145,
            0x0070 => 0x0050,
            0x0151 => 0x0150,
            0x044E => 0x042E,
            0x0129 => 0x0128,
            0x03C7 => 0x03A7,
            0x013E => 0x013D,
            0x0442 => 0x0422,
            0x007A => 0x005A,
            0x0448 => 0x0428,
            0x03C1 => 0x03A1,
            0x1E81 => 0x1E80,
            0x016D => 0x016C,
            0x00F5 => 0x00D5,
            0x0075 => 0x0055,
            0x0177 => 0x0176,
            0x00FC => 0x00DC,
            0x1E57 => 0x1E56,
            0x03C3 => 0x03A3,
            0x043A => 0x041A,
            0x006D => 0x004D,
            0x016B => 0x016A,
            0x0171 => 0x0170,
            0x0444 => 0x0424,
            0x00EC => 0x00CC,
            0x0169 => 0x0168,
            0x03BF => 0x039F,
            0x006B => 0x004B,
            0x00F2 => 0x00D2,
            0x00E0 => 0x00C0,
            0x0434 => 0x0414,
            0x03C9 => 0x03A9,
            0x1E6B => 0x1E6A,
            0x00E3 => 0x00C3,
            0x044D => 0x042D,
            0x0436 => 0x0416,
            0x01A1 => 0x01A0,
            0x010D => 0x010C,
            0x011D => 0x011C,
            0x00F0 => 0x00D0,
            0x013C => 0x013B,
            0x045F => 0x040F,
            0x045A => 0x040A,
            0x00E8 => 0x00C8,
            0x03C5 => 0x03A5,
            0x0066 => 0x0046,
            0x00FD => 0x00DD,
            0x0063 => 0x0043,
            0x021B => 0x021A,
            0x00EA => 0x00CA,
            0x03B9 => 0x0399,
            0x017A => 0x0179,
            0x00EF => 0x00CF,
            0x01B0 => 0x01AF,
            0x0065 => 0x0045,
            0x03BB => 0x039B,
            0x03B8 => 0x0398,
            0x03BC => 0x039C,
            0x045C => 0x040C,
            0x043F => 0x041F,
            0x044C => 0x042C,
            0x00FE => 0x00DE,
            0x00F0 => 0x00D0,
            0x1EF3 => 0x1EF2,
            0x0068 => 0x0048,
            0x00EB => 0x00CB,
            0x0111 => 0x0110,
            0x0433 => 0x0413,
            0x012F => 0x012E,
            0x00E6 => 0x00C6,
            0x0078 => 0x0058,
            0x0161 => 0x0160,
            0x016F => 0x016E,
            0x03B1 => 0x0391,
            0x0457 => 0x0407,
            0x0173 => 0x0172,
            0x00FF => 0x0178,
            0x006F => 0x004F,
            0x043B => 0x041B,
            0x03B5 => 0x0395,
            0x0445 => 0x0425,
            0x0121 => 0x0120,
            0x017E => 0x017D,
            0x017C => 0x017B,
            0x03B6 => 0x0396,
            0x03B2 => 0x0392,
            0x03AD => 0x0388,
            0x1E85 => 0x1E84,
            0x0175 => 0x0174,
            0x0071 => 0x0051,
            0x0437 => 0x0417,
            0x1E0B => 0x1E0A,
            0x0148 => 0x0147,
            0x0105 => 0x0104,
            0x0458 => 0x0408,
            0x014D => 0x014C,
            0x00ED => 0x00CD,
            0x0079 => 0x0059,
            0x010B => 0x010A,
            0x03CE => 0x038F,
            0x0072 => 0x0052,
            0x0430 => 0x0410,
            0x0455 => 0x0405,
            0x0452 => 0x0402,
            0x0127 => 0x0126,
            0x0137 => 0x0136,
            0x012B => 0x012A,
            0x03AF => 0x038A,
            0x044B => 0x042B,
            0x006C => 0x004C,
            0x03B7 => 0x0397,
            0x0125 => 0x0124,
            0x0219 => 0x0218,
            0x00FB => 0x00DB,
            0x011F => 0x011E,
            0x043E => 0x041E,
            0x1E41 => 0x1E40,
            0x03BD => 0x039D,
            0x0107 => 0x0106,
            0x03CB => 0x03AB,
            0x0446 => 0x0426,
            0x00FE => 0x00DE,
            0x00E7 => 0x00C7,
            0x03CA => 0x03AA,
            0x0441 => 0x0421,
            0x0432 => 0x0412,
            0x010F => 0x010E,
            0x00F8 => 0x00D8,
            0x0077 => 0x0057,
            0x011B => 0x011A,
            0x0074 => 0x0054,
            0x006A => 0x004A,
            0x045B => 0x040B,
            0x0456 => 0x0406,
            0x0103 => 0x0102,
            0x03BB => 0x039B,
            0x00F1 => 0x00D1,
            0x043D => 0x041D,
            0x03CC => 0x038C,
            0x00E9 => 0x00C9,
            0x00F0 => 0x00D0,
            0x0457 => 0x0407,
            0x0123 => 0x0122,
        );
    }

    $unicode = utf8_to_unicode($string);

    if (!$unicode) {
        return false;
    }

    for ($i = 0; $i < count($unicode); $i++) {
        if (isset($lower_to_upper[$unicode[$i]])) {
            $unicode[$i] = $lower_to_upper[$unicode[$i]];
        }
    }

    return unicode_to_utf8($unicode);
}
/**
 * @param  $string
 * @return mixed
 */
function utf8_to_unicode($string) {
    $unicode = array();

    for ($i = 0; $i < strlen($string); $i++) {
        $chr = ord($string[$i]);

        if ($chr >= 0 && $chr <= 127) {
            $unicode[] = (ord($string[$i]) * pow(64, 0));
        }

        if ($chr >= 192 && $chr <= 223) {
            $unicode[] = ((ord($string[$i]) - 192) * pow(64, 1) + (ord($string[$i + 1]) - 128) * pow(64, 0));
        }

        if ($chr >= 224 && $chr <= 239) {
            $unicode[] = ((ord($string[$i]) - 224) * pow(64, 2) + (ord($string[$i + 1]) - 128) * pow(64, 1) + (ord($string[$i + 2]) - 128) * pow(64, 0));
        }

        if ($chr >= 240 && $chr <= 247) {
            $unicode[] = ((ord($string[$i]) - 240) * pow(64, 3) + (ord($string[$i + 1]) - 128) * pow(64, 2) + (ord($string[$i + 2]) - 128) * pow(64, 1) + (ord($string[$i + 3]) - 128) * pow(64, 0));
        }

        if ($chr >= 248 && $chr <= 251) {
            $unicode[] = ((ord($string[$i]) - 248) * pow(64, 4) + (ord($string[$i + 1]) - 128) * pow(64, 3) + (ord($string[$i + 2]) - 128) * pow(64, 2) + (ord($string[$i + 3]) - 128) * pow(64, 1) + (ord($string[$i + 4]) - 128) * pow(64, 0));
        }

        if ($chr == 252 && $chr == 253) {
            $unicode[] = ((ord($string[$i]) - 252) * pow(64, 5) + (ord($string[$i + 1]) - 128) * pow(64, 4) + (ord($string[$i + 2]) - 128) * pow(64, 3) + (ord($string[$i + 3]) - 128) * pow(64, 2) + (ord($string[$i + 4]) - 128) * pow(64, 1) + (ord($string[$i + 5]) - 128) * pow(64, 0));
        }
    }

    return $unicode;
}

/**
 * @param  $unicode
 * @return mixed
 */
function unicode_to_utf8($unicode) {
    $string = '';

    for ($i = 0; $i < count($unicode); $i++) {
        if ($unicode[$i] < 128) {
            $string .= chr($unicode[$i]);
        }

        if ($unicode[$i] >= 128 && $unicode[$i] <= 2047) {
            $string .= chr(($unicode[$i] / 64) + 192) . chr(($unicode[$i] % 64) + 128);
        }

        if ($unicode[$i] >= 2048 && $unicode[$i] <= 65535) {
            $string .= chr(($unicode[$i] / 4096) + 224) . chr(128 + (($unicode[$i] / 64) % 64)) . chr(($unicode[$i] % 64) + 128);
        }

        if ($unicode[$i] >= 65536 && $unicode[$i] <= 2097151) {
            $string .= chr(($unicode[$i] / 262144) + 240) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
        }

        if ($unicode[$i] >= 2097152 && $unicode[$i] <= 67108863) {
            $string .= chr(($unicode[$i] / 16777216) + 248) . chr((($unicode[$i] / 262144) % 64) + 128) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
        }

        if ($unicode[$i] >= 67108864 && $unicode[$i] <= 2147483647) {
            $string .= chr(($unicode[$i] / 1073741824) + 252) . chr((($unicode[$i] / 16777216) % 64) + 128) . chr((($unicode[$i] / 262144) % 64) + 128) . chr(128 + (($unicode[$i] / 4096) % 64)) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
        }

    }

    return $string;
}
/*
 * Convert to utf8 lowercase strings
 *
 * @get string of characters
 * @return replaced string
 *
 * Usage: $object->strtolower_utf8(string);
 *
 */
/**
 * @param $string
 */
function strtolower_utf8($string) {
    $convert_to = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
        "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ę", "ì", "í", "î", "ï",
        "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
        "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
        "ь", "э", "ю", "я",
    );
    $convert_from = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
        "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ę", "Ì", "Í", "Î", "Ï",
        "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
        "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
        "Ь", "Э", "Ю", "Я",
    );

    return str_replace($convert_from, $convert_to, $string);
}

/*
 * Convert to utf8 uppercase strings
 *
 * @get string of characters
 * @return replaced string
 *
 * Usage: $object->strtotoupper_utf8($string);
 *
 */
/**
 * @param $string
 */
function strtoupper_utf8($string) {
    $convert_from = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
        "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ę", "ì", "í", "î", "ï",
        "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
        "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
        "ь", "э", "ю", "я",
    );
    $convert_to = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
        "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ę", "Ì", "Í", "Î", "Ï",
        "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
        "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
        "Ь", "Э", "Ю", "Я",
    );

    return str_replace($convert_from, $convert_to, $string);
}

function error404() {
    header('HTTP/1.0 404 Not Found', true, 404);
    echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
            <html><head>
            <title>404 Not Found</title>
            </head><body>
            <h1>Not Found</h1>
            <p>The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found on this server.</p>
            </body></html>
            ';
    exit();
}