<?php
namespace Zereri\Lib\Cache;


class File implements \Zereri\Lib\Interfaces\Cache
{
    private function getFilePath($key)
    {
        return __ROOT__ . "/App/FileCache/$key.txt";
    }


    public function set($key, $value = "", $time = "")
    {
        if (is_array($key)) {
            $time = $value ?: config("cache.time");
            foreach ($key as $each_key => $each_value) {
                $this->saveCacheDataToFile($each_key, $each_value, $time);
            }
        } else {
            $this->saveCacheDataToFile($key, $value, $time ?: config("cache.time"));
        }
    }


    private function saveCacheDataToFile($key, $value, $time)
    {
        $file_path = $this->getFilePath($key);
        $data = json_encode([
            "time"    => $time,
            "content" => $value
        ]);

        file_put_contents($file_path, $data);
    }


    public function get($key)
    {
        if (is_array($key)) {
            $cache_data_arr = [];
            foreach ($key as $each_key) {
                $cache_data_arr[ $each_key ] = $this->getCacheDataFromFile($each_key);
            }

            return $cache_data_arr;
        } else {
            return $this->getCacheDataFromFile($key);
        }
    }


    private function getCacheDataFromFile($key)
    {
        if (!$this->has($key)) {
            return NULL;
        }

        $data = $this->getCacheFileContentAndDecode($this->getFilePath($key));

        return $data["content"];
    }


    public function has($key)
    {
        $file_path = $this->getFilePath($key);

        if (!file_exists($file_path)) {
            return FALSE;
        }

        $data = $this->getCacheFileContentAndDecode($file_path);
        if ($this->isCacheTimeOut($file_path, $data["time"])) {
            return FALSE;
        }

        return true;
    }


    private function getCacheFileContentAndDecode($file_path)
    {
        return json_decode(file_get_contents($file_path), true);
    }


    private function isCacheTimeOut($file_path, $expect_cache_time)
    {
        return (0 !== $expect_cache_time) && (time() >= $expect_cache_time + filemtime($file_path));
    }


    public function delete($key)
    {
        $file_path = $this->getFilePath($key);

        return unlink($file_path);
    }


    public function flush()
    {
        $path = __ROOT__ . "/App/FileCache";
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    unlink($path . "/" . $file);
                }
            }

            closedir($handle);
        }
    }


    public function Increment($key, $num = 1)
    {
        if ($data = $this->get($key)) {
            $num = $data + $num;
        }

        return $this->set($key, $num);
    }


    public function Decrement($key, $num = 1)
    {
        if ($data = $this->get($key)) {
            $num = $data - $num;
        } else {
            $num = 0 - $num;
        }

        return $this->set($key, $num);
    }
}