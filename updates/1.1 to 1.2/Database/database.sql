ALTER TABLE items
CHANGE regular_price regular_price DOUBLE NULL,
CHANGE extended_price extended_price DOUBLE NULL,
CHANGE total_sales_amount total_sales_amount DOUBLE DEFAULT 0;

ALTER TABLE item_discounts
CHANGE regular_price regular_price DOUBLE NOT NULL,
CHANGE extended_price extended_price DOUBLE NULL;

ALTER TABLE users
CHANGE balance balance DOUBLE DEFAULT 0;

ALTER TABLE sales
CHANGE price price DOUBLE NOT NULL,
CHANGE total total DOUBLE NOT NULL;

ALTER TABLE transactions
CHANGE amount amount DOUBLE NOT NULL,
CHANGE fees fees DOUBLE DEFAULT 0,
CHANGE total total DOUBLE NOT NULL;

ALTER TABLE transaction_items
CHANGE price price DOUBLE NOT NULL;

ALTER TABLE statements
CHANGE amount amount DOUBLE NOT NULL;

ALTER TABLE support_earnings
CHANGE price price DOUBLE NOT NULL,
CHANGE total total DOUBLE NOT NULL;

ALTER TABLE plans
CHANGE price price DOUBLE NULL;


ALTER TABLE premium_earnings
CHANGE price price DOUBLE NOT NULL,
CHANGE total total DOUBLE NOT NULL;

ALTER TABLE `items` 
ADD COLUMN `status` BOOLEAN NOT NULL DEFAULT TRUE 
AFTER `is_featured`;

UPDATE `settings` SET `value` = '{\"terms_of_use_link\":\"\\/terms-of-use\",\"licenses_terms_link\":\"\\/licenses-terms\",\"free_items_policy_link\":\"\\/free-items-policy\",\"gdpr_cookie_policy_link\":\"\\/gdpr-policy\"}' WHERE `key`="links";





