import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", () => {

    const ctx = document.getElementById("bookingChart");
    if (!ctx) return;

    // Get data from dataset attributes
    const labels = JSON.parse(ctx.dataset.labels || "[]");
    const data = JSON.parse(ctx.dataset.values || "[]");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Reservas",
                data: data,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

});