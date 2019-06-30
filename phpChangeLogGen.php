#!/usr/bin/env php
<?php

    date_default_timezone_set("America/Curacao");

    foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
        if (file_exists($file)) {
            require $file;
            echo $file ."\n";
            break;
        }
    }

    new \LogGen\Boot($argv);
?>
