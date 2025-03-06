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
     * @param string $email email пользователя
     * @return string
     */
    static function createDiscountCoupon($email): string
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


    /**
     * - Отправляет купон пользователю
     * @param string $email email пользователя
     * @param string $couponСode код купона
     * @return bool
     */
    static function sendСouponToEmail($email, $couponСode)
    {
        $subject =  __('Ваш купон на скидку 10%', 'tt');
        $message = __('Спасибо за подписку! Ваш купон:', 'tt') . " <strong>$couponСode</strong>";
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        return wp_mail($email, $subject, $message, $headers);
    }


    /**
     * - Процесс генерации купона
     * @return void
     */
    static function processSubscriptions()
    {
        $filePath = THEME_PATH . '/subscribers.txt';

        if (!file_exists($filePath)) {
            echo '<p style="color:red;">' . __('Нет пользователей для рассылки', 'tt') . '</p>';
            return;
        }

        $subscribers = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $sentCount = 0;
        $errorCount = 0;

        if (empty($subscribers)) {
            echo '<p style="color:red;">' . __('Нет пользователей для рассылки', 'tt') . '</p>';
            return;
        }

        foreach ($subscribers as $subscriber) {
            $email = trim($subscriber);
            if (is_email($email)) {
                $couponCode = self::createDiscountCoupon($email);
                if (self::sendСouponToEmail($email, $couponCode)) {
                    $sentCount++;
                } else {
                    $errorCount++;
                }
            }
        }

        echo "<p style='color:green;'>" . __('Успешно отправлено:', 'tt') . " $sentCount</p>";
        if ($errorCount > 0) {
            echo "<p style='color:red;'>" . __('Ошибок при отправке:', 'tt') . " $errorCount</p>";
        }
    }
}
