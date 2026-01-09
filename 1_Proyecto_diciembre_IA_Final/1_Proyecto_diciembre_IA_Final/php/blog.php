<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Active360</title>
    <link rel="stylesheet" href="../css/blog.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>

<body>
    
    <header>
       <?php require_once 'cabezera.php'; ?>
    </header>

    <main class="blog-main">
        <section class="blog-hero">
            <h1>El Blog de Active360</h1>
            <p>Descobreix els nostres consells, entrenaments i tendències en fitness</p>
        </section>
        <section class="blog-articles">
            <article class="blog-card featured">
                <div class="blog-image-container">
                    <img src="../img/crossfit-workout2.webp" alt="CrossFit entrenament">
                    <span class="category-tag">Fitness</span>
                    <span class="copyright-blog">© Sports Magazine</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">
                        <span class="author">Per Daniel López</span> - 
                        <span class="date">30 de desembre de 2024</span>
                    </div>
                    <h2>CrossFit: Més que un entrenament, un estil de vida</h2>
                    <p>Gaudeix de les millors sessions de Cross training. Les classes es desenvolupen sobre la base d'un circuit d'entrenament d'exercicis a través d’estacions i amb suport music.</p>
                    <a href="../html/entrada_crossfit.php" class="read-more">Continua llegint ></a>
                </div>
            </article>
            <article class="blog-card">
                <div class="blog-image-container">
                    <img src="../img/les-mills.jpg" alt="Les Mills entrenament">
                    <span class="category-tag">Fitness</span>
                    <span class="copyright-blog">© Fitness World</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">Per Sofía Martín - 25 de desembre de 2023</div>
                    <h2>Les Mills</h2>
                    <p>L'entrenament Les Mills va néixer a Nova Zelanda per combatre el sedentarisme de les persones amb aquest "problema". És un sistema basat en classes en grup que canvia les dinàmiques cada trimestre i utilitza la música per estimular l'esforç.</p>
                    <a href="../html/entrada_lesmills.php" class="read-more">Continua llegint ></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image-container">
                    <img src="../img/spinning.jpg" alt="Spinning class">
                    <span class="category-tag">Spinning</span>
                    <span class="copyright-blog">© Health Magazine</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">Per Elena Navarro - 20 de desembre de 2023</div>
                    <h2>Spinning augmenta la vitalitat</h2>
                    <p>Crema de calories: El spinning és una forma d'exercici cardiovascular d'alta intensitat que pot ajudar a cremar calories de manera efectiva.</p>
                    <a href="../html/entrada_spinning.php" class="read-more">Continua llegint ></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image-container">
                    <img src="../img/personal-trainer.jpg" alt="Entrenador personal">
                    <span class="category-tag">Fitness</span>
                    <span class="copyright-blog">© Personal Train</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">Per Lluís Sabater - 15 de desembre de 2023</div>
                    <h2>Un entrenador personal per a tu</h2>
                    <p>Aconsegueix els resultats més ràpidament amb un entrenador personal.</p>
                    <a href="../html/entrada_entrenador.php" class="read-more">Continua llegint ></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image-container">
                    <img src="../img/ioga.webp" alt="Ioga per a principiants">
                    <span class="category-tag">Fitness</span>
                    <span class="copyright-blog">© Wellness Journal</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">Per Ana Spiteri - 10 de desembre de 2023</div>
                    <h2>Ioga per a principiants: començant el teu viatge</h2>
                    <p>Si estàs pensant en iniciar-te en la pràctica del ioga, aquest article és per a tu. Comprèn els conceptes bàsics, els beneficis i algunes postures fàcils per començar, proporciona una introducció amigable a aquesta pràctica mil·lenària.</p>
                    <a href="../html/entrada_ioga.php" class="read-more">Continua llegint ></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image-container">
                    <img src="../img/pilates.png" alt="Pilates exercici">
                    <span class="category-tag">Pilates</span>
                    <span class="copyright-blog">© Body & Mind</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">Per Carla Pérez - 5 de desembre de 2023</div>
                    <h2>El poder de Pilates</h2>
                    <p>Pilates és un exercici de baix impacte que se centra en la força central, la respiració adequada i els moviments controlats. Va ser creat per primera vegada per Joseph Pilates el 1923 i el programa d'exercicis té com a objectiu millorar.</p>
                    <a href="../html/entrada_pilates.php" class="read-more">Continua llegint ></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image-container">
                    <img src="../img/bodypump.jpg" alt="Bodypump class">
                    <span class="category-tag">Body Pump</span>
                    <span class="copyright-blog">© Gym Life</span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">Per Jordi Llopis - 30 de novembre de 2023</div>
                    <h2>Iniciat al Bodypumps</h2>
                    <p>És la classe original de barra i discs que tonifica tot el cos. En una sessió de Bodypump treballes els principals grups musculars utilitzant els millors exercicis de la sala de fitness, com per exemple squats, elevacions i curls.</p>
                    <a href="../html/entrada_bodypump.php" class="read-more">Continua llegint ></a>
                </div>
            </article>
        </section>
    </main>
</body>
</html>
