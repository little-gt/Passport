<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 重置密码页面模板
 * 用户点击邮件链接后，输入新密码的页面。
 *
 * UI 与 BooAdmin 登录页同源：同一张 hero 图、同一套渐变遮罩、
 * 同一套按钮语义变量（--booadmin-accent-button）。
 *
 * @package Passport
 */

include __DIR__ . '/partial/common.php';

/** @var \Widget\Options $options */

$menuTitle = _t('重置密码');

$captchaType = (string) ($this->config->captchaType ?? 'default');
$recaptchaSiteKey = (string) ($this->config->sitekeyRecaptcha ?? '');
$hcaptchaSiteKey = (string) ($this->config->sitekeyHcaptcha ?? '');
$geetestCaptchaId = (string) ($this->config->captchaIdGeetest ?? '');

// token / signature 只用于回传表单值，属性输出时统一转义
$token = (string) ($this->request->token ?? '');
$signature = (string) ($this->request->signature ?? '');

$heroImage = 'https://cdn.garfieldtom.cool/img/wldairy/poster/illustration/MemoryAdministrationBureau.jpg';

include __DIR__ . '/partial/header.php';
?>
<div class="min-h-screen flex bg-discord-light text-discord-text">
    <!-- Left Side: Hero Image（与 admin/login.php 完全一致） -->
    <div class="hidden md:flex md:w-1/2 flex-col justify-center items-center bg-cover bg-center relative" style="background-color: var(--booadmin-hero-fallback); background-image: linear-gradient(135deg, var(--booadmin-hero-gradient-a), var(--booadmin-hero-gradient-b)), url('<?php echo htmlspecialchars($heroImage, ENT_QUOTES, 'UTF-8'); ?>');">
        <div class="absolute inset-0 pointer-events-none" style="background-color: var(--booadmin-hero-overlay);"></div>
        <div class="relative z-10 text-white p-12 text-center">
            <h1 class="text-4xl font-bold mb-4"><?php $options->title(); ?></h1>
            <p class="text-lg opacity-90"><?php $options->description(); ?></p>
        </div>
        <div class="absolute bottom-6 text-white/50 text-xs">
            Copyright &copy; <?php echo date('Y'); ?> BooAdmin Team. All rights reserved
        </div>
    </div>

    <!-- Right Side: Reset Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 overflow-y-auto bg-white">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900 mb-2"><?php _e('重置密码'); ?></h2>
                <p class="text-gray-500"><?php _e('请输入您的新密码'); ?></p>
            </div>

            <form action="<?php echo htmlspecialchars(passportRoute('/passport/reset'), ENT_QUOTES, 'UTF-8'); ?>" method="post" enctype="application/x-www-form-urlencoded" class="space-y-6">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="signature" value="<?php echo htmlspecialchars($signature, ENT_QUOTES, 'UTF-8'); ?>">

                <div>
                    <label for="password-input" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('新密码'); ?> <span style="color: var(--booadmin-danger);">*</span></label>
                    <input id="password-input" name="password" type="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-discord-accent/50 focus:border-discord-accent transition-all" required placeholder="<?php _e('请输入新密码'); ?>" autocomplete="new-password">
                    <p class="mt-1 text-xs text-gray-500"><?php _e('建议使用特殊字符与字母、数字的混编样式，以增加系统安全性'); ?></p>
                </div>

                <div>
                    <label for="confirm-input" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('密码确认'); ?> <span style="color: var(--booadmin-danger);">*</span></label>
                    <input id="confirm-input" name="confirm" type="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-discord-accent/50 focus:border-discord-accent transition-all" required placeholder="<?php _e('请再次输入密码'); ?>" autocomplete="new-password">
                    <p class="mt-1 text-xs text-gray-500"><?php _e('请确认你的密码，与上面输入的密码保持一致'); ?></p>
                </div>

                <input name="do" type="hidden" value="password">

                <?php if ($captchaType === 'default'): ?>
                <div>
                    <label for="captcha-input" class="block text-sm font-medium mb-1" style="color: var(--booadmin-text);"><?php _e('验证码'); ?> <span style="color: var(--booadmin-danger);">*</span></label>
                    <div class="flex gap-3">
                        <input type="text" name="captcha" id="captcha-input" class="flex-1 min-w-0 px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-discord-accent/50 focus:border-discord-accent transition-all" required placeholder="<?php _e('请输入验证码'); ?>" autocomplete="off">
                        <div class="relative w-32 h-12 flex-shrink-0" style="width:128px;height:48px;">
                            <div class="passport-captcha-loader absolute inset-0 flex items-center justify-center" style="background: var(--booadmin-surface-2);">
                                <i class="fas fa-spinner fa-spin" style="color: var(--booadmin-muted);"></i>
                            </div>
                            <img class="passport-captcha-img w-full h-full object-cover cursor-pointer hidden" width="128" height="48" alt="<?php _e('验证码'); ?>" title="<?php _e('点击图片刷新验证码'); ?>" data-captcha-url="<?php echo htmlspecialchars($options->index('/passport/captcha'), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                    <p class="mt-1 text-xs" style="color: var(--booadmin-muted);"><?php _e('请输入图片中的字符，不区分大小写'); ?></p>
                </div>
                <?php elseif ($captchaType === 'recaptcha' && $recaptchaSiteKey !== ''): ?>
                <div class="flex justify-center">
                    <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey, ENT_QUOTES, 'UTF-8'); ?>"></div>
                </div>
                <?php elseif ($captchaType === 'hcaptcha' && $hcaptchaSiteKey !== ''): ?>
                <div class="flex justify-center">
                    <div class="h-captcha" data-sitekey="<?php echo htmlspecialchars($hcaptchaSiteKey, ENT_QUOTES, 'UTF-8'); ?>"></div>
                </div>
                <?php elseif ($captchaType === 'geetest' && $geetestCaptchaId !== ''): ?>
                <div id="captcha-geetest"></div>
                <input type="hidden" name="lot_number" id="lot_number">
                <input type="hidden" name="captcha_output" id="captcha_output">
                <input type="hidden" name="pass_token" id="pass_token">
                <input type="hidden" name="gen_time" id="gen_time">
                <?php endif; ?>

                <div>
                    <button type="submit" class="passport-btn-primary w-full flex justify-center py-3 px-4 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-discord-accent transition-all">
                        <?php _e('更新密码'); ?>
                    </button>
                </div>
            </form>

            <div>
                <button type="button" data-nav-url="<?php echo htmlspecialchars($options->adminUrl('login.php'), ENT_QUOTES, 'UTF-8'); ?>" class="passport-btn-primary w-full flex justify-center py-3 px-4 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-discord-accent transition-all">
                    <?php _e('返回登录'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php // --- 按需加载第三方 CAPTCHA 脚本 --- ?>
<?php if ($captchaType === 'default'): ?>
<script>
(function () {
    function refreshCaptcha(img) {
        if (img.dataset.refreshing === '1') return;
        img.dataset.refreshing = '1';

        var loader = img.previousElementSibling;
        img.classList.add('hidden');
        if (loader) loader.classList.remove('hidden');

        var base = img.getAttribute('data-captcha-url') || '';
        img.src = base + '?' + Math.random();

        function done() {
            img.classList.remove('hidden');
            if (loader) loader.classList.add('hidden');
            img.dataset.refreshing = '0';
        }
        img.onload = done;
        img.onerror = done;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.passport-captcha-img').forEach(function (img) {
            img.addEventListener('click', function () { refreshCaptcha(img); });
            refreshCaptcha(img);
        });
    });
})();
</script>
<?php elseif ($captchaType === 'recaptcha' && $recaptchaSiteKey !== ''): ?>
<script src="https://www.recaptcha.net/recaptcha/api.js" async defer></script>
<?php elseif ($captchaType === 'hcaptcha' && $hcaptchaSiteKey !== ''): ?>
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
<?php elseif ($captchaType === 'geetest' && $geetestCaptchaId !== ''): ?>
<script src="https://static.geetest.com/v4/gt4.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('captcha-geetest');
    if (!el || typeof initGeetest4 !== 'function') return;

    initGeetest4({
        captchaId: <?php echo passportJson($geetestCaptchaId); ?>,
        product: 'popup',
        language: 'zh-cn'
    }, function (captcha) {
        captcha.appendTo(el);
        captcha.onSuccess(function () {
            var result = captcha.getValidate();
            if (!result) return;
            ['lot_number', 'captcha_output', 'pass_token', 'gen_time'].forEach(function (key) {
                var input = document.getElementById(key);
                if (input) input.value = result[key] || '';
            });
        });
    });
});
</script>
<?php endif; ?>

<script>document.body.classList.add('loaded');</script>

<?php include __DIR__ . '/partial/notice.php'; ?>

</body>
</html>
