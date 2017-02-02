<?php
namespace Zereri\Lib\Interfaces;

interface Cache
{
    /**添加或修改数据
     *
     * @param string||array $key
     * @param string $value
     * @param string $time
     *
     * @return mixed
     */
    public function set($key, $value = "", $time = "");


    /**获取数据
     *
     * @param string||array $key
     *
     * @return mixed
     */
    public function get($key);


    /**判断值是否存在该值
     *
     * @param string $key
     *
     * @return mixed
     */
    public function Has($key);


    /**删除指定数据
     *
     * @param string $key
     *
     * @return mixed
     */
    public function Delete($key);


    /**删除所有数据
     *
     * @return mixed
     */
    public function Flush();


    /**数据值增加
     *
     * @param string $key
     * @param int $num
     *
     * @return mixed
     */
    public function Increment($key, $num = 1);


    /**数据值减少
     *
     * @param string $key
     * @param int $num
     *
     * @return mixed
     */
    public function Decrement($key, $num = 1);
}