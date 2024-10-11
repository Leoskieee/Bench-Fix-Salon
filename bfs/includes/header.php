<style>
    #navbarNav {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    li {
        list-style: none;
    }

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

    summary::-webkit-details-marker {
        display: none;
    }

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
        border-radius: 0;
        background-color: #f9f9f9;
        color: black;
        text-decoration: none;
    }

    .dropdown a.nav-link:hover {
        color: #fff;
        background-color: #6f42c1;
    }

</style>

<section class=" w3l-header-4 header-sticky">
    <header class="absolute-top">
        <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <h1><a class="navbar-brand" href="index.php"> <!--<span class="fa fa-line-chart" aria-hidden="true"></span> -->
            Bench Fix Salon
            </a></h1>
            <button class="navbar-toggler bg-gradient collapsed" type="button" data-toggle="collapse"
                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa icon-expand fa-bars"></span>
        <span class="fa icon-close fa-times"></span>
            </button>
      
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                     
                     <?php if (strlen($_SESSION['bpmsuid']==0)) {?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="admin/index.php">Admin</a>
                    </li> -->
                     <li class="nav-item">
                        <a class="nav-link" href="signup.php">Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li><?php }?>
                    
                </ul>
                <?php if (strlen($_SESSION['bpmsuid']>0)) {?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="book-appointment.php">Book Salon</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="booking-history.php">Booking History</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="invoice-history.php">Invoice History</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li> -->
                    <li class="nav-item">
                        <details class="dropdown">
                            <summary class="dropdown-button">☰</summary>
                            <div class="dropdown-content">
                                <a class="nav-link" href="profile.php">Profile</a>
                                <a class="nav-link" href="change-password.php">Setting</a>
                                <a class="nav-link" href="booking-history.php">Booking History</a>
                                <a class="nav-link" href="book-appointment.php">Book Salon</a>
                                <a class="nav-link" href="logout.php">Logout</a>
                            </div>
                        </details>
                        <!-- <a class="nav-link" href="change-password.php">Setting</a> -->
                    </li>
                     <!-- <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li> -->
                  <?php }?>
            </div>
        </div>

        </nav>
    </div>
      </header>
</section>