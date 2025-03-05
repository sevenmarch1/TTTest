<?php

namespace TT;

use TT\Traits\Singletone;

class Loader
{

    use Singletone;


    /**
     * - Устанавливаем значения по умолчанию
     */
    protected function __construct()
    {
        // устанавливаем основные константы
        define('THEME_URI', get_stylesheet_directory_uri() . '/');
        define('THEME_PATH', get_stylesheet_directory() . '/');
    }


    /**
     * - Метод загрузки темы
     * @return self
     */
    function setup(): self
    {
        date_default_timezone_set('UTC');

        $this->addSupports();

        return $this;
    }


    /**
     * - Добавляет дополнительные поддержки
     * @return static
     */
    protected function addSupports()
    {
        // добавляем theme support
        add_action('after_setup_theme', function () {
            add_theme_support('menus');
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            add_theme_support('woocommerce');
        });

        return $this;
    }
}
