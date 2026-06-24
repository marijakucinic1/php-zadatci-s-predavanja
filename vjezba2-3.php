<?php
// vjezba1d.php — forma + slika (nadogradnja na vjezba1c.php)
// Osnovni PHP pojmovi: varijable, $_GET, echo, HTML, jednostavan CSS (bez sessiona i uploada)

$naslov = "PHP dokument — vježba 1d";
$autor  = "Marija Kučinić";
$opis   = "Ova stranica nadograđuje vježbu 1c: biramo temu (dark/light), odabiremo sliku i po želji prikazujemo opis.";

// --- Dozvoljene vrijednosti ---
$dozvoljeneTeme  = array("dark", "light");
$dozvoljeneSlike = array(
  "php"    => "img/php.jpg",
  "server" => "img/server.jpg",
  "code"   => "img/code.jpg"
);

// --- Ulaz (GET) s default vrijednostima ---
$temaKey  = isset($_GET["tema"]) && in_array($_GET["tema"], $dozvoljeneTeme) ? $_GET["tema"] : "dark";
$slikaKey = isset($_GET["slika"]) && isset($dozvoljeneSlike[$_GET["slika"]]) ? $_GET["slika"] : "php";
$prikaziOpis = isset($_GET["opis"]); // checkbox

// --- Izvedene vrijednosti za prikaz ---
$slikaPath = $dozvoljeneSlike[$slikaKey];

// Jednostavna "sanitizacija" za prikaz u HTML-u:
function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

// Tema → boje (CSS varijable)
if ($temaKey === "light") {
  $bg = "#f1f5f9";  // svijetla pozadina
  $card = "#ffffff";
  $text = "#0f172a";
  $muted = "#64748b";
  $accent = "#1d4ed8";
} else {
  $bg = "#0f172a";  // tamna pozadina
  $card = "#ffffff";
  $text = "#111827";
  $muted = "#6b7280";
  $accent = "#2563eb";
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Vježba 1d — forma (GET), izbor teme i slike, osnovni CSS.">
  <title><?php echo h($naslov); ?></title>
  <style>
    :root{
      --bg: <?php echo $bg; ?>;
      --card: <?php echo $card; ?>;
      --text: <?php echo $text; ?>;
      --muted: <?php echo $muted; ?>;
      --accent: <?php echo $accent; ?>;
    }
    *{ box-sizing: border-box; }
    body{
      margin:0; font-size:16px; background:var(--bg); color:var(--text);
      font-family: system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;
    }
    .wrap{
      max-width: 720px; margin: 48px auto; background: var(--card);
      padding: 32px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }
    h1{ margin:0 0 12px; font-size: 2rem; }
    p{ margin:0 0 14px; line-height: 1.6; }
    .muted{ color: var(--muted); font-size: .95rem; }
    
    .btn, .btn:link, .btn:visited {
      display: inline-block;
      padding: 10px 16px;
      font: inherit;
      line-height: 1;
      color: var(--accent);
      background: transparent;
      border: 1px solid var(--accent);
      border-radius: 10px;
      text-decoration: none;
      cursor: pointer;
      transition: background .15s, color .15s;
      -webkit-appearance: none;
      appearance: none;
    }

    .btn:hover {
      background: var(--accent);
      color: #fff;
    }

    .btn:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 2px;
    }

    .btn:active {
      opacity: .9;
    }

    @media (prefers-reduced-motion: reduce) { .btn { transition: none; } }

    .row{ display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }
    .figure{ margin: 10px 0 16px; }
    .figure img{ max-width:100%; height:auto; display:block; border-radius:10px; }
    form{ margin-top: 8px; }
    label{ display:block; margin: 6px 0; }
    select, input[type="radio"], input[type="checkbox"]{ margin-right:6px; }
    fieldset{ border:1px solid #e5e7eb; border-radius:10px; padding:10px 12px; margin:10px 0; }
    legend{ padding:0 6px; color: var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>
    <p>Ovu stranicu izradio/la je <strong><?php echo h($autor); ?></strong>.</p>

    <div class="figure">
      <img src="<?php echo h($slikaPath); ?>" alt="<?php echo h($slikaKey); ?>">
    </div>

    <?php if ($prikaziOpis): ?>
      <p><?php echo h($opis); ?></p>
    <?php endif; ?>

    <form method="get" action="vjezba1d.php">
      <fieldset>
        <legend>Odaberi temu</legend>
        <label><input type="radio" name="tema" value="dark"  <?php echo $temaKey==="dark" ? "checked" : ""; ?>> Dark</label>
        <label><input type="radio" name="tema" value="light" <?php echo $temaKey==="light" ? "checked" : ""; ?>> Light</label>
      </fieldset>

      <fieldset>
        <legend>Odaberi sliku</legend>
        <label for="slika">Slika:</label>
        <select id="slika" name="slika">
          <option value="php"    <?php echo $slikaKey==="php"    ? "selected" : ""; ?>>PHP</option>
          <option value="server" <?php echo $slikaKey==="server" ? "selected" : ""; ?>>Server</option>
          <option value="code"   <?php echo $slikaKey==="code"   ? "selected" : ""; ?>>Code</option>
        </select>
      </fieldset>

      <label><input type="checkbox" name="opis" <?php echo $prikaziOpis ? "checked" : ""; ?>> Prikaži opis</label>

      <div class="row" style="margin-top:10px">
        <button class="btn" type="submit">Primijeni odabir</button>
        <a class="btn" href="vjezba1c.php">Natrag na vježba 1c</a>
      </div>
    </form>

    <p class="muted">© <?php echo date("Y"); ?> — Demo za PHP</p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba1d.php -->
