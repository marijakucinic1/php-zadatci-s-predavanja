<?php
// vjezba4_3.php — Brojanje riječi (str_word_count)
$naslov = "Zadatak str_word_count";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$ulaz      = null;
$brojRijeci = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["ulaz"]) && trim($_POST["ulaz"]) !== "") {
    $ulaz       = $_POST["ulaz"];
    $brojRijeci = str_word_count($ulaz);
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
    .opis { color:var(--muted); font-size:.9rem; margin:0 0 20px; line-height:1.5; }
    label { display:block; margin-bottom:6px; font-weight:500; }
    input[type="text"] {
      width:100%; padding:9px 12px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s;
    }
    input[type="text"]:focus { border-color:var(--accent); }
    .btn {
      display:inline-block; margin-top:12px; padding:10px 20px;
      font:inherit; font-size:1rem; font-weight:600; cursor:pointer;
      border:none; border-radius:10px;
      background:var(--accent); color:#fff; transition:opacity .15s;
    }
    .btn:hover { opacity:.88; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.75; }
    @media (prefers-reduced-motion: reduce) { .btn, input[type="text"] { transition:none; } }
    .rezultat { margin-top:20px; padding:14px 18px; background:#f0f6ff;
                border-left:4px solid var(--accent); border-radius:8px;
                font-size:.95rem; line-height:1.6; }
    .rezultat .ulazni-niz { color:var(--accent); font-family:monospace; }
    .rezultat strong { color:var(--text); }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p class="opis">U zadatku se traži da se ispiše koliko je riječi u rečenici. Koristite naredbu <code>str_word_count</code>.</p>

    <form method="post" action="vjezba4_3.php">
      <label for="ulaz">Ulazni niz:</label>
      <input type="text" id="ulaz" name="ulaz"
             value="<?php echo $ulaz !== null ? h($ulaz) : ''; ?>"
             placeholder="Upiši rečenicu..." required>
      <button class="btn" type="submit">ispiši broj riječi</button>
    </form>

    <?php if ($brojRijeci !== null): ?>
      <div class="rezultat">
        <span class="ulazni-niz">ulazni niz: <?php echo h($ulaz); ?></span>
        sadrži <strong><?php echo $brojRijeci; ?> riječi</strong>.
      </div>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba4_3.php -->
