<?php

if(isset($_POST['answer']))
{
    $answer = $_POST['answer'];

    $apiKey = "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";

    $prompt = "
Generate exactly 10 multiple choice questions from the following content.

Format strictly like this:

Q1. Question text
A) Option 1
B) Option 2
C) Option 3
D) Option 4
Answer: A
Explanation: Explanation text

Q2. Question text
A) Option 1
B) Option 2
C) Option 3
D) Option 4
Answer: B
Explanation: Explanation text

Continue this format until Q10.

Do NOT use markdown.
Do NOT use ** symbols.
Do NOT add any extra text before or after the quiz.

Content:
".$answer;

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

    curl_setopt($ch, CURLOPT_URL,
        "https://api.groq.com/openai/v1/chat/completions");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer ".$apiKey
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS,
        json_encode($data));

    $response = curl_exec($ch);

if(curl_errno($ch))
{
    die("cURL Error: " . curl_error($ch));
}

curl_close($ch);

$result = json_decode($response, true);

if(isset($result['choices'][0]['message']['content']))
{
    $quiz = $result['choices'][0]['message']['content'];
}
else
{
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    exit();
}

    echo "<form id='quizForm'>";

    /* Topic Name */
   

$topic = $_POST['topic'] ?? "Quiz";

echo "<input type='hidden'
             name='topic'
             value=\"".htmlspecialchars($topic)."\">";
    $blocks = preg_split('/Q\d+\./', $quiz);
    array_shift($blocks);

    $qno = 1;

    foreach($blocks as $block)
    {
        preg_match(
            '/^(.*?)\nA\)\s*(.*?)\nB\)\s*(.*?)\nC\)\s*(.*?)\nD\)\s*(.*?)\nAnswer:\s*([A-D])\nExplanation:\s*(.*)$/s',
            trim($block),
            $m
        );

        if($m)
        {
            echo "<h3>Q$qno. ".$m[1]."</h3>";

            /* Save Question */
            echo "<input type='hidden'
                         name='question$qno'
                         value=\"".htmlspecialchars($m[1])."\">";

            echo "<input type='radio'
                         name='q$qno'
                         value='A'> A) ".$m[2]."<br>";

            echo "<input type='radio'
                         name='q$qno'
                         value='B'> B) ".$m[3]."<br>";

            echo "<input type='radio'
                         name='q$qno'
                         value='C'> C) ".$m[4]."<br>";

            echo "<input type='radio'
                         name='q$qno'
                         value='D'> D) ".$m[5]."<br><br>";

            echo "<input type='hidden'
                         name='correct$qno'
                         value='".$m[6]."'>";

            echo "<input type='hidden'
                         name='explanation$qno'
                         value=\"".htmlspecialchars($m[7])."\">";
        }

        $qno++;
    }

    echo "<button type='button'
                  onclick='submitQuiz()'>
                  Submit Quiz
          </button>";

    echo "</form>";

    echo "<div id='quizResult'></div>";
}
?>