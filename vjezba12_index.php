<?php
// vjezba12/index.php — Ispis kolačića
$autor = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$imeCookie      = isset($_COOKIE["korisnik_ime"])        ? $_COOKIE["korisnik_ime"]        : null;
$emailCookie    = isset($_COOKIE["korisnik_email"])      ? $_COOKIE["korisnik_email"]      : null;
$kategCookie    = isset($_COOKIE["korisnik_kategorija"]) ? $_COOKIE["korisnik_kategorija"] : null;

$imaKolacic = ($imeCookie !== null && $emailCookie !== null && $kategCookie !== null);

// Brisanje kolačića na zahtjev
if (isset($_GET["obrisi"])) {
  setcookie("korisnik_ime",        "", time() - 3600, "/");
  setcookie("korisnik_email",      "", time() - 3600, "/");
  setcookie("korisnik_kategorija", "", time() - 3600, "/");
  header("Location: index.php");
  exit;
}

$kategorijaNaziv = [
  "sport"       => "⚽ Sport",
  "tehnologija" => "💻 Tehnologija",
  "kultura"     => "🎭 Kultura",
  "ekonomija"   => "📈 Ekonomija",
];
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Početna — Cookie demo</title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280;
            --accent:#2563eb; --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:520px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 20px; font-size:1.6rem; }
    .dobrodosao { font-size:1.1rem; margin:0 0 20px; }
    .dobrodosao strong { color:var(--accent); }
    .info-blok { background:#f8fafc; border-radius:12px; padding:18px 20px; margin-bottom:20px; }
    .info-red { display:flex; justify-content:space-between; align-items:center;
                padding:7px 0; border-bottom:1px solid #e5e7eb; font-size:.95rem; }
    .info-red:last-child { border-bottom:none; }
    .info-label { color:var(--muted); }
    .info-val { font-weight:600; }
    .btn {
      display:inline-block; padding:10px 20px; font:inherit; font-size:.95rem;
      font-weight:600; cursor:pointer; border-radius:10px;
      text-decoration:none; transition:opacity .15s;
    }
    .btn-primary { background:var(--accent); color:#fff; border:none; }
    .btn-danger  { background:transparent; color:var(--red); border:1px solid var(--red); }
    .btn:hover { opacity:.85; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn:active { opacity:.7; }
    @media (prefers-reduced-motion: reduce) { .btn { transition:none; } }
    .row { display:flex; gap:10px; flex-wrap:wrap; }
    .nema-kolacica { padding:20px; background:#fef9c3; border-radius:12px;
                     color:#92400e; font-size:.95rem; margin-bottom:20px; }
    .nema-kolacica a { color:#92400e; font-weight:600; }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1>🏠 Početna stranica</h1>

    <?php if ($imaKolacic): ?>
      <p class="dobrodosao">
        Dobrodošao/la, <strong><?php echo h($imeCookie); ?></strong>! 👋
      </p>

      <div class="info-blok">
        <div class="info-red">
          <span class="info-label">Ime</span>
          <span class="info-val"><?php echo h($imeCookie); ?></span>
        </div>
        <div class="info-red">
          <span class="info-label">E-mail</span>
          <span class="info-val"><?php echo h($emailCookie); ?></span>
        </div>
        <div class="info-red">
          <span class="info-label">Kategorija novosti</span>
          <span class="info-val">
            <?php echo isset($kategorijaNaziv[$kategCookie])
              ? h($kategorijaNaziv[$kategCookie])
              : h($kategCookie); ?>
          </span>
        </div>
        <div class="info-red">
          <span class="info-label">Kolačić vrijedi</span>
          <span class="info-val">30 dana</span>
        </div>
      </div>

      <div class="row">
        <a class="btn btn-primary" href="news.php">✏️ Uredi pretplatu</a>
        <a class="btn btn-danger"  href="index.php?obrisi=1"
           onclick="return confirm('Obrisati kolačiće?')">🗑️ Obriši kolačiće</a>
      </div>

    <?php else: ?>
      <div class="nema-kolacica">
        Nema aktivnih kolačića. <a href="news.php">Postavi kolačić →</a>
      </div>
      <a class="btn btn-primary" href="news.php">Idi na pretplatu</a>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba12/index.php -->
