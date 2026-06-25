<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fo'Orders - Café Fourfalas</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>
<body>

    <div class="app-container">
        
        <?= $this->renderSection('content'); ?>
        
    </div>

    <?= $this->renderSection('scripts'); ?>

</body>
</html>