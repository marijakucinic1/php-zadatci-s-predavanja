<?php
// vjezba1c.php — PHP blok na početku
$naslov     = "PHP dokument — vježba 1c";
$autor      = "Marija Kučinić";
$opis       = "Ova stranica nastavlja vježbu 1b i služi za uvježbavanje varijabli, ispisa i osnovnog CSS-a.";
$linkInfo   = "https://www.php.net";
$linkNatrag = "vjezba1b.php";
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Vježba 1c — nastavak na vjezba1b.php">
  <title><?php echo htmlspecialchars($naslov); ?></title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280; --accent:#2563eb; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:720px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 12px; font-size:2rem; }
    p  { margin:0 0 14px; line-height:1.6; }
    a:not(.btn) { color:var(--text); text-decoration:none; }
    a:not(.btn):hover { text-decoration:underline; }
    .btn { display:inline-block; padding:10px 16px; border:1px solid var(--accent);
           border-radius:10px; text-decoration:none; color:var(--text);
           transition:background .15s, color .15s; }
    .btn:hover { background:var(--accent); color:#fff; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.8; }
    @media (prefers-reduced-motion: reduce) { .btn { transition:none; } }
    .muted { color:var(--muted); font-size:.9rem; margin-top:8px; }
    .row { display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo htmlspecialchars($naslov); ?></h1>
    <p>Ovu stranicu izradio/la je <strong><?php echo htmlspecialchars($autor); ?></strong>.</p>
    <p><?php echo htmlspecialchars($opis); ?></p>
    <div class="row">
      <a class="btn" href="<?php echo htmlspecialchars($linkInfo); ?>" target="_blank" rel="noopener">Saznaj više o PHP-u</a>
      <a class="btn" href="<?php echo htmlspecialchars($linkNatrag); ?>">Natrag na vježba 1b</a>
    </div>
    <p class="muted">&copy; <?php echo date('Y'); ?> — Demo za PHP</p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba1c.php -->
