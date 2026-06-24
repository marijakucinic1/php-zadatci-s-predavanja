<?php
// vjezba18.php — Lista korisnika + edit (ime, prezime, država)
$autor = "Marija Kučinić";

function h($s) { return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); }

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "vjezba17";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset("utf8mb4");

$poruka = null;
$greska = null;

// --- SAVE EDIT ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_id"])) {
  $id       = (int)$_POST["edit_id"];
  $name     = trim($_POST["name"]     ?? "");
  $lastname = trim($_POST["lastname"] ?? "");
  $cid      = (int)($_POST["country_id"] ?? 0);

  if ($name === "" || $lastname === "") {
    $greska = "Ime i prezime su obavezni.";
  } else {
    $stmt = $conn->prepare(
      "UPDATE users SET name=?, lastname=?, country_id=?, updated_at=NOW() WHERE id=?"
    );
    $cidVal = $cid > 0 ? $cid : null;
    $stmt->bind_param("ssii", $name, $lastname, $cidVal, $id);
    $stmt->execute();
    $stmt->close();
    $poruka = "Korisnik ažuriran.";
    header("Location: vjezba18.php?ok=1");
    exit;
  }
}

if (isset($_GET["ok"])) $poruka = "Korisnik uspješno ažuriran!";

// Edit mode
$editId   = isset($_GET["edit"]) ? (int)$_GET["edit"] : 0;
$editUser = null;
if ($editId > 0) {
  $stmt = $conn->prepare("SELECT id, name, lastname, country_id FROM users WHERE id=?");
  $stmt->bind_param("i", $editId);
  $stmt->execute();
  $editUser = $stmt->get_result()->fetch_assoc();
  $stmt->close();
}

// Dohvati sve države
$countries = [];
$res = $conn->query("SELECT id, name FROM countries ORDER BY name");
while ($row = $res->fetch_assoc()) $countries[] = $row;

// Dohvati sve korisnike s državom
$users = [];
$res = $conn->query(
  "SELECT u.id, u.name, u.lastname, u.email, c.name AS country_name
   FROM users u
   LEFT JOIN countries c ON u.country_id = c.id
   ORDER BY u.lastname, u.name"
);
while ($row = $res->fetch_assoc()) $users[] = $row;

$conn->close();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista korisnika</title>
  <style>
    :root { --bg:#0f172a; --card:#ffffff; --text:#111827; --muted:#6b7280;
            --accent:#2563eb; --green:#16a34a; --red:#dc2626; }
    * { box-sizing: border-box; }
    body { margin:0; font-size:16px; background:var(--bg); color:var(--text);
           font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
    .wrap { max-width:780px; margin:48px auto; background:var(--card); padding:32px;
            border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
    h1 { margin:0 0 20px; font-size:1.6rem; }
    .alert { padding:10px 16px; border-radius:10px; margin-bottom:16px; font-size:.92rem; }
    .alert.ok  { background:#dcfce7; color:var(--green); }
    .alert.err { background:#fee2e2; color:var(--red); }
    table { width:100%; border-collapse:collapse; font-size:.93rem; }
    th { text-align:left; padding:9px 12px; background:#f8fafc;
         border-bottom:2px solid #e5e7eb; color:var(--muted); font-weight:600; }
    td { padding:9px 12px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:#fafafa; }
    .user-name { font-weight:600; }
    .country { color:var(--accent); font-size:.88rem; }
    .btn-edit {
      padding:5px 12px; font-size:.82rem; font-weight:600; cursor:pointer;
      border:1px solid var(--accent); border-radius:7px; background:transparent;
      color:var(--accent); text-decoration:none; transition:background .15s, color .15s;
    }
    .btn-edit:hover { background:var(--accent); color:#fff; }
    /* Edit form */
    .edit-blok { margin-bottom:24px; padding:20px 24px; background:#f0f6ff;
                 border-left:4px solid var(--accent); border-radius:10px; }
    .edit-blok h2 { margin:0 0 14px; font-size:1.1rem; }
    .edit-row { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:10px; }
    .edit-row label { display:block; font-weight:500; font-size:.88rem; margin-bottom:3px; }
    .edit-row .field { flex:1; min-width:140px; }
    input[type="text"], select {
      width:100%; padding:8px 10px; font-size:.95rem;
      border:1px solid #d1d5db; border-radius:8px; outline:none;
      background:#fff; transition:border-color .15s;
    }
    input[type="text"]:focus, select:focus { border-color:var(--accent); }
    .edit-actions { display:flex; gap:10px; margin-top:12px; }
    .btn {
      padding:9px 18px; font:inherit; font-size:.9rem; font-weight:600;
      cursor:pointer; border-radius:9px; transition:opacity .15s;
    }
    .btn-primary { background:var(--accent); color:#fff; border:none; }
    .btn-cancel  { background:transparent; color:var(--muted); border:1px solid #d1d5db;
                   text-decoration:none; display:inline-flex; align-items:center; }
    .btn:hover { opacity:.85; }
    .btn:focus-visible { outline:3px solid var(--accent); outline-offset:2px; }
    @media (prefers-reduced-motion: reduce) { .btn, input, select, .btn-edit { transition:none; } }
    .autor { margin-top:24px; font-size:.85rem; color:var(--muted); }
  </style>
</head>
<body>
  <main class="wrap">
    <h1>👥 Lista korisnika</h1>

    <?php if ($poruka): ?>
      <div class="alert ok"><?php echo h($poruka); ?></div>
    <?php elseif ($greska): ?>
      <div class="alert err"><?php echo h($greska); ?></div>
    <?php endif; ?>

    <?php if ($editUser): ?>
      <div class="edit-blok">
        <h2>✏️ Uredi korisnika #<?php echo $editUser['id']; ?></h2>
        <form method="post" action="vjezba18.php">
          <input type="hidden" name="edit_id" value="<?php echo h($editUser['id']); ?>">
          <div class="edit-row">
            <div class="field">
              <label>Ime</label>
              <input type="text" name="name" value="<?php echo h($editUser['name']); ?>" required>
            </div>
            <div class="field">
              <label>Prezime</label>
              <input type="text" name="lastname" value="<?php echo h($editUser['lastname']); ?>" required>
            </div>
            <div class="field">
              <label>Država</label>
              <select name="country_id">
                <option value="0">— bez države —</option>
                <?php foreach ($countries as $c): ?>
                  <option value="<?php echo $c['id']; ?>"
                          <?php echo $c['id'] == $editUser['country_id'] ? "selected" : ""; ?>>
                    <?php echo h($c['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="edit-actions">
            <button class="btn btn-primary" type="submit">Spremi</button>
            <a class="btn btn-cancel" href="vjezba18.php">Odustani</a>
          </div>
        </form>
      </div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Ime i prezime</th>
          <th>E-mail</th>
          <th>Država</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr><td colspan="5" style="color:var(--muted);text-align:center;padding:20px;">
            Nema korisnika u bazi.
          </td></tr>
        <?php else: ?>
          <?php foreach ($users as $u): ?>
            <tr>
              <td style="color:var(--muted)"><?php echo $u['id']; ?></td>
              <td class="user-name">
                <?php echo h($u['name']); ?> <?php echo h($u['lastname']); ?>
              </td>
              <td><?php echo h($u['email']); ?></td>
              <td class="country">
                <?php echo $u['country_name'] ? h($u['country_name']) : '<span style="color:var(--muted)">—</span>'; ?>
              </td>
              <td>
                <a class="btn-edit" href="vjezba18.php?edit=<?php echo $u['id']; ?>">
                  Uredi
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <p class="autor">&copy; <?php echo date('Y'); ?> — <?php echo h($autor); ?></p>
  </main>
</body>
</html>
<!-- Naziv datoteke: vjezba18.php -->
