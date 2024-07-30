# h-translator
php translator tool


## install
```
composer require hollisho/h-translator
```

## usage

```php
$translator = new Translator();
$phpFileLoader = new PhpFileLoader();
$translator->addLoader('phpFile', $phpFileLoader);
$translator->addResource('phpFile', dirname(__DIR__) . "/Files/zh-cn.php", 'zh_CN');
$trans = $translator->trans("user.username");
```