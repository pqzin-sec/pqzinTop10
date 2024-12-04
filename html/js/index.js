const severityChart = new Chart(document.querySelector('#severityChart'), {
    type: 'pie',
    data: {
        labels: ['Crítica', 'Alta', 'Média', 'Baixa', 'Informacional'],
        datasets: [{
            data: [],
            backgroundColor: ['#ff0000', '#ff8c19', '#ffff00', '#00b050', '#00b0f0'],
            borderWidth: 1
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
    }
});

const vulnTypeChart = new Chart(document.querySelector('#vulnTypeChart'), {
    type: 'bar',
    data: {
        labels: ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10'],
        datasets: [{
            label: '',
            backgroundColor: '#007bff',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                ticks: {
                    beginAtZero: true,
                    callback: function (value) {
                        return Number.isInteger(value) ? value : '';
                    }
                }
            }
        }
    }
});

function updateDashboard(criticalVulns, highVulns, mediumVulns, lowVulns, informationalVulns, totalVulns) {
    document.querySelector('#totalVulns').innerText = totalVulns;
    document.querySelector('#criticalVulns').innerText = criticalVulns;
    document.querySelector('#highVulns').innerText = highVulns;
    document.querySelector('#mediumVulns').innerText = mediumVulns;
    document.querySelector('#lowVulns').innerText = lowVulns;
    document.querySelector('#informationalVulns').innerText = informationalVulns;
}

function updateTables(vulnerabilityMonth) {
    var tbody = document.querySelector('#vulnTable tbody');
    tbody.innerHTML = '';
    if (!vulnerabilityMonth) {
        return
    }
    vulnerabilityMonth.sort(function (a, b) {
        return b.amount - a.amount;
    });

    vulnerabilityMonth.forEach(function (vuln) {
        var row = document.createElement('tr');
        row.innerHTML = `<td>${vuln.name}</td>
                         <td>${vuln.category}</td>
                         <td>${vuln.amount}</td>
                         <td>${vuln.severity}</td>`;
        tbody.appendChild(row);
    });
}

function updateVulnerabilityDiff(pastVulnerabilityMonth, criticalVulns, highVulns, mediumVulns, lowVulns, informationalVulns, totalVulns) {
    var pastMonths = { "critical": 0, "high": 0, "medium": 0, "low": 0, "informational": 0 };
    var pastCategories = { 'A1': 0, 'A2': 0, 'A3': 0, 'A4': 0, 'A5': 0, 'A6': 0, 'A7': 0, 'A8': 0, 'A9': 0, 'A10': 0 }
    if (!pastVulnerabilityMonth) {
        document.querySelector('#totalVulnsDiff').innerText = '';
        document.querySelector('#criticalVulnsDiff').innerText = '';
        document.querySelector('#highVulnsDiff').innerText = '';
        document.querySelector('#mediumVulnsDiff').innerText = '';
        document.querySelector('#lowVulnsDiff').innerText = '';
        document.querySelector('#informationalVulnsDiff').innerText = '';
        return
    }
    pastVulnerabilityMonth.forEach(vuln => {
        const severity = vuln.severity;
        const category = vuln.category;
        pastMonths[severity] += vuln.amount;
        pastCategories[category] += vuln.amount;
    });

    const diffCriticalVulns = criticalVulns - pastMonths.critical;
    const diffHighVulns = highVulns - pastMonths.high;
    const diffMediumVulns = mediumVulns - pastMonths.medium;
    const diffLowVulns = lowVulns - pastMonths.low;
    const diffInformationalVulns = informationalVulns - pastMonths.informational;
    const diffTotalVulns = totalVulns - Object.values(pastMonths).reduce((acc, val) => acc + val, 0);

    document.querySelector('#totalVulnsDiff').innerText = diffTotalVulns;
    document.querySelector('#criticalVulnsDiff').innerText = diffCriticalVulns;
    document.querySelector('#highVulnsDiff').innerText = diffHighVulns;
    document.querySelector('#mediumVulnsDiff').innerText = diffMediumVulns;
    document.querySelector('#lowVulnsDiff').innerText = diffLowVulns;
    document.querySelector('#informationalVulnsDiff').innerText = diffInformationalVulns;
}

function updateVulnerabilityData(month) {
    var vulnerabilityMonth
    var months = { "critical": 0, "high": 0, "medium": 0, "low": 0, "informational": 0 };
    var categories = { 'A1': 0, 'A2': 0, 'A3': 0, 'A4': 0, 'A5': 0, 'A6': 0, 'A7': 0, 'A8': 0, 'A9': 0, 'A10': 0 }


    if (vulnerability[month]) {
        var vulnerabilityMonth = vulnerability[month]
        vulnerabilityMonth.forEach(vuln => {
            const severity = vuln.severity;
            const category = vuln.category;
            months[severity] += vuln.amount;
            categories[category] += vuln.amount;
        });
    }

    const criticalVulns = months.critical;
    const highVulns = months.high;
    const mediumVulns = months.medium;
    const lowVulns = months.low;
    const informationalVulns = months.informational;
    const totalVulns = Object.values(months).reduce((acc, val) => acc + val, 0);

    updateVulnerabilityDiff(vulnerability[month - 1], criticalVulns, highVulns, mediumVulns, lowVulns, informationalVulns, totalVulns)

    severityChart.data.datasets[0].data = [criticalVulns, highVulns, mediumVulns, lowVulns, informationalVulns];
    vulnTypeChart.data.datasets[0].data = categories;

    updateTables(vulnerabilityMonth)
    updateDashboard(criticalVulns, highVulns, mediumVulns, lowVulns, informationalVulns, totalVulns)
    severityChart.update();
    vulnTypeChart.update();
    let select = document.getElementById('monthSelect')
    if (select != month) {
        document.getElementById('monthSelect').value = month
    }
}

document.getElementById('monthSelect').addEventListener('change', function () {
    updateVulnerabilityData(this.value);
});