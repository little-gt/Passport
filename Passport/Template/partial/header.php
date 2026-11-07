<?php
/**
 * Passport 插件独立前端模板 - 头部
 *
 * 主题令牌由 Template/css/passport-tokens.css 单一提供（对齐 BooAdmin
 * light.css / dark.css）；工具类由 Tailwind 产物 passport.css 提供。
 * 这里只保留页面布局与通知组件所必需的少量样式，不再内联复制调色板。
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$menuTitle = isset($menuTitle) ? (string) $menuTitle : _t('密码找回');
$siteTitle = (string) $options->title;
$charset = (string) $options->charset;
$lang = (string) $options->lang;
$pluginUrl = $options->pluginUrl . '/Passport';

/** 资源版本号：升级时统一破缓存，避免散落的 ?v= 字面量 */
$assetVersion = passportAssetVersion();
?>
<!DOCTYPE HTML>
<html lang="<?php echo htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>">
    <head>
        <meta charset="<?php echo htmlspecialchars($charset, ENT_QUOTES, 'UTF-8'); ?>">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php _e('%s - %s', $menuTitle, $siteTitle); ?></title>
        <meta name="robots" content="noindex, nofollow">

        <!-- 单一变量源必须先于工具类加载 -->
        <link rel="stylesheet" href="<?php echo htmlspecialchars($pluginUrl . '/Template/css/passport-tokens.css?v=' . rawurlencode($assetVersion), ENT_QUOTES, 'UTF-8'); ?>">
        <link rel="stylesheet" href="<?php echo htmlspecialchars($pluginUrl . '/Template/css/passport.css?v=' . rawurlencode($assetVersion), ENT_QUOTES, 'UTF-8'); ?>">
        <link href="https://cdn.garfieldtom.cool/resource/libs/fontawesome/7.2.0/css/all.min.css" rel="stylesheet">

        <style>
            /* 本页不加载 Tailwind preflight，需补上等价的基础盒模型重置：
               否则浏览器默认 content-box 下，带内边距的栏（如右侧表单区的
               w-1/2 + p-*）宽度会超出 50%，与左侧 hero（无 padding）比例错位。 */
            *, ::before, ::after { box-sizing: border-box; }
            html { height: 100%; }
            body {
                /* 本页不加载 Tailwind preflight，必须显式清掉浏览器默认的
                   body margin（8px），否则整页四周会出现一条白边 */
                margin: 0;
                padding: 0;
                min-height: 100%;
                font-family: "Inter", "Noto Sans SC", -apple-system, BlinkMacSystemFont, sans-serif;
                background: var(--booadmin-bg);
                color: var(--booadmin-text);
                font-size: 87.5%;
                line-height: 1.5;
            }
            code, pre, .mono, input[type="password"], input[type="text"], textarea, select {
                font-family: "Cascadia Code", ui-monospace, monospace;
            }

            /* ===== 通知组件（与 BooAdmin 同构） ===== */
            #typecho-notification-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 99999;
                display: flex;
                flex-direction: column;
                gap: 10px;
                max-width: 360px;
                pointer-events: none;
            }

            .typecho-notification {
                pointer-events: all;
                background: var(--booadmin-surface);
                border: 1px solid var(--booadmin-border);
                border-left: 3px solid var(--booadmin-muted);
                padding: 14px 16px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
                width: 100%;
                min-width: 300px;
                opacity: 0;
                transform: translateX(400px);
                transition: opacity 0.3s cubic-bezier(0.23, 1, 0.32, 1), transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                color: var(--booadmin-text);
                border-radius: 0;
            }
            .typecho-notification.show { opacity: 1; transform: translateX(0); }
            .typecho-notification.hide { opacity: 0; transform: translateX(400px); transition-duration: 0.2s; }

            .typecho-notification-icon {
                flex-shrink: 0;
                width: 18px; height: 18px;
                display: flex; align-items: center; justify-content: center;
                font-size: 14px; margin-top: 2px;
                color: var(--booadmin-muted);
            }
            .typecho-notification-content { flex: 1; display: flex; flex-direction: column; gap: 4px; }
            .typecho-notification-title { font-weight: 600; font-size: 13px; line-height: 1.4; color: var(--booadmin-text); }
            .typecho-notification-messages { font-size: 12px; line-height: 1.4; color: var(--booadmin-muted); }
            .typecho-notification-close {
                flex-shrink: 0;
                width: 18px; height: 18px;
                border: none; background: transparent;
                color: var(--booadmin-border-strong);
                cursor: pointer; font-size: 16px; padding: 0; margin-top: 2px; line-height: 1;
                transition: color 0.2s;
            }
            .typecho-notification-close:hover { color: var(--booadmin-muted); }

            .typecho-notification.success { border-left-color: var(--booadmin-success); }
            .typecho-notification.success .typecho-notification-icon,
            .typecho-notification.success .typecho-notification-title { color: var(--booadmin-success); }
            .typecho-notification.error { border-left-color: var(--booadmin-danger); }
            .typecho-notification.error .typecho-notification-icon { color: var(--booadmin-danger); }
            .typecho-notification.error .typecho-notification-title { color: var(--booadmin-error-text); }
            .typecho-notification.notice,
            .typecho-notification.warning { border-left-color: var(--booadmin-warning); }
            .typecho-notification.notice .typecho-notification-icon,
            .typecho-notification.warning .typecho-notification-icon,
            .typecho-notification.notice .typecho-notification-title,
            .typecho-notification.warning .typecho-notification-title { color: var(--booadmin-warning); }
            .typecho-notification.info { border-left-color: var(--booadmin-info); }
            .typecho-notification.info .typecho-notification-icon { color: var(--booadmin-info); }

            @media (max-width: 768px) {
                #typecho-notification-container { left: 12px; right: 12px; max-width: none; }
                .typecho-notification { min-width: auto; }
            }
        </style>
    </head>
    <body>
    <script>
    /**
     * 「返回登录」等导航按钮：使用真实 <button> 元素，样式与主提交按钮完全一致。
     * 用事件委托处理跳转，避免内联 onclick；目标 URL 必须是同源绝对/相对地址，
     * 杜绝 javascript: 等伪协议被写进 data-nav-url 后造成注入。
     */
    (function () {
        function isSafeNavigation(url) {
            if (!url) return false;
            try {
                var target = new URL(url, window.location.href);
                return target.origin === window.location.origin
                    && (target.protocol === 'http:' || target.protocol === 'https:');
            } catch (e) {
                return false;
            }
        }

        document.addEventListener('click', function (event) {
            var el = event.target.closest ? event.target.closest('[data-nav-url]') : null;
            if (!el) return;
            var url = el.getAttribute('data-nav-url');
            if (isSafeNavigation(url)) {
                window.location.href = url;
            }
        });
    })();
    </script>
