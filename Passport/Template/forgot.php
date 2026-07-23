<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 忘记密码页面模板
 * 用户输入邮箱申请重置链接的页面。
 * @package Passport
 * @version 1.2.0
 */

// 导入公共变量和初始化
include 'partial/common.php';

/** @var \Widget\Options $options */

// 设置页面标题
$menuTitle = _t('找回密码');

// 从配置中安全获取 CAPTCHA 相关的变量，并进行 HTML 转义
$captchaType = htmlspecialchars((string) ($this->config->captchaType ?? 'default'));
$recaptchaSiteKey = htmlspecialchars((string) ($this->config->sitekeyRecaptcha ?? ''));
$hcaptchaSiteKey = htmlspecialchars((string) ($this->config->sitekeyHcaptcha ?? ''));
$geetestCaptchaId = htmlspecialchars((string) ($this->config->captchaIdGeetest ?? ''));

include 'partial/header.php';
?>
<div class="min-h-screen flex bg-discord-light text-discord-text">
    <!-- Left Side: Hero Image -->
    <div class="hidden md:flex md:w-1/2 flex-col justify-center items-center bg-cover bg-center relative" style="background-image: url('https://cdn.garfieldtom.cool/img/wldairy/poster/horizontal/%E9%81%87%E8%A7%81%E4%BD%A0%E7%9A%84%E7%8C%AB_%E9%82%A3%E4%B8%80%E5%A4%A9.jpg');">
        <div class="absolute inset-0 pointer-events-none" style="background-color: var(--booadmin-hero-overlay);"></div>
        <div class="relative z-10 text-white p-12 text-center">
            <h1 class="text-4xl font-bold mb-4"><?php $options->title(); ?></h1>
            <p class="text-lg opacity-90"><?php $options->description(); ?></p>
        </div>
        <div class="absolute bottom-6 text-white/50 text-xs">
            Copyright &copy; <?php echo date('Y'); ?> Passport Team. All rights reserved
        </div>
    </div>

    <!-- Right Side: Forgot Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 overflow-y-auto bg-white">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900 mb-2"><?php _e('找回密码'); ?></h2>
                <p class="text-gray-500"><?php _e('请输入您的邮箱地址以接收重置链接'); ?></p>
            </div>

            <form action="<?php echo passport_route_url('/passport/forgot'); ?>" method="post" enctype="application/x-www-form-urlencoded" class="space-y-6">
                <div>
                    <label for="mail-input" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('邮箱'); ?> <span style="color: var(--booadmin-danger);">*</span></label>
                    <input id="mail-input" name="mail" type="email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-discord-accent/50 focus:border-discord-accent transition-all" required placeholder="<?php _e('请输入您的邮箱地址'); ?>" autocomplete="email">
                    <p class="mt-1 text-xs text-gray-500"><?php _e('请输入您忘记密码的账号所对应的邮箱地址'); ?></p>
                </div>

                <input name="do" type="hidden" value="mail">

                <?php if ($captchaType === 'default'): ?>
                <div>
                    <label for="captcha-input" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('验证码'); ?> <span style="color: var(--booadmin-danger);">*</span></label>
                    <div class="flex gap-3">
                        <input type="text" name="captcha" id="captcha-input" class="flex-1 min-w-0 px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-discord-accent/50 focus:border-discord-accent transition-all" required placeholder="<?php _e('请输入验证码'); ?>" autocomplete="off">
                        <div class="relative w-32 h-12 flex-shrink-0" style="width:128px;height:48px;">
                            <div class="passport-captcha-loader absolute inset-0 flex items-center justify-center" style="background: var(--booadmin-surface-2);">
                                <i class="fas fa-spinner fa-spin" style="color: var(--booadmin-muted);"></i>
                            </div>
                            <img class="passport-captcha-img w-full h-full object-cover cursor-pointer hidden" width="128" height="48" alt="<?php _e('验证码'); ?>" title="<?php _e('点击图片刷新验证码'); ?>" onclick="refreshCaptcha(this);">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500"><?php _e('请输入图片中的字符，不区分大小写'); ?></p>
                </div>
                <?php elseif ($captchaType === 'recaptcha' && !empty($recaptchaSiteKey)): ?>
                <div class="flex justify-center">
                    <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaSiteKey; ?>"></div>
                </div>
                <?php elseif ($captchaType === 'hcaptcha' && !empty($hcaptchaSiteKey)): ?>
                <div class="flex justify-center">
                    <div class="h-captcha" data-sitekey="<?php echo $hcaptchaSiteKey; ?>"></div>
                </div>
                <?php elseif ($captchaType === 'geetest' && !empty($geetestCaptchaId)): ?>
                <div id="captcha-geetest"></div>
                <input type="hidden" name="lot_number" id="lot_number">
                <input type="hidden" name="captcha_output" id="captcha_output">
                <input type="hidden" name="pass_token" id="pass_token">
                <input type="hidden" name="gen_time" id="gen_time">
                <?php endif; ?>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border text-sm font-medium text-white bg-discord-accent hover:bg-discord-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-discord-accent transition-all">
                        <?php _e('发送重置链接'); ?>
                    </button>
                </div>
            </form>

            <div>
                <a href="<?php $options->adminUrl('login.php'); ?>" class="block w-full text-center py-3 px-4 border text-sm font-medium transition-all hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2" style="background: var(--booadmin-bg); border-color: var(--booadmin-border); color: var(--booadmin-muted); --tw-ring-color: var(--booadmin-border-strong);">
                    <?php _e('返回登录'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php // --- 按需加载第三方 CAPTCHA 脚本 --- ?>
<?php if ($captchaType === 'default'): ?>
<script>
function refreshCaptcha(imgElement) {
    if (imgElement.classList.contains('refreshing')) return;

    const loader = imgElement.previousElementSibling;
    imgElement.classList.add('refreshing', 'hidden');
    loader.classList.remove('hidden');

    const baseUrl = imgElement.src ? imgElement.src.split('?')[0] : '<?php $options->index("/passport/captcha"); ?>';
    imgElement.src = baseUrl + '?' + Math.random();

    imgElement.onload = function() {
        imgElement.classList.remove('refreshing', 'hidden');
        loader.classList.add('hidden');
    };
    imgElement.onerror = function() {
        imgElement.classList.remove('refreshing', 'hidden');
        loader.classList.add('hidden');
    };
}

document.addEventListener('DOMContentLoaded', function() {
    const captchaImg = document.querySelector('.passport-captcha-img');
    if (captchaImg) refreshCaptcha(captchaImg);
});
</script>
<?php elseif ($captchaType === 'recaptcha' && !empty($recaptchaSiteKey)): ?>
<script src="https://www.recaptcha.net/recaptcha/api.js" async defer></script>
<?php elseif ($captchaType === 'hcaptcha' && !empty($hcaptchaSiteKey)): ?>
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
<?php elseif ($captchaType === 'geetest' && !empty($geetestCaptchaId)): ?>
<script src="https://static.geetest.com/v4/gt4.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const captchaElement = document.getElementById('captcha-geetest');
    if (captchaElement) {
        initGeetest4({
            captchaId: '<?php echo $geetestCaptchaId; ?>',
            product: 'popup',
            language: 'zh-cn'
        }, function (captcha) {
            captcha.appendTo(captchaElement);
            captcha.onSuccess(function () {
                const result = captcha.getValidate();
                if (result) {
                    document.getElementById('lot_number').value = result.lot_number;
                    document.getElementById('captcha_output').value = result.captcha_output;
                    document.getElementById('pass_token').value = result.pass_token;
                    document.getElementById('gen_time').value = result.gen_time;
                }
            });
        });
    }
});
</script>
<?php endif; ?>

<script>document.body.classList.add('loaded');</script>

<?php
// 显示 Session 中的通知
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['passport_notice'])) {
    $notice = $_SESSION['passport_notice'];
    unset($_SESSION['passport_notice']);
    
    // 确保容器存在
    echo '<div id="typecho-notification-container"></div>';
    
    // 图标映射
    $icons = [
        'success' => '<i class="fas fa-check-circle"></i>',
        'error' => '<i class="fas fa-times-circle"></i>',
        'notice' => '<i class="fas fa-exclamation-triangle"></i>',
        'info' => '<i class="fas fa-info-circle"></i>',
        'warning' => '<i class="fas fa-exclamation-triangle"></i>'
    ];
    
    // 标题映射
    $titles = [
        'success' => '操作成功',
        'error' => '出错了',
        'notice' => '注意',
        'info' => '提示',
        'warning' => '警告'
    ];
    
    $type = $notice['type'] ?? 'notice';
    $message = $notice['message'] ?? '';
    $icon = $icons[$type] ?? $icons['notice'];
    $title = $titles[$type] ?? $titles['notice'];
    
    // 构建通知元素（与 BooAdmin 完全一致）
    echo '<script>';
    echo '(function() {';
    echo '  var type = "' . $type . '";';
    echo '  var icon = \'' . $icon . '\';';
    echo '  var title = "' . $title . '";';
    echo '  var message = "' . addslashes($message) . '";';
    echo '  ';
    echo '  var notification = document.createElement("div");';
    echo '  notification.className = "typecho-notification " + type;';
    echo '  notification.innerHTML = ';
    echo '    \'<div class="typecho-notification-icon">\' + icon + \'</div>\' +';
    echo '    \'<div class="typecho-notification-content">\' +';
    echo '      \'<div class="typecho-notification-title">\' + title + \'</div>\' +';
    echo '      \'<div class="typecho-notification-messages">\' + message + \'</div>\' +';
    echo '    \'</div>\' +';
    echo '    \'<button class="typecho-notification-close" aria-label="关闭"><i class="fas fa-times"></i></button>\';';
    echo '  ';
    echo '  document.getElementById("typecho-notification-container").appendChild(notification);';
    echo '  ';
    echo '  setTimeout(function() { notification.classList.add("show"); }, 10);';
    echo '  ';
    echo '  notification.querySelector(".typecho-notification-close").addEventListener("click", function() {';
    echo '    notification.classList.add("hide");';
    echo '    setTimeout(function() { notification.remove(); }, 300);';
    echo '  });';
    echo '  ';
    echo '  setTimeout(function() {';
    echo '    notification.classList.add("hide");';
    echo '    setTimeout(function() { notification.remove(); }, 300);';
    echo '  }, 5000);';
    echo '})();';
    echo '</script>';
}
?>

</body>
</html>