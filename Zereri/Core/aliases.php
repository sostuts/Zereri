<?php
foreach ($GLOBALS['user_config']['aliases'] as $aliase => $class_name) {
    class_alias($class_name, $aliase);
}