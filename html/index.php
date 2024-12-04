<?php include_once '../includes/vulns.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/icon.gif">
    <title>pqziz Dashboard 😀👍</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src=" https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js "></script>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pqzin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./add.php">Add Vulnerabilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./debug_json.php">json</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Month Selector -->
            <div class="col-md-12 mb-4">
                <div class="form-group">
                    <label for="monthSelect">Select Month</label>
                    <select id="monthSelect" class="form-control">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Statistics -->
            <div class="col-md-4 mb-4">
                <div class="card" id="cardTotal">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Total Vulnerabilities</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 id="totalVulns"></h3>
                        <p>Vulnerabilities found</p>
                        <p id="totalVulnsDiff" class="text-muted"></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" id="cardCritical">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Critical Severity</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 id="criticalVulns"></h3>
                        <p>Critical Vulnerabilities</p>
                        <p id="criticalVulnsDiff" class="text-muted"></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" id="cardHigh">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">High Severity</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 id="highVulns"></h3>
                        <p>High Vulnerabilities</p>
                        <p id="highVulnsDiff" class="text-muted"></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" id="cardMedium">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Medium Severity</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 id="mediumVulns"></h3>
                        <p>Medium Vulnerabilities</p>
                        <p id="mediumVulnsDiff" class="text-muted"></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" id="cardLow">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Low Severity</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 id="lowVulns"></h3>
                        <p>Low Vulnerabilities</p>
                        <p id="lowVulnsDiff" class="text-muted"></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" id="cardInfo">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Informational Severity</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 id="informationalVulns"></h3>
                        <p>Informational Vulnerabilities</p>
                        <p id="informationalVulnsDiff" class="text-muted"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Severity Distribution Chart -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title">Severity Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="severityChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Vulnerability Types Chart -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title">Vulnerability Types</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="vulnTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vulnerabilities Breakdown -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="card-title">Vulnerabilities by Type (OWASP Top 10)</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="vulnTable">
                            <thead>
                                <tr>
                                    <th>Vulnerability</th>
                                    <th>Classification</th>
                                    <th>Quantity</th>
                                    <th>Severity</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        var vulnerability = <?php
                            echo json_encode($vulnerabilitiesByMonth);
                            ?>;
    </script>
    <script src="./js/index.js"></script>
    <script>
        updateVulnerabilityData(<?php echo date('m') ?>)
    </script>
</body>

</html>