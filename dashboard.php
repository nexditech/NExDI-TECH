[11:07 pm, 13/09/2025] NY Dawara: <?php
require_once _DIR_ . '/../inc/config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = strtolower(trim($_POST['email'] ?? ''));
  $password = $_POST['password'] ?? '';

  if ($email && $password) {
    $stmt = $pdo->prepare("SELECT id, full_name, password_hash, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
      // Start secure session
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['full_name'];
      $_SESSION['role'] = $user['role'];

      // Redirect to dashboard
      header('Location: dashboard.php');
      exit;
    } else {
      $err…
[11:20 pm, 13/09/2025] NY Dawara: <?php
require_once _DIR_ . '/../inc/config.php';
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}

$name = $_SESSION['user_name'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NExDI Tech Hub - Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6f9;
    }
    header {
      background: #111827;
      color: white;
      padding: 15px 20px;
      text-align: center;
    }
    .sidebar {
      width: 220px;
      height: 100vh;
      background: #1f2937;
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 70px;
    }
    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: #ddd;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #374151;
      color: #fff;
    }
    .main {
      margin-left: 220px;
      padding: 20px;
    }
    .card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card h3 {
      margin-top: 0;
      color: #111827;
    }
    .logout {
      position: absolute;
      bottom: 20px;
      left: 20px;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Welcome, <?= htmlspecialchars($name) ?> 👋</h1>
    <p>Role: <?= htmlspecialchars($role) ?></p>
  </header>

  <div class="sidebar">
    <a href="#overview">📊 Overview</a>
    <a href="#projects">💡 Projects</a>
    <a href="#community">👥 Community</a>
    <a href="#learning">📚 Learning</a>
    <a href="#support">🛠 Support</a>
    <a href="logout.php" class="logout">🚪 Logout</a>
  </div>

  <div class="main">
    <section id="overview" class="card">
      <h3>Dashboard Overview</h3>
      <p>This is your central hub for all things NExDI Tech. From projects to community collaboration, everything starts here.</p>
    </section>

    <div class="grid">
      <section id="projects" class="card">
        <h3>My Projects</h3>
        <p>You are currently working on:</p>
        <ul>
          <li>AI Research Tool</li>
          <li>Website Builder</li>
          <li>Mobile Payment App</li>
        </ul>
      </section>

      <section id="community" class="card">
        <h3>Community</h3>
        <p>Connect with innovators and creators inside NExDI Hub.</p>
        <button>Join Discussion</button>
      </section>

      <section id="learning" class="card">
        <h3>Learning Resources</h3>
        <p>Continue your growth:</p>
        <ul>
          <li>Web Development</li>
          <li>Cybersecurity Basics</li>
          <li>Cloud Computing</li>
        </ul>
      </section>

      <section id="support" class="card">
        <h3>Support</h3>
        <p>Email: support@nexditech.org</p>
        <p>WhatsApp: +234-XXXXXXXXXX</p>
      </section>
    </div>
  </div>
</body>
</html>