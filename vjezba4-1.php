<?php
// vjezba4_1.php — Odabir vozila (radio gumbi)
$naslov = "Označi vozilo";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$vozila   = ["Audi", "BMW", "Renault", "Citroen"];
$odabrano = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["vozilo"]) && in_array($_POST["vozilo"], $vozila)) {
    $odabrano = $_POST["vozilo"];
  }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo h($naslov); ?></title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280; --accent:#2563eb; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:420px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 20px; font-size:1.5rem; }
    .radio-group { display:flex; flex-direction:column; gap:10px; margin-bottom:20px; }
    .radio-group label {
      display:flex; align-items:center; gap:10px;
      padding:10px 14px; border:1px solid #e5e7eb; border-radius:10px;
      cursor:pointer; transition:border-color .15s, background .15s;
    }
    .radio-group label:hover { border-color:var(--accent); background:#f0f6ff; }
    .radio-group input[type="radio"] { accent-color:var(--accent); width:18px; height:18px; }
    .btn {
      display:block; width:100%; padding:12px; font:inherit; font-size:1rem;
      font-weight:600; cursor:pointer; border:none; border-radius:10px;
      background:var(--accent); color:#fff; transition:opacity .15s;
    }
    .btn:hover { opacity:.88; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.75; }
    @media (prefers-reduced-motion: reduce) { .btn, label { transition:none; } }
    .rezultat { margin-top:20px; padding:14px 18px; background:#f0f6ff;
                border-left:4px solid var(--accent); border-radius:8px; font-size:1rem; }
    .rezultat strong { color:var(--accent); }
    .autor { margin-top:20px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <form method="post" action="vjezba4_1.php">
      <div class="radio-group">
        <?php foreach ($vozila as $v): ?>
          <label>
            <input type="radio" name="vozilo" value="<?php echo h($v); ?>"
                   <?php echo $odabrano === $v ? "checked" : ""; ?>>
            <?php echo h($v); ?>
          </label>
        <?php endforeach; ?>
      </div>
      <button class="btn" type="submit">Pošalji</button>
    </form>

    <?php if ($odabrano): ?>
      <div class="rezultat">Odabrano vozilo: <strong><?php echo h($odabrano); ?></strong></div>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba4_1.php -->
