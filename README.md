# h-translator
php translator tool


## install
```
composer require hollisho/h-translator
```

## basic usage

```php
$translator = new Translator();
$phpFileLoader = new PhpFileLoader();
$translator->addLoader('phpFile', $phpFileLoader);
$translator->addResource('phpFile', dirname(__DIR__) . "/Files/zh-cn.php", 'zh_CN');
$trans = $translator->trans("user.username");
```

## moment translator

```php
$localeManager = new LocaleManager();
$localeManager->setLocale(LocaleVo::EN_US);
$momentTranslator = new MomentTranslator($localeManager);
// format with moment.js definitions
$momentTranslator->format('llll');
```

## moment format
```php
$momentTranslator->format('LT');   // 17:00
$momentTranslator->format('LTS');  // 17:00:03
$momentTranslator->format('L');    // 2024/08/01
$momentTranslator->format('l');    // 2024/8/1
$momentTranslator->format('LL');   // 2024年8月1日
$momentTranslator->format('ll');   // 2024年8月1日
$momentTranslator->format('LLL');  // 2024年8月1日下午5点00分
$momentTranslator->format('lll');  // 2024年8月1日 17:00
$momentTranslator->format('LLLL'); // 2024年8月1日星期四下午5点00分
$momentTranslator->format('llll'); // 2024年8月1日星期四 17:00

```