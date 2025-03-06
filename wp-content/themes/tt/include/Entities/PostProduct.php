<?php

namespace TT\Entities;

use TT\Constants\PostTypes;

class PostProduct
{

    protected static $postType = PostTypes::PRODUCT;

    /**
     * - Получает наименование всех товаров
     * @return []
     */
    static function getAllProducts(): array
    {
        // OLD 
        //
        // $args = [
        //     'post_type' => 'product',
        //     'posts_per_page' => -1,
        // ];
        // $products = get_posts($args);
        // $titles = [];
        // foreach ($products as $product) {
        //     $titles[] = $product->post_title;
        // }
        // return $titles;


        global $wpdb;

        $query = "SELECT post_title FROM {$wpdb->prefix}posts WHERE post_type = '" . self::$postType . "' AND post_status = 'publish'";

        $results = $wpdb->get_col($query);

        return $results;
    }

    /**
     * - Возвращает самые популярные товары
     * @param int $count количество популярных товаров
     * @return []
     */
    static function getTopSellingProducts($count = 3): array
    {
        global $wpdb;

        $query = "
        SELECT p.ID, p.post_title, SUM(opl.product_qty) as total_sales
        FROM {$wpdb->prefix}posts p
        INNER JOIN {$wpdb->prefix}wc_order_product_lookup opl ON p.ID = opl.product_id
        INNER JOIN {$wpdb->prefix}wc_orders o ON opl.order_id = o.id
        WHERE p.post_type = %s
        AND p.post_status = 'publish'
        AND o.date_created_gmt >= NOW() - INTERVAL 7 DAY
        GROUP BY p.ID
        ORDER BY total_sales DESC
        LIMIT %d
    ";

        return $wpdb->get_results($wpdb->prepare($query, self::$postType, $count), ARRAY_A);
    }
}
