<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nem Ip Cam - Ajax Sikkerhedsudstyr</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <link rel="stylesheet" media="only screen and (max-width:1024px)" href="/assets/css/telefonstyle.css">
</head>
<body>
    <!-- Top Bar -->
    <?php require dirname(__DIR__) . '/partials/topbar.php'; ?>
    
    <!-- Header with Logo and Search -->
    <?php require dirname(__DIR__) . '/partials/header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?php echo $content ?? ''; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php require dirname(__DIR__) . '/partials/footer.php'; ?>
</body>
</html> 