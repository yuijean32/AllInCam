// public/js/dashboard.js
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('graphiqueGains').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: lesMois,
            datasets: [{
                label: 'Gains (FCFA)',
                data: lesGains,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        }
    });
});