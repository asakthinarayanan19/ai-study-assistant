<?php

if(isset($_POST['answer']))
{
    $answer = $_POST['answer'];

    /* Groq API Key */
    $apiKey = "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";

    $prompt = "
Generate a study knowledge map from the following content.

Rules:
- Use tree format.
- Maximum 3 levels.
- Important concepts only.

Example:

C Programming
├── Variables
├── Functions
├── Arrays
│   └── Strings
└── Pointers

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

    curl_setopt(
        $ch,
        CURLOPT_URL,
        "https://api.groq.com/openai/v1/chat/completions"
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
            "Content-Type: application/json",
            "Authorization: Bearer ".$apiKey
        ]
    );

    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        json_encode($data)
    );

    $response = curl_exec($ch);

    if(curl_errno($ch))
    {
        die("cURL Error: ".curl_error($ch));
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if(isset($result['choices'][0]['message']['content']))
    {
        $map = $result['choices'][0]['message']['content'];

        echo "
        <div style='
            background:white;
            padding:20px;
            border-radius:20px;
            margin-top:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        '>

            <h2>🗺️ AI Knowledge Map</h2>

            <pre style='
                white-space:pre-wrap;
                font-size:16px;
                line-height:1.8;
            '>$map</pre>

        </div>
        ";
    }
    else
    {
        echo "Failed to generate knowledge map.";
    }
}
?>