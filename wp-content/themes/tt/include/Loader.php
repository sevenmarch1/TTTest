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
            load_theme_textdomain('tt', THEME_PATH . 'languages');
            if (! class_exists('WooCommerce')) {
                add_action('admin_notices', [__CLASS__, 'woocommerceRequiredNotice']);
                switch_theme(WP_DEFAULT_THEME);
            }
        });

        return $this;
    }

    static function woocommerceRequiredNotice()
    {
        echo '<div class="notice notice-error is-dismissible">
            <p><strong>Ошибка:</strong> ' . __('Для работы данной темы требуется плагин WooCommerce. Пожалуйста, установите и активируйте WooCommerce', 'tt') . '</p>
        </div>';
    }
}
