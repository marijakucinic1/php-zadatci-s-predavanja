<?php
// vjezba16/register.php — Registracijska forma + upis u bazu
$autor = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

// DB konfiguracija
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "vjezba16";

$greske  = [];
$uspjeh  = false;

// Dohvati POST vrijednosti za prikaz
$f = [
  "name"     => isset($_POST["name"])     ? trim($_POST["name"])     : "",
  "lastname" => isset($_POST["lastname"]) ? trim($_POST["lastname"]) : "",
  "email"    => isset($_POST["email"])    ? trim($_POST["email"])    : "",
  "username" => isset($_POST["username"]) ? trim($_POST["username"]) : "",
  "password" => "",
  "country"  => isset($_POST["country"])  ? trim($_POST["country"])  : "",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $f["password"] = isset($_POST["password"]) ? $_POST["password"] : "";

  // Validacija
  if ($f["name"] === "")     $greske[] = "Ime je obavezno.";
  if ($f["lastname"] === "") $greske[] = "Prezime je obavezno.";
  if (!filter_var($f["email"], FILTER_VALIDATE_EMAIL)) $greske[] = "E-mail nije ispravan.";

  $uLen = strlen($f["username"]);
  if ($uLen < 5 || $uLen > 10) $greske[] = "Korisničko ime mora imati 5–10 znakova.";
  if (strlen($f["password"]) < 4) $greske[] = "Lozinka mora imati najmanje 4 znaka.";

  if (empty($greske)) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
      $greske[] = "Greška pri spajanju na bazu: " . $conn->connect_error;
    } else {
      $stmt = $conn->prepare(
        "INSERT INTO users (name, lastname, email, username, password, country)
         VALUES (?, ?, ?, ?, ?, ?)"
      );
      $hashed = password_hash($f["password"], PASSWORD_DEFAULT);
      $stmt->bind_param("ssssss",
        $f["name"], $f["lastname"], $f["email"],
        $f["username"], $hashed, $f["country"]
      );

      if ($stmt->execute()) {
        $uspjeh = true;
        $f = array_fill_keys(array_keys($f), ""); // reset forme
      } else {
        if ($conn->errno === 1062) {
          $greske[] = "Korisničko ime ili e-mail već postoji.";
        } else {
          $greske[] = "Greška pri unosu: " . $conn->error;
        }
      }
      $stmt->close();
      $conn->close();
    }
  }
}

$drzave = ["","Afghanistan","Albania","Algeria","Argentina","Australia","Austria","Belgium",
           "Bosnia and Herzegovina","Brazil","Canada","China","Croatia","Czech Republic",
           "Denmark","Egypt","Finland","France","Germany","Greece","Hungary","India",
           "Ireland","Italy","Japan","Mexico","Netherlands","New Zealand","Norway",
           "Poland","Portugal","Romania","Russia","Serbia","Slovakia","Slovenia",
           "South Africa","Spain","Sweden","Switzerland","Turkey","Ukraine",
           "United Kingdom","United States"];
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Form</title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280;
            --accent:#2563eb; --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:520px; margin:48px auto; background:var(--card); padding:36px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 24px; font-size:1.7rem; }
    label { display:block; margin:14px 0 4px; font-weight:500; font-size:.95rem; }
    .hint { font-size:.78rem; color:var(--red); margin:2px 0 0; }
    input[type="text"], input[type="email"], input[type="password"], select {
      width:100%; padding:9px 12px; font-size:1rem;
      border:1px solid #d1d5db; border-radius:8px;
      outline:none; transition:border-color .15s; background:#fff;
    }
    input:focus, select:focus { border-color:var(--accent); }
    select { color: #6b7280; }
    select option:not(:first-child) { color: var(--text); }
    .btn {
      display:block; width:100%; margin-top:22px; padding:13px;
      font:inherit; font-size:1rem; font-weight:700; cursor:pointer;
      border:none; border-radius:10px;
      background:#22c55e; color:#fff; transition:opacity .15s;
      letter-spacing:.3px;
    }
    .btn:hover { opacity:.88; }
    .btn:focus-visible { outline:3px solid #22c55e; outline-offset:2px; }
    .btn:active { opacity:.75; }
    @media (prefers-reduced-motion: reduce) { .btn, input, select { transition:none; } }
    .alert { margin-top:18px; padding:12px 16px; border-radius:10px; font-size:.92rem; }
    .alert.ok  { background:#dcfce7; color:var(--green); font-weight:600; }
    .alert.err { background:#fee2e2; color:var(--red); }
    .alert.err ul { margin:6px 0 0; padding-left:18px; }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1>Registration Form</h1>

    <form method="post" action="vjezba16_register.php" novalidate>
      <label for="name">First Name *</label>
      <input type="text" id="name" name="name"
             value="<?php echo h($f['name']); ?>" placeholder="Your name..">

      <label for="lastname">Last Name *</label>
      <input type="text" id="lastname" name="lastname"
             value="<?php echo h($f['lastname']); ?>" placeholder="Your last name..">

      <label for="email">Your E-mail *</label>
      <input type="email" id="email" name="email"
             value="<?php echo h($f['email']); ?>" placeholder="Your e-mail..">

      <label for="username">
        Username: *
        <span class="hint">(Username must have min 5 and max 10 char)</span>
      </label>
      <input type="text" id="username" name="username"
             value="<?php echo h($f['username']); ?>" placeholder="Username.."
             minlength="5" maxlength="10">

      <label for="password">
        Password: *
        <span class="hint">(Password must have min 4 char)</span>
      </label>
      <input type="password" id="password" name="password"
             placeholder="Password.." minlength="4">

      <label for="country">Country:</label>
      <select id="country" name="country">
        <?php foreach ($drzave as $d): ?>
          <option value="<?php echo h($d); ?>"
                  <?php echo $f['country'] === $d && $d !== "" ? "selected" : ""; ?>>
            <?php echo $d === "" ? "molimo odaberite" : h($d); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button class="btn" type="submit">Submit</button>
    </form>

    <?php if ($uspjeh): ?>
      <div class="alert ok">✅ Registracija uspješna! Korisnik je dodan u bazu.</div>
    <?php elseif (!empty($greske)): ?>
      <div class="alert err">
        <strong>Ispravite greške:</strong>
        <ul><?php foreach ($greske as $g) echo "<li>" . h($g) . "</li>"; ?></ul>
      </div>
    <?php endif; ?>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba16_register.php -->
