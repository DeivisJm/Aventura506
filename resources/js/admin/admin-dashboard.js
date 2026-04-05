import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("bookingChart");
    if (!ctx) return;

    const labels = JSON.parse(ctx.dataset.labels || "[]");
    const data = JSON.parse(ctx.dataset.values || "[]");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels,
            datasets: [
                {
                    label: "Reservas",
                    data,
                    borderRadius: 10,
                    borderSkipped: false,
                    backgroundColor: "rgba(34, 197, 94, 0.82)",
                    hoverBackgroundColor: "rgba(22, 163, 74, 0.92)",
                    maxBarThickness: 42,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "#0f172a",
                    titleColor: "#ffffff",
                    bodyColor: "#e5e7eb",
                    padding: 12,
                    cornerRadius: 12
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: "#64748b",
                        font: {
                            size: 12,
                            weight: "600"
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(148, 163, 184, 0.18)"
                    },
                    ticks: {
                        color: "#64748b",
                        font: {
                            size: 12
                        },
                        precision: 0
                    }
                }
            }
        }
    });
});