<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="./public/assets/images_s/regexbyte.png" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .card {
            margin-top: 100px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-in-out;
        }

        .card-title {
            color: #333;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .clock {
            font-size: 24px;
            color: #007bff;
            border: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card mx-auto">
            <div class="card-body">
                <h4 class="card-title" style="color: brown;">Session Error</h4>
                <p>Oops! It seems your are logout.</p>
                <div id="countdown" class="clock">10</div>
                <p>Redirecting you to the login page...</p>
                <a href="<?= base_url('login'); ?>" class="btn btn-primary">Login</a>
            </div>
        </div>
    </div>

    <!-- JavaScript to redirect after 10 seconds -->
    <script>
        var timeLeft = 10;
        var countdown = document.getElementById('countdown');
        var redirectTimer = setInterval(function () {
            timeLeft--;
            countdown.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(redirectTimer);
                window.location.href = '<?= base_url('login'); ?>';
            }
        }, 1000);
    </script>
</body>

</html>