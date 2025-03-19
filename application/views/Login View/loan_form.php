<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Request Form</title>
    <!-- Add your custom CSS or use Bootstrap for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f4f7fc;
    }

    .container {
        max-width: 600px;
        margin-top: 50px;
    }

    .card {
        padding: 30px;
        border-radius: 8px;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="card shadow">
            <h3 class="text-center">Loan Request Form</h3>
            <form action="<?php echo site_url('loan_request/submit_request'); ?>" method="post">
                <!-- Select Bank -->
                <div class="form-group">
                    <label for="bank">Select Bank:</label>
                    <select class="form-control" name="bank_id" id="bank" required>
                        <option value="">Select a bank</option>
                        <?php foreach ($banks as $bank): ?>
                        <option value="<?php echo $bank['id']; ?>"><?php echo $bank['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Loan Amount -->
                <div class="form-group">
                    <label for="loan_amount">Loan Amount:</label>
                    <input type="number" class="form-control" name="loan_amount" id="loan_amount"
                        placeholder="Enter loan amount" required>
                </div>

                <!-- Loan Tenure -->
                <div class="form-group">
                    <label for="tenure">Loan Tenure (Months):</label>
                    <input type="number" class="form-control" name="tenure" id="tenure"
                        placeholder="Enter loan tenure in months" required>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Submit Loan Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>