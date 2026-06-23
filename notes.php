<?php
include "backend/config.php";

/* Display Selected Note */
$selected_note = null;

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    $note_result = mysqli_query(
        $conn,
        "SELECT * FROM notes
         WHERE id = $id"
    );

    if(mysqli_num_rows($note_result) > 0)
    {
        $selected_note = mysqli_fetch_assoc($note_result);
    }
}

/* Fetch All Notes */
$result = mysqli_query(
    $conn,
    "SELECT * FROM notes
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Notes</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f4f6f9;
            padding:30px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .header{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            margin-bottom:30px;
        }

        .header h1{
            margin-bottom:10px;
        }

        .back-btn{
            display:inline-block;
            background:orangered;
            color:white;
            text-decoration:none;
            padding:12px 20px;
            border-radius:12px;
            margin-top:15px;
        }

        .back-btn:hover{
            opacity:0.9;
        }

        .form-box{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            margin-bottom:30px;
        }

        input[type=text]{
            width:100%;
            padding:15px;
            border:1px solid #ddd;
            border-radius:10px;
            margin-bottom:20px;
        }

        textarea{
            width:100%;
            padding:15px;
            border:1px solid #ddd;
            border-radius:10px;
            resize:none;
            margin-bottom:20px;
        }

        button{
            background:orangered;
            color:white;
            border:none;
            padding:12px 25px;
            border-radius:12px;
            cursor:pointer;
            font-size:16px;
        }

        button:hover{
            opacity:0.9;
        }

        .notes-title{
            margin-bottom:20px;
        }

        .note-card{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            margin-bottom:20px;
        }

        .note-card h3{
            margin-bottom:15px;
            color:orangered;
        }

        .note-card p,
.selected-note p{
    font-size:18px;
    line-height:1.8;
    color:#333;
    white-space:normal;
    text-align:justify;
}

        .note-card strong,
        .selected-note strong{
            color:orangered;
            font-weight:bold;
        }

        .date{
            color:gray;
            margin-top:15px;
            font-size:14px;
        }

        .view-btn{
            display:inline-block;
            background:orangered;
            color:white;
            text-decoration:none;
            padding:10px 18px;
            border-radius:10px;
            margin-top:15px;
            font-size:14px;
            font-weight:bold;
        }

        .view-btn:hover{
            opacity:0.9;
        }

        .selected-note{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            margin-top:20px;
            margin-bottom:20px;
        }

        .selected-note h2{
            color:orangered;
            margin-bottom:20px;
        }

    </style>

</head>

<body>

<div class="container">
        <div class="header">

        <h1>📝 Notes</h1>

        <p>
            Create and manage your study notes.
        </p>

        <a href="dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

        <?php
        if($selected_note)
        {
        ?>

            <div class="selected-note">

                <h2>
                    <?php
                    echo htmlspecialchars(
                        $selected_note['title']
                    );
                    ?>
                </h2>

                <hr style="
                    margin:15px 0;
                    border:1px solid #eee;
                ">

                <p>

                    <?php

                    $content = $selected_note['content'];

/* Convert HTML breaks */
$content = str_replace(
    array("<br>", "<br/>", "<br />"),
    "\n",
    $content
);

/* Remove separator lines */
$content = preg_replace('/={3,}/', '', $content);
$content = preg_replace('/-{3,}/', '', $content);

/* Remove multiple blank lines */
$content = preg_replace("/\n\s*\n\s*\n+/", "\n\n", $content);

/* Convert **Heading** to bold */
$content = preg_replace(
    '/\*\*(.*?)\*\*/',
    '<strong>$1</strong>',
    $content
);

echo nl2br(trim($content));

                    ?>

                </p>

            </div>

        <?php
        }
        ?>

    </div>

    <div class="form-box">

        <form
            action="backend/add_note.php"
            method="POST"
        >

            <input
                type="text"
                name="title"
                placeholder="Enter Note Title"
                required
            >

            <textarea
                name="content"
                rows="6"
                placeholder="Write your notes here..."
                required
            ></textarea>

            <button
                type="submit"
                name="save"
            >
                Save Note
            </button>

        </form>

    </div>

    <h2 class="notes-title">
        📚 Saved Notes
    </h2>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>

    <div class="note-card">

        <h3>
            <?php
            echo htmlspecialchars(
                $row['title']
            );
            ?>
        </h3>

        <p>

            <?php

            /* Note Preview */

            $preview = $row['content'];

            if(strlen($preview) > 150)
            {
                $preview = substr(
                    $preview,
                    0,
                    150
                ) . "...";
            }

            /* Remove visible <br> tags */

            $preview = str_replace(
                array(
                    "<br>",
                    "<br/>",
                    "<br />"
                ),
                " ",
                $preview
            );

            /* Remove ** symbols */

            $preview = preg_replace(
                '/\*\*(.*?)\*\*/',
                '$1',
                $preview
            );

            echo htmlspecialchars($preview);

            ?>

        </p>

        <?php
        if(strlen($row['content']) > 150)
        {
        ?>

            <a
                href="notes.php?id=<?php echo $row['id']; ?>"
                class="view-btn"
            >
                View More
            </a>

        <?php
        }
        ?>

        <div class="date">

            Saved on:
            <?php echo $row['created_at']; ?>

        </div>

    </div>

<?php } ?>

</div>

</body>
</html>