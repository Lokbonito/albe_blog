/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./storage/framework/views/*.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./vendor/laravel/breeze/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: "#ecfdf5",
                    100: "#d1fae5",
                    200: "#a7f3d0",
                    300: "#6ee7b7",
                    400: "#34d399",
                    500: "#10b981",
                    600: "#059669",
                    700: "#047857",
                    800: "#065f46",
                    900: "#064e3b",
                },
            },
            boxShadow: {
                soft: "0 10px 30px -12px rgba(0,0,0,.15)",
                card: "0 6px 20px -8px rgba(0,0,0,.12)",
            },
            fontFamily: {
                sans: ["Instrument Sans", "ui-sans-serif", "system-ui"],
            },
        },
    },
    plugins: [require("@tailwindcss/typography")],
};
