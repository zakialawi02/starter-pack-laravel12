import "./bootstrap";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// Fungsi untuk menghitung waktu relatif (misal: 2 hours ago)
/**
 * Calculates and returns a human-readable relative time string from a given date
 *
 * @param {string} dateStr - The date string to calculate relative time from
 * @returns {string} A formatted relative time string (e.g., "2 hours ago", "just now")
 *
 * @example
 * timeAgo("2023-12-01T10:00:00Z") // Returns "2 days ago"
 * timeAgo("2023-12-03T11:55:00Z") // Returns "5 minutes ago"
 */
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
/**
 * Formats a date string into a customizable, localized date format
 *
 * @param {string|null|undefined} dateString - The date string to format (ISO format recommended)
 * @param {boolean} [includeTime=true] - Whether to include time in the formatted output
 * @param {Object|null} [customOptions=null] - Custom formatting options to override defaults
 * @param {string} [locale="en-US"] - The locale to use for formatting (e.g., "en-US", "id-ID")
 * @param {string} [fallback="-"] - The fallback value to return if formatting fails
 * @returns {string} A formatted date string or the fallback value
 *
 * @example
 * formatCustomDate("2023-12-01T10:30:00Z") // Returns "Dec 1, 2023, 10:30"
 * formatCustomDate("2023-12-01", false) // Returns "Dec 1, 2023"
 * formatCustomDate("", true, null, "en-US", "No date") // Returns "No date"
 * formatCustomDate("2023-12-01", true, { weekday: "long" }, "id-ID") // Returns custom format
 */
function formatCustomDate(
    dateString,
    includeTime = true,
    customOptions = null,
    locale = "en-US",
    fallback = "-"
) {
    if (!dateString) {
        return fallback;
    }

    const defaultOptions = {
        day: "numeric",
        month: "short",
        year: "numeric",
    };

    if (includeTime) {
        defaultOptions.hour = "2-digit";
        defaultOptions.minute = "2-digit";
        defaultOptions.hour12 = false;
    }

    const options = customOptions
        ? { ...defaultOptions, ...customOptions }
        : defaultOptions;

    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) {
            return fallback;
        }
        return date.toLocaleDateString(locale, options);
    } catch (error) {
        return fallback;
    }
}
window.timeAgo = timeAgo;
window.formatCustomDate = formatCustomDate;
