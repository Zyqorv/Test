<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Play</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main class="page-stack">

        <div class="tiles" id="tiles" aria-label="PreDictio"></div>

        <p class="tagline">Guess the word from its definition.</p>

        <div class="game-card">
            <div class="definition-label">Definition</div>
            <div class="definition-box" id="definition">Loading definition...</div>

            <div id="hints-container">
                <!-- Hints will be revealed here sequentially -->
            </div>

            <div class="input-group">
                <input type="text" id="guess-input" placeholder="Type your guess here...">
                <button class="btn btn-primary" onclick="checkGuess()">Submit</button>
            </div>

            <button class="btn btn-secondary" onclick="revealNextHint()">Reveal Next Hint</button>

            <div id="message"></div>
        </div>

    </main>

    <script src="js/tiles.js"></script>
    <script>
        // Local dummy dataset mimicking what the API/DB would eventually return
        const localWords = [
            {
                word: "apple",
                definition: "A round fruit with red, green, or yellow skin and crisp white flesh.",
                hints: [
                    { type: "Length", value: "5 letters" },
                    { type: "Part of Speech", value: "Noun" },
                    { type: "Synonym", value: "Pome" },
                    { type: "Rhyme", value: "Chapel" }
                ]
            },
            {
                word: "courage",
                definition: "The ability to do something that frightens one; bravery.",
                hints: [
                    { type: "Length", value: "7 letters" },
                    { type: "Part of Speech", value: "Noun" },
                    { type: "Antonym", value: "Cowardice" },
                    { type: "Synonym", value: "Valor" }
                ]
            }
        ];

        let currentIndex = 0;
        let currentHintIndex = 0;

        function loadGame() {
            const currentItem = localWords[currentIndex];
            document.getElementById('definition').innerText = currentItem.definition;
            document.getElementById('hints-container').innerHTML = '';
            document.getElementById('guess-input').value = '';
            const messageEl = document.getElementById('message');
            messageEl.innerText = '';
            messageEl.className = '';
            currentHintIndex = 0;
        }

        function revealNextHint() {
            const currentItem = localWords[currentIndex];
            if (currentHintIndex < currentItem.hints.length) {
                const hint = currentItem.hints[currentHintIndex];
                const container = document.getElementById('hints-container');

                const hintDiv = document.createElement('div');
                hintDiv.className = 'hint-section';
                hintDiv.innerHTML = `<div class="hint-title">${hint.type}</div><div>${hint.value}</div>`;

                container.appendChild(hintDiv);
                currentHintIndex++;
            } else {
                const messageEl = document.getElementById('message');
                messageEl.innerText = "No more hints available!";
                messageEl.className = "incorrect";
            }
        }

        function checkGuess() {
            const userGuess = document.getElementById('guess-input').value.trim().toLowerCase();
            const correctWord = localWords[currentIndex].word.toLowerCase();
            const messageEl = document.getElementById('message');

            if (userGuess === correctWord) {
                messageEl.innerText = "Correct! Moving to next word...";
                messageEl.className = "correct";

                // Move to next word after a brief delay
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % localWords.length;
                    loadGame();
                }, 2000);
            } else {
                messageEl.innerText = "Incorrect, try again!";
                messageEl.className = "incorrect";
            }
        }

        // Initialize the first round
        window.onload = loadGame;
    </script>

</body>
</html>