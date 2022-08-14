<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN'); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav"
            aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="categories.php"><?php echo lang('CATEGORIES'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="items.php"><?php echo lang('ITEMS'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="members.php"><?php echo lang('MEMBERS'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="comments.php"><?php echo lang('COMMENTS'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#"><?php echo lang('STITISTISC'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#"><?php echo lang('LOGS'); ?></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Abdo
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="members.php?do=Edit&UserID=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="Logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>