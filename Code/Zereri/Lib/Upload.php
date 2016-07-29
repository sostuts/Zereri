<?php
namespace Zereri\Lib;

class Upload
{
    private $file;

    private $file_suffix;

    private $file_path;


    public function __construct($upfile, $file_path = '')
    {
        $this->file = $upfile;
        $this->file_suffix = $this->getFileSuffix();
        $this->file_path = $this->getNewFilePath($file_path);
    }


    /**保存文件
     *
     * @return mixed
     * @throws UserException
     */
    public function saveFile()
    {
        $this->validFile();

        $new_file_name = $this->getNewFilePath() . '/' . $this->getNewFileName();

        return $this->moveFile($new_file_name);
    }


    /**获取文件后缀
     *
     * @return mixed
     */
    protected function getFileSuffix()
    {
        $pieces = explode(".", $this->file['name']);

        return end($pieces);
    }


    /**验证文件合法性
     *
     * @throws UserException
     */
    private function validFile()
    {
        if (!$this->isValidSuffix()) {
            throw new UserException('Invalid Suffix!');
        }

        if (!$this->isVaildSize()) {
            throw new UserException('Invalid Size!');
        }
    }

    /**验证文件后缀合法
     *
     * @return bool
     */
    private function isValidSuffix()
    {
        return in_array($this->file_suffix, $GLOBALS['user_config']['file']['suffix']);
    }

    /**验证文件大小合法
     *
     * @return bool
     */
    private function isVaildSize()
    {
        return $this->file['size'] <= $GLOBALS['user_config']['file']['size'];
    }


    /**获取保存文件名
     *
     * @return string
     */
    private function getNewFileName()
    {
        $pre_file_name = md5(time() . $this->file['tmp_name']);

        return $pre_file_name . '.' . $this->file_suffix;
    }


    /**获取保存文件路径
     *
     * @return mixed
     * @throws UserException
     */
    private function getNewFilePath($file_path)
    {
        if (!$file_path) {
            $file_path = $GLOBALS['user_config']['file']['path'];
        }
        if (!file_exists($file_path)) {
            throw new UserException('Invalid File Path!');
        }

        return $file_path;
    }


    /**保存文件
     *
     * @param $new_file_name
     *
     * @return mixed
     * @throws UserException
     */
    protected function moveFile($new_file_name)
    {
        if (!move_uploaded_file($this->file['tmp_name'], $new_file_name)) {
            throw new UserException('Upload Fail!');
        }

        return $new_file_name;
    }
}
