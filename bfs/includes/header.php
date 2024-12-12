<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        details.dropdown {
            position: relative;
            z-index: 1000;
        }

        summary.dropdown-button {
            list-style: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: white;
            cursor: pointer;
            font-size: 24px;
        }

        summary::-webkit-details-marker,
        summary::marker {
            display: none;
        }

        .dropdown-content {
            width: max-content;
            position: absolute;
            right: 0;
            z-index: 10;
            border-radius: 0.2rem;
            background-color: white;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .dropdown a.nav-link {
            display: block;
            padding: 10px;
            background-color: #f9f9f9;
            color: black;
            text-decoration: none;
        }

        .dropdown a.nav-link:hover {
            color: #fff;
            background-color: #6f42c1;
        }

        /* Remove default Bootstrap dropdown menu styles */
        .custom-dropdown-menu {
            background: white !important; /* Background color */
            border: none !important; /* Remove borders */
            box-shadow: none; /* Remove shadow */
            padding: 0 !important; /* Remove padding */
            min-width: 150px; /* Set a default width if needed */
        }

        /* Remove default item styles */
        .custom-dropdown-item {
            background-color: transparent; /* Transparent background */
            color: black; /* Text color */
            padding: 10px 15px; /* Add custom padding */
            border: none; /* Remove borders */
            text-decoration: none; /* Remove underline */
        }

        /* Hover effect */
        .custom-dropdown-item:hover {
            background-color: #6f42c1; /* Highlight color on hover */
            color: #fff; /* Text color on hover */
        }

        /* Remove default toggle button styles */
        .custom-dropdown-toggle {
            color: black; /* Text color */
            background: none; /* No background */
            border: none; /* No border */
            padding: 0; /* No padding */
            font-size: 24px; /* Adjust size */
            cursor: pointer; /* Pointer cursor */
        }

        /* Remove the arrow from the dropdown-toggle */
        .no-arrow::after {
            display: none; /* Hide the default Bootstrap dropdown arrow */
        }

        .navbar-toggler .navbar-toggler-icon {
            color: white !important;
        }

        /* Custom styling for the navbar toggler */
        .custom-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .search-bar-container {
        margin: 1rem 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .search-form {
        display: flex;
        }

        .search-input {
        padding: 0.5rem;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 4px;
        }

        .search-btn {
        padding: 0.5rem 1rem;
        background-color: hotpink;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 0.5rem;
        }

        .search-btn:hover {
        background-color: #d11c7c;
        }

        #search-results {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
    </style>
</head>

<body>
    <section class="w3l-header-4 header-sticky" style="z-index: 1000; position:relative;">
        <header class="absolute-top">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="index.php">Win Salon</a>
                    <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="products.php">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="services.php">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.php">Contact</a>
                            </li>
                            <?php if (strlen($_SESSION['bpmsuid'] == 0)) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="signup.php">Signup</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="login.php">Login</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="search-bar-container">
                            <form class="search-form" id="search-form" onsubmit="return false;">
                                <input type="text" id="search-input" placeholder="Search for services or products..." class="search-input">
                                <!-- <button type="submit" class="search-btn">Search</button> -->
                            </form>
                        </div>

                        <?php if (strlen($_SESSION['bpmsuid']) > 0) { ?>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle custom-dropdown-toggle no-arrow" href="#" id="userMenu" role="button" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ☰
                                    </a>
                                    <ul class="dropdown-menu custom-dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                        <li><a class="dropdown-item custom-dropdown-item" href="profile.php">Profile</a></li>
                                        <li><a class="dropdown-item custom-dropdown-item" href="change-password.php">Setting</a></li>
                                        <li><a class="dropdown-item custom-dropdown-item" href="booking-history.php">Booking History</a></li>
                                        <li><a class="dropdown-item custom-dropdown-item" href="book-appointment.php">Book Salon</a></li>
                                        <li><a class="dropdown-item custom-dropdown-item" href="feedback.php">Feedback</a></li>
                                        <li><a class="dropdown-item custom-dropdown-item" href="logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                </nav>
            </div>
        </header>
    </section>
    <section class="w3l-header-4 header-sticky" style="display: flex; align-items: center; justify-content: center;">
        <div id="search-results" class="row" style="width: 100%; max-width: 1300px; margin-inline: 0 !important;">
            <!-- Search results will be dynamically added here -->
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- search bar -->
     <script>
        document.getElementById('search-input').addEventListener('input', function () {
            const query = this.value;

            // Fetch results dynamically
            fetch('includes/fetch_query.php', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `query=${encodeURIComponent(query)}`
            })
                .then(response => response.text())
                .then(data => {
                document.getElementById('search-results').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });

     </script>
</body>

</html>
