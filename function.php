<?php
include '../config.php';




if(isset($_POST['user_id']) && isset($_POST['message_text'])) {

    $user_id = $_POST['user_id'];
    $message_text = $_POST['message_text'];
    $message_id = rand();
    $seen = 'no';
    $datetoday = date("Y-m-d");
    $timetoday = date("H:i:s");
    $my_id = $_SESSION['active_login'] ?? '';

    if(!$my_id) {
        echo json_encode(['error'=>'User not logged in']);
        exit;
    }

    $insert = $conn->prepare("INSERT INTO `messages` (message_id,message,user_id,date_sent,time_sent,seen,receiver) VALUES (?,?,?,?,?,?,?)");
    $insert->bind_param("sssssss",$message_id,$message_text,$my_id,$datetoday,$timetoday,$seen,$user_id);
    $insert->execute();

    echo json_encode(['success'=>true]);
}


if (isset($_POST['save_transaction'])) {
    $customer_fullname = $_POST['customer_fullname'] ?? '';
    $action_id = "action_" . rand();

    if (!empty($_FILES['files']['name'][0])) {
        $amount = 0.0;
        $quantity_transaction = 0;
        $option_to_apply = null;
        $first_total = 0.0;
   
        foreach ($_FILES['files']['name'] as $index => $file_name) {
            $option = isset($_POST['options'][$index]) ? trim($_POST['options'][$index]) : '';
            $quantity_value = isset($_POST['quantity'][$index]) ? (int)$_POST['quantity'][$index] : 0;
            $copies_value = isset($_POST['copies'][$index]) ? (int)$_POST['copies'][$index] : 1;
            $total_quantity  = $quantity_value * $copies_value;
            $total = isset($_POST['total'][$index]) ? (float)$_POST['total'][$index] : 0.0;

            if ($option !== "" && $option_to_apply === null) {
                $option_to_apply = $option;
                $first_total = $total;
            }

            if ($option === "") {
                $missing_option = true;
            }

            $amount += $total;
            $quantity_transaction += $total_quantity;
        }

        if ($option_to_apply === null) {
            $_SESSION['error'] = "Please Select Type of Printing";
            header("Location: index.php");
            exit;
        }
      
        foreach ($_FILES['files']['name'] as $index => $file_name) {
            $option = $option_to_apply;
            $quantity_value = isset($_POST['quantity'][$index]) ? (int)$_POST['quantity'][$index] : 0;
            $copies_value = isset($_POST['copies'][$index]) ? (int)$_POST['copies'][$index] : 1;

          
            $quantity = $quantity_value * $copies_value;
            $total = isset($_POST['total'][$index]) ? (float)$_POST['total'][$index] : 0.0;

            $get_stocks = $conn->prepare("SELECT * FROM `stocks` WHERE `user_id` = ?");
            $get_stocks->bind_param("s", $user_idko);
            $get_stocks->execute();
            $result_stocks = $get_stocks->get_result();

            if ($result_stocks->num_rows > 0) {
                $row_stocks = $result_stocks->fetch_assoc();
                $laminating_plastic = (int)$row_stocks['laminating_plastic'];
                $long_bond_paper = (int)$row_stocks['long_bond_paper'];
                $short_bond_paper = (int)$row_stocks['short_bond_paper'];
                $photo_paper = (int)$row_stocks['photo_paper'];
                $a4_bond_paper = (int)$row_stocks['a4_bond_paper'];
            } else {
                $_SESSION['error'] = "No stock record found. Please add stocks first.";
                header("Location: index.php");
                exit;
            }
         
            if (
                ($option === "Xerox Long Bond Paper" && $long_bond_paper < $quantity) ||
                ($option === "Xerox Short Bond Paper" && $short_bond_paper < $quantity) ||
                ($option === "Xerox a4 Bond Paper" && $a4_bond_paper < $quantity) ||
                ($option === "Printing Long Bond Paper" && $long_bond_paper < $quantity) ||
                ($option === "Printing Short Bond Paper" && $short_bond_paper < $quantity) ||
                ($option === "Printing a4 Bond Paper" && $a4_bond_paper < $quantity) ||
                ($option === "Book Binding Long" && $long_bond_paper < $quantity) ||
                ($option === "Book Binding Short" && $short_bond_paper < $quantity) ||
                ($option === "Book Binding a4" && $a4_bond_paper < $quantity) ||
                ($option === "Lamination" && $laminating_plastic < $quantity) ||
                ($option === "Photo Print" && $photo_paper < $quantity)
            ){
                $_SESSION['error'] = "Insufficient stock for $option. Please update your stocks.";
                header("Location: index.php");
                exit;
            }

            
            if ($option === "Xerox Long Bond Paper" || $option === "Printing Long Bond Paper" || $option === "Book Binding Long") {
                $new_long_bond_paper = max($long_bond_paper - $quantity, 0);
                $update_stocks = $conn->prepare("UPDATE `stocks` SET `long_bond_paper` = ? WHERE `user_id` = ?");
                $update_stocks->bind_param("is", $new_long_bond_paper, $user_idko);
                $update_stocks->execute();

            } elseif ($option === "Xerox Short Bond Paper" || $option === "Printing Short Bond Paper" || $option === "Book Binding Short") {
                $new_short_bond_paper = max($short_bond_paper - $quantity, 0);
                $update_stocks = $conn->prepare("UPDATE `stocks` SET `short_bond_paper` = ? WHERE `user_id` = ?");
                $update_stocks->bind_param("is", $new_short_bond_paper, $user_idko);
                $update_stocks->execute();

            } elseif ($option === "Xerox a4 Bond Paper" || $option === "Printing a4 Bond Paper" || $option === "Book Binding a4") {
                $new_a4_bond_paper = max($a4_bond_paper - $quantity, 0);
                $update_stocks = $conn->prepare("UPDATE `stocks` SET `a4_bond_paper` = ? WHERE `user_id` = ?");
                $update_stocks->bind_param("is", $new_a4_bond_paper, $user_idko);
                $update_stocks->execute();

            } elseif ($option === "Lamination") {
                $new_laminating_plastic = max($laminating_plastic - $quantity, 0);
                $update_stocks = $conn->prepare("UPDATE `stocks` SET `laminating_plastic` = ? WHERE `user_id` = ?");
                $update_stocks->bind_param("is", $new_laminating_plastic, $user_idko);
                $update_stocks->execute();

            } elseif ($option === "Photo Print") {
                $new_photo_paper = max($photo_paper - $quantity, 0);
                $update_stocks = $conn->prepare("UPDATE `stocks` SET `photo_paper` = ? WHERE `user_id` = ?");
                $update_stocks->bind_param("is", $new_photo_paper, $user_idko);
                $update_stocks->execute();
            }

            $file_tmp = $_FILES['files']['tmp_name'][$index];
            $destination = "../uploads/" . basename($file_name);

            if (move_uploaded_file($file_tmp, $destination)) {
                $transaction_id = "transaction_" . uniqid();
                $insert = $conn->prepare("INSERT INTO `transaction` 
                    (`transaction_id`,`file`,`type`,`quantity`,`total`,`user_id`,`date_uploaded`,`time_uploaded`,`action_id`,`copies`) 
                    VALUES (?,?,?,?,?,?,?,?,?,?)");
                $insert->bind_param(
                    "ssssssssss",
                    $transaction_id,
                    $file_name,
                    $option,
                    $quantity,
                    $total,
                    $user_idko,
                    $datetoday,
                    $timetoday,
                    $action_id,
                    $copies_value
                );
                $insert->execute();
            } else {
                $_SESSION['error'] = "Failed to upload file: " . $file_name;
                header("Location: index.php");
                exit;
            }
        }

        $invoice_id = "INV-" . rand();
        $insert_invoice = $conn->prepare("INSERT INTO `invoice` 
            (`invoice_id`,`user_id`,`customer_fullname`,`date_transaction`,`time_transaction`,`amount`,`quantity`,`action_id`) 
            VALUES (?,?,?,?,?,?,?,?)");
        $insert_invoice->bind_param(
            "ssssssss",
            $invoice_id,
            $user_idko,
            $customer_fullname,
            $datetoday,
            $timetoday,
            $amount,
            $quantity_transaction,
            $action_id
        );
        $insert_invoice->execute();

        $_SESSION['success'] = "$option Successfully Inserted";
        header("Location: index.php");
        exit;

    } else {
        $_SESSION['error'] = "No Files Selected";
        header("Location: index.php");
        exit;
    }
}



if (isset($_POST['sent_message'])) {
    $message = $_POST['message'] ?? '';
    $files = $_FILES['files']['name'] ?? '';
    $action_id = rand();
    
    $seen = "no";
    $type = "message";

    // Fetch all users
    $get_users = $conn->prepare("SELECT * FROM `accounts` WHERE `user_id` != ?");
    $get_users->bind_param("s", $user_idko);
    $get_users->execute();
    $result_user = $get_users->get_result();
    
    $user_ids = [];  // Array to hold all user IDs
    if ($result_user->num_rows > 0) {
        while ($row_user = $result_user->fetch_assoc()) {
            $user_ids[] = htmlspecialchars_decode($row_user['user_id'] ?? []);
        }
    }

    // Insert message for each user
    foreach ($user_ids as $receivers) {
        $message_id = rand() . uniqid();
        $insert = $conn->prepare("INSERT INTO `messages` (message_id, message, action_id_message, user_id, date_sent, time_sent, seen, receiver, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssssssss", $message_id, $message, $action_id, $user_idko, $datetoday, $timetoday, $seen, $receivers, $type);
        $insert->execute();
    }

    // Redirect after all messages are inserted
    header("location: messages.php");
    exit;
}

if (isset($_POST['save_stocks'])) {

    $laminating_plastic = (int)($_POST['laminating_plastic'] ?? 0);
    $long_bond_paper = (int)($_POST['long_bond_paper'] ?? 0);
    $short_bond_paper = (int)($_POST['short_bond_paper'] ?? 0);
    $a4_bond_paper = (int)($_POST['a4_bond_paper'] ?? 0);
    $photo_paper = (int)($_POST['photo_paper'] ?? 0);


    if (
        $laminating_plastic === 0 &&
        $long_bond_paper === 0 &&
        $short_bond_paper === 0 &&
        $a4_bond_paper === 0 &&
        $photo_paper === 0
    ) {
        $_SESSION['error'] = "Please fill up at least one textbox.";
        header("Location: add_stocks.php");
        exit;
    }

  
    $check = $conn->prepare("SELECT * FROM stocks WHERE user_id = ? LIMIT 1");
    $check->bind_param("s", $user_idko);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
      
        $row = $result->fetch_assoc();

        $new_laminating_plastic = $row['laminating_plastic'] + $laminating_plastic;
        $new_long_bond_paper = $row['long_bond_paper'] + $long_bond_paper;
        $new_short_bond_paper = $row['short_bond_paper'] + $short_bond_paper;
        $new_a4_bond_paper = $row['a4_bond_paper'] + $a4_bond_paper;
        $new_photo_paper = $row['photo_paper'] + $photo_paper;

        $update = $conn->prepare("UPDATE stocks SET 
            laminating_plastic = ?, 
            long_bond_paper = ?, 
            short_bond_paper = ?, 
            a4_bond_paper = ?, 
            photo_paper = ?
            WHERE user_id = ?
        ");
        $update->bind_param("iiiiis", 
            $new_laminating_plastic, 
            $new_long_bond_paper, 
            $new_short_bond_paper, 
            $new_a4_bond_paper, 
            $new_photo_paper, 
            $user_idko
        );
        $update->execute();

        $_SESSION['success'] = "Stocks updated successfully!";
    } else {
   
        $stock_id = rand(100000, 999999);

        $insert = $conn->prepare("INSERT INTO stocks 
            (stock_id, laminating_plastic, long_bond_paper, short_bond_paper, a4_bond_paper, photo_paper, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $insert->bind_param("iiiiiis", 
            $stock_id, 
            $laminating_plastic, 
            $long_bond_paper, 
            $short_bond_paper, 
            $a4_bond_paper, 
            $photo_paper, 
            $user_idko
        );
        $insert->execute();

        $_SESSION['success'] = "Stocks added successfully!";
    }

    header("Location: add_stocks.php");
    exit;
}



if (isset($_POST['save_paper_jam'])) {

    $type   = $_POST['type'];
    $pieces = (int) $_POST['pieces'];

    if ($pieces <= 0) {
        $_SESSION['error'] = "Invalid pieces value";
        header("Location: index.php");
        exit;
    }

 
    if ($type === "long") {

        $data_type = "Long Bond Paper";

        // Get total stock for user
        $get_stocks = $conn->prepare(
            "SELECT SUM(long_bond_paper) AS total FROM stocks WHERE user_id = ?"
        );
        $get_stocks->bind_param("s", $user_idko);
        $get_stocks->execute();
        $result = $get_stocks->get_result();
        $row = $result->fetch_assoc();

        $total_stock = (int) ($row['total'] ?? 0);

        if ($total_stock <= 0) {
            $_SESSION['error'] = "No stocks for Long Bond Paper";
            header("Location: index.php");
            exit;
        }

        if ($pieces > $total_stock) {
            $_SESSION['error'] = "Long Bond Paper out of stocks";
            header("Location: index.php");
            exit;
        }

        // Insert paper jam
        $paper_jam_id = rand();
        $insert = $conn->prepare(
            "INSERT INTO paper_jam (paper_jam_id, pieces, type) VALUES (?, ?, ?)"
        );
        $insert->bind_param("sis", $paper_jam_id, $pieces, $data_type);
        $insert->execute();

        // Update stocks
        $new_stock = $total_stock - $pieces;
        $update = $conn->prepare(
            "UPDATE stocks SET long_bond_paper = ? WHERE user_id = ?"
        );
        $update->bind_param("is", $new_stock, $user_idko);
        $update->execute();

        $_SESSION['success'] = "Saved successfully";
        header("Location: index.php");
        exit;
    }

  
    elseif ($type === "short") {

        $data_type = "Short Bond Paper";

        $get_stocks = $conn->prepare(
            "SELECT SUM(short_bond_paper) AS total FROM stocks WHERE user_id = ?"
        );
        $get_stocks->bind_param("s", $user_idko);
        $get_stocks->execute();
        $result = $get_stocks->get_result();
        $row = $result->fetch_assoc();

        $total_stock = (int) ($row['total'] ?? 0);

        if ($total_stock <= 0 || $pieces > $total_stock) {
            $_SESSION['error'] = "No stocks for Short Bond Paper";
            header("Location: index.php");
            exit;
        }

        $paper_jam_id = rand();
        $insert = $conn->prepare(
            "INSERT INTO paper_jam (paper_jam_id, pieces, type) VALUES (?, ?, ?)"
        );
        $insert->bind_param("sis", $paper_jam_id, $pieces, $data_type);
        $insert->execute();

        $new_stock = $total_stock - $pieces;
        $update = $conn->prepare(
            "UPDATE stocks SET short_bond_paper = ? WHERE user_id = ?"
        );
        $update->bind_param("is", $new_stock, $user_idko);
        $update->execute();

        $_SESSION['success'] = "Saved successfully";
        header("Location: index.php");
        exit;
    }

   
    elseif ($type === "a4") {

        $data_type = "A4 Bond Paper";

        $get_stocks = $conn->prepare(
            "SELECT SUM(a4_bond_paper) AS total FROM stocks WHERE user_id = ?"
        );
        $get_stocks->bind_param("s", $user_idko);
        $get_stocks->execute();
        $result = $get_stocks->get_result();
        $row = $result->fetch_assoc();

        $total_stock = (int) ($row['total'] ?? 0);

        if ($total_stock <= 0 || $pieces > $total_stock) {
            $_SESSION['error'] = "No stocks for A4 Bond Paper";
            header("Location: index.php");
            exit;
        }

        $paper_jam_id = rand();
        $insert = $conn->prepare(
            "INSERT INTO paper_jam (paper_jam_id, pieces, type) VALUES (?, ?, ?)"
        );
        $insert->bind_param("sis", $paper_jam_id, $pieces, $data_type);
        $insert->execute();

        $new_stock = $total_stock - $pieces;
        $update = $conn->prepare(
            "UPDATE stocks SET a4_bond_paper = ? WHERE user_id = ?"
        );
        $update->bind_param("is", $new_stock, $user_idko);
        $update->execute();

        $_SESSION['success'] = "Saved successfully";
        header("Location: index.php");
        exit;
    }


    else {
        $_SESSION['error'] = "Type doesn't exist";
        header("Location: index.php");
        exit;
    }
}


