<?php
const PHOTO_DIR = 'images';

$images = glob(PHOTO_DIR . '/*.{jpg,jpeg,png}', GLOB_BRACE);

$errors = isset($_GET['errors']) ? explode(',', $_GET['errors']) : [];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фото Галерея</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Фото Галерея</h1>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="photo" accept="image/*" required>
    <button type="submit">Завантажити</button>
</form>

<?php if (!empty($errors)): ?>
    <ul class="error-list">
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div class="gallery">
    <?php foreach ($images as $image): ?>
        <a href="<?php echo $image; ?>" data-size="1024x1024" class="gallery-item">
            <img src="<?php echo $image; ?>" alt="Photo" />
        </a>
    <?php endforeach; ?>
</div>

<script>
    if (window.location.search.includes('errors')) {
        const url = new URL(window.location);
        url.searchParams.delete('errors');
        window.history.replaceState({}, document.title, url.toString());
    }
</script>
</body>
</html>
