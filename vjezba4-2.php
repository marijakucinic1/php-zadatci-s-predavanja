<?php
// vjezba4_2.php — Radno vrijeme dućana (if/else + datum/vrijeme)
$naslov = "Radno vrijeme dućana";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

// Hrvatski državni praznici i blagdani (MM-DD format)
$praznici = [
  "01-01", // Nova godina
  "01-06", // Sveta tri kralja
  "04-20", // Uskrs 2025 (promjenjiv — za produkciju koristiti računanje)
  "04-21", // Uskrsni ponedjeljak 2025
  "05-01", // Praznik rada
  "05-29", // Tijelovo 2025 (promjenjiv)
  "06-22", // Dan antifašističke borbe
  "06-25", // Dan državnosti
  "08-05", // Dan domovinske zahvalnosti
  "08-15", // Velika Gospa
  "11-01", // Svi sveti
  "11-18", // Dan sjećanja
  "12-25", // Božić
  "12-26", // Sveti Stjepan
];

$sada      = new DateTime("now", new DateTimeZone("Europe/Zagreb"));
$danTjedna = (int)$sada->format("N"); // 1=pon ... 7=ned
$sat       = (int)$sada->format("G"); // 0-23
$datumKey  = $sada->format("m-d");

$jePraznik = in_array($datumKey, $praznici);
$jeNedjelja = ($danTjedna === 7);
$jeSubota   = ($danTjedna === 6);

// Logika
if ($jePraznik) {
  $status  = "zatvoren";
  $razlog  = "Dućan je zatvoren — državni praznik ili blagdan.";
} elseif ($jeNedjelja) {
  $status  = "zatvoren";
  $razlog  = "Nedjelja — dućan ne radi.";
} elseif ($jeSubota) {
  $otvoren = ($sat >= 9 && $sat < 14);
  $status  = $otvoren ? "otvoren" : "zatvoren";
  $razlog  = $otvoren
    ? "Subota — dućan radi od 9 do 14 h."
    : "Subota — dućan radi od 9 do 14 h, trenutno je zatvoreno.";
} else {
  $otvoren = ($sat >= 8 && $sat < 20);
  $status  = $otvoren ? "otvoren" : "zatvoren";
  $razlog  = $otvoren
    ? "Dućan radi od 8 do 20 h — trenutno je otvoren."
    : "Dućan radi od 8 do 20 h — trenutno je zatvoreno.";
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo h($naslov); ?></title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280;
            --accent:#2563eb; --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:480px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 6px; font-size:1.6rem; }
    .vrijeme { color:var(--muted); font-size:.9rem; margin:0 0 24px; }
    .status-blok { padding:20px 24px; border-radius:12px; text-align:center; }
    .status-blok.otvoren  { background:#dcfce7; color:var(--green); }
    .status-blok.zatvoren { background:#fee2e2; color:var(--red); }
    .status-ikona { font-size:2.5rem; display:block; margin-bottom:8px; }
    .status-naziv { font-size:1.4rem; font-weight:700; text-transform:uppercase; }
    .status-razlog { margin-top:8px; font-size:.95rem; font-weight:400; }
    .tablica { width:100%; margin-top:20px; border-collapse:collapse; font-size:.9rem; }
    .tablica th { text-align:left; color:var(--muted); font-weight:500;
                  padding:6px 0; border-bottom:1px solid #f1f5f9; }
    .tablica td { padding:6px 0; border-bottom:1px solid #f1f5f9; }
    .tablica tr:last-child td { border-bottom:none; }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p class="vrijeme">
      <?php echo $sada->format("l, d.m.Y."); ?> — <?php echo $sada->format("H:i"); ?> h
    </p>

    <div class="status-blok <?php echo $status; ?>">
      <span class="status-ikona"><?php echo $status === "otvoren" ? "🟢" : "🔴"; ?></span>
      <div class="status-naziv"><?php echo strtoupper($status); ?></div>
      <div class="status-razlog"><?php echo h($razlog); ?></div>
    </div>

    <table class="tablica">
      <tr><th>Dan</th><th>Radno vrijeme</th></tr>
      <tr><td>Ponedjeljak – Petak</td><td>08:00 – 20:00</td></tr>
      <tr><td>Subota</td><td>09:00 – 14:00</td></tr>
      <tr><td>Nedjelja</td><td>Zatvoreno</td></tr>
      <tr><td>Praznici i blagdani</td><td>Zatvoreno</td></tr>
    </table>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba4_2.php -->
