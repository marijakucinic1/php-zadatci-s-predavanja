<?php
// vjezba2_4.php — formula c = (3a - b) / 2
$naslov = "Vježba 2-4 — Formula c = (3a – b) / 2";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$a = $b = $c = null;
$prikaziRezultat = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["a"], $_POST["b"]) && $_POST["a"] !== "" && $_POST["b"] !== "") {
    $a = (float)$_POST["a"];
    $b = (float)$_POST["b"];
    $c = (3 * $a - $b) / 2;
    $prikaziRezultat = true;
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
    .wrap { max-width:720px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 12px; font-size:2rem; }
    p  { margin:0 0 14px; line-height:1.6; }
    label { display:block; margin:8px 0 4px; font-weight:500; }
    input[type="number"] {
      width:100%; padding:8px 10px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s;
    }
    input[type="number"]:focus { border-color:var(--accent); }
    .btn { display:inline-block; padding:10px 20px; border:1px solid var(--accent);
           border-radius:10px; text-decoration:none; color:var(--accent);
           background:transparent; font:inherit; cursor:pointer;
           transition:background .15s, color .15s; margin-top:14px; }
    .btn:hover { background:var(--accent); color:#fff; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.8; }
    @media (prefers-reduced-motion: reduce) { .btn, input[type="number"] { transition:none; } }
    .rezultat { margin-top:20px; padding:16px 20px; background:#f0f6ff;
                border-left:4px solid var(--accent); border-radius:8px; }
    .rezultat strong { font-size:1.2rem; color:var(--accent); }
    .formula { color:var(--muted); font-size:.9rem; margin:0 0 4px; }
    .muted { color:var(--muted); font-size:.9rem; margin-top:20px; }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p>Ovu stranicu izradila je <strong><?php echo h($autor); ?></strong>.</p>
    <p class="formula">Formula: <strong>c = (3a – b) / 2</strong></p>

    <form method="post" action="vjezba2_4.php">
      <label for="a">Vrijednost a:</label>
      <input type="number" id="a" name="a" step="any"
             value="<?php echo $prikaziRezultat ? h($_POST['a']) : ''; ?>" required>

      <label for="b">Vrijednost b:</label>
      <input type="number" id="b" name="b" step="any"
             value="<?php echo $prikaziRezultat ? h($_POST['b']) : ''; ?>" required>

      <button class="btn" type="submit">Pošalji</button>
    </form>

    <?php if ($prikaziRezultat): ?>
      <div class="rezultat">
        <p style="margin:0 0 4px;">c = (3 × <?php echo h($a); ?> – <?php echo h($b); ?>) / 2</p>
        <p style="margin:0;">Rezultat: <strong>c = <?php echo $c; ?></strong></p>
      </div>
    <?php endif; ?>

    <p class="muted">&copy; <?php echo date('Y'); ?> — Demo za PHP</p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba2_4.php -->
