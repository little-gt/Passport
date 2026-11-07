/**
 * Passport Tailwind CSS v3 配置
 *
 * 与 BooAdmin 主构建链保持一致（config/v3/tailwind.config.js）：
 * 所有颜色工具类都转发到 --booadmin-* 语义变量，产物中不出现硬编码字面色值。
 * 变量的实际取值由 Template/css/passport-tokens.css 提供（对齐 BooAdmin
 * light.css / dark.css），因此明暗主题只需维护一处。
 *
 * 构建（在插件根目录执行）：
 *   ../../tailwindcss-3.4.17.exe -c config/tailwind.config.js \
 *       -i config/input.css -o Passport/Template/css/passport.css --minify
 *
 * content 使用相对「配置文件所在目录」的路径，不含任何机器绝对路径。
 *
 * @type {import('tailwindcss').Config}
 */

const path = require('path');

/**
 * content 路径基于 __dirname 解析，与执行构建时的 cwd 无关。
 * 这样任何人在任意目录调用 CLI 都能得到一致产物。
 */
const src = (glob) => path.resolve(__dirname, '../Passport/Template', glob);

const v = (name, fallback) =>
    `color-mix(in srgb, var(--booadmin-${name}, ${fallback}) calc(<alpha-value> * 100%), transparent)`;

const dv = (name) =>
    `color-mix(in srgb, var(--color-discord-${name}) calc(<alpha-value> * 100%), transparent)`;

const discord = {
    light:   dv('light'),
    accent:  dv('accent'),
    text:    dv('text'),
    muted:   dv('muted'),
};

const backgroundColor = Object.assign({
    white: v('surface', '#ffffff'),
    gray: {
        50:  v('surface-2', '#f9fafb'),
        100: v('surface-muted', '#f3f4f6'),
        200: v('active', '#e5e7eb'),
    },
    transparent: 'transparent',
    current: 'currentColor',
}, { discord });

const textColor = Object.assign({
    white: v('on-accent', '#ffffff'),
    gray: {
        400: v('muted', '#9ca3af'),
        500: v('muted', '#6b7280'),
        600: v('text', '#4b5563'),
        700: v('text', '#374151'),
        900: v('text', '#111827'),
    },
    red: { 500: v('danger', '#dc2626') },
    transparent: 'transparent',
    current: 'currentColor',
}, { discord });

const borderColor = Object.assign({
    DEFAULT: v('border', '#e5e7eb'),
    gray: {
        100: v('border', '#e5e7eb'),
        200: v('border', '#e5e7eb'),
        300: v('border-strong', '#d1d5db'),
    },
    transparent: 'transparent',
    current: 'currentColor',
}, { discord });

module.exports = {
    content: [
        src('**/*.php'),
        src('**/*.css'),
    ],
    theme: {
        extend: {
            backgroundColor,
            textColor,
            borderColor,
            divideColor: borderColor,
            ringColor: Object.assign({}, borderColor, { DEFAULT: v('accent', '#5865f2') }),
            ringOffsetColor: backgroundColor,
            placeholderColor: textColor,
            caretColor: textColor,
        },
    },
    plugins: [],
};
