<?php
// vjezba3_2.php — Kalkulator (switch naredba)
$naslov = "Kalkulator (Switch naredba)";
$autor  = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$broj1     = null;
$broj2     = null;
$rezultat  = null;
$operacija = null;
$greska    = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $broj1     = isset($_POST["broj1"]) && $_POST["broj1"] !== "" ? (float)$_POST["broj1"] : null;
  $broj2     = isset($_POST["broj2"]) && $_POST["broj2"] !== "" ? (float)$_POST["broj2"] : null;
  $operacija = isset($_POST["op"]) ? $_POST["op"] : null;

  if ($broj1 !== null && $broj2 !== null && $operacija !== null) {
    switch ($operacija) {
      case "+":
        $rezultat = $broj1 + $broj2;
        break;
      case "-":
        $rezultat = $broj1 - $broj2;
        break;
      case "*":
        $rezultat = $broj1 * $broj2;
        break;
      case "/":
        if ($broj2 == 0) {
          $greska = "Dijeljenje s nulom nije moguće!";
        } else {
          $rezultat = $broj1 / $broj2;
        }
        break;
      default:
        $greska = "Nepoznata operacija.";
    }
  }
}

// Zaokruži ako je cijeli broj
function fmt($n) {
  return ($n == floor($n)) ? (int)$n : round($n, 6);
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
    .wrap { max-width:480px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 20px; font-size:1.6rem; }
    label { display:block; margin:12px 0 4px; font-weight:500; }
    input[type="number"] {
      width:100%; padding:8px 10px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s;
    }
    input[type="number"]:focus { border-color:var(--accent); }
    .rezultat-row { margin:16px 0 4px; font-weight:500; }
    .rezultat-val {
      font-size:1.3rem; font-weight:700; color:var(--accent);
      min-height:1.8rem; display:block;
    }
    .greska { color:#dc2626; font-weight:600; }
    .ops { display:flex; gap:10px; margin-top:18px; }
    .btn-op {
      flex:1; padding:12px 0; font:inherit; font-size:1.1rem; font-weight:700;
      cursor:pointer; border:1px solid #d1d5db; border-radius:10px;
      background:#f9fafb; color:var(--text);
      transition:background .15s, border-color .15s, color .15s;
    }
    .btn-op:hover { background:var(--accent); border-color:var(--accent); color:#fff; }
    .btn-op:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    .btn-op:active { opacity:.8; }
    .btn-op.aktivan { background:var(--accent); border-color:var(--accent); color:#fff; }
    @media (prefers-reduced-motion: reduce) { .btn-op, input[type="number"] { transition:none; } }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1><?php echo h($naslov); ?></h1>

    <form method="post" action="vjezba3_2.php">
      <!-- čuvamo vrijednosti polja i aktivnu op -->
      <label for="broj1">Upiši prvi broj *</label>
      <input type="number" id="broj1" name="broj1" step="any"
             value="<?php echo $broj1 !== null ? h($broj1) : ''; ?>" required>

      <label for="broj2">Upiši drugi broj *</label>
      <input type="number" id="broj2" name="broj2" step="any"
             value="<?php echo $broj2 !== null ? h($broj2) : ''; ?>" required>

      <p class="rezultat-row">Rezultat:
        <span class="rezultat-val">
          <?php
            if ($greska) {
              echo '<span class="greska">' . h($greska) . '</span>';
            } elseif ($rezultat !== null) {
              echo h($broj1) . ' ' . h($operacija) . ' ' . h($broj2) . ' = <strong>' . fmt($rezultat) . '</strong>';
            }
          ?>
        </span>
      </p>

      <!-- skriveno polje za op — postavljamo ga JS-om na klik -->
      <input type="hidden" name="op" id="op" value="<?php echo $operacija ? h($operacija) : ''; ?>">

      <div class="ops">
        <?php foreach (['+', '-', '*', '/'] as $op): ?>
          <button type="submit" class="btn-op <?php echo $operacija === $op ? 'aktivan' : ''; ?>"
                  onclick="document.getElementById('op').value='<?php echo $op; ?>'">
            <?php echo h($op); ?>
          </button>
        <?php endforeach; ?>
      </div>
    </form>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba3_2.php -->
