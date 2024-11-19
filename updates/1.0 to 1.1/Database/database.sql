UPDATE `settings` SET `value` = '{\"buy_now_button\":1,\"item_total_sales\":1,\"free_item_total_downloads\":1,\"reviews_status\":1,\"comments_status\":1,\"support_status\":1,\"changelogs_status\":1,\"free_items_require_login\":0,\"trending_number\":\"20\",\"best_selling_number\":\"20\",\"convert_images_webp\":\"1\",\"file_duration\":\"24\"}' WHERE `key` = 'item';

ALTER TABLE items
ADD COLUMN purchase_method TINYINT DEFAULT 1 AFTER support_instructions,
ADD COLUMN purchase_url TEXT NULL AFTER purchase_method;
