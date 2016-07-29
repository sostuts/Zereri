<?php
namespace Zereri\Lib;

class Smarty
{
    /**smarty实例
     *
     * @var mixed
     */
    private $smarty;


    /**引入smarty文件
     *
     * @return $this
     */
    private function requireFile()
    {
        require_once __ROOT__ . '/Zereri/Extension/Smarty/libs/Autoloader.php';
        require_once __ROOT__ . '/Zereri/Extension/Smarty/libs/Smarty.class.php';

        return $this;
    }


    /**实例化smarty
     *
     * @return $this
     */
    private function newIntance()
    {
        \Smarty_Autoloader::register();
        $this->smarty = new \Smarty;

        return $this;
    }


    /**
     * 设置smarty配置
     */
    private function setConfig()
    {
        $this->smarty->debugging = $GLOBALS['user_config']['smarty']['debugging'];
        $this->smarty->caching = $GLOBALS['user_config']['smarty']['caching'];
        $this->smarty->cache_lifetime = $GLOBALS['user_config']['smarty']['cache_lifetime'];

        $this->smarty->cache_dir = $GLOBALS['config']['smarty']['cache_dir'];
        $this->smarty->template_dir = $GLOBALS['config']['smarty']['template_dir'];
        $this->smarty->compile_dir = $GLOBALS['config']['smarty']['compile_dir'];
        $this->smarty->config_dir = $GLOBALS['config']['smarty']['config_dir'];

        $this->smarty->left_delimiter = $GLOBALS['user_config']['smarty']['left_delimiter'];
        $this->smarty->right_delimiter = $GLOBALS['user_config']['smarty']['right_delimiter'];
    }


    /**渲染加载模板文件或生成静态文件
     *
     * @param        $file
     * @param array  $values
     * @param string $fetch_file
     *
     * @return mixed
     */
    public function load($file, array $values, $fetch_file = "")
    {
        $this->requireFile()->newIntance()->setConfig();

        foreach ($values as $param => $value) {
            $this->smarty->assign($param, $value);
        }

        if ($fetch_file) {
            return $this->saveHtml($file, $fetch_file);
        }

        $this->smarty->display($file);
    }


    /**页面静态化
     *
     * @param $file
     * @param $fetch_file
     *
     * @return int
     */
    protected function saveHtml($file, $fetch_file)
    {
        return file_put_contents($fetch_file, $this->smarty->fetch($file));
    }
}