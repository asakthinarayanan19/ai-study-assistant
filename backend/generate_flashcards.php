<?php
include "config.php";

if (isset($_POST['topic'])) {

    $topic = trim($_POST['topic']);

    if ($topic == "") {
        echo "Please enter a topic.";
        exit();
    }

    $apiKey = "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";

    $prompt = "
Generate exactly 10 flashcards about the topic below.

Format strictly like this:

Question: Question text
Answer: Answer text

Question: Question text
Answer: Answer text

Continue until 10 flashcards.

Do NOT use markdown.
Do NOT add numbering.
Do NOT add extra explanations.

Topic:
" . $topic;

    $data = [
        "model" => "llama-3.3-70b-versatile",
        "messages" => [
            [
                "role" => "user",
                "content" => $prompt
            ]
        ]
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.groq.com/openai/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        exit();
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!isset($result['choices'][0]['message']['content'])) {
        echo "Failed to generate flashcards.";
        exit();
    }

    $flashcards = $result['choices'][0]['message']['content'];

    preg_match_all(
        '/Question:\s*(.*?)\nAnswer:\s*(.*?)(?=\nQuestion:|$)/s',
        $flashcards,
        $matches,
        PREG_SET_ORDER
    );

    if (count($matches) == 0) {
        echo "No flashcards generated.";
        exit();
    }

    echo "<div id='battle-container'>";

    foreach ($matches as $index => $card) {

        $question = trim($card[1]);
        $answer = trim($card[2]);

        mysqli_query(
            $conn,
            "INSERT INTO flashcards(topic,question,answer)
             VALUES(
                '" . mysqli_real_escape_string($conn, $topic) . "',
                '" . mysqli_real_escape_string($conn, $question) . "',
                '" . mysqli_real_escape_string($conn, $answer) . "'
             )"
        );

        echo "
        <div class='flashcard' data-answer='" . htmlspecialchars($answer, ENT_QUOTES) . "'>

            <h3>" . htmlspecialchars($question) . "</h3>

            <input type='text' class='userAnswer' placeholder='Your answer'>

            <br><br>

            <button onclick='checkAnswer(this)'>
                Check Answer
            </button>

            <div class='result'></div>

        </div>
        ";
    }

    echo "</div>";

    echo "
    <div style='margin-top:20px;'>
        <h3>XP: <span id='xp'>0</span></h3>
        <h3>🔥 Combo: <span id='combo'>0</span></h3>
    </div>
    ";
}
?>