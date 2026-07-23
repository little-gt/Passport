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
        <link rel="stylesheet" href="<?php echo $pluginUrl; ?>/Template/css/passport.css?v=1.2.0">
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

            /* ========================================
             * 主题变量 - 与 BooAdmin light.css / dark.css 完全一致
             * 亮色为默认值，暗色通过 @media (prefers-color-scheme: dark) 覆盖
             * ======================================== */
            :root {
                color-scheme: light;

                /* 基础色板 - Backgrounds */
                --booadmin-bg: #f2f3f5;
                --booadmin-sidebar: #e3e5e8;
                --booadmin-active: #d4d7dc;

                /* 表面色板 - Surfaces */
                --booadmin-surface: #ffffff;
                --booadmin-surface-2: #f9fafb;
                --booadmin-surface-muted: #f3f4f6;

                /* 边框色板 - Borders */
                --booadmin-border: #e5e7eb;
                --booadmin-border-strong: #d1d5db;

                /* 文本色板 - Text Colors */
                --booadmin-text: #2e3338;
                --booadmin-muted: #5c5e66;
                --booadmin-placeholder: #9ca3af;
                --booadmin-on-accent: #ffffff;

                /* 控件色板 - Form Controls */
                --booadmin-control-bg: #f3f4f6;
                --booadmin-control-bg-hover: #e5e7eb;
                --booadmin-control-disabled-bg: #f3f4f6;
                --booadmin-control-disabled-text: #9ca3af;
                --booadmin-focus-ring: rgba(88, 101, 242, 0.22);

                /* 强调色 - Accent */
                --booadmin-accent: #5865f2;
                --booadmin-accent-hover: #4752c4;
                --booadmin-accent-active: #3c45a5;
                --booadmin-accent-rgb: 88, 101, 242;

                /* 链接色 - Links */
                --booadmin-link: #467b96;
                --booadmin-link-hover: #499bc3;
                --booadmin-link-active: #39647a;
                --booadmin-link-disabled: #508cab;
                --booadmin-link-soft-bg: #d8e7ee;
                --booadmin-link-soft-hover: #a5cadc;

                /* 语义色 - Success */
                --booadmin-success: #16a34a;
                --booadmin-success-bg: #def7ec;
                --booadmin-success-bg-alt: #e6efc2;
                --booadmin-success-text: #03543f;
                --booadmin-success-text-strong: #264409;

                /* 语义色 - Warning */
                --booadmin-warning: #ea580c;
                --booadmin-warning-bg: #fff6bf;
                --booadmin-warning-text: #8a6d3b;

                /* 语义色 - Danger/Error */
                --booadmin-danger: #dc2626;
                --booadmin-danger-strong: #a4403f;
                --booadmin-danger-hover: #a4403f;
                --booadmin-danger-active: #9c3e3c;
                --booadmin-danger-disabled: #c1605e;
                --booadmin-error-bg: #fde8e8;
                --booadmin-error-text: #9b1c1c;

                /* 语义色 - Info */
                --booadmin-info: #2563eb;
                --booadmin-info-hover: #1e40af;
                --booadmin-info-bg: #eff6ff;

                /* 高亮与选中 - Highlights */
                --booadmin-highlight-soft: #f3f4f6;
                --booadmin-highlight-danger: #fbc2c4;
                --booadmin-highlight-warm: #fffbcc;
                --booadmin-selection-bg: #eef2ff;
                --booadmin-selection-border: #c7d2fe;

                /* 遮罩层 - Overlays */
                --booadmin-overlay: rgba(0, 0, 0, 0.5);
                --booadmin-overlay-solid: #000000;
                --booadmin-hero-overlay: rgba(0, 0, 0, 0.58);

                /* 兼容性别名 - Legacy Aliases */
                --color-discord-light: var(--booadmin-bg);
                --color-discord-sidebar: var(--booadmin-sidebar);
                --color-discord-active: var(--booadmin-active);
                --color-discord-accent: var(--booadmin-accent);
                --color-discord-text: var(--booadmin-text);
                --color-discord-muted: var(--booadmin-muted);
            }

            @media (prefers-color-scheme: dark) {
                :root {
                    color-scheme: dark;

                    /* 基础色板 - Backgrounds (纯黑基底) */
                    --booadmin-bg: #000000;
                    --booadmin-sidebar: #0a0a0a;
                    --booadmin-active: #1a1a1a;

                    /* 表面色板 - Surfaces (中性微层次) */
                    --booadmin-surface: #0d0d0d;
                    --booadmin-surface-2: #151515;
                    --booadmin-surface-muted: #080808;

                    /* 边框色板 - Borders */
                    --booadmin-border: #222222;
                    --booadmin-border-strong: #333333;

                    /* 文本色板 - Text Colors (柔和白) */
                    --booadmin-text: #e4e4e7;
                    --booadmin-muted: #a1a1aa;
                    --booadmin-placeholder: #71717a;
                    --booadmin-on-accent: #ffffff;

                    /* 控件色板 - Form Controls */
                    --booadmin-control-bg: #18181b;
                    --booadmin-control-bg-hover: #1f1f23;
                    --booadmin-control-disabled-bg: #080808;
                    --booadmin-control-disabled-text: #52525b;
                    --booadmin-focus-ring: rgba(99, 102, 199, 0.18);

                    /* 强调色 - Accent (深沉靛蓝) */
                    --booadmin-accent: #6366c7;
                    --booadmin-accent-hover: #7c7fd6;
                    --booadmin-accent-active: #9899e3;
                    --booadmin-accent-rgb: 99, 102, 199;

                    /* 链接色 - Links */
                    --booadmin-link: #7c7fd6;
                    --booadmin-link-hover: #9899e3;
                    --booadmin-link-active: #b4b5ec;
                    --booadmin-link-disabled: #5558a3;
                    --booadmin-link-soft-bg: #16162a;
                    --booadmin-link-soft-hover: #1e1e38;

                    /* 语义色 - Success (柔和绿) */
                    --booadmin-success: #6bc78a;
                    --booadmin-success-bg: #0a1f12;
                    --booadmin-success-bg-alt: #0a1f12;
                    --booadmin-success-text: #6bc78a;
                    --booadmin-success-text-strong: #95d4ab;

                    /* 语义色 - Warning (柔和琥珀) */
                    --booadmin-warning: #d4a72a;
                    --booadmin-warning-bg: #2a2208;
                    --booadmin-warning-text: #d4a72a;

                    /* 语义色 - Danger/Error (低饱和红) */
                    --booadmin-danger: #e07a7a;
                    --booadmin-danger-strong: #7a2020;
                    --booadmin-danger-hover: #d46464;
                    --booadmin-danger-active: #e09191;
                    --booadmin-danger-disabled: #9e2828;
                    --booadmin-error-bg: #2a0c10;
                    --booadmin-error-text: #e8aaaa;

                    /* 语义色 - Info (低饱和蓝) */
                    --booadmin-info: #7aadf0;
                    --booadmin-info-hover: #a3c8f5;
                    --booadmin-info-bg: #081420;

                    /* 高亮与选中 - Highlights */
                    --booadmin-highlight-soft: #111111;
                    --booadmin-highlight-danger: #2e0f12;
                    --booadmin-highlight-warm: #221e0a;
                    --booadmin-selection-bg: #181830;
                    --booadmin-selection-border: #2a2a44;

                    /* 遮罩层 - Overlays */
                    --booadmin-overlay: rgba(0, 0, 0, 0.75);
                    --booadmin-overlay-solid: #000000;
                    --booadmin-hero-overlay: rgba(0, 0, 0, 0.65);

                    /* 兼容性别名 - Legacy Aliases */
                    --color-discord-light: var(--booadmin-bg);
                    --color-discord-sidebar: var(--booadmin-sidebar);
                    --color-discord-active: var(--booadmin-active);
                    --color-discord-accent: var(--booadmin-accent);
                    --color-discord-text: var(--booadmin-text);
                    --color-discord-muted: var(--booadmin-muted);
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