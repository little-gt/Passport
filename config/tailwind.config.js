/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    'c:/Users/coole/Documents/GitHub/BooAdmin/chajian/Passport/Passport/Template/*.php',
    'c:/Users/coole/Documents/GitHub/BooAdmin/chajian/Passport/Passport/Template/partial/*.php'
  ],
  theme: {
    extend: {
      colors: {
        discord: {
          light: "var(--color-discord-light)",
          sidebar: "var(--color-discord-sidebar)",
          active: "var(--color-discord-active)",
          accent: "var(--color-discord-accent)",
          text: "var(--color-discord-text)",
          muted: "var(--color-discord-muted)",
        }
      }
    }
  },
  plugins: [],
}