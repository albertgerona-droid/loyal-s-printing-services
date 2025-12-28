<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loyal Print - Monthly Sales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="..//style.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../image/logo-1.jpeg" type="image/x-icon">
  <script src="../js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <a href="monthly.php" class="nav-link active" ><i class="bi bi-calendar3"></i> Monthly Sales</a>
        <a href="overall.php" class="nav-link"><i class="bi bi-bar-chart-line"></i> Overall Sales</a>
        <a href="messages.php" class="nav-link"><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
        <a href="stocks.php" class="nav-link"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
      </nav>

     <div class="profile mt-auto" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <img src="..//image/logo-1.jpeg" alt="admin" />
        <div class="meta">Admin User<small>Loyal Print Manager</small></div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
      <button id="sidebarToggle" class="sidebar-toggle d-lg-none">
        <i class="bi bi-list"></i>
      </button>

      <!-- MONTHLY SALES SECTION -->
      <section id="monthly-section">
        <h4 class="mb-4" style="margin-top: 50px;">Monthly Sales </h4>

        <!-- Overview Cards -->
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <div class="card shadow-sm p-3 h-100">
              <div class="d-flex align-items-center">
                <i class="bi bi-cash-coin text-success fs-3 me-3"></i>
                <div>
                  <div class="text-muted small">Total Sales</div>
                <?php
                    $get_count = $conn->prepare("
                        SELECT SUM(amount) AS total_this_month 
                        FROM invoice 
                        WHERE user_id = ? 
                          AND MONTH(date_transaction) = MONTH(CURRENT_DATE())
                          AND YEAR(date_transaction) = YEAR(CURRENT_DATE())
                    ");
                    $get_count->bind_param("s", $user_idko);
                    $get_count->execute();
                    $result = $get_count->get_result();
                    $row = $result->fetch_assoc();

                    $total_this_month = $row['total_this_month'] ?? 0;
                    ?>

                  <div class="fw-bold text-success">₱<?php echo $total_this_month; ?></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card shadow-sm p-3 h-100">
              <div class="d-flex align-items-center">
                <i class="bi bi-cart-check text-primary fs-3 me-3"></i>
                <div>
                  <div class="text-muted small">Total Transaction</div>
                    <?php
                    $get_count = $conn->prepare("SELECT COUNT(*) as `total_transaction` FROM `invoice` WHERE `user_id` = ? AND MONTH(date_transaction) = MONTH(CURRENT_DATE()) AND YEAR(date_transaction) = YEAR(CURRENT_DATE())");
                    $get_count->bind_param("s", $user_idko);
                    $get_count->execute();
                    $result = $get_count->get_result();
                    $row = $result->fetch_assoc();

                    $total_transaction = $row['total_transaction'] ?? 0;
                    ?>

                  <div class="fw-bold"><?php echo $total_transaction; ?></div>
                </div>
              </div>
            </div>
          </div>


        </div>

        <!-- Sales Table -->
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Monthly Transactions</h5>
          </div>
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr>
                  <th>Invoice ID</th>
                  <th>Customer</th>
                  <th>Quantity</th>
                  <th>Amount</th>
                  <th>Time</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $get_invoice = $conn->prepare("SELECT * FROM `invoice` WHERE `user_id` = ? AND MONTH(date_transaction) = MONTH(CURRENT_DATE()) AND YEAR(date_transaction) = YEAR(CURRENT_DATE())");
                $get_invoice->bind_param("s",$user_idko);
                $get_invoice->execute();
                $result_daily = $get_invoice->get_result();
                if($result_daily->num_rows>0){
                  while($row_daily = mysqli_fetch_assoc($result_daily)){
                    $invoice_id = htmlspecialchars($row_daily['invoice_id'] ?? '');
                    $customer_fullname = htmlspecialchars($row_daily['customer_fullname'] ?? '');
                    $date_transaction = htmlspecialchars($row_daily['date_transaction'] ?? '');
                    $time_transaction = htmlspecialchars($row_daily['time_transaction'] ?? '');
                    $amount = htmlspecialchars($row_daily['amount'] ?? '');
                    $quantity = htmlspecialchars($row_daily['quantity'] ?? '');
                    $action_id = htmlspecialchars($row_daily['action_id'] ?? '');
                    $location_back = "monthly.php";
                ?>
                <tr>
                  <td><?php echo $invoice_id; ?></td>
                  <td><?php echo $customer_fullname; ?></td>
                  <td><?php echo $quantity; ?></td>
                  <td>&#8369;<?php echo $amount; ?></td>
                  <td><?php echo $time_transaction; ?></td>
                  <td><?php echo $date_transaction; ?></td>
                </tr>
                <?php
                   }
                }else{
                  echo "<tr><td colspan='7'>No Daily Transaction Found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
  </div>


                
  <script src="../js/bootstrap.bundle.min.js"></script>
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