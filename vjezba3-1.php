<?php
// vjezba3_1.php — Igra pogađanja broja (if + rand())
$naslov = "Igra (pogodi broj)";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$poruka     = null;
$pogodak    = null;
$zamisljeniBroj = null;
$uneseniPogodak = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $zamisljeniBroj = isset($_POST["zamislljeni"]) ? (int)$_POST["zamislljeni"] : rand(1, 9);
  $uneseniPogodak = isset($_POST["pogodak"]) && $_POST["pogodak"] !== "" ? (int)$_POST["pogodak"] : null;

  if ($uneseniPogodak !== null) {
    if ($uneseniPogodak === $zamisljeniBroj) {
      $pogodak = true;
      $poruka  = "Pogodak, probaj ponovo!";
    } else {
      $pogodak = false;
      $poruka  = "Krivo, probaj ponovo!";
    }
  }
} else {
  $zamisljeniBroj = rand(1, 9);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo h($naslov); ?></title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280; --accent:#2563eb;
            --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:480px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 20px; font-size:1.6rem; }
    p  { margin:0 0 14px; line-height:1.6; }
    label { display:block; margin-bottom:6px; font-weight:500; }
    input[type="number"] {
      width:100%; padding:8px 10px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s;
    }
    input[type="number"]:focus { border-color:var(--accent); }
    .btn {
      display:inline-block; width:100%; margin-top:14px; padding:11px 20px;
      font:inherit; font-size:1rem; font-weight:600; cursor:pointer;
      border:none; border-radius:10px; text-align:center;
      background:var(--accent); color:#fff;
      transition:opacity .15s;
    }
    .btn:hover { opacity:.88; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.75; }
    @media (prefers-reduced-motion: reduce) { .btn, input[type="number"] { transition:none; } }
    .rezultat {
      margin-top:16px; padding:12px 16px;
      border-radius:10px; font-weight:600; font-size:1rem;
      text-align:center;
    }
    .rezultat.pogodak { background:#dcfce7; color:var(--green); }
    .rezultat.krivo   { background:#fee2e2; color:var(--red); }
    .zamislljeni { margin-top:10px; font-size:.9rem; color:var(--muted); }
    .autor { margin-top:20px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>

    <form method="post" action="vjezba3_1.php">
      <!-- čuvamo zamišljeni broj kroz submit -->
      <input type="hidden" name="zamislljeni" value="<?php echo h($zamisljeniBroj); ?>">

      <label for="pogodak">Upiši jedan broj od 1 do 9</label>
      <input type="number" id="pogodak" name="pogodak"
             min="1" max="9" step="1"
             value="<?php echo $uneseniPogodak !== null ? h($uneseniPogodak) : ''; ?>"
             required>

      <button class="btn" type="submit">Pošalji</button>
    </form>

    <?php if ($poruka !== null): ?>
      <div class="rezultat <?php echo $pogodak ? 'pogodak' : 'krivo'; ?>">
        <?php echo h($poruka); ?>
      </div>
      <p class="zamislljeni">Zamišljeni broj je <?php echo h($zamisljeniBroj); ?></p>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba3_1.php -->
