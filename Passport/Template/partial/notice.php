<?php
/**
 * Session 一次性通知渲染（forgot.php / reset.php 共享）
 *
 * 历史上这段在两个模板里各复制了一份，并用 addslashes() 把消息拼进
 * JS 字符串、再用 innerHTML 拼接 DOM —— 存在存储型 XSS 且难以维护。
 * 现在统一用 passportJson() 注入数据、用 DOM API 构建节点，
 * 消息一律走 textContent，永不作为 HTML 解析。
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['passport_notice']) && is_array($_SESSION['passport_notice'])) {
    $notice = $_SESSION['passport_notice'];
    unset($_SESSION['passport_notice']);

    $allowedTypes = ['success', 'error', 'notice', 'info', 'warning'];
    $type = isset($notice['type']) && in_array($notice['type'], $allowedTypes, true)
        ? $notice['type'] : 'notice';
    $message = isset($notice['message']) ? (string) $notice['message'] : '';

    $icons = [
        'success' => 'fa-check-circle',
        'error'   => 'fa-times-circle',
        'notice'  => 'fa-exclamation-triangle',
        'info'    => 'fa-info-circle',
        'warning' => 'fa-exclamation-triangle',
    ];
    $titles = [
        'success' => _t('操作成功'),
        'error'   => _t('出错了'),
        'notice'  => _t('注意'),
        'info'    => _t('提示'),
        'warning' => _t('警告'),
    ];
    ?>
    <div id="typecho-notification-container"></div>
    <script>
    (function () {
        var payload = <?php echo passportJson([
            'type'    => $type,
            'icon'    => $icons[$type],
            'title'   => $titles[$type],
            'message' => $message,
        ]); ?>;

        var container = document.getElementById('typecho-notification-container');
        if (!container) {
            return;
        }

        var box = document.createElement('div');
        box.className = 'typecho-notification ' + payload.type;

        var iconWrap = document.createElement('div');
        iconWrap.className = 'typecho-notification-icon';
        var icon = document.createElement('i');
        icon.className = 'fas ' + payload.icon;
        iconWrap.appendChild(icon);

        var content = document.createElement('div');
        content.className = 'typecho-notification-content';
        var title = document.createElement('div');
        title.className = 'typecho-notification-title';
        title.textContent = payload.title;
        var messages = document.createElement('div');
        messages.className = 'typecho-notification-messages';
        // 消息按纯文本写入，杜绝 HTML 注入
        messages.textContent = payload.message;
        content.appendChild(title);
        content.appendChild(messages);

        var close = document.createElement('button');
        close.className = 'typecho-notification-close';
        close.setAttribute('aria-label', <?php echo passportJson(_t('关闭')); ?>);
        var closeIcon = document.createElement('i');
        closeIcon.className = 'fas fa-times';
        close.appendChild(closeIcon);

        box.appendChild(iconWrap);
        box.appendChild(content);
        box.appendChild(close);
        container.appendChild(box);

        function dismiss() {
            box.classList.add('hide');
            window.setTimeout(function () { box.remove(); }, 300);
        }

        close.addEventListener('click', dismiss);
        window.setTimeout(function () { box.classList.add('show'); }, 10);
        window.setTimeout(dismiss, 5000);
    })();
    </script>
    <?php
}
