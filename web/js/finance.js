document.addEventListener('DOMContentLoaded', function () {

    const editModal = document.getElementById('editAccountModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('edit-account-id').value       = btn.dataset.id;
            document.getElementById('edit-account-name').value     = btn.dataset.name;
            document.getElementById('edit-account-currency').value = btn.dataset.currency;
            document.getElementById('edit-account-type').value = btn.dataset.type;
            document.getElementById('edit-account-balance').value  = btn.dataset.balance;
        });
    }

    const deleteModal = document.getElementById('deleteAccountModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('delete-account-id').value         = btn.dataset.id;
            document.getElementById('delete-account-name').textContent = btn.dataset.name;
        });
    }

    // Accounts carousel
    const carousel = document.getElementById('accounts-carousel');
    const prevBtn  = document.getElementById('accounts-prev');
    const nextBtn  = document.getElementById('accounts-next');

    if (carousel) {
        const scrollAmount = () => carousel.offsetWidth * 0.75;

        const updateButtons = () => {
            if (prevBtn) prevBtn.disabled = carousel.scrollLeft <= 0;
            if (nextBtn) nextBtn.disabled = carousel.scrollLeft + carousel.offsetWidth >= carousel.scrollWidth - 1;
        };

        if (prevBtn) prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });

        if (nextBtn) nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });

        carousel.addEventListener('scroll', updateButtons);
        updateButtons(); // set initial state
    }

    const financeTabs = document.querySelectorAll('.finance-tab');
    const financePanels = document.querySelectorAll('.finance-panel');

    financeTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            financeTabs.forEach(t => t.classList.remove('active'));
            financePanels.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).classList.add('active');
        });
    });

    let balanceChart = null;

    function renderBalanceChart(days) {
        const canvas = document.getElementById('balanceHistoryChart');
        if (!canvas) return;

        const weekData = JSON.parse(document.getElementById("balanceHistoryWeek").textContent);
        const monthData = JSON.parse(document.getElementById("balanceHistoryMonth").textContent);

        const data = days === 7 ? weekData : monthData;

        if (!data || !Array.isArray(data)) {
            console.log("Invalid data!");
            return;
        }

        const styles = getComputedStyle(document.documentElement);

        const accent = styles.getPropertyValue('--accent').trim();
        const textMuted = styles.getPropertyValue('--chart-text-muted').trim();
        const gridColor = styles.getPropertyValue('--chart-grid-color').trim();
        const fontSmall = styles.getPropertyValue('--chart-font-small').trim();
        const fontMedium = styles.getPropertyValue('--chart-font-medium').trim();
        const fontSmallValue = parseInt(fontSmall);
        const fontMediumValue = parseInt(fontMedium);

        const labels = data.map(d => d.date);
        const values = data.map(d => d.amount);

        if (balanceChart) balanceChart.destroy();

        balanceChart = new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    borderColor: accent,
                    backgroundColor: accent + '20',
                    fill: true,
                    tension: 0.4,
                    pointRadius: days == 7 ? 4 : 2,
                    pointHoverRadius: 6,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        ticks: { 
                            color: textMuted, 
                            font: { size: fontSmallValue }
                         },
                        grid: { display: false }
                    },
                    y: {
                        ticks: { 
                            color: textMuted, 
                            font: { size: fontSmallValue }
                        },
                        grid: { color:  gridColor }
                    }
                }
            }
        });
    }

    renderBalanceChart(7);

    document.querySelectorAll('.balance-range-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.balance-range-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            renderBalanceChart(parseInt(this.dataset.days));
        });
    });
});