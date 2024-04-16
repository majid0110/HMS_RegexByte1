<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired</title>
</head>

<body>
    <h1>Session Expired</h1>
    <p>Your session has expired. Please log in again.</p>
    <!-- Optionally, you can use JavaScript to display a dialog box -->
    <script>
        alert("Your session has expired. Please log in again.");
        window.location.href = "<?php echo base_url('login'); ?>";
    </script>
</body>

</html>