

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Loyal Print - Dashboard Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <link href="..//style.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../image/logo-1.jpeg" type="image/x-icon">
  <script src="../js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@5.4.394/+esm"></script>
  <?php
      include '../config.php';
      include '../alerts.php'; 
      include 'logout_modal.php';
 if(!isset($_SESSION['active_login'])){
  echo "<script>location.href='../index.php';</script>";
}
  ?>
  <style>
    body {
      box-sizing: border-box;
    }
    
    .stats-card {
      background: white;
      border: 1px solid #e9ecef;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    
    .stats-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .stats-icon {
      width: 60px;
      height: 60px;
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
    }
    
    .upload-area {
      border: 3px dashed #dee2e6;
      border-radius: 20px;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    
    .upload-area:hover {
      border-color: #3498db;
      background: #f8f9fa;
    }
    
    .upload-area.dragover {
      border-color: #2ecc71;
      background: linear-gradient(135deg, #eafaf1 0%, #d5f4e6 100%);
      transform: scale(1.05);
    }
    
    .file-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      border: 1px solid #e9ecef;
    }
    
    .file-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }
    
    .transaction-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      border-left: 5px solid #3498db;
      transition: all 0.3s ease;
    }
    
    .transaction-card:hover {
      transform: translateX(5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    
    .btn-custom {
      border-radius: 25px;
      padding: 10px 25px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      border: none;
      position: relative;
      overflow: hidden;
    }
    
    .print-option-card {
      border: 2px solid #e9ecef;
      border-radius: 15px;
      transition: all 0.3s ease;
      cursor: pointer;
      background: white;
      position: relative;
      overflow: hidden;
    }
    
    .print-option-card:hover {
      border-color: #3498db;
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(52, 152, 219, 0.15);
    }
    
    .print-option-card.selected {
      border-color: #2ecc71;
      background: linear-gradient(135deg, #eafaf1 0%, #d5f4e6 100%);
      box-shadow: 0 10px 25px rgba(46, 204, 113, 0.2);
    }
    
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1060;
      min-width: 300px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
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
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <div id="sidebarOverlay" class="sidebar-overlay" aria-hidden="true"></div>
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <img src="..//image/logo-1.jpeg" alt="Loyal Print Logo" />
        <div>
          <p class="fw-bold text-light m-0"><?php echo $branch_nameko; ?></p>
          <div class="sub">Staff Dashboard </div>
        </div>
      </div>

       <nav class="mt-2">
        <a href="index.php" class="nav-link active"><i class="bi bi-circle-half"></i> Dashboard Home</a>
        <a href="sales.php" class="nav-link"><i class="bi bi-bar-chart-line"></i>Sales</a>
        <a href="messages.php" class="nav-link"><i class="bi bi-chat-left-dots"></i> Messages <span class="noti position-relative"></span></a>
        <a href="stocks.php" class="nav-link"><i class="bi bi-floppy2-fill"></i> Inventory of Stocks</a>
      </nav>

      <div class="profile mt-auto" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <img src="..//image/logo-1.jpeg" alt="admin" />
        <div class="meta">
          Admin User
          <small>Loyal Print Manager</small>
        </div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <!-- Hamburger -->
      <button id="sidebarToggle" class="sidebar-toggle d-lg-none">
        <i class="bi bi-list"></i>
      </button>

      <section>
        <div class="page-header">
          <div>
            <h1>Dashboard Overview</h1>
            <p>Welcome back! Here's what's happening at Loyal Print today.</p>
          </div>
          <div class="last-updated">
         
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
          <div class="col-12 col-md-12 col-xl-12">
            <div class="card stats-card h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-primary me-3">
                    <i class="fas fa-file-alt"></i>
                  </div>
                  <div>
                    <p class="small text-muted mb-1 fw-semibold">TOTAL FILES</p>
                    <?php
                  $count_files = $conn->prepare("SELECT COUNT(*) as `total_files` FROM `transaction` WHERE `user_id` = ?");
                  $count_files->bind_param("s",$user_idko);
                  $count_files->execute();
                  $result_files = $count_files->get_result();
                  if($result_files->num_rows>0){
                    while($row_files = mysqli_fetch_assoc($result_files)){
                      $total_files = htmlspecialchars($row_files['total_files'] ?? 0);
                    }
                  }
                    ?>
                    <h3 class="fw-bold mb-0" id="totalFiles"><?php echo $total_files; ?></h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--
          <div class="col-12 col-md-6 col-xl-4">
            <div class="card stats-card h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-success me-3">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <div>
                    <p class="small text-muted mb-1 fw-semibold">COMPLETED TASKS</p>
                    <h3 class="fw-bold mb-0">18</h3>
                    <small class="text-success">
                      <i class="fas fa-arrow-up me-1"></i>8% from last week
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-12 col-md-6 col-xl-4">
            <div class="card stats-card h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-center">
                  <div class="stats-icon bg-warning me-3">
                    <i class="fas fa-hdd"></i>
                  </div>
                  <div>
                    <p class="small text-muted mb-1 fw-semibold">STORAGE USED</p>
                    <h3 class="fw-bold mb-0">2.4 GB</h3>
                    <small class="text-info">
                      <i class="fas fa-info-circle me-1"></i>24% of 10GB
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>-->
        </div>
        <form action="function.php" method="POST" class="card mb-3 p-3">
          <div class="mb-3">
            <div class="row">
              <div class="col-lg-6">
                <label for="" class="form-label">Paper Jam</label>
                <input type="text" name="pieces" class="form-control" placeholder="Enter Paper Jam" minlength="1"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
              </div>
              <div class="col-lg-6">
                <label for="" class="form-label">Type of Coupon Bond</label>
                <select name="type" id="" class="form-control">
                  <option value="" disabled selected>Select</option>
                  <option value="long">Long Bond Paper</option>
                  <option value="short">Short Bond Paper</option>
                  <option value="a4">A4 Bond Paper</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3 text-end">
            <input type="submit" name="save_paper_jam" class="btn btn-success" value="Save">
          </div>
        </form>
        <!-- File Upload Section -->
        <form action="function.php" method="POST" enctype="multipart/form-data">
          <div class="card mb-4">
          <div class="card-header bg-transparent border-0 pb-0">
            <h4 class="card-title fw-bold mb-0">
              <i class="bi bi-cloud-upload me-2 text-primary"></i>Upload Files
            </h4>
            <p class="text-muted small mb-0">Drag and drop files or click to browse</p>
          </div>
          <div class="card-body">
            <div class="upload-area text-center p-5" 
                 id="uploadArea"
                 ondrop="handleDrop(event)" 
                 ondragover="handleDragOver(event)" 
                 ondragleave="handleDragLeave(event)"
                 onclick="document.getElementById('fileInput').click()">
              <i class="bi bi-cloud-upload fa-3x text-muted mb-3"></i>
              <h5 class="fw-semibold text-dark mb-2">Drop files here or click to browse</h5>
              <p class="text-muted small mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Supports: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max 10MB)
              </p>
            </div>
            
            <input type="file" id="fileInput" name="files[]" multiple  class="d-none" onchange="handleFileSelect(event)" required>
            
            <!-- Upload Progress -->
            <div id="uploadProgress" class="mt-4 d-none">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small fw-semibold">Uploading...</span>
                <span class="small text-muted" id="progressPercent">0%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 0%"></div>
              </div>
              <p class="small text-muted mt-2 mb-0" id="progressText">Preparing upload...</p>
            </div>
            
            <!-- File List -->
            <div id="fileList" class="mt-4 ">
            </div>

            <div class="customer-form mb-3">
                 <input type="text" class="form-control" name="customer_fullname" placeholder="Enter Customer Fullname" required>
            </div>

            <div class="commad_button  text-end">
                <button type="submit" name="save_transaction" class="btn btn-success btn-custom " >
                  <i class="bi bi-send me-1"></i>Submit Order
                </button>
            </div>
          </div>
        </div>
        </form>

        <!-- Transaction History -->
        <div class="card">
          <div class="card-header bg-transparent border-0 pb-0">
            <h4 class="card-title fw-bold mb-0">
              <i class="bi bi-clock-history me-2 text-primary"></i>Transaction History
            </h4>
            <p class="text-muted small mb-0">Track your print job submissions and status</p>
          </div>
          <div class="card-body">
            <div id="transactionHistory">
              <div class="overflow-auto">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Type</th>
                        <th>Pages</th>
                        <th>Copies</th>
                        <th>Total</th>
                        <th>Date Uploaded</th>
                        <th>Time Uploded</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $get_mytransaction= $conn->prepare("SELECT * FROM `transaction` WHERE `user_id` = ? GROUP BY `action_id`");
                        $get_mytransaction->bind_param("s",$user_idko);
                        $get_mytransaction->execute();
                        $result_transaction = $get_mytransaction->get_result();
                        if($result_transaction->num_rows>0){
                          while($row_trasaction = mysqli_fetch_assoc($result_transaction)){
                            $type = htmlspecialchars($row_trasaction['type'] ?? '');
                            $quantity = htmlspecialchars($row_trasaction['quantity'] ?? '');
                            $total = htmlspecialchars($row_trasaction['total'] ?? '');
                            $date_uploaded = htmlspecialchars($row_trasaction['date_uploaded'] ?? '');
                            $time_uploaded = htmlspecialchars($row_trasaction['time_uploaded'] ?? '');
                            $copies = htmlspecialchars($row_trasaction['copies'] ?? '');
                            ?>
                             <tr>
                              <td><?php echo $type; ?></td>
                              <td><?php echo $quantity; ?></td>
                              <td><?php echo $copies; ?></td>
                              <td>&#8369; <?php echo $total; ?></td>
                              <td><?php echo $date_uploaded; ?></td>
                              <td><?php echo $time_uploaded; ?></td>
                            </tr>
                            <?php

                          }
                        }else{
                          echo "<tr><td colspan='5'>No Trasaction Found</td></tr>";
                        }
                      ?>
                     
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
   <!-- 🔹 Modal for file preview -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="filePreviewLabel">File Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div id="filePreviewContent" class="w-100"></div>
      </div>
    </div>
  </div>
</div>


<?php
 $count_stocks_long_bond = $conn->prepare("SELECT * FROM `stocks` WHERE `user_id` = ?");
 $count_stocks_long_bond->bind_param("s",$user_idko);
 $count_stocks_long_bond->execute();
 $result_data = $count_stocks_long_bond->get_result();
 if($result_data->num_rows>0){
  while($row_get = mysqli_fetch_assoc($result_data)){
    $laminating_plastic = (int)$row_get['laminating_plastic'] ?? 0;
    $long_bond_paper = (int)$row_get['long_bond_paper'] ?? 0;
    $photo_paper = (int)$row_get['photo_paper'] ?? 0;
    $short_bond_paper = (int)$row_get['short_bond_paper'] ?? 0;
    $a4_bond_paper = (int)$row_get['a4_bond_paper'] ?? 0;

  }
 }
?>


<script>
let uploadedGroup = null;
let selectedPrintOption = null;
let transactions = [];
let transactionCounter = 1;

// Handle drag & drop
function handleDragOver(event) {
  event.preventDefault();
  document.getElementById('uploadArea').classList.add('dragover');
}

function handleDragLeave(event) {
  event.preventDefault();
  document.getElementById('uploadArea').classList.remove('dragover');
}

function handleDrop(event) {
  event.preventDefault();
  document.getElementById('uploadArea').classList.remove('dragover');
  processFiles(event.dataTransfer.files);
}

function handleFileSelect(event) {
  processFiles(event.target.files);
}

// Process files, count PDF pages
async function processFiles(files) {
  if (!files.length) return;

  let totalPages = 0;
  const previews = [];

  for (const file of files) {
    let filePages = 1; // default for non-PDF

    if (file.type === "application/pdf") {
      try {
        const arrayBuffer = await file.arrayBuffer();
        const content = new Uint8Array(arrayBuffer);
        const text = new TextDecoder("utf-8").decode(content);
        const matches = text.match(/\/Type\s*\/Page\b/g);
        filePages = matches ? matches.length : 1;
      } catch (err) {
        console.error("PDF page count error:", err);
        filePages = 1;
      }
    }

    totalPages += filePages;

    previews.push({
      name: file.name,
      type: file.type,
      url: URL.createObjectURL(file),
      pages: filePages
    });
  }

  uploadedGroup = {
    groupName: `Batch_${new Date().getTime()}`,
    totalFiles: files.length,
    totalPages: totalPages,
    fileNames: Array.from(files).map(f => f.name),
    size: Array.from(files).reduce((acc, f) => acc + f.size, 0),
    uploadDate: new Date().toLocaleDateString(),
    previews: previews
  };

  updateFileList();

  // ✅ Set quantity input = total pages
  const qtyInput = document.getElementById('quantity');
  if (qtyInput) {
    qtyInput.value = uploadedGroup.totalPages;
    qtyInput.min = uploadedGroup.totalPages;

    qtyInput.addEventListener('input', () => {
      if (parseInt(qtyInput.value) < uploadedGroup.totalPages || isNaN(qtyInput.value)) {
        qtyInput.value = uploadedGroup.totalPages;
      }
      updateTotal();
    });

    updateTotal();
  }
}

// Update file list display
function updateFileList() {
  const fileList = document.getElementById('fileList');
  fileList.innerHTML = '';

  if (!uploadedGroup) return;

  const size = formatFileSize(uploadedGroup.size);
  const card = document.createElement('div');
  card.className = 'file-card mb-3';
  card.innerHTML = `
    <div class="card">
      <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-3">
              <i class="bi bi-folder2-open text-primary"></i>
            </div>
            <div>
              <h6 class="fw-semibold mb-1">
                Uploaded Batch (${uploadedGroup.totalFiles} files / ${uploadedGroup.totalPages} pages)
              </h6>
              <small class="text-muted">${size} • Uploaded ${uploadedGroup.uploadDate}</small>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-secondary btn-sm" onclick="viewFilePreview()">
              <i class="bi bi-eye me-1"></i>Preview
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="showPrintOptions()">
              <i class="bi bi-printer me-1"></i>Print Options
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFiles()">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>

        <div id="printOptions" class="collapse mt-3">
          <div class="card bg-light">
            <div class="card-header bg-transparent border-0">
              <h6 class="fw-bold mb-0"><i class="bi bi-printer me-2 text-primary"></i>Print Options</h6>
            </div>
            <div class="card-body">
              <div class="row g-3" id="optionCards">
                ${getPrintOptionCards()}
              </div>

              <div class="mt-4 p-3 bg-primary bg-opacity-10 rounded-3">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <div class="mb-2">
                      <small class="fw-semibold text-primary">Selected Service:</small>
                      <input type="text" id="selectedOption" name="options[]" class="form-control form-control-sm" readonly>
                    </div>
                    <div id="sizeSelector" class="mb-2 d-none">
                      <small class="fw-semibold text-primary">Select Size / Type:</small>
                      <select class="form-select form-select-sm" onchange="updateSizePrice()" id="selectedSize">
                        <option value="" disabled selected>-- Choose Option --</option>
                      </select>
                    </div>
                   <div class="d-flex align-items-center gap-2">
                    <small class="fw-semibold text-primary me-2">Page / Pages:</small>
                 <input type="text" 
                  id="quantity" 
                  name="quantity[]" 
                  value="1" 
                  min="1"
                  class="form-control form-control-sm" 
                  style="width: 80px;" 
                  onchange="updateTotal()"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    <small class="fw-semibold text-primary mx-2">Copies:</small>
                    <input type="text" id="copies" name="copies[]" value="1" min="1"
                          class="form-control form-control-sm" style="width: 80px;"
                          onchange="updateTotal()"   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                  </div>

                  </div>

                  <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="mb-2">
                      <h5 class="fw-bold text-primary mb-0">
                        Total: ₱ <input type="text" id="total" name="total[]"  value="0.00" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  `;
  fileList.appendChild(card);
}

// Helper to format file sizes
function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Show print options
function showPrintOptions() {
  const optionsDiv = document.getElementById('printOptions');
  const bsCollapse = new bootstrap.Collapse(optionsDiv, { toggle: true });
}
  // Recalculate total when quantity or size changes
function updateSizePrice() {
  const select = document.getElementById('selectedSize');
  const price = parseFloat(select.value) || 0;
  selectedPrintOption.price = price;
  updateTotal();
}

function updateTotal() {
  const qty = parseInt(document.getElementById("quantity").value) || 1;
  let finalPrice = 0;

  if (!selectedPrintOption) {
    document.getElementById("total").value = '0.00';
    return;
  }

  // Book Binding special pricing
  if (selectedPrintOption.type.includes("Book Binding")) {
    if (qty <= 160) {
      finalPrice = 80;
    } else {
      finalPrice = 120;
    }
  } else {
    // Other services: use dropdown price × quantity
    finalPrice = (selectedPrintOption.price || 0) * qty;
  }

  document.getElementById("total").value = finalPrice.toFixed(2);
}


  // Update total live while typing quantity
  document.addEventListener("input", (e) => {
    if (e.target.id === "quantity") updateTotal();
  });


function getPrintOptionCards() {
  const options = [
    { type: 'Xerox Long Bond Paper', icon: 'bi-files', color: 'primary', label: 'Xerox Long Bond Paper (<?php echo $long_bond_paper; ?>)' },
    { type: 'Xerox Short Bond Paper', icon: 'bi-files', color: 'primary', label: 'Xerox Short Bond Paper (<?php echo $short_bond_paper; ?>)' },
    { type: 'Xerox a4 Bond Paper', icon: 'bi-files', color: 'primary', label: 'Xerox a4 Bond Paper (<?php echo $a4_bond_paper; ?>)' },
    { type: 'Printing Long Bond Paper', icon: 'bi-palette', color: 'success', label: 'Printing Long Bond Paper (<?php echo $long_bond_paper; ?>)' },
    { type: 'Printing Short Bond Paper', icon: 'bi-palette', color: 'success', label: 'Printing Short Bond Paper (<?php echo $short_bond_paper; ?>)' },
    { type: 'Printing a4 Bond Paper', icon: 'bi-palette', color: 'success', label: 'Printing a4 Bond Paper (<?php echo $a4_bond_paper; ?>)' },
    { type: 'Photo Print', icon: 'bi-image', color: 'warning', label: 'Photo Print (<?php echo $photo_paper; ?>)' },
    { type: 'laminate', icon: 'bi-shield-check', color: 'info', label: 'Lamination (<?php echo $laminating_plastic; ?>)' },
    { type: 'Book Binding Long', icon: 'bi-book', color: 'secondary', label: 'Book Binding Long (<?php echo $long_bond_paper; ?>)' },
    { type: 'Book Binding Short', icon: 'bi-book', color: 'secondary', label: 'Book Binding Short (<?php echo $short_bond_paper; ?>)' },
    { type: 'Book Binding a4', icon: 'bi-book', color: 'secondary', label: 'Book Binding a4 (<?php echo $a4_bond_paper; ?>)' },
    { type: 'tarpaulin', icon: 'bi-image', color: 'danger', label: 'Tarpaulin' }
  ];

  return options.map(opt => `
    <div class="col-12 col-md-6 col-lg-4">
      <div class="print-option-card card h-100 p-3" 
           data-option="${opt.type}" 
           onclick="selectPrintOption('${opt.type}', this)">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="fw-semibold mb-0">
            <i class="bi ${opt.icon} me-2 text-${opt.color}"></i>${opt.label}
          </h6>
          ${opt.price ? `<span class="h6 fw-bold text-${opt.color} mb-0">${opt.price}</span>` : ''}
        </div>
      </div>
    </div>
  `).join('');
}

function viewFilePreview() {
  const previewDiv = document.getElementById('filePreviewContent');
  previewDiv.innerHTML = '';

  if (!uploadedGroup) {
    previewDiv.innerHTML = `<p class="text-muted">No files available.</p>`;
  } else {
    uploadedGroup.previews.forEach(file => {
      if (file.type.startsWith('image/')) {
        previewDiv.innerHTML += `<img src="${file.url}" class="img-fluid rounded shadow mb-3" alt="${file.name}">`;
      } else if (file.type === 'application/pdf') {
        previewDiv.innerHTML += `<embed src="${file.url}" type="application/pdf" width="100%" height="400px" class="mb-3"/>`;
      } else {
        previewDiv.innerHTML += `<p class="text-muted">${file.name} (Preview not available)</p>`;
      }
    });
  }

  const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
  modal.show();
}

function removeFiles() {
  if (uploadedGroup && uploadedGroup.previews) {
    uploadedGroup.previews.forEach(p => URL.revokeObjectURL(p.url));
  }
  uploadedGroup = null;
  document.getElementById('fileList').innerHTML = '';
}

function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function showPrintOptions() {
  const optionsDiv = document.getElementById('printOptions');
  const bsCollapse = new bootstrap.Collapse(optionsDiv, { toggle: true });
}
function selectPrintOption(optionType, card) {
  document.querySelectorAll('.print-option-card').forEach(c => {
    c.classList.remove('selected');
    c.style.borderColor = '#e9ecef';
    c.style.backgroundColor = 'white';
  });

  card.classList.add('selected');
  card.style.borderColor = '#2ecc71';
  card.style.backgroundColor = '#eafaf1';

  const optionNames = {
    'Xerox Long Bond Paper': 'Xerox Long Bond Paper',
    'Xerox Short Bond Paper': 'Xerox Short Bond Paper',
    'Xerox a4 Bond Paper': 'Xerox a4 Bond Paper',
    'Printing Long Bond Paper': 'Printing Long Bond Paper',
    'Printing Short Bond Paper': 'Printing Short Bond Paper',
    'Printing a4 Bond Paper': 'Printing a4 Bond Paper',
    'Photo Print': 'Photo Print',
    'laminate': 'Lamination',
    'Book Binding Long': 'Book Binding Long',
    'Book Binding Short': 'Book Binding Short',
    'Book Binding a4': 'Book Binding a4',
    'tarpaulin': 'Tarpaulin'
  };

  selectedPrintOption = { type: optionType, name: optionNames[optionType], price: 0 };
  document.getElementById('selectedOption').value = optionNames[optionType];

  // Only show size dropdown for non-Book Binding
  const sizeDiv = document.getElementById('sizeSelector');
  if (optionType.includes("Book Binding")) {
      sizeDiv.classList.add('d-none'); // hide size dropdown
  } else {
      sizeDiv.classList.remove('d-none');
      setupSizeDropdown(optionType);
  }

  // Always recalc total when switching options
  updateTotal();
}



function setupSizeDropdown(optionType) {
  const sizeDiv = document.getElementById('sizeSelector');
  const select = document.getElementById('selectedSize');
  select.innerHTML = `<option value="">-- Choose Option --</option>`;
  sizeDiv.classList.remove('d-none');

    const sizeOptions = {
      'Printing Long Bond Paper': [
        { label: 'Plain - ₱3.00', price: 3 },
        { label: 'Apparent - ₱5.00', price: 5 },
        { label: 'Half - ₱8.00', price: 8 },
        { label: 'Full Colored - ₱10.00', price: 10 }
      ],
       'Printing Long Bond Paper': [
        { label: 'Plain - ₱3.00', price: 3 },
        { label: 'Apparent - ₱5.00', price: 5 },
        { label: 'Half - ₱8.00', price: 8 },
        { label: 'Full Colored - ₱10.00', price: 10 }
      ],
      'Printing Short Bond Paper': [
        { label: 'A4 Size - ₱35.00', price: 35 },
        { label: '5×3 Size - ₱20.00', price: 20 },
        { label: '4R Size - ₱15.00', price: 15 },
        { label: '3R Size - ₱10.00', price: 10 }
      ],
      'Printing a4 Bond Paper': [
        { label: 'A4 Size - ₱35.00', price: 35 },
        { label: '5×3 Size - ₱20.00', price: 20 },
        { label: '4R Size - ₱15.00', price: 15 },
        { label: '3R Size - ₱10.00', price: 10 }
      ],
      'laminate': [
        { label: 'A4 - ₱20.00', price: 20 },
        { label: '8R - ₱25.00', price: 25 },
        { label: '6R - ₱30.00', price: 30 },
        { label: '5R - ₱35.00', price: 35 },
        { label: '4R - ₱40.00', price: 40 }
      ],
      'Book Binding a4': [
        { label: 'Softcover (below 160 pages) - ₱80.00', price: 80 },
        { label: 'Softcover (above 101 pages) - ₱120.00', price: 120 },
        { label: 'Hardcover (below 200 pages) - ₱500.00', price: 500 },
        { label: 'Hardcover (above 201 pages) - ₱600.00', price: 600 }
      ],
      'Book Binding Short': [
        { label: 'Softcover (below 160 pages) - ₱80.00', price: 80 },
        { label: 'Softcover (above 101 pages) - ₱120.00', price: 120 },
        { label: 'Hardcover (below 200 pages) - ₱500.00', price: 500 },
        { label: 'Hardcover (above 201 pages) - ₱600.00', price: 600 }
      ],
      'Book Binding Long': [
        { label: 'Softcover (below 160 pages) - ₱80.00', price: 80 },
        { label: 'Softcover (above 101 pages) - ₱120.00', price: 120 },
        { label: 'Hardcover (below 200 pages) - ₱500.00', price: 500 },
        { label: 'Hardcover (above 201 pages) - ₱600.00', price: 600 }
      ],
       'Photo Print': [
        { label: 'A4 Size - ₱35.00', price: 35 },
        { label: '5×3 Size - ₱20.00', price: 20 },
        { label: '4R Size - ₱15.00', price: 15 },
        { label: '3R Size - ₱10.00', price: 10 }
      ],
      'Xerox Long Bond Paper': [
        { label: 'Per Page - ₱2.00', price: 2 }
      ],
      'Xerox Short Bond Paper': [
        { label: 'Per Page - ₱2.00', price: 2 }
      ],
      'Xerox a4 Bond Paper': [
        { label: 'Per Page - ₱2.00', price: 2 }
      ],
      'tarpaulin': [
        // 1x Series
    { label: '1x1 - ₱25', price: 25 },
    { label: '1x2 - ₱50', price: 50 },
    { label: '1x3 - ₱75', price: 75 },
    { label: '1x4 - ₱100', price: 100 },
    { label: '1x5 - ₱125', price: 125 },
    { label: '1x6 - ₱150', price: 150 },
    { label: '1x7 - ₱175', price: 175 },
    { label: '1x8 - ₱200', price: 200 },
    { label: '1x9 - ₱225', price: 225 },
    { label: '1x10 - ₱250', price: 250 },
    { label: '1x11 - ₱275', price: 275 },
    { label: '1x12 - ₱300', price: 300 },

    // 2x Series
    { label: '2x1 - ₱50', price: 50 },
    { label: '2x2 - ₱75', price: 75 },
    { label: '2x3 - ₱100', price: 100 },
    { label: '2x4 - ₱125', price: 125 },
    { label: '2x5 - ₱150', price: 150 },
    { label: '2x6 - ₱175', price: 175 },
    { label: '2x7 - ₱200', price: 200 },
    { label: '2x8 - ₱225', price: 225 },
    { label: '2x9 - ₱250', price: 250 },
    { label: '2x10 - ₱275', price: 275 },
    { label: '2x11 - ₱300', price: 300 },
    { label: '2x12 - ₱325', price: 325 },

    // 3x Series
    { label: '3x1 - ₱75', price: 75 },
    { label: '3x2 - ₱100', price: 100 },
    { label: '3x3 - ₱125', price: 125 },
    { label: '3x4 - ₱150', price: 150 },
    { label: '3x5 - ₱175', price: 175 },
    { label: '3x6 - ₱200', price: 200 },
    { label: '3x7 - ₱225', price: 225 },
    { label: '3x8 - ₱250', price: 250 },
    { label: '3x9 - ₱275', price: 275 },
    { label: '3x10 - ₱300', price: 300 },
    { label: '3x11 - ₱325', price: 325 },
    { label: '3x12 - ₱350', price: 350 },

    // 4x Series
    { label: '4x1 - ₱100', price: 100 },
    { label: '4x2 - ₱125', price: 125 },
    { label: '4x3 - ₱150', price: 150 },
    { label: '4x4 - ₱175', price: 175 },
    { label: '4x5 - ₱200', price: 200 },
    { label: '4x6 - ₱225', price: 225 },
    { label: '4x7 - ₱250', price: 250 },
    { label: '4x8 - ₱275', price: 275 },
    { label: '4x9 - ₱300', price: 300 },
    { label: '4x10 - ₱325', price: 325 },
    { label: '4x11 - ₱350', price: 350 },
    { label: '4x12 - ₱375', price: 375 },

    // 5x Series
    { label: '5x1 - ₱125', price: 125 },
    { label: '5x2 - ₱150', price: 150 },
    { label: '5x3 - ₱175', price: 175 },
    { label: '5x4 - ₱200', price: 200 },
    { label: '5x5 - ₱225', price: 225 },
    { label: '5x6 - ₱250', price: 250 },
    { label: '5x7 - ₱275', price: 275 },
    { label: '5x8 - ₱300', price: 300 },
    { label: '5x9 - ₱325', price: 325 },
    { label: '5x10 - ₱350', price: 350 },
    { label: '5x11 - ₱375', price: 375 },
    { label: '5x12 - ₱400', price: 400 },
      ]
    };

  if (sizeOptions[optionType]) {
    sizeOptions[optionType].forEach(opt => {
      const optionEl = document.createElement('option');
      optionEl.textContent = opt.label;
      optionEl.value = opt.price;
      select.appendChild(optionEl);
    });
  }
}

function updateTotal() {
  const qty = parseInt(document.getElementById("quantity").value) || 1;
  const copies = parseInt(document.getElementById("copies").value) || 1;
  let finalPrice = 0;

  if (!selectedPrintOption) {
    document.getElementById("total").value = '0.00';
    return;
  }

  // Book Binding special pricing
  if (selectedPrintOption.type.includes("Book Binding")) {
    if (qty <= 160) {
      finalPrice = 80 * copies;
    } else {
      finalPrice = 120 * copies;
    }
  } else {
    // Other services: use dropdown price × pages × copies
    finalPrice = (selectedPrintOption.price || 0) * qty * copies;
  }

  document.getElementById("total").value = finalPrice.toFixed(2);
}

document.addEventListener("input", (e) => {
  if (e.target.id === "quantity" || e.target.id === "copies") updateTotal();
});


function submitPrintJob() {
  if (!selectedPrintOption || selectedPrintOption.price === 0) {
    alert('Please select a service and size option first!');
    return;
  }

  const quantity = parseInt(document.getElementById('quantity').value) || 1;
  const transaction = {
    id: transactionCounter++,
    groupName: uploadedGroup.groupName,
    fileCount: uploadedGroup.totalFiles,
    printType: selectedPrintOption.name,
    price: selectedPrintOption.price,
    quantity: quantity,
    total: selectedPrintOption.price * quantity,
    status: 'In Print',
    date: new Date().toLocaleString()
  };

  transactions.unshift(transaction);
  updateTransactionHistory();

  alert(`✅ Print job submitted!\nTransaction #${transaction.id}`);
}

function updateTransactionHistory() {
  const historyDiv = document.getElementById('transactionHistory');
  if (transactions.length === 0) {
    historyDiv.innerHTML = `<p class="text-muted text-center">No transactions yet.</p>`;
    return;
  }

  historyDiv.innerHTML = `
    <table class="table table-striped">
      <thead><tr>
        <th>#</th><th>Batch</th><th>Files</th><th>Service</th><th>Qty</th><th>Total</th><th>Status</th><th>Date</th>
      </tr></thead>
      <tbody>
        ${transactions.map(t => `
          <tr>
            <td>${t.id}</td>
            <td>${t.groupName}</td>
            <td>${t.fileCount}</td>
            <td>${t.printType}</td>
            <td>${t.quantity}</td>
            <td>₱${t.total.toFixed(2)}</td>
            <td><span class="badge bg-primary">${t.status}</span></td>
            <td>${t.date}</td>
          </tr>
        `).join('')}
      </tbody>
    </table>
  `;
}
</script>


<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'985efc50f401fee5',t:'MTc1OTAxNzg5MC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
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