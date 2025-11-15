Run the following command to install the WooCommerce API client:
composer require automattic/woocommerce

In your .env file, add the following WooCommerce API credentials:
WOOCOMMERCE_STORE_URL=https://yourstore.com
WOOCOMMERCE_CONSUMER_KEY=ck_xxxxxxxxxxxxxxxxxxx
WOOCOMMERCE_CONSUMER_SECRET=cs_xxxxxxxxxxxxxxxxxxx
WOOCOMMERCE_VERSION=wc/v3

Create the service file 
app/Providers/WooCommerceService.php

Create the controller file
app/Http/Controllers/WooCommerceController.php

Create Routes in api.php