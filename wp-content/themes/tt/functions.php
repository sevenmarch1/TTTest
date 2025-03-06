<?php

require_once __DIR__ . '/vendor/autoload.php';

\TT\Loader::getInstance()
    ->setup();

//создает страницу в админке для генерации купонов    
\TT\Admin::getInstance()
    ->setup();