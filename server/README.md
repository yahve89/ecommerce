
# Update database schema

The last thing you need to do is updating your database schema by applying the migrations. Make sure that you have properly configured db application component and run the following command:

```
 php yii migrate/up --migrationPath=@yii/rbac/migrations
 php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
```

получить позницу
UPDATE `product` SET `price`= CEIL((`price_opt` / 100 * `markup`) + `price_opt`) WHERE id = 275

https://tm-shopify029-hair.myshopify.com/collections/accessories