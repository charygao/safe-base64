# SafeBase64 

An url safe base64 encode/decode library.

[![Build Status](https://travis-ci.org/pengzhile/safe-base64.svg?branch=master)](https://travis-ci.org/pengzhile/safe-base64)
[![Test Status](https://php-eye.com/badge/pengzhile/safe-base64/tested.svg?branch=master)](https://travis-ci.org/pengzhile/safe-base64)
[![Latest Stable Version](https://poser.pugx.org/pengzhile/safe-base64/v/stable)](https://packagist.org/packages/pengzhile/safe-base64)

## 特点

* Encode之后的字符串是URL安全的。
* Decode支持对标准的Base64编码进行解码。

### 示例

```php
use Pengzhile\Utils\SafeBase64\SafeBase64;

$strEncoded = SafeBase64::encode('balabala');
$strDecoded = SafeBase64::decode($strEncoded);
```
