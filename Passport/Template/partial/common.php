<?php
/**
 * Passport 独立页面公共引导
 *
 * 本文件由 forgot.php / reset.php 在 Typecho 路由上下文中 include。
 * 提供 $options / $security 两个 Widget 与若干共享辅助函数。
 *
 * 历史版本在此处用 Typecho_Widget::widget('Widget_Init') 做「兼容
 * 1.2.1 / 1.3.0」的二次初始化并 try/catch 吞掉异常；新版 Typecho 的路由
 * 已完成初始化，那段逻辑既冗余又会掩盖真实错误，故移除。
 */

use Widget\Options;
use Widget\Security;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** @var Options $options */
$options = Options::alloc();

/** @var Security $security */
$security = Security::alloc();

/**
 * PHP → JS 字面量的唯一安全出口。
 *
 * 历史上模板用 addslashes() 把消息拼进 JS 字符串再写进 innerHTML，
 * 既不能防止 </script> 提前闭合，也没有对 HTML 做净化。
 * 这里用 HEX_* 全套标志，把 < > & ' " 全部转成 \uXXXX。
 *
 * @param mixed $value
 * @return string 可直接作为 JS 字面量的文本
 */
function passportJson($value): string
{
    $flags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
    $json = json_encode($value, $flags);

    return $json === false ? 'null' : $json;
}

/**
 * 生成路由 URL。
 * @param string $route 如 '/passport/forgot'
 */
function passportRoute(string $route): string
{
    return \Typecho\Common::url($route, Options::alloc()->index);
}

/**
 * 静态资源版本号。唯一真源是 Plugin::VERSION；
 * 若自动加载异常（如插件目录被改名），降级为 dev 以禁缓存，避免报错。
 */
function passportAssetVersion(): string
{
    $class = '\\TypechoPlugin\\Passport\\Plugin';
    return class_exists($class) ? (string) $class::VERSION : 'dev';
}
