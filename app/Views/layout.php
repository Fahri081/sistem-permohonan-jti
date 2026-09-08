<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= $this->renderSection('title') ?: 'JTI Signature' ?>
    </title>


    <!-- ========================================
         FONT AWESOME
    ========================================= -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <!-- ========================================
         CSS GLOBAL
    ========================================= -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/app.css') ?>"
    >


    <!-- ========================================
         CSS ADMIN DASHBOARD
    ========================================= -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/admin/dashboard.css') ?>"
    >


    <?= $this->renderSection('styles') ?>

</head>


<body>

    <!-- ========================================
         MAIN APPLICATION
    ========================================= -->

    <?= $this->renderSection('content') ?>


    <!-- ========================================
         JAVASCRIPT
    ========================================= -->

    <?= $this->renderSection('scripts') ?>

</body>

</html>