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
<style>
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
        <a href="sales.php" class="nav-link"><i class="bi bi-bar-chart-line"></i>Sales</a>
        <a href="messages.php" class="nav-link"><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
        <a href="stocks.php" class="nav-link active"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
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
          <h4>Inventory of Stocks</h4>
        </div>
        <div class="button d-flex justify-content-between mb-5">
            <a href="view_low_stocks.php" ><img src="../image/growth.png" alt=""> <span class="stocks_get  position-relative"></span></a>
            <a href="add_stocks.php" class="btn btn-primary">Add Stocks</a>
        </div>
        <div class="data">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"type="button" role="tab" aria-controls="home" aria-selected="true">
                    Inventory
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="false">
                        Stocks
                    </button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0 bg-white rounded-bottom" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="mb-3">
                    <h3>Today Total Stocks Deduction</h3>
                    <div class="overflow-auto">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Laminating Plastic</th>
                            <th>Long Bond Paper </th>
                            <th>Short Bond Paper </th>
                            <th>A4 Bond Paper </th>
                            <th>Photo Paper</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_long = 0;
                        $total_short = 0;
                        $total_a4 = 0;
                        $total_laminating = 0;
                        $total_photopaper = 0;

                        // --- LONG ---
                        $type_long_xerox = "Xerox Long Bond Paper";
                        $type_long_print = "Printing Long Bond Paper";
                        $type_long_binding = "Book Binding Long";
                        $q_long = $conn->prepare("
                            SELECT SUM(quantity) AS total_long 
                            FROM `transaction` 
                            WHERE `date_uploaded` = ? AND `user_id` = ? 
                            AND (`type` = ? OR `type` = ? OR `type` = ?)
                        ");
                        $q_long->bind_param("sssss", $datetoday, $user_idko, $type_long_xerox, $type_long_print, $type_long_binding);
                        $q_long->execute();
                        $r_long = $q_long->get_result();
                        if ($r_long->num_rows > 0) {
                            $row_long = $r_long->fetch_assoc();
                            $total_long = (int)($row_long['total_long'] ?? 0);
                        }

                        // --- SHORT ---
                        $type_short_xerox = "Xerox Short Bond Paper";
                        $type_short_print = "Printing Short Bond Paper";
                        $type_short_binding = "Book Binding Short";
                        $q_short = $conn->prepare("
                            SELECT SUM(quantity) AS total_short 
                            FROM `transaction` 
                            WHERE `date_uploaded` = ? AND `user_id` = ? 
                            AND (`type` = ? OR `type` = ? OR `type` = ?)
                        ");
                        $q_short->bind_param("sssss", $datetoday, $user_idko, $type_short_xerox, $type_short_print, $type_short_binding);
                        $q_short->execute();
                        $r_short = $q_short->get_result();
                        if ($r_short->num_rows > 0) {
                            $row_short = $r_short->fetch_assoc();
                            $total_short = (int)($row_short['total_short'] ?? 0);
                        }

                        // --- A4 ---
                        $type_a4_xerox = "Xerox a4 Bond Paper";
                        $type_a4_print = "Printing a4 Bond Paper";
                        $type_a4_binding = "Book Binding a4";
                        $q_a4 = $conn->prepare("
                            SELECT SUM(quantity) AS total_a4 
                            FROM `transaction` 
                            WHERE `date_uploaded` = ? AND `user_id` = ? 
                            AND (`type` = ? OR `type` = ? OR `type` = ?)
                        ");
                        $q_a4->bind_param("sssss", $datetoday, $user_idko, $type_a4_xerox, $type_a4_print, $type_a4_binding);
                        $q_a4->execute();
                        $r_a4 = $q_a4->get_result();
                        if ($r_a4->num_rows > 0) {
                            $row_a4 = $r_a4->fetch_assoc();
                            $total_a4 = (int)($row_a4['total_a4'] ?? 0);
                        }

                        // --- LAMINATION ---
                        $laminating = "Lamination";
                        $q_lam = $conn->prepare("
                            SELECT SUM(quantity) AS total_laminating 
                            FROM `transaction` 
                            WHERE `date_uploaded` = ? AND `user_id` = ? AND `type` = ?
                        ");
                        $q_lam->bind_param("sss", $datetoday, $user_idko, $laminating);
                        $q_lam->execute();
                        $r_lam = $q_lam->get_result();
                        if ($r_lam->num_rows > 0) {
                            $row_lam = $r_lam->fetch_assoc();
                            $total_laminating = (int)($row_lam['total_laminating'] ?? 0);
                        }

                        // --- PHOTO PAPER ---
                        $photo_paper = "Photo Print";
                        $q_photo = $conn->prepare("
                            SELECT SUM(quantity) AS total_photopaper 
                            FROM `transaction` 
                            WHERE `date_uploaded` = ? AND `user_id` = ? AND `type` = ?
                        ");
                        $q_photo->bind_param("sss", $datetoday, $user_idko, $photo_paper);
                        $q_photo->execute();
                        $r_photo = $q_photo->get_result();
                        if ($r_photo->num_rows > 0) {
                            $row_photo = $r_photo->fetch_assoc();
                            $total_photopaper = (int)($row_photo['total_photopaper'] ?? 0);
                        }
                        ?>

                        <tr>
                            <td><?= $total_laminating; ?> Pieces</td>
                            <td><?= $total_long; ?> Pieces</td>
                            <td><?= $total_short; ?> Pieces</td>
                            <td><?= $total_a4; ?> Pieces</td>
                            <td><?= $total_photopaper; ?> Pieces</td>
                        </tr>


                        </tbody>
                      </table>
                    </div>
                  </div>
                  <h3>Today Transactions</h3>
                    <div class="overflow-auto">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>File</th>
                            <th>Type</th>
                            <th>Pages</th>
                            <th>Copies</th>
                            <th>Total</th>
                            <th>Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $number =1;
                          $get_info = $conn->prepare("SELECT * FROM `transaction` WHERE `date_uploaded` = ? AND `user_id` = ? GROUP BY `action_id` ORDER BY time_uploaded");
                          $get_info->bind_param("ss",$datetoday,$user_idko);
                          $get_info->execute();
                          $result_get = $get_info->get_result();
                          if($result_get->num_rows>0){
                            while($row_get = mysqli_fetch_assoc($result_get)){
                              $file  = htmlspecialchars($row_get['file']);
                              $type  = htmlspecialchars($row_get['type']);
                              $quantity  = htmlspecialchars($row_get['quantity']);
                              $total  = htmlspecialchars($row_get['total']);
                              $copies  = htmlspecialchars($row_get['copies']);
                              $time_uploaded  = htmlspecialchars($row_get['time_uploaded']);
                          
                        
                            
                          ?>
                          <tr>
                            <td><?php echo $number; ?></td>
                            <td><a href="../uploads/<?php echo $file; ?>" target="_blank">View</a></td>
                            <td><?php echo $type; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo $copies; ?></td>
                            <td>&#8369;<?php echo number_format($total, 0); ?></td>
                            <td><?php echo $time_uploaded; ?></td>
                          </tr>
                          <?php 
                          $number++;
                       
                          }
                          }else{
                            echo "<tr><td colspan='7'>No Trasaction Found Today</td></tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="overflow">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Laminating Plastic</th>
                                    <th>Long Bond Paper </th>
                                    <th>Short Bond Paper </th>
                                    <th>A4 Bond Paper </th>
                                    <th>Photo Paper</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $number =1;
                                $get_stocks = $conn->prepare("SELECT * FROM `stocks` WHERE `user_id` = ?");
                                $get_stocks->bind_param("s",$user_idko);
                                $get_stocks->execute();
                                $result_get = $get_stocks->get_result();
                                if($result_get->num_rows>0){
                                    while($row_get = mysqli_fetch_assoc($result_get)){
                                        $laminating_plastic = htmlspecialchars($row_get['laminating_plastic'] ?? 0);
    
                                        $laminating_plastic = htmlspecialchars($row_get['laminating_plastic'] ?? 0);
                                        $long_bond_paper = htmlspecialchars($row_get['long_bond_paper'] ?? 0);
                                        $short_bond_paper = htmlspecialchars($row_get['short_bond_paper'] ?? 0);
                                        $a4_bond_paper = htmlspecialchars($row_get['a4_bond_paper'] ?? 0);
                                        $photo_paper = htmlspecialchars($row_get['photo_paper'] ?? 0);
                                        ?>
                                            <tr>
                                                <td><?php echo $number; ?></td>
                                                <td><?php echo $laminating_plastic; ?></td>
                                                <td><?php echo $long_bond_paper; ?></td>
                                                <td><?php echo $short_bond_paper; ?></td>
                                                <td><?php echo $a4_bond_paper; ?></td>
                                                <td><?php echo $photo_paper; ?></td>
                                            </tr>
                                        <?php
                                        $number++;
                                    }
                                }else{
                                    echo "<tr><td colspan='5'>No Result Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>

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
        url: "get_stocks.php", 
        method: "GET",
        success: function(response) {
            $('.stocks_get').html(response);
        },
        error: function() {
            $('.stocks_get').html("Failed to load data.");
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