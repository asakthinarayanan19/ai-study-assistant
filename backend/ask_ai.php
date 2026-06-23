<?php

include "config.php";

if(isset($_POST['question']))
{
    $question = $_POST['question'];

    $apiKey = "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";

    $data = [
        "model" => "llama-3.3-70b-versatile",
        "messages" => [
            [
                "role" => "user",
                "content" => $question
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
            "Authorization: Bearer " . $apiKey
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
        echo "cURL Error: " . curl_error($ch);
        curl_close($ch);
        exit();
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if(isset($result['choices'][0]['message']['content']))
    {
        $ai_response =
            $result['choices'][0]['message']['content'];

        /* Save chat history */
        $savedQuestion = mysqli_real_escape_string(
            $conn,
            $question
        );

        $savedAnswer = mysqli_real_escape_string(
            $conn,
            $ai_response
        );

        mysqli_query(
            $conn,
            "INSERT INTO chat_history(question,answer)
             VALUES('$savedQuestion','$savedAnswer')"
        );

        echo nl2br($ai_response);
    }
    else
    {
        echo "Failed to get AI response.";
    }
}
?>