<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loyal Print - Branch Management</title>
  <link rel="shortcut icon" href="../image/logo-1.jpeg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="../style.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/mycss.css">
  <script src="../js/jquery.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <style>
    .chart-container {
      height: 400px;
    }

    /* --- Sidebar Toggle CSS --- */
    .sidebar {
      width: 267px;
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

    .btn_branch{
      background:#2c3e50;
      color:white;
    }
    .btn_branch:hover{
       color:#2c3e50;
       border:1px solid #2c3e50;
    }
  </style>
</head>

<body>
<?php
  include '../config.php';
  include '../alerts.php'; 
  if(!isset($_SESSION['admin_session'])){
    echo "<script>location.href='../index.php';</script>";
  }
?>
<div class="app">
  <!-- Overlay for mobile -->
  <div id="sidebarOverlay" class="sidebar-overlay" aria-hidden="true"></div>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <img src="../image/logo-1.jpeg" alt="Loyal Print Logo" />
      <div>
        <div class="title">Loyal's&nbsp;Printing Shop</div>
        <div class="sub">Admin Dashboard</div>
      </div>
    </div>

    <nav class="mt-2">
      <a href="index.php" class="nav-link"><i class="bi bi-circle-half"></i> Dashboard Home</a>
      <a href="users.php" class="nav-link active"><i class="bi bi-person-circle"></i> Branch</a> 
      <a href="sales.php" class="nav-link"><i class="bi bi-bar-chart-line"></i> Sales</a>
      <a href="messages.php" class="nav-link"><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
      <a href="stocks.php" class="nav-link"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
    </nav>

    <div class="profile mt-auto" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor:pointer;">
      <img src="../image/logo-1.jpeg" alt="admin" />
      <div class="meta">
        Admin User
        <small>Loyal Print Manager</small>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">
    <button id="sidebarToggle" class="sidebar-toggle d-lg-none"><i class="bi bi-list"></i></button>

    <section>
      <h4 class="mb-4" style="margin-top: 50px;">Branch Management</h4>
        <div class="mb-3 text-end">
           <a href="add_branch.php" class="btn btn_branch"><img src="../image/subsidiary.png" alt=""> Add Branch</a>
        </div>
        <div class="card shadow-sm p-3">
            <h5 class="mb-3">Existing Users</h5>
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>User ID</th>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $type="Admin";
                  $get_accounts = $conn->prepare("SELECT * FROM `accounts` WHERE `user_type` != ? ");
                  $get_accounts->bind_param("s",$type);
                  $get_accounts->execute();
                  $result_accounts = $get_accounts->get_result();
                  if($result_accounts->num_rows>0){
                    while($row_acc = mysqli_fetch_assoc($result_accounts)){
                      echo "<tr>
                        <td>".htmlspecialchars($row_acc['user_id'])."</td>
                        <td>".htmlspecialchars($row_acc['branch_name'])."</td>
                        <td>".htmlspecialchars($row_acc['location'])."</td>
                        <td>".htmlspecialchars($row_acc['email'])."</td>
                      </tr>";
                    }
                  }else{
                    echo "<tr><td colspan='4'>No Branch Account Found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

    </section>
  </main>
</div>


  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">Are you sure you want to log out?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script>
// Sidebar toggle script
document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const toggleBtn = document.getElementById("sidebarToggle");
  const overlay = document.getElementById("sidebarOverlay");
  const main = document.querySelector(".main");

  if (!sidebar || !toggleBtn) return;

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
    if (sidebar.classList.contains("active")) closeSidebar();
    else openSidebar();
  });

  overlay.addEventListener("click", closeSidebar);
  document.addEventListener("keydown", e => {
    if (e.key === "Escape") closeSidebar();
  });

  // Auto-close when clicking a nav link (mobile)
  sidebar.addEventListener("click", e => {
    if (e.target.closest("a.nav-link") && window.innerWidth <= 991) {
      closeSidebar();
    }
  });
});
</script>

<script>
/* AJAX polling for notifications */
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
  fetchOwnerRequests();
  setInterval(fetchOwnerRequests, 1000);
});
</script>
</body>
</html>
