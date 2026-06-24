<?php
// vjezba13/index.php — Ispis sjednice (session)
session_start();

$autor = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

// Brisanje sjednice na zahtjev
if (isset($_GET["obrisi"])) {
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
}

$imeSes   = isset($_SESSION["korisnik_ime"])        ? $_SESSION["korisnik_ime"]        : null;
$emailSes = isset($_SESSION["korisnik_email"])      ? $_SESSION["korisnik_email"]      : null;
$kategSes = isset($_SESSION["korisnik_kategorija"]) ? $_SESSION["korisnik_kategorija"] : null;

$imaSjednicu = ($imeSes !== null && $emailSes !== null && $kategSes !== null);

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
  <title>Početna — Session demo</title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280;
            --accent:#2563eb; --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:520px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 6px; font-size:1.6rem; }
    .session-badge { display:inline-block; margin-bottom:16px; padding:4px 10px;
                     background:#f0fdf4; color:var(--green); border:1px solid #bbf7d0;
                     border-radius:20px; font-size:.8rem; font-weight:600; }
    .dobrodosao { font-size:1.1rem; margin:0 0 20px; }
    .dobrodosao strong { color:var(--accent); }
    .info-blok { background:#f8fafc; border-radius:12px; padding:18px 20px; margin-bottom:20px; }
    .info-red { display:flex; justify-content:space-between; align-items:center;
                padding:7px 0; border-bottom:1px solid #e5e7eb; font-size:.95rem; }
    .info-red:last-child { border-bottom:none; }
    .info-label { color:var(--muted); }
    .info-val { font-weight:600; }
    .session-id { font-size:.78rem; color:var(--muted); word-break:break-all;
                  background:#f1f5f9; padding:6px 10px; border-radius:6px;
                  margin-bottom:16px; }
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
    .nema-sjednice { padding:20px; background:#fef9c3; border-radius:12px;
                     color:#92400e; font-size:.95rem; margin-bottom:20px; }
    .nema-sjednice a { color:#92400e; font-weight:600; }
    .napomena { margin-top:14px; font-size:.82rem; color:var(--muted);
                padding:8px 12px; background:#f8fafc; border-radius:8px; }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1>🏠 Početna stranica</h1>
    <span class="session-badge">🔐 session_start()</span>

    <?php if ($imaSjednicu): ?>
      <p class="dobrodosao">
        Dobrodošao/la, <strong><?php echo h($imeSes); ?></strong>! 👋
      </p>

      <div class="session-id">
        Session ID: <?php echo h(session_id()); ?>
      </div>

      <div class="info-blok">
        <div class="info-red">
          <span class="info-label">Ime</span>
          <span class="info-val"><?php echo h($imeSes); ?></span>
        </div>
        <div class="info-red">
          <span class="info-label">E-mail</span>
          <span class="info-val"><?php echo h($emailSes); ?></span>
        </div>
        <div class="info-red">
          <span class="info-label">Kategorija novosti</span>
          <span class="info-val">
            <?php echo isset($kategorijaNaziv[$kategSes])
              ? h($kategorijaNaziv[$kategSes])
              : h($kategSes); ?>
          </span>
        </div>
        <div class="info-red">
          <span class="info-label">Trajanje sjednice</span>
          <span class="info-val">Dok je preglednik otvoren</span>
        </div>
      </div>

      <div class="row">
        <a class="btn btn-primary" href="news.php">✏️ Uredi sjednicu</a>
        <a class="btn btn-danger"  href="index.php?obrisi=1"
           onclick="return confirm('Uništiti sjednicu?')">🗑️ Završi sjednicu</a>
      </div>

      <p class="napomena">
        ℹ️ Za razliku od kolačića, sjednica se briše zatvaranjem preglednika ili pozivom
        <code>session_destroy()</code>.
      </p>

    <?php else: ?>
      <div class="nema-sjednice">
        Nema aktivne sjednice. <a href="news.php">Pokreni sjednicu →</a>
      </div>
      <a class="btn btn-primary" href="news.php">Idi na pretplatu</a>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba13/index.php -->
