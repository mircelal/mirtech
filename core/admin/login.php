<?php

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['password'] ?? '';
    if (password_verify($pass, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    }
    $error = 'Şifrə yanlışdır.';
}
?>
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Giriş — MirTech Admin</title>
<?php require CORE_PATH . '/includes/head-fonts.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="<?= asset('admin/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('assets/css/typography-az.css') ?>">
</head>
<body class="adm-body adm-login-page">
<div class="adm-login-scene">
  <div class="adm-login-card">
    <div class="adm-login-brand">
      <span class="adm-login-mark"><i class="fa-solid fa-code"></i></span>
      <div>
        <strong>Mir<span>Tech</span></strong>
        <span>Admin panel</span>
      </div>
    </div>

    <h1>Daxil olun</h1>
    <p>Layihə, xidmət və sayt parametrlərini idarə edin.</p>

    <?php if ($error): ?>
    <div class="adm-alert adm-alert-err adm-login-alert" role="alert">
      <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
      <span><?= htmlspecialchars($error) ?></span>
    </div>
    <?php endif; ?>

    <form class="adm-form adm-login-form" method="post" novalidate>
      <label for="admin-password">Şifrə</label>
      <div class="adm-login-field">
        <i class="fa-solid fa-lock adm-login-field-ico" aria-hidden="true"></i>
        <input
          type="password"
          id="admin-password"
          name="password"
          required
          autofocus
          autocomplete="current-password"
          placeholder="Şifrənizi daxil edin"
        >
        <button type="button" class="adm-login-toggle" id="toggle-password" aria-label="Şifrəni göstər">
          <i class="fa-solid fa-eye" aria-hidden="true"></i>
        </button>
      </div>

      <button type="submit" class="adm-btn adm-btn-login">
        <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
        Panelə daxil ol
      </button>
    </form>

    <a href="<?= url() ?>" class="adm-login-back">
      <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
      Ana sayta qayıt
    </a>
  </div>
</div>
<script>
(function () {
  var btn = document.getElementById('toggle-password');
  var input = document.getElementById('admin-password');
  if (!btn || !input) return;
  btn.addEventListener('click', function () {
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.setAttribute('aria-label', show ? 'Şifrəni gizlət' : 'Şifrəni göstər');
    btn.querySelector('i').className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
  });
})();
</script>
</body>
</html>
