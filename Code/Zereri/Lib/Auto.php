<?php
namespace Zereri\Lib;

class Auto
{
    /**加载类文件
     *
     * @param $class_name
     */
    public static function loadClass($class_name)
    {
        self::load($class_name, 'class');
    }


    /**加载普通PHP文件
     *
     * @param $class_name
     */
    public static function loadPHP($class_name)
    {
        self::load($class_name, '');
    }


    /**加载对应的文件
     *
     * @param $class_name
     * @param $suffix
     */
    private static function load($class_name, $suffix)
    {
        self::loadFile(self::getFileName($class_name, $suffix));
    }


    /**获取类文件名字
     *
     * @param $class_name
     * @param $suffix
     *
     * @return string
     */
    private static function getFileName($class_name, $suffix)
    {
        $suffix = empty($suffix) ?: '.' . $suffix;

        return __ROOT__ . DIRECTORY_SEPARATOR . preg_replace('/\\\/', DIRECTORY_SEPARATOR, $class_name) . $suffix . '.php';
    }


    /**加载文件
     *
     * @param $file_name
     *
     * @throws \Exception
     */
    private static function loadFile($file_name)
    {
        if (is_file($file_name)) {
            require $file_name;
        } else {
//            throw new \Exception("Cant find the " . $file_name);
        }
    }
}