<?php
if (!isset($_SESSION['user'])) {
    header("Location: pages/signIn.php");
    exit;
}
?>

<section class="cards">
    <div class="card">
        <div>
            <h3>Consultations Aujourd'hui</h3>
            <p class="card-value">12</p>
            <span>Produits consultés</span>
        </div>
        <div class="image-container">
            <img src="../asets/eye.svg" alt="eye icon" />
        </div>
    </div>
    <div class="card">
        <div>
            <h3>Ventes du Mois</h3>
            <p class="card-value">24</p>
            <span>Articles vendus</span>
        </div>
        <div class="image-container">
            <img src="../asets/arrow.svg" alt="arrow icon" />
        </div>
    </div>
    <div class="card">
        <div>
            <h3>Rapports Générés</h3>
            <p class="card-value">3</p>
            <span>Rapports consultés</span>
        </div>
        <div class="image-container">
            <img src="../asets/file.svg" alt="file icon" />
        </div>
    </div>
    <div class="card">
        <div>
            <h3>Alertes Stock</h3>
            <p class="card-value">3</p>
            <span>Produits en rupture</span>
        </div>
        <div class="image-container">
            <img src="../asets/alert.svg" alt="alert icon" />
        </div>
    </div>
</section>