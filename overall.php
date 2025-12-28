<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loyal Print - Overall Sales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <link href="..//style.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../image/logo-1.jpeg" type="image/x-icon">
  <script src="../js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  <style>
    .chart-container {
      height: 400px;
    }
  </style>
</head>
<body>
   <?php
      include '../config.php';
      include '../alerts.php'; 
      include 'logout_modal.php';
 if(!isset($_SESSION['active_login'])){
  echo "<script>location.href='../index.php';</script>";
}

  ?>
  <div class="app">
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <img src="..//image/logo-1.jpeg" alt="Loyal Print Logo" />
        <div>
         <div class="title">Loyal's Printing Shop</div>
          <div class="sub">Staff Dashboard</div>
        </div>
      </div>

       <nav class="mt-2">
        <a href="index.php" class="nav-link "><i class="bi bi-circle-half"></i> Dashboard Home</a>
        <a href="daily.php" class="nav-link  "><i class="bi bi-calendar2"></i> Daily Sales</a>
        <a href="monthly.php" class="nav-link " ><i class="bi bi-calendar3"></i> Monthly Sales</a>
        <a href="overall.php" class="nav-link active"><i class="bi bi-bar-chart-line"></i> Overall Sales</a>
        <a href="messages.php" class="nav-link"><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
        <a href="stocks.php" class="nav-link"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
      </nav>

      <div class="profile mt-auto" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <img src="..//image/logo-1.jpeg" alt="admin" />
        <div class="meta">Admin User<small>Loyal Print Manager</small></div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <button id="sidebarToggle" class="sidebar-toggle d-lg-none"><i class="bi bi-list"></i></button>

      <section>
        <h4 class="mb-4" style="margin-top: 50px;">Overall Sales Analytics</h4>

        <!-- LAYOUT: CHART + TABLE -->
        <div class="row g-4">
          <!-- Chart Column -->
          <div class="col-lg-12">
            <div class="card shadow-sm p-3">
              <h5 class="mb-3">Sales Chart</h5>
              <div class="chart-container">
               <?php
$get = $conn->prepare("
    SELECT DATE_FORMAT(date_transaction, '%M %Y') AS month, 
           SUM(amount) AS total
    FROM invoice
    WHERE user_id = ?
    GROUP BY DATE_FORMAT(date_transaction, '%Y-%m')
    ORDER BY month ASC
");

$get->bind_param("s", $user_idko);
$get->execute();
$result = $get->get_result();

$months = [];
$totals = [];
while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];      // e.g. "2025-01"
    $totals[] = $row['total'];      // monthly sum
}
?>

       <canvas id="overallChart"></canvas>

<script>
  const ctx = document.getElementById('overallChart').getContext('2d');

  const months = <?= json_encode($months) ?>;
  const totals = <?= json_encode($totals) ?>;

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Monthly Sales',
        data: totals,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Monthly Sales (₱)'
        },
        datalabels: {
          anchor: 'center',
          align: 'center',
          color: '#000',
          font: {
            weight: 'bold',
            size: 12
          },
          formatter: function(value) {
            return '₱' + value.toLocaleString();
          }
        }
      },
      scales: {
        y: { beginAtZero: true }
      }
    },
    plugins: [ChartDataLabels]
  });
</script>


              </div>
            </div>
          </div>

          <!-- Table Column -->
       
        </div>
      </section>
    </main>
  </div>


  <script src="js/bootstrap.bundle.min.js"></script>
 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
  /*ajax pooliing real time */
document.addEventListener("DOMContentLoaded", () => {
      function fetchOwnerRequests() {
    $.ajax({
        url: "fetch_notifications.php", 
        method: "GET",
        success: function(response) {
            $('.noti').html(response);
        },
        error: function() {
            $('.noti').html("Failed to load data.");
        }
    });
}

// Fetch initially
fetchOwnerRequests();

// Poll every 5 seconds
setInterval(fetchOwnerRequests, 1000);
});
</script>