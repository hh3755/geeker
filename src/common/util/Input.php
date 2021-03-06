<?php
/**
 * @author: Jackong
 * Date: 14-3-13
 * Time: 下午6:39
 */

namespace src\common\util;


use Slim\Slim;
use src\common\Log;

class Input {
    public static function get($name, $pattern = null, $default = null) {
        $value = self::optional($name, $pattern);
        if (!is_null($value)) {
            return $value;
        }
        if (!is_null($default)) {
            return $default;
        }
        $msg = "Invalid parameter $name";
        $app = Slim::getInstance();
        $request = $app->request();
        Log::warn($request->getIp(), $request->getUserAgent(), $request->getResourceUri(), $msg);
        $app->halt(400, $msg);
        return null;
    }

    public static function optional($name, $pattern = null) {
        $value = Slim::getInstance()->request()->params($name);
        if (is_null($value)) {
            return null;
        }
        if (is_null($pattern)) {
            return $value;
        }
        if (preg_match($pattern, $value, $matches)) {
            return $value;
        }
        return null;
    }
}
