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
}
