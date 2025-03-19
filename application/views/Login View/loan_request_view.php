<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Loan Request</title>
</head>

<body>
    <form action="<?php echo site_url('loan_request/submit_request'); ?>" method="post">
        <label for="bank">Select Bank:</label>
        <select name="bank_id" id="bank">
            <?php foreach ($banks as $bank): ?>
            <option value="<?php echo $bank['id']; ?>"><?php echo $bank['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="loan_amount">Loan Amount:</label>
        <input type="text" name="loan_amount" id="loan_amount"><br>

        <label for="tenure">Loan Tenure (in months):</label>
        <input type="text" name="tenure" id="tenure"><br>

        <button type="submit">Submit Loan Request</button>
    </form>
</body>

</html>