<?php
$naslov = "Moj prvi PHP dokument";
$autor = "Marija Kučinić";

echo "<h1>$naslov</h1>";
echo "<p>Ovu stranicu izradila je <strong>$autor</strong>.</p>";
echo '<a href="https://www.netflix.com/hr/" target="_blank">Posjeti NETFLIX.HR</a>';
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $naslov; ?></title>
</head>
<body>
</body>
</html>

<!-- Naziv datoteke: vjezba1.php -->