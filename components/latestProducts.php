<?php
if (!isset($_SESSION['user'])) {
    header("Location: pages/signIn.php");
    exit;
}
?>

<section class="produit-consulter recent-products">
        <div>
          <img src="../asets/eye.svg" alt="eye box" />
          <h2>Consultés Récemment</h2>
        </div>
        <ul class="product-list">
          <li>
            <div>
              <strong>Produit8</strong>
              <p>test60 Prénomtest60</p>
              <span class="price">45,25 €</span>
            </div>
            <div class="stock">
              <span>Il y a 15min</span>
              <small class="good">Stock: 06</small>
            </div>
          </li>
          <li>
            <div>
              <strong>Produit7</strong>
              <p>Lampion Robert</p>
              <span class="price">245,50 €</span>
            </div>
            <div class="stock">
              <span>Il y a 15min</span>
              <small class="low">Stock: 04</small>
            </div>
          </li>
          <li>
            <div>
              <strong>Produit6</strong>
              <p>Dalia Rosa François</p>
              <span class="price">150,25 €</span>
            </div>
            <div class="stock">
              <span>Il y a 15min</span>
              <small class="low">Stock: 02</small>
            </div>
          </li>
        </ul>
      </section>
