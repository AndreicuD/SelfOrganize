document.addEventListener('DOMContentLoaded', function () {

    const trendCanvas = document.getElementById('welcomeTrendChart');
    if (trendCanvas) {
        const accent = getComputedStyle(document.documentElement).getPropertyValue('--accent').trim() || '#2596be';

        new Chart(trendCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: [0, 5, 4, 6, 5, 8, 10],
                    borderColor: accent,
                    backgroundColor: accent + '30',
                    fill: true,
                    tension: 0.5,
                    pointRadius: 0,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                animation: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });
    }

    
});