<?php
require __ROOT__.'/Zereri/Lib/Auto.class.php';

spl_autoload_register('\Zereri\Lib\Auto::loadClass');
spl_autoload_register('\Zereri\Lib\Auto::loadPHP');
