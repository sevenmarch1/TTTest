<?php

use TT\Entities\PostCoupon;

?>

<div class="wrap">
    <h1><?= __('Генерация купонов', 'tt'); ?></h1>
    <form method="post">
        <button type="submit" name="generate_coupons" class="button button-primary"><?= __('Сгенерировать купоны', 'tt'); ?></button>
    </form>

    <?php
    if (isset($_POST['generate_coupons'])) {
        PostCoupon::processSubscriptions();
    }
    ?>
</div>