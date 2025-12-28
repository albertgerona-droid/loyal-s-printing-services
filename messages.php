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

  <style>
    .main_messages{

        padding:30px;
        height: 50vh;
    }
    /* Ensure the message section scrolls and the form stays at the bottom */
#daily-section {
    position: relative;
    padding-bottom: 70px; /* Adjust based on the height of your message form */
}

/* Style for the messages container, making it scrollable */
.messages {
    max-height: calc(100vh - 150px); /* Adjust the height so that the messages section scrolls */
    overflow-y: scroll;
    padding-right: 15px; /* To add space for the scroll bar */
}

form input{
  width:50%;
  
}

/* Input form stays fixed at the bottom */
form.d-flex {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: white; /* Optional: to keep the background white */
    padding: 10px;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Optional: add some shadow for better separation */
    z-index: 100;
}

/* Adjust the message input field's height and layout */
form.d-flex .form-control {
    height: 40px;
    flex-grow: 1;
}

/* Optional: Space between the input and button */
form.d-flex button {
    height: 40px;
    width: 40px;
    margin-left: 10px;
}

.message_input{
  width:75%;
}

@media(max-width:991px){
  .message_input{
    width:100%;
  }
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
        <a href="messages.php" class="nav-link active"><i class="bi bi-chat-left-dots"></i> Messages</a>
        <a href="stocks.php" class="nav-link"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
      </nav>

      <div class="profile mt-auto" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <img src="..//image/logo-1.jpeg" alt="admin" />
        <div class="meta">Admin User<small>Loyal Print Manager</small></div>
      </div>
    </aside>

    <main class="main">
    <button id="sidebarToggle" class="sidebar-toggle d-lg-none">
        <i class="bi bi-list"></i>
      </button>
    <!-- DAILY SALES SECTION -->
      <section id="daily-section" >
        <div class="section-title d-flex justify-content-between align-items-center mb-3" style="margin-top: 50px;">
          <h4>Messages</h4>
        </div>
        <div class="main-content">
            <div class="head_message">
                <h4>Loyal's Print Services</h4>
            </div>
            <div class="messages h-100">

            </div>
             
        </div>
      </section>
    </main>
  </div>


  <script src="js/bootstrap.bundle.min.js"></script>
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

<script>
  /*ajax pooliing real time */
document.addEventListener("DOMContentLoaded", () => {
      function fetchOwnerRequests() {
    $.ajax({
        url: "fetch_messages.php", 
        method: "GET",
        success: function(response) {
            $('.messages').html(response);
        },
        error: function() {
            $('.messages').html("Failed to load data.");
        }
    });
}

// Fetch initially
fetchOwnerRequests();

// Poll every 5 seconds
setInterval(fetchOwnerRequests, 1000);
});
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
