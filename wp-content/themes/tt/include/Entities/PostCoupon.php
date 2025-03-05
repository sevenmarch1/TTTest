<?php

namespace TT\Entities;

use TT\Constants\PostTypes;

class PostCoupon
{

    protected static $postType = PostTypes::COUPON;

    
    /**
     * - Генерируети уникальное имя купона
     * @return string
     */
    protected static function generateCouponCode(): string
    {
        return strtoupper(uniqid('DISCOUNT_', true));
    }


    /**
     * - Создает купон
     * @return int
     */
    static function createDiscountCoupon($email): int
    {
        $couponСode = self::generateCouponCode();

        $couponData = array(
            'post_title'  => $couponСode,
            'post_content' => __('Скидка 10% на следующую покупку!', 'tt'),
            'post_status'  => 'publish',
            'post_type'    => self::$postType,
        );


        $couponId = wp_insert_post($couponData);

        update_post_meta($couponId, 'discount_type', 'percent');
        update_post_meta($couponId, 'coupon_amount', '10');
        update_post_meta($couponId, 'individual_use', 'yes');
        update_post_meta($couponId, 'usage_limit', 1);
        update_post_meta($couponId, 'email_restrictions', array($email));

        return $couponСode;
    }
}
