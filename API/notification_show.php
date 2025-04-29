<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Notification</title>

    <!-- Bootstrap 5 CSS for Styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts for more professional typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        /* Toast Container Styling */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        /* Toast Custom Styling */
        .toast {
            border-radius: 8px;
            width: 300px;
            padding: 15px;
            background-color: #28a745;
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .toast-body {
            font-weight: 500;
        }

        .toast-close-btn {
            font-size: 20px;
            color: #ffffff;
            opacity: 0.8;
        }

        .toast-close-btn:hover {
            opacity: 1;
        }

        .btn-close {
            background-color: transparent;
            border: none;
            outline: none;
        }
    </style>

    <!-- Pusher JS SDK -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
</head>

<body>

    <!-- Toast Notification Container -->
    <div class="toast-container">
        <div id="orderToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toast-body">
                    <!-- Notification message will be inserted here -->
                </div>
                <button type="button" class="btn-close btn-close-white toast-close-btn" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        // Initialize Pusher with your credentials
        const pusher = new Pusher('a1964c3ac950c1a0cdf5', {
            cluster: 'mt1' // Your Pusher cluster
        });

        // Subscribe to the user-specific channel (example: user-123)
        const userId = 123;  // Example user ID, change this dynamically
        const channel = pusher.subscribe('orders');

        // Bind to the 'order' event to show the notification
        channel.bind('new_order', function(data) {
            // Update the toast with order details
            console.log(data)
            const toastBody = document.getElementById('toast-body');
            toastBody.innerText = `New Order Received!`;

            // Show the toast notification
            const toast = new bootstrap.Toast(document.getElementById('orderToast'));
            toast.show();
        });
    </script>

    <!-- Bootstrap Bundle JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
