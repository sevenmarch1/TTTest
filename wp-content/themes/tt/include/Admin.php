<?php

namespace TT;

use TT\Traits\Singletone;

class Admin
{
    use Singletone;

    function setup(): self
    {
        add_action('admin_menu', [__CLASS__, 'generateCouponAdminMenu']);

        return $this;
    }


    static function generateCouponAdminMenu()
    {
        add_menu_page(
            __('Генерация купонов', 'tt'),
            __('Купоны', 'tt'),
            'manage_options',
            'tt-generate-coupon',
            function () {
                require THEME_PATH . 'template-parts/admin/generate-coupon-page.php';
            },
            'dashicons-tickets',
            25
        );
    }

}
