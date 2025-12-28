<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loyal Print - Daily Sales</title>
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
        <a href="daily.php" class="nav-link active "><i class="bi bi-calendar2"></i> Daily Sales</a>
        <a href="monthly.php" class="nav-link"><i class="bi bi-calendar3"></i> Monthly Sales</a>
        <a href="overall.php" class="nav-link"><i class="bi bi-bar-chart-line"></i> Overall Sales</a>
        <a href="messages.php" class="nav-link"><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
        <a href="stocks.php" class="nav-link"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
      </nav>

      <div class="profile mt-auto" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <img src="..//image/logo-1.jpeg" alt="admin" />
        <div class="meta">Admin User<small>Loyal Print Manager</small></div>
      </div>
    </aside>

    <main class="main">
      <button id="sidebarToggle" class="sidebar-toggle d-lg-none"><i class="bi bi-list"></i></button>

    <!-- DAILY SALES SECTION -->
      <section id="daily-section" >
        <div class="section-title d-flex justify-content-between align-items-center mb-3" style="margin-top: 50px;">
          <h4
          >Daily Sales</h4>
        </div>

        <div class="overview-cards d-flex gap-3 flex-wrap mb-3">

        <div class="panel p-0">
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
                  <!--<th>Action</th>-->
                </tr>
              </thead>
              <tbody>
                <?php
                $get_invoice = $conn->prepare("SELECT * FROM `invoice` WHERE `user_id` = ? AND `date_transaction` = ?");
                $get_invoice->bind_param("ss",$user_idko,$datetoday);
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
                    $location_back = "daily.php";
                ?>
                <tr>
                  <td><?php echo $invoice_id; ?></td>
                  <td><?php echo $customer_fullname; ?></td>
                  <td><?php echo $quantity; ?></td>
                  <td>&#8369;<?php echo $amount; ?></td>
                  <td><?php echo $time_transaction; ?></td>
                  <td><?php echo $date_transaction; ?></td>
                  <!--<td>
                     <a href="view_transaction.php?action_id=<?php echo $action_id; ?>&location_back=<?php echo $location_back; ?>" class="btn btn-success"><i class="bi bi-eye"></i> View Transaction</a>
                  </td>-->
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


  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('sidebarToggle').addEventListener('click',()=>{ 
      document.getElementById('sidebar').classList.toggle('show'); 
      document.body.classList.toggle('sidebar-open');
    });
  </script>

  
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