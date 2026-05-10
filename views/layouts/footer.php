<?php
$user    = $_SESSION['user'] ?? null;
$ctrl    = $_GET['controller'] ?? 'home';
$action  = $_GET['action'] ?? 'index';

$hasSidebar = ($user !== null);
$isHero     = (!$user && $ctrl === 'home' && $action === 'index');
?>

<?php if ($hasSidebar): ?>
    </main><!-- /.app-main -->
</div><!-- /.app-layout -->

<div style="background:var(--dark);color:rgba(255,255,255,.4);text-align:center;font-size:.75rem;padding:.75rem;">
    &copy; <?= date('Y') ?> Covoit TN — élaboré par Abir Dorai — L2BI 
</div>

<?php elseif ($isHero): ?>
</main>

<!-- SECTION POURQUOI CHOISIR -->
<section class="section" style="background:linear-gradient(135deg,#1e293b,#0f172a);color:white;padding:4rem 1rem;"> 
  <div class="container">
    
    <h2 style="text-align:center;font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;margin-bottom:2.5rem">
      Pourquoi choisir <span style="color:#22c55e">CovoitTN</span> ?
    </h2>

    <div class="grid-3">

      <div class="card-why">
        <div class="icon">💰</div>
        <h3>Économique</h3>
        <p>Partagez les frais de trajet et économisez jusqu'à 70% sur vos voyages.</p>
      </div>

      <div class="card-why">
        <div class="icon">🌱</div>
        <h3>Écologique</h3>
        <p>Réduisez votre empreinte carbone en partageant les trajets.</p>
      </div>

      <div class="card-why">
        <div class="icon">🤝</div>
        <h3>Convivial</h3>
        <p>Rencontrez de nouvelles personnes et voyagez en bonne compagnie.</p>
      </div>

    </div>
  </div>
</section>

<footer class="site-footer">
    &copy; <?= date('Y') ?> <strong style="color:#fff">Covoit TN</strong> —
    La plateforme de covoiturage tunisienne — élaboré par Abir Dorai — L2BI 
</footer>

<?php else: ?>
</div><!-- /.page-container -->
</main>

<footer class="site-footer">
    &copy; <?= date('Y') ?> <strong style="color:#fff">Covoit TN</strong> —
    La plateforme de covoiturage tunisienne — ESEN, Université de la Manouba
</footer>
<?php endif; ?>

<!-- CSS -->
<style>
.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}

.card-why {
  background: rgba(255,255,255,0.05);
  padding: 2rem;
  border-radius: 15px;
  text-align: center;
  transition: 0.3s;
}

.card-why:hover {
  transform: translateY(-8px);
  background: rgba(255,255,255,0.1);
}

.icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.card-why p {
  opacity: 0.7;
  font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 768px) {
  .grid-3 {
    grid-template-columns: 1fr;
  }
}
</style>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>