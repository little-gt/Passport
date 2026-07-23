<?php
/**
 * Passport 插件独立前端模板 - 头部
 *
 * 用于 Typecho 插件 Passport 的独立前端页面（如找回密码、重置密码）的头部模板。
 * 样式对齐 BooAdmin 主题视觉规范，使用 Tailwind CSS。
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// --- 变量和配置获取 ---
$menuTitle = isset($menuTitle) ? (string) $menuTitle : _t('密码找回');
$siteTitle = (string) $options->title;
$charset = (string) $options->charset;
$lang = (string) $options->lang;
$pluginUrl = $options->pluginUrl . '/Passport';
?>
<!DOCTYPE HTML>
<html lang="<?php echo htmlspecialchars($lang); ?>">
    <head>
        <meta charset="<?php echo htmlspecialchars($charset); ?>">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?php _e('%s - %s', $menuTitle, $siteTitle); ?></title>
        <meta name="robots" content="noindex, nofollow">
        <!-- TailwindCSS -->
        <link rel="stylesheet" href="<?php echo $pluginUrl; ?>/Template/css/style.css?v=1.2.0">
        <!-- Font Awesome -->
        <link href="https://cdn.garfieldtom.cool/resource/libs/fontawesome/7.2.0/css/all.min.css" rel="stylesheet">
        <style>
            /* 字体导入 */
            @import url('https://fonts.googleapis.com/css2?family=Cascadia+Code:ital,wght@0,200..700;1,200..700&family=Inter:wght@100..900&family=Noto+Sans+SC:wght@100..900&display=swap');
            
            /* 全局字体设置 */
            html {
                height: 100%;
            }
            body {
                font-family: "Inter", "Noto Sans SC", -apple-system, BlinkMacSystemFont, sans-serif;
                background: var(--booadmin-bg);
                color: var(--booadmin-text);
                font-size: 87.5%;
                line-height: 1.5;
            }
            code, pre, .mono, input[type="password"], input[type="text"], textarea, select {
                font-family: "Cascadia Code", monospace;
            }

            /* 主题变量 - 黑色模式 */
            :root {
                --booadmin-bg: #000000;
                --booadmin-hero-overlay: rgba(0, 0, 0, 0.5);
                --booadmin-accent: #5865f2;
                --booadmin-accent-hover: #4752c4;
                --color-discord-light: #000000;
                --color-discord-accent: #5865f2;
                --color-discord-text: #ffffff;
                --booadmin-surface: #0a0a0a;
                --booadmin-border: #1a1a1a;
                --booadmin-text: #ffffff;
                --booadmin-muted: #a0a0a0;
                --booadmin-border-strong: #2a2a2a;
                --booadmin-success: #22c55e;
                --booadmin-success-text-strong: #16a34a;
                --booadmin-danger: #ef4444;
                --booadmin-error-text: #f87171;
                --booadmin-warning: #fbbf24;
                --booadmin-warning-text: #f59e0b;
                --booadmin-info: #3b82f6;
                --booadmin-info-hover: #2563eb;
            }
            @media (prefers-color-scheme: dark) {
                :root {
                    --booadmin-bg: #000000;
                    --booadmin-hero-overlay: rgba(0, 0, 0, 0.5);
                    --booadmin-accent: #7983f5;
                    --booadmin-accent-hover: #6d75e8;
                    --color-discord-light: #000000;
                    --color-discord-accent: #7983f5;
                    --color-discord-text: #ffffff;
                    --booadmin-surface: #0a0a0a;
                    --booadmin-border: #1a1a1a;
                    --booadmin-text: #ffffff;
                    --booadmin-muted: #a0a0a0;
                    --booadmin-border-strong: #2a2a2a;
                    --booadmin-success: #22c55e;
                    --booadmin-success-text-strong: #16a34a;
                    --booadmin-danger: #ef4444;
                    --booadmin-error-text: #f87171;
                    --booadmin-warning: #fbbf24;
                    --booadmin-warning-text: #f59e0b;
                    --booadmin-info: #60a5fa;
                    --booadmin-info-hover: #3b82f6;
                }
            }
            /* 基础重置 */
            body { opacity: 0; transition: opacity 0.15s ease; }
            body.loaded { opacity: 1; }
            
            /* 通知系统 */
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
                box-shadow: none;
                padding: 14px 16px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
                width: 100%;
                min-width: 300px;
                opacity: 0;
                transform: translateX(400px);
                transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                border-left: 3px solid var(--booadmin-muted);
                color: var(--booadmin-text);
                border-radius: 0;
            }

            /* Show Animation */
            .typecho-notification.show {
                opacity: 1;
                transform: translateX(0);
            }

            /* Hide Animation */
            .typecho-notification.hide {
                opacity: 0;
                transform: translateX(400px);
                transition: all 0.2s ease-out;
            }

            .typecho-notification-icon {
                flex-shrink: 0;
                width: 18px;
                height: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                font-weight: 600;
                color: var(--booadmin-muted);
                margin-top: 2px;
            }

            .typecho-notification-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .typecho-notification-title {
                font-weight: 600;
                font-size: 13px;
                line-height: 1.4;
                color: var(--booadmin-text);
            }

            .typecho-notification-messages {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .typecho-notification-messages li {
                font-size: 12px;
                line-height: 1.4;
                color: var(--booadmin-muted);
                margin-bottom: 0;
            }

            .typecho-notification-messages li:not(:last-child) {
                margin-bottom: 2px;
            }

            .typecho-notification-close {
                flex-shrink: 0;
                width: 18px;
                height: 18px;
                border: none;
                background: transparent;
                color: var(--booadmin-border-strong);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: color 0.2s;
                font-size: 16px;
                padding: 0;
                margin-top: 2px;
                line-height: 1;
            }

            .typecho-notification-close:hover {
                color: var(--booadmin-muted);
            }

            .typecho-notification.success {
                border-left-color: var(--booadmin-success);
            }
            .typecho-notification.success .typecho-notification-icon {
                color: var(--booadmin-success);
            }
            .typecho-notification.success .typecho-notification-title {
                color: var(--booadmin-success);
            }

            .typecho-notification.error {
                border-left-color: var(--booadmin-danger);
            }
            .typecho-notification.error .typecho-notification-icon {
                color: var(--booadmin-danger);
            }
            .typecho-notification.error .typecho-notification-title {
                color: var(--booadmin-error-text);
            }

            .typecho-notification.notice,
            .typecho-notification.warning {
                border-left-color: var(--booadmin-warning);
            }
            .typecho-notification.notice .typecho-notification-icon,
            .typecho-notification.warning .typecho-notification-icon {
                color: var(--booadmin-warning);
            }
            .typecho-notification.notice .typecho-notification-title,
            .typecho-notification.warning .typecho-notification-title {
                color: var(--booadmin-warning);
            }

            .typecho-notification.info {
                border-left-color: var(--booadmin-info);
            }
            .typecho-notification.info .typecho-notification-icon {
                color: var(--booadmin-info);
            }
            .typecho-notification.info .typecho-notification-title {
                color: var(--booadmin-text);
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(400px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slideOutRight {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(400px);
                }
            }

            @media (max-width: 768px) {
                #typecho-notification-container {
                    left: 12px;
                    right: 12px;
                    max-width: none;
                }

                .typecho-notification {
                    min-width: auto;
                }
            }
        </style>
    </head>
    <body>