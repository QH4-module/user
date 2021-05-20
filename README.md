QH4框架扩展模块-用户模块

### 功能
1、获取和设置用户基本信息

2、修改密码

### 依赖
该模块依赖于 `city` 城市模块
```
composer require qh4/city
```

### api列表
```php
actionGetBasicInfo()
```
获取用户的基本信息

```php
actionSetBasicInfo()
```
设置用户的基本信息

```php
actionChangePassword()
```
通过旧密码修改密码

```php
actionUploadAvatar()
```
上传头像

```php
actionBalanceHistoryList()
```
分页获取余额变动历史记录

```php
actionScoresHistoryList()
```
分页获取积分变动历史记录


### 方法列表
```php
/**
 * 减少用户余额
 * 调用该函数,务必开启事务和异常处理
 * @param string $user_id
 * @param float $price 金额,单位元,支持2位小数
 * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
 * @param DbModel $db 开启事务的数据库操作句柄
 * @param ExtUser|null $external
 * @return bool 成功返回true
 *              返回false表示用户余额不足
 */
public static function decrBalance($user_id, $price, $act, $db, ExtUser $external = null)
```

```php
/**
 * 增加用户余额
 * 调用该函数,务必开启事务和异常处理
 * @param string $user_id
 * @param float $price 变动金额,单位元,最多2位小数
 * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
 * @param DbModel $db 开启事务的数据库操作句柄
 * @param ExtUser|null $external
 */
public static function incrBalance($user_id, $price, $act, $db, ExtUser $external = null)
```

```php
/**
 * 减少用户积分
 * 调用该函数,务必开启事务和异常处理
 * @param string $user_id
 * @param float $point 变动的积分,支持2位小数
 * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
 * @param DbModel $db 开启事务的数据库操作句柄
 * @param ExtUser|null $external
 * @return bool 成功返回true
 *              返回false表示用户积分
 * @return bool
 */
public static function decrScores($user_id, $point, $act, $db, ExtUser $external = null)
```

```php
/**
 * 增加用户积分
 * 调用该函数,务必开启事务和异常处理
 * @param string $user_id
 * @param float $point 变动积分,最多2位小数
 * @param int $act 对应数据表的act字段,完全自定义,作为类型使用
 * @param DbModel $db 开启事务的数据库操作句柄
 * @param ExtUser|null $external
 */
public static function incrScores($user_id, $point, $act, $db, ExtUser $external = null)
```