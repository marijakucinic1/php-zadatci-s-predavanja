<?php
// vjezba4_4.php — Prosti brojevi manji od 100
$naslov = "Prosti brojevi manji od 100";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

// Funkcija koja provjerava je li broj prost
function jeProst(int $n): bool {
  if ($n < 2) return false;
  for ($i = 2; $i <= sqrt($n); $i++) {
    if ($n % $i === 0) return false;
  }
  return true;
}

// Prikupljamo sve proste brojeve < 100
$prostiBrojevi = [];
for ($i = 2; $i < 100; $i++) {
  if (jeProst($i)) {
    $prostiBrojevi[] = $i;
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
    .wrap { max-width:600px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 6px; font-size:1.6rem; }
    .opis { color:var(--muted); font-size:.9rem; margin:0 0 8px; line-height:1.5; }
    .definicija { font-size:.85rem; color:var(--muted); margin:0 0 24px;
                  padding:10px 14px; background:#f8fafc; border-radius:8px;
                  border-left:3px solid var(--accent); }
    .brojac { font-size:.9rem; color:var(--muted); margin-bottom:12px; }
    .brojac strong { color:var(--accent); }
    .grid {
      display:flex; flex-wrap:wrap; gap:8px;
    }
    .broj {
      width:44px; height:44px; display:flex; align-items:center; justify-content:center;
      border-radius:8px; font-weight:600; font-size:.95rem;
      background:#f0f6ff; color:var(--accent); border:1px solid #bfdbfe;
    }
    .autor { margin-top:28px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p class="opis">Funkcija <code>jeProst()</code> ispituje je li broj prost, a zatim se ispisuju svi prosti brojevi manji od 100.</p>
    <p class="definicija">
      * Prosti brojevi su svi prirodni brojevi djeljivi bez ostatka sa brojem 1 i sami sa sobom, a strogo su veći od broja 1.
    </p>

    <p class="brojac">Pronađeno: <strong><?php echo count($prostiBrojevi); ?></strong> prostih brojeva manjih od 100</p>

    <div class="grid">
      <?php foreach ($prostiBrojevi as $b): ?>
        <div class="broj"><?php echo $b; ?></div>
      <?php endforeach; ?>
    </div>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba4_4.php -->
