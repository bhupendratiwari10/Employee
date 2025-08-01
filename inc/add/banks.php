<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_type = $_POST["account_type"];
    $account_name = $_POST["account_name"];
    $account_code = $_POST["account_code"];
    $currency = $_POST["currency"];
    $account_number = $_POST["account_number"];
    $bank_name = $_POST["bank_name"];
    $ifsc = $_POST["ifsc"];
    $description = $_POST["description"];
    $is_primary = isset($_POST["is_primary"]) ? 1 : 0;


    $sql = "INSERT INTO zw_banks (account_type, account_name, account_code, currency, account_number, bank_name, ifsc, description, is_primary)
            VALUES ('$account_type', '$account_name', '$account_code', '$currency', '$account_number', '$bank_name', '$ifsc', '$description', $is_primary)";

    if (mysqli_query($con, $sql)) {
       echo "<script>alert('Bank added successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

?>

<form method="post" action="">
        <label for="account_type">Select Account Type:</label>
        <select id="account_type" name="account_type" required>
            <option value="Bank">Bank</option>
            <option value="Credit Card">Credit Card</option>
        </select>
        <br>

        <label for="account_name">Account Name:</label>
        <input type="text" id="account_name" name="account_name" required>
        <br>

        <label for="account_code">Account Code:</label>
        <input type="text" id="account_code" name="account_code">
        <br>

        <label for="currency">Currency:</label>
        <input type="text" id="currency" name="currency">
        <br>

        <label for="account_number">Account Number:</label>
        <input type="text" id="account_number" name="account_number">
        <br>

        <label for="bank_name">Bank Name:</label>
        <input type="text" id="bank_name" name="bank_name">
        <br>

        <label for="ifsc">IFSC:</label>
        <input type="text" id="ifsc" name="ifsc">
        <br>

        <label for="description">Description (Max 500 characters):</label>
        <textarea id="description" name="description" rows="4" maxlength="500"></textarea>
        <br>

        <label for="is_primary">Make this primary:</label>
        <input type="checkbox" id="is_primary" name="is_primary" value="1">
        <br>

        <input type="submit" value="Add Account">
    </form>