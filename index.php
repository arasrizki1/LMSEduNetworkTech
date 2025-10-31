<?php
// File: public/index.php (Dashboard Utama)
require_once __DIR__ . '../includes/db.php';
$page_title = 'Beranda Utama';
require __DIR__ . '../includes/header.php';
?>

<!-- Hero Section -->
<section class="text-center py-5 hero-section">
  <h1 class="fw-bold text-primary mb-3">Selamat Datang di EduNetworkTech</h1>
  <p class="lead text-secondary">Platform pembelajaran dan komunitas Teknisi Jaringan Komputer</p>
  <div class="mt-4">
    <a href="login.php" class="btn btn-primary btn-lg me-2">Masuk</a>
    <a href="register.php" class="btn btn-outline-primary btn-lg">Daftar</a>
  </div>
</section>

<!-- Card Menu Dashboard -->
<section class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-4 mb-4">
      <div class="card card-menu network-card text-center shadow-sm">
        <div class="card-body">
          <div class="network-icon mb-3">
            <i class="bi bi-router"></i>
          </div>
          <h5 class="card-title">Jaringan & Infrastruktur</h5>
          <p class="text-muted">Pelajari cara kerja jaringan komputer, topologi, dan keamanan jaringan.</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card card-menu network-card text-center shadow-sm">
        <div class="card-body">
          <div class="network-icon mb-3">
            <i class="bi bi-globe2"></i>
          </div>
          <h5 class="card-title">Komunitas Teknisi</h5>
          <p class="text-muted">Bergabung dengan sesama teknisi jaringan untuk berbagi pengetahuan dan pengalaman.</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card card-menu network-card text-center shadow-sm">
        <div class="card-body">
          <div class="network-icon mb-3">
            <i class="bi bi-laptop"></i>
          </div>
          <h5 class="card-title">Kelas & Sertifikasi</h5>
          <p class="text-muted">Ikuti kelas, ujian, dan dapatkan sertifikat resmi EduNetworkTech.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Background Animation Section -->
<div class="network-background">
  <div class="node"></div>
  <div class="node"></div>
  <div class="node"></div>
  <div class="node"></div>
  <div class="node"></div>
</div>

<style>
.hero-section {
  background: linear-gradient(180deg, #E9F7FF 0%, #F8FBFF 100%);
  border-radius: 12px;
}
.network-card {
  border-left: 5px solid #0ea5e9;
  border-radius: 14px;
  transition: all 0.3s ease;
}
.network-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 10px 30px rgba(2,6,23,0.08);
}
.network-icon {
  font-size: 40px;
  color: #0ea5e9;
}
.network-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
  background: radial-gradient(circle at center, #E9F7FF, #cceeff);
}
.network-background .node {
  position: absolute;
  width: 8px;
  height: 8px;
  background: #0ea5e9;
  border-radius: 50%;
  animation: floatNode 10s infinite ease-in-out;
}
@keyframes floatNode {
  0% { transform: translateY(0); opacity: 0.7; }
  50% { transform: translateY(-30px); opacity: 1; }
  100% { transform: translateY(0); opacity: 0.7; }
}
.network-background .node:nth-child(1) { top: 20%; left: 25%; animation-delay: 0s; }
.network-background .node:nth-child(2) { top: 40%; left: 60%; animation-delay: 2s; }
.network-background .node:nth-child(3) { top: 70%; left: 35%; animation-delay: 4s; }
.network-background .node:nth-child(4) { top: 60%; left: 80%; animation-delay: 6s; }
.network-background .node:nth-child(5) { top: 30%; left: 10%; animation-delay: 8s; }
</style>

<?php require __DIR__ . '../includes/footer.php'; ?>
