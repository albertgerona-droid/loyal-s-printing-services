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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>
<body>


<style>
   .sidebar {
      width: 320px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    @media (max-width: 991px) {
    

      .sidebar.active {
        transform: translateX(0);
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.25);
      }

      .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1045;
      }

      .sidebar-overlay.show {
        display: block;
      }

      .main.shifted {
        transform: translateX(260px);
        transition: transform 0.3s ease;
      }
    }
</style>

  <?php
      include '../config.php';
      include '../alerts.php'; 
      include 'logout_modal.php';
 if(!isset($_SESSION['active_login'])){
  echo "<script>location.href='../index.php';</script>";
}
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';
  ?>
  <div class="app">
    <div id="sidebarOverlay" class="sidebar-overlay" aria-hidden="true"></div>
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <img src="..//image/logo-1.jpeg" alt="Loyal Print Logo" />
        <div>
         <p class="fw-bold text-light m-0"><?php echo $branch_nameko; ?></p>
          <div class="sub">Staff Dashboard</div>
        </div>
      </div>

       <nav class="mt-2">
        <a href="index.php" class="nav-link "><i class="bi bi-circle-half"></i> Dashboard Home</a>
        <a href="sales.php" class="nav-link active"><i class="bi bi-bar-chart-line"></i>Sales</a>
        <a href="messages.php" class="nav-link "><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
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
                    <h4>Sales</h4>
                    </div>

                    <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $active_tab == 'home' ? 'active' : ''; ?>" 
                                id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                                type="button" role="tab">Daily</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $active_tab == 'monthly' ? 'active' : ''; ?>" 
                                id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                                type="button" role="tab">Monthly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $active_tab == 'all' ? 'active' : ''; ?>" 
                                id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                                type="button" role="tab">Overall</button>
                    </li>
                    </ul>

                    <div class="tab-content mt-3" id="myTabContent">

                    <!-- DAILY TAB -->
                    <div class="tab-pane fade <?php echo $active_tab == 'home' ? 'show active' : ''; ?> p-3" id="home-tab-pane" role="tabpanel">
                        <form method="GET" action="" class="d-flex justify-content-end align-items-end">
                        <input type="hidden" name="tab" value="home">
                        <div class="d-flex gap-2 align-items-end">
                            <div>
                            <label class="form-label fw-semibold">Select Date:</label>
                            <input type="date" name="date" class="form-control"
                                    value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="button" class="btn btn-danger" onclick="downloadPDF('dailyTable', 'Daily_Sales_Report')">Download PDF</button>
                        </div>
                        </form>

                        <div class="overflow-auto mt-3" id="dailyTable">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th>Pages</th>
                                <th>Amount</th>
                                <th>Time</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $selected_date = $_GET['date'] ?? $datetoday;
                            $get_invoice = $conn->prepare("SELECT * FROM `invoice` WHERE `user_id` = ? AND `date_transaction` = ?");
                            $get_invoice->bind_param("ss", $user_idko, $selected_date);
                            $get_invoice->execute();
                            $result = $get_invoice->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['invoice_id']}</td>
                                    <td>{$row['customer_fullname']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>&#8369;{$row['amount']}</td>
                                    <td>{$row['time_transaction']}</td>
                                    <td>{$row['date_transaction']}</td>
                                </tr>";
                                }
                            } else echo "<tr><td colspan='6' class='text-center text-muted'>No transactions found.</td></tr>";
                            ?>
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- MONTHLY TAB -->
                    <div class="tab-pane fade <?php echo $active_tab == 'monthly' ? 'show active' : ''; ?> p-3" id="profile-tab-pane" role="tabpanel">
                        <form method="GET" action="" class="d-flex justify-content-end align-items-end">
                        <input type="hidden" name="tab" value="monthly">
                        <div class="d-flex gap-2 align-items-end">
                            <div>
                            <label class="form-label fw-semibold">Select Month:</label>
                            <input type="month" name="month" class="form-control"
                                    value="<?php echo isset($_GET['month']) ? $_GET['month'] : date('Y-m'); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="button" class="btn btn-danger" onclick="downloadPDF('monthlyTable', 'Monthly_Sales_Report')">Download PDF</button>
                        </div>
                        </form>

                        <div class="overflow-auto mt-3" id="monthlyTable">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Invoice ID</th><th>Customer</th><th>Quantity</th><th>Amount</th><th>Time</th><th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $selected_month = $_GET['month'] ?? date('Y-m');
                            $year = date('Y', strtotime($selected_month . "-01"));
                            $month = date('m', strtotime($selected_month . "-01"));
                            $get_invoice = $conn->prepare("SELECT * FROM `invoice` WHERE `user_id`=? AND MONTH(`date_transaction`)=? AND YEAR(`date_transaction`)=?");
                            $get_invoice->bind_param("sii", $user_idko, $month, $year);
                            $get_invoice->execute();
                            $result = $get_invoice->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['invoice_id']}</td>
                                    <td>{$row['customer_fullname']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>&#8369;{$row['amount']}</td>
                                    <td>{$row['time_transaction']}</td>
                                    <td>{$row['date_transaction']}</td>
                                </tr>";
                                }
                            } else echo "<tr><td colspan='6' class='text-center text-muted'>No monthly transactions.</td></tr>";
                            ?>
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- OVERALL TAB -->
                    <div class="tab-pane fade <?php echo $active_tab == 'all' ? 'show active' : ''; ?> p-3" id="contact-tab-pane" role="tabpanel">
                        <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger mb-3" onclick="downloadPDF('overallTable', 'Overall_Sales_Report')">Download PDF</button>
                        </div>

                        <div class="overflow-auto" id="overallTable">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Invoice ID</th><th>Customer</th><th>Quantity</th><th>Amount</th><th>Time</th><th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $get_invoice = $conn->prepare("SELECT * FROM `invoice` WHERE `user_id` = ?");
                            $get_invoice->bind_param("s", $user_idko);
                            $get_invoice->execute();
                            $result = $get_invoice->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['invoice_id']}</td>
                                    <td>{$row['customer_fullname']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>&#8369;{$row['amount']}</td>
                                    <td>{$row['time_transaction']}</td>
                                    <td>{$row['date_transaction']}</td>
                                </tr>";
                                }
                            } else echo "<tr><td colspan='6' class='text-center text-muted'>No transactions found.</td></tr>";
                            ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>

                    <!-- JS PDF EXPORT FUNCTION -->
                    <script>
                    async function downloadPDF(tableId, filename) {
                    const { jsPDF } = window.jspdf;
                    const element = document.getElementById(tableId);

                    const pdf = new jsPDF('p', 'pt', 'a4');
                    const canvas = await html2canvas(element, { scale: 2 });
                    const imgData = canvas.toDataURL('image/png');
                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save(filename + '.pdf');
                    }
                    </script>

       
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

 <script>
  // Sidebar toggle script
  document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");
    const main = document.querySelector(".main");

    if (!sidebar || !toggleBtn) {
      console.error("Sidebar or toggle button not found!");
      return;
    }

    function openSidebar() {
      sidebar.classList.add("active");
      overlay.classList.add("show");
      main.classList.add("shifted");
    }

    function closeSidebar() {
      sidebar.classList.remove("active");
      overlay.classList.remove("show");
      main.classList.remove("shifted");
    }

    toggleBtn.addEventListener("click", () => {
      if (sidebar.classList.contains("active")) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });

    overlay.addEventListener("click", closeSidebar);
    document.addEventListener("keydown", e => {
      if (e.key === "Escape") closeSidebar();
    });
  });
  </script>