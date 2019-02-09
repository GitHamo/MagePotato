## Potato for Magento 2


| Module | Description |
| ------ | ------ |
| Basic | ... |
| Tools | ... |




#### Install
Run the following commandz in Magento 2 root folder
```
composer require githamo/magepotato
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

#### Upgrade
Run the following commandz in Magento 2 root folder
```
composer update githamo/magepotato
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
php bin/magento setup:di:compile
```

#### Development

Want to contribute? Great!
