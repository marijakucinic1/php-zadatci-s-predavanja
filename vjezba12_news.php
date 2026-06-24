<?php
// vjezba12/news.php — Inicijalizacija kolačića
$autor = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$poruka = null;
$greska = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $ime      = isset($_POST["ime"])      ? trim($_POST["ime"])      : "";
  $email    = isset($_POST["email"])    ? trim($_POST["email"])    : "";
  $kategorija = isset($_POST["kategorija"]) ? $_POST["kategorija"] : "";

  $dozvoljenKat = ["sport", "tehnologija", "kultura", "ekonomija"];

  if ($ime === "" || $email === "" || !in_array($kategorija, $dozvoljenKat)) {
    $greska = "Popunite sva polja ispravno.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $greska = "Unesite ispravnu e-mail adresu.";
  } else {
    // Postavi kolačiće na 30 dana
    $expire = time() + 30 * 24 * 60 * 60;
    setcookie("korisnik_ime",        $ime,        $expire, "/");
    setcookie("korisnik_email",      $email,      $expire, "/");
    setcookie("korisnik_kategorija", $kategorija, $expire, "/");
    $poruka = "Kolačići su postavljeni! <a href='index.php'>Idi na početnu stranicu →</a>";
  }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pretplata na novosti</title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280;
            --accent:#2563eb; --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:500px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 6px; font-size:1.6rem; }
    .opis { color:var(--muted); font-size:.9rem; margin:0 0 24px; }
    label { display:block; margin:12px 0 4px; font-weight:500; }
    input[type="text"], input[type="email"], select {
      width:100%; padding:9px 12px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s; background:#fff;
    }
    input:focus, select:focus { border-color:var(--accent); }
    .btn {
      display:block; width:100%; margin-top:20px; padding:12px;
      font:inherit; font-size:1rem; font-weight:600; cursor:pointer;
      border:none; border-radius:10px;
      background:var(--accent); color:#fff; transition:opacity .15s;
    }
    .btn:hover { opacity:.88; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.75; }
    @media (prefers-reduced-motion: reduce) { .btn, input, select { transition:none; } }
    .alert { margin-top:18px; padding:12px 16px; border-radius:10px; font-size:.95rem; }
    .alert.ok  { background:#dcfce7; color:var(--green); }
    .alert.ok a { color:var(--green); font-weight:600; }
    .alert.err { background:#fee2e2; color:var(--red); }
    .nav { margin-top:20px; font-size:.9rem; }
    .nav a { color:var(--accent); text-decoration:none; }
    .nav a:hover { text-decoration:underline; }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1>📰 Pretplata na novosti</h1>
    <p class="opis">Unesite podatke za personaliziranu pretplatu. Podaci se spremaju u kolačić.</p>

    <form method="post" action="news.php">
      <label for="ime">Vaše ime</label>
      <input type="text" id="ime" name="ime"
             value="<?php echo isset($_POST['ime']) ? h($_POST['ime']) : (isset($_COOKIE['korisnik_ime']) ? h($_COOKIE['korisnik_ime']) : ''); ?>"
             placeholder="npr. Ana Anić" required>

      <label for="email">E-mail adresa</label>
      <input type="email" id="email" name="email"
             value="<?php echo isset($_POST['email']) ? h($_POST['email']) : (isset($_COOKIE['korisnik_email']) ? h($_COOKIE['korisnik_email']) : ''); ?>"
             placeholder="ana@email.com" required>

      <label for="kategorija">Kategorija novosti</label>
      <select id="kategorija" name="kategorija">
        <?php
          $kategorije = ["sport" => "Sport", "tehnologija" => "Tehnologija",
                         "kultura" => "Kultura", "ekonomija" => "Ekonomija"];
          $trenutnaKat = isset($_POST['kategorija']) ? $_POST['kategorija']
                       : (isset($_COOKIE['korisnik_kategorija']) ? $_COOKIE['korisnik_kategorija'] : '');
          foreach ($kategorije as $val => $label):
        ?>
          <option value="<?php echo h($val); ?>" <?php echo $trenutnaKat === $val ? "selected" : ""; ?>>
            <?php echo h($label); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button class="btn" type="submit">Spremi kolačić</button>
    </form>

    <?php if ($poruka): ?>
      <div class="alert ok"><?php echo $poruka; ?></div>
    <?php elseif ($greska): ?>
      <div class="alert err"><?php echo h($greska); ?></div>
    <?php endif; ?>

    <p class="nav"><a href="index.php">← Natrag na početnu</a></p>
    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba12/news.php -->
