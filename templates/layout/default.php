
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= $this->fetch('title') ?: 'Ticket System' ?>
    </title>

    <!-- Local Bootstrap Icons -->
    <?= $this->Html->css('/vendor/bootstrap-icons/font/bootstrap-icons.min.css') ?>

    <!-- OverlayScrollbars -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">

    <!-- Local AdminLTE CSS -->
    <?= $this->Html->css('/vendor/adminlte/css/adminlte.min.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                       data-lte-toggle="sidebar"
                       href="#"
                       role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>

            <span class="navbar-text ms-auto">
                Ticket System
            </span>

        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow"
           data-bs-theme="dark">

        <div class="sidebar-brand">
            <a href="<?= $this->Url->build('/tickets') ?>"
               class="brand-link">
                <span class="brand-text fw-light">
                    Ticket System
                </span>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="menu">

                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="nav-icon bi bi-ticket-detailed"></i>
                             <p>Tickets</p>',
                            ['controller' => 'Tickets', 'action' => 'index'],
                            [
                                'class' => 'nav-link',
                                'escape' => false
                            ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="nav-icon bi bi-plus-circle"></i>
                             <p>Add Ticket</p>',
                            ['controller' => 'Tickets', 'action' => 'add'],
                            [
                                'class' => 'nav-link',
                                'escape' => false
                            ]
                        ) ?>
                    </li>

                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="nav-icon bi bi-box-arrow-right"></i>
                             <p>Logout</p>',
                            ['controller' => 'Users', 'action' => 'logout'],
                            [
                                'class' => 'nav-link',
                                'escape' => false
                            ]
                        ) ?>
                    </li>

                </ul>
            </nav>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">Ticket Management</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>

            </div>
        </div>

    </main>

</div>

<!-- jQuery: needed by existing AJAX code -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap and AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>

<!-- Local AdminLTE JavaScript -->
<?= $this->Html->script('/vendor/adminlte/js/adminlte.min.js') ?>

<?= $this->fetch('script') ?>

</body>
</html>
```