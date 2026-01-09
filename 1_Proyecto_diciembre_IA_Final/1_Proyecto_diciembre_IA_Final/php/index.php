<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Active360 - Aconsegueix la teva millor forma física</title>
  <!-- index.php está dentro de /php, así que salimos una carpeta para ir a /css -->
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <header>
       <?php require_once 'cabezera.php'; ?>
    </header>

  <!-- HERO -->
  <section class="hero">
    <!-- imagen en /img -->
    <img src="../img/main6.jpg" alt="Entrenament Actiu" class="hero-img">
    <div class="hero-overlay">
      <h1>Active360: Aconsegueix la teva millor forma física</h1>
    </div>
  </section>

  <!-- WHY + NEWSLETTER -->
  <section class="why-newsletter">
    <article class="why-active">
      <h2>Per què Active360?</h2>
      <p>A Active360, combinem l'experiència en fitness amb un enfocament personalitzat per ajudar-te a assolir els teus objectius de salut i benestar.</p>
      <div class="features">
        <div class="feature-card">
          <img src="../img/workout.png" alt="Icona Entrenament" class="feature-icon-img">
          <h3>Entrenament Personalitzat</h3>
          <p>Programes dissenyats exclusivament per a tu.</p>
        </div>
        <div class="feature-card">
          <img src="../img/nutrition.png" alt="Icona Nutrició" class="feature-icon-img">
          <h3>Nutrició i Benestar</h3>
          <p>Consells pràctics per a una vida equilibrada.</p>
        </div>
        <div class="feature-card">
          <img src="../img/progression.png" alt="Icona Ioga" class="feature-icon-img">
          <h3>Flexibilitat i Ioga</h3>
          <p>Millora la teva mobilitat i redueix l’estrès.</p>
        </div>
      </div>
    </article>
    
    
  </section>

  <!-- ACTIVITIES -->
  <section class="activities">
    <article class="activity">
      <img src="../img/home-bloc5.jpg" alt="Activitats dirigides">
      <div class="activity-content">
        <h2>Activitats dirigides</h2>
        <p>Classes variades per a totes les edats i nivells, amb monitoratge professional que et guia en cada pas.</p>
        <p>Des de sessions de tonificació fins a entrenaments cardiovasculars, trobaràs l’activitat que millor s’adapta al teu estil de vida.</p>
        <span class="copyright">© Fit Magazine, 2024</span>
        <a href="../html/dirigides_landing.php" class="btn-more">Més informació</a>
      </div>
    </article>

    <article class="activity">
      <img src="../img/home-bloc2.jpg" alt="Benestar mental">
      <div class="activity-content">
        <h2>Benestar mental</h2>
        <p>Programes que combinen exercici físic amb tècniques de relaxació i mindfulness.</p>
        <p>El nostre objectiu és ajudar-te a aconseguir equilibri emocional i reduir l’estrès del dia a dia.</p>
        <span class="copyright">© Mindful Life, 2024</span>
        <a href="../html/benestar_landing.php" class="btn-more">Més informació</a>
      </div>
    </article>

    <article class="activity">
      <img src="../img/home-bloc0.jpg" alt="Exercici i activitat física">
      <div class="activity-content">
        <h2>Exercici i activitat física</h2>
        <p>L’activitat física regular és clau per mantenir la salut del cor i la força muscular.</p>
        <p>Amb rutines variades i adaptables, promovem un estil de vida actiu i saludable per a tothom.</p>
        <span class="copyright">© Revista Salut, 2024</span>
        <a href="../html/exercici_landing.php" class="btn-more">Més informació</a>
      </div>
    </article>

    <article class="activity">
      <img src="../img/crossfit-workout.jpg" alt="CrossFit">
      <div class="activity-content">
        <h2>CrossFit, un estil de vida</h2>
        <p>Sessions d’alta intensitat que treballen força, resistència i agilitat.</p>
        <p>El CrossFit no és només entrenament, és un estil de vida que et desafia i et fa superar-te dia a dia.</p>
        <span class="copyright">© Sports Illustrated, 2024</span>
        <!-- si entrada.php está en /php, sería "entrada.php"; si está fuera, "../entrada.php" -->
        <a href="../html/crossfit_landing.php" class="btn-more">Més informació</a>
      </div>
    </article>
  </section>

</body>
</html>