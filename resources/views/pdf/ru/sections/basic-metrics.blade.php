<h2 style="margin-bottom:20px;">Топ-10 авторов</h2>

<div style="display:flex; justify-content:space-between;">

    <div style="width:48%;">
        <h3 style="text-align:center;">По сообщениям</h3>
        <canvas id="messagesChart"></canvas>
    </div>

    <div style="width:48%;">
        <h3 style="text-align:center;">По реакциям</h3>
        <canvas id="reactionsChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const messagesData = @json($topMessages);
    const reactionsData = @json($topReactions);

    function buildPieChart(canvasId, data) {
        const ctx = document.getElementById(canvasId);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.map(item => 'ID ' + item.user_id),
                datasets: [{
                    data: data.map(item => item.count),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    buildPieChart('messagesChart', messagesData);
    buildPieChart('reactionsChart', reactionsData);
</script>
