import "./bootstrap";
import "flowbite";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// Fungsi untuk menghitung waktu relatif (misal: 2 hours ago)
function timeAgo(dateStr) {
    const date = new Date(dateStr);
    const seconds = Math.floor((new Date() - date) / 1000);
    const intervals = [
        { label: "year", seconds: 31536000 },
        { label: "month", seconds: 2592000 },
        { label: "day", seconds: 86400 },
        { label: "hour", seconds: 3600 },
        { label: "minute", seconds: 60 },
        { label: "second", seconds: 1 },
    ];

    for (const interval of intervals) {
        const count = Math.floor(seconds / interval.seconds);
        if (count > 0) {
            return `${count} ${interval.label}${count !== 1 ? "s" : ""} ago`;
        }
    }
    return "just now";
}
window.timeAgo = timeAgo;

$(document).ready(function () {
    const themeToggle = document.getElementById("theme-toggle");
    const iconSun = document.getElementById("icon-sun");
    const iconMoon = document.getElementById("icon-moon");
    function applyTheme(theme) {
        document.documentElement.classList.toggle("dark", theme === "dark");
        localStorage.setItem("theme", theme);
        iconSun ? iconSun.classList.toggle("hidden", theme !== "dark") : null;
        iconMoon ? iconMoon.classList.toggle("hidden", theme === "dark") : null;
    }
    // Cek tema saat ini
    const savedTheme = localStorage.getItem("theme") || "light";
    applyTheme(savedTheme);
    // Toggle tema saat tombol diklik
    themeToggle.addEventListener("click", function () {
        const newTheme = document.documentElement.classList.contains("dark")
            ? "light"
            : "dark";
        applyTheme(newTheme);
    });
});
