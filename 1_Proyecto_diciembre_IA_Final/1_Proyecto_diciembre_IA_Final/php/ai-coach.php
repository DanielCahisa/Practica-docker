<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Coach - Active360</title>
    <link rel="stylesheet" href="../css/ai-coach.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <header>
       <?php require_once 'cabezera.php'; ?>
    </header>

    <main class="ai-coach-main">
        <section class="ai-hero">
            <h1>Active360 AI Coach: El teu Entrenador Personal Intel·ligent</h1>
            <p>Pregunta qualsevol cosa sobre nutrició, rutines d'entrenament, recuperació o suplements. La IA està limitada estrictament a temes de fitness i benestar.</p>
        </section>

        <div class="chat-wrapper">
            
            <div class="coming-soon-overlay">
                <div class="coming-soon-content">
                    <span class="coming-soon-icon">🚧</span> <h2 class="coming-soon-title">Estem treballant en això</h2>
                    <p class="coming-soon-text">
                        La nostra Intel·ligència Artificial està entrenant al gimnàs per oferir-te el millor servei.<br><br>
                        <strong>Disponible molt aviat.</strong>
                    </p>
                </div>
            </div>

            <section class="chat-interface-container chat-blurred">
                <div class="chat-history" id="chat-history">
                    <div class="chat-message ai-response">
                        <p>Hola! Sóc l'AI Coach d'Active360. Estic preparat/ada per ajudar-te a assolir els teus objectius de fitness. Comencem?</p>
                    </div>
                    <div class="chat-message user-message">
                        <p>Vull una rutina d'esquena per guanyar massa muscular.</p>
                    </div>
                    <div class="chat-message ai-response">
                        <p>Analitzant la teva petició...</p>
                    </div>
                </div>

                <form id="chat-form" class="chat-input-form">
                    <textarea id="user-input" placeholder="Escriu la teva pregunta..." rows="3" disabled></textarea>
                    <button type="submit" class="btn-send" disabled>Enviar</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>