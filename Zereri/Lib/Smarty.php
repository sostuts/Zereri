<?php
namespace Zereri\Lib;

class Smarty
{
    /**smarty实例
     *
     * @var mixed
     */
    private $smarty;


    private function newIntance()
    {
        $this->smarty = new \Smarty;

        return $this;
    }


    private function setConfig()
    {
        $smarty_config = config("smarty");
        $this->smarty->debugging = $smarty_config['debugging'];
        $this->smarty->caching = $smarty_config['caching'];
        $this->smarty->cache_lifetime = $smarty_config['cache_lifetime'];

        $this->smarty->cache_dir = $GLOBALS['config']['smarty']['cache_dir'];
        $this->smarty->template_dir = $GLOBALS['config']['smarty']['template_dir'];
        $this->smarty->compile_dir = $GLOBALS['config']['smarty']['compile_dir'];
        $this->smarty->config_dir = $GLOBALS['config']['smarty']['config_dir'];

        $this->smarty->left_delimiter = $smarty_config['left_delimiter'];
        $this->smarty->right_delimiter = $smarty_config['right_delimiter'];
    }


    public function load($file, array $values, $save_file_path = "")
    {
        $this->newIntance()->setConfig();

        foreach ($values as $param => $value) {
            $this->smarty->assign($param, $value);
        }

        if ($save_file_path) {
            return $this->smartyRenderAndSaveHtmlToFile($file, $save_file_path);
        }

        $this->smarty->display($file);
    }


    protected function smartyRenderAndSaveHtmlToFile($file, $save_file_path)
    {
        return file_put_contents($save_file_path, $this->smarty->fetch($file));
    }
}