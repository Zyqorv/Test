<?php
/*
Expected JSON Response:


{
    "wordId": 42,
    "definition": "The quality of being honest and having strong moral principles.",
    "hints": [
        {
            "type": "Length",
            "value": "9 letters"
        },
        {
            "type": "Part of Speech",
            "value": "Noun"
        },
        {
            "type": "Synonym",
            "value": "Honesty"
        },
        {
            "type": "Syllable Count",
            "value": "4 syllables"
        }
    ]
}


*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreDictio &mdash; Play</title>
    <link rel="stylesheet" href="/css/style.css">
</head>


<body>


<main class="page-stack">


    <div class="tiles" id="tiles" aria-label="PreDictio"></div>


    <p class="tagline">Guess the word from its definition.</p>


    <div class="game-card">


        <div class="definition-label">Definition</div>


        <div class="definition-box" id="definition">
            Loading definition...
        </div>


        <div id="hints-container"></div>


        <div class="input-group">


            <input
                type="text"
                id="guess-input"
                placeholder="Type your guess here..."
            >


            <button
                class="btn btn-primary"
                onclick="checkGuess()">
                Submit
            </button>


        </div>


        <button
            class="btn btn-secondary"
            onclick="revealNextHint()">
            Reveal Next Hint
        </button>


        <button onclick="window.location.href='/account/'" class="btn btn-secondary">Account</button>


        <div id="message"></div>


    </div>


</main>


<script src="/js/tiles.js"></script>


<script>


let currentItem = null;
let currentHintIndex = 0;


async function loadGame() {


    const message = document.getElementById("message");
    const definition = document.getElementById("definition");


    message.innerText = "";
    message.className = "";


    try {


        const response = await fetch("/game/getWord.php");


        if (!response.ok) {
            throw new Error("Server returned an error.");
        }


        currentItem = await response.json();


        if (!currentItem || !currentItem.definition || !currentItem.hints) {
            throw new Error("Invalid game data received.");
        }


        definition.innerText = currentItem.definition;


        document.getElementById("hints-container").innerHTML = "";
        document.getElementById("guess-input").value = "";


        currentHintIndex = 0;


    } catch (error) {


        console.error(error);


        definition.innerText = "Unable to load a word.";


        message.innerText =
            "Error: Unable to load a word. Please try refreshing the page.";


        message.className = "incorrect";
    }
}




function revealNextHint() {
   
    if (!currentItem) {
        return;
    }


    if (currentHintIndex >= currentItem.hints.length) {


        document.getElementById("message").innerText =
            "No more hints available!";


        return;
    }


    const hint = currentItem.hints[currentHintIndex];


    const div = document.createElement("div");


    div.className = "hint-section";


    div.innerHTML = `
        <div class="hint-title">${hint.type}</div>
        <div>${hint.value}</div>
    `;


    document
        .getElementById("hints-container")
        .appendChild(div);


    currentHintIndex++;
}


async function checkGuess() {


    if (!currentItem) {
        return;
    }


    const message = document.getElementById("message");


    try {


        const guess = document
            .getElementById("guess-input")
            .value
            .trim();


        const response = await fetch("/game/checkGuess.php", {


            method: "POST",


            headers: {
                "Content-Type": "application/json"
            },


            body: JSON.stringify({


                wordId: currentItem.wordId,


                guess: guess


            })


        });


        if (!response.ok) {
            throw new Error("Server returned an error.");
        }


        const result = await response.json();


        if (result.correct) {


            message.innerText = "Correct! Loading next word...";
            message.className = "correct";


            setTimeout(loadGame, 1500);


        } else {


            message.innerText = "Incorrect, try again!";
            message.className = "incorrect";


        }


    } catch (error) {


        console.error(error);


        message.innerText =
            "Error: Unable to check guess. Please try again.";


        message.className = "incorrect";


    }


}


window.onload = loadGame;


</script>


</body>
</html>
