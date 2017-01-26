<?php
namespace Zereri\Lib\Basic;

use \Zereri\Lib\UserException;

class Config
{
    public static function &getConfigSelf($config_name)
    {
        $config_name_array = explode('.', $config_name);
        switch (count($config_name_array)) {
            case 1:
                $config_self =& $GLOBALS["user_config"][ $config_name_array[0] ];
                break;
            case 2:
                $config_self =& $GLOBALS["user_config"][ $config_name_array[0] ][ $config_name_array[1] ];
                break;
            case 3:
                $config_self =& $GLOBALS["user_config"][ $config_name_array[0] ][ $config_name_array[1] ][ $config_name_array[2] ];
                break;
            case 4:
                $config_self =& $GLOBALS["user_config"][ $config_name_array[0] ][ $config_name_array[1] ][ $config_name_array[2] ][ $config_name_array[3] ];
                break;
            case 5:
                $config_self =& $GLOBALS["user_config"][ $config_name_array[0] ][ $config_name_array[1] ][ $config_name_array[2] ][ $config_name_array[3] ][ $config_name_array[4] ];
                break;
            default:
                throw new UserException('Out of the index!');
        }

        return $config_self;
    }
}