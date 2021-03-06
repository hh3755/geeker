<?php
/**
 * @author: Jackong
 * Date: 14-3-25
 * Time: 下午5:15
 */

namespace src\config;


use src\common\Config;

class Service {
    use Config;
    protected static function prod()
    {
        return array(
            'ak' => 'TixdQ5pd2r9Su4Q1G0oUCEtO',
            'sk' => 'smUmBPlexEZNcAGyGkYHTcbBueYTnVMA',
            'redis' => array(
                'host' => 'redis.duapp.com',
                'port' => 80,
                'name' => 'uulQAzmFiQjGOebmXKxi',
            ),
            'mongo' => array(
                'ak' => 'GXTnHcjgvKPIl1MKbdxnmcQK',
                'sk' => '2RGpR7kuue9wCQX4oFHL8hXYnE2zpsg4',
                'host' => 'mongo.duapp.com',
                'port' => '8908',
                'name' => 'RGFauSekXKrYgGCstaDB',
            ),
        );
    }

    protected static function dev()
    {
        return array(
            'redis' => array(
                'name' => 'ww',
                'host' => '127.0.0.1',
                'port' => 6379,
            ),
            'mongo' => array(
                'name' => 'user',
                'host' => '127.0.0.1',
                'port' => '27017',
            ),
        );
    }

} 