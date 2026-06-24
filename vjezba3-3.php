<?php
// vjezba3_3.php — Prosjek i konačna ocjena kolokvija
$naslov = "Ocjena iz predmeta";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$kol1     = null;
$kol2     = null;
$prosjek  = null;
$ocjena   = null;
$poruka   = null;
$negativno = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $kol1 = isset($_POST["kol1"]) && $_POST["kol1"] !== "" ? (float)$_POST["kol1"] : null;
  $kol2 = isset($_POST["kol2"]) && $_POST["kol2"] !== "" ? (float)$_POST["kol2"] : null;

  if ($kol1 !== null && $kol2 !== null) {
    // Provjera negativnih ocjena
    if ($kol1 < 1 || $kol2 < 1) {
      $negativno = true;
      $poruka = "Jedan od kolokvija je negativan — konačna ocjena je negativna (nedovoljan).";
      $ocjena = 1;
    } else {
      $prosjek = ($kol1 + $kol2) / 2;

      // Konačna ocjena
      if ($prosjek < 1 || $prosjek > 5) {
        $poruka = "Ocjena mora biti između 1 i 5.";
      } elseif ($prosjek >= 4.5) {
        $ocjena = 5;
      } elseif ($prosjek >= 3.5) {
        $ocjena = 4;
      } elseif ($prosjek >= 2.5) {
        $ocjena = 3;
      } elseif ($prosjek >= 1.5) {
        $ocjena = 2;
      } else {
        $ocjena = 1;
        $negativno = true;
        $poruka = "Prosjek je ispod 1.5 — konačna ocjena je negativna (nedovoljan).";
      }
    }
  }
}

$nazivOcjene = [1 => "Nedovoljan (1)", 2 => "Dovoljan (2)", 3 => "Dobar (3)", 4 => "Vrlo dobar (4)", 5 => "Odličan (5)"];
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo h($naslov); ?></title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280; --accent:#2563eb;
            --green:#16a34a; --red:#dc2626; --yellow:#d97706; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:500px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 6px; font-size:1.6rem; }
    .podnaslov { color:var(--muted); font-size:.9rem; margin:0 0 20px; }
    label { display:block; margin:12px 0 4px; font-weight:500; }
    .hint { font-size:.8rem; color:var(--muted); margin:2px 0 0; }
    input[type="number"] {
      width:100%; padding:8px 10px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s;
    }
    input[type="number"]:focus { border-color:var(--accent); }
    .btn {
      display:block; width:100%; margin-top:20px; padding:12px;
      font:inherit; font-size:1rem; font-weight:600; cursor:pointer;
      border:none; border-radius:10px;
      background:var(--accent); color:#fff;
      transition:opacity .15s;
    }
    .btn:hover { opacity:.88; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.75; }
    @media (prefers-reduced-motion: reduce) { .btn, input[type="number"] { transition:none; } }

    .rezultat { margin-top:20px; border-radius:12px; overflow:hidden; }
    .rezultat-row { display:flex; justify-content:space-between; align-items:center;
                    padding:10px 16px; border-bottom:1px solid #f1f5f9; }
    .rezultat-row:last-child { border-bottom:none; }
    .rezultat-label { color:var(--muted); font-size:.9rem; }
    .rezultat-val { font-weight:600; }
    .rezultat-header { background:#f8fafc; }

    .ocjena-blok { margin-top:16px; padding:16px 20px; border-radius:12px;
                   text-align:center; font-weight:700; font-size:1.15rem; }
    .ocjena-blok.pozitivna { background:#dcfce7; color:var(--green); }
    .ocjena-blok.negativna { background:#fee2e2; color:var(--red); }
    .ocjena-blok.srednja   { background:#fef9c3; color:var(--yellow); }

    .poruka { margin-top:10px; font-size:.88rem; color:var(--muted); text-align:center; }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p class="podnaslov">Unesite ocjene kolokvija (1–5) za izračun prosjeka i konačne ocjene.</p>

    <form method="post" action="vjezba3_3.php">
      <label for="kol1">Ocjena I. kolokvija *</label>
      <input type="number" id="kol1" name="kol1" min="1" max="5" step="0.5"
             value="<?php echo $kol1 !== null ? h($kol1) : ''; ?>" required>
      <span class="hint">Raspon: 1 – 5 (negativan = ispod 1)</span>

      <label for="kol2">Ocjena II. kolokvija *</label>
      <input type="number" id="kol2" name="kol2" min="1" max="5" step="0.5"
             value="<?php echo $kol2 !== null ? h($kol2) : ''; ?>" required>
      <span class="hint">Raspon: 1 – 5 (negativan = ispod 1)</span>

      <button class="btn" type="submit">Izračunaj</button>
    </form>

    <?php if ($ocjena !== null): ?>
      <div class="rezultat">
        <div class="rezultat-row rezultat-header">
          <span class="rezultat-label">I. kolokvij</span>
          <span class="rezultat-val"><?php echo h($kol1); ?></span>
        </div>
        <div class="rezultat-row rezultat-header">
          <span class="rezultat-label">II. kolokvij</span>
          <span class="rezultat-val"><?php echo h($kol2); ?></span>
        </div>
        <?php if ($prosjek !== null): ?>
        <div class="rezultat-row">
          <span class="rezultat-label">Prosjek</span>
          <span class="rezultat-val"><?php echo round($prosjek, 2); ?></span>
        </div>
        <?php endif; ?>
      </div>

      <?php
        $klasa = $ocjena >= 3 ? 'pozitivna' : ($ocjena == 2 ? 'srednja' : 'negativna');
      ?>
      <div class="ocjena-blok <?php echo $klasa; ?>">
        Konačna ocjena: <?php echo h($nazivOcjene[$ocjena]); ?>
      </div>

      <?php if ($poruka): ?>
        <p class="poruka"><?php echo h($poruka); ?></p>
      <?php endif; ?>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba3_3.php -->
