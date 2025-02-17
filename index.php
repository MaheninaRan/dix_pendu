<?php 
    include('./data.php'); 
    include('./traitement.php'); 
    session_start();

    if(empty($_SESSION['word_to_find'])) {
        $_SESSION['word_to_find'] = getRandomWord($words);
    }

    if(empty($_SESSION['word_find'])) {
        $_SESSION['word_find'] = '';
    }
    
    setWordInput($_GET['word']);
    process();
    //session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendu</title>
    <link rel="stylesheet" href="./index.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="title">
                <h1>Jeux Pendu</h1>
            </div>
            <div class="score">
                <div class="j1">
                    <?php
                        if(empty($_SESSION['scorej1'])) {
                            echo "0";
                        } else{
                            echo $_SESSION['scorej1'];
                        }
                    ?>
                </div> 
                <div class="j2">
                    <?php
                        if(empty($_SESSION['scorej2'])) {
                            echo "0";
                        } else{
                            echo $_SESSION['scorej2'];
                        }
                    ?>
                </div>   
            </div>
            <div class="images">
                <img src="<?php echo $images[$_SESSION['error_count']] ?>" alt="">
            </div>
            <div class="words-container">
                <div class="word-content">
                    <?php for($i=0; $i < strlen($_SESSION['word_to_find']); $i++) { ?>
                    <div class="word">
                        <div class="word-display">
                        <?php for($j=0; $j < strlen($_SESSION['word_find']); $j++) { 
                            if(strtolower($_SESSION['word_to_find'][$i]) == strtolower($_SESSION['word_find'][$j])) {
                                echo $_SESSION['word_find'][$j];
                                break;
                            }    
                        } ?>
                        </div>
                        <div class="underline"></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="input-group-container">
                <form action="" method="get">
                    <div class="input-group">
                        <input 
                            type="text"
                            placeholder="Entrer un mot"
                            name="word"
                            require
                            max=1
                        >
                        <button type="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php 
        if(isFinish() || $_SESSION['error_count'] == 7) {
            finishGame();
            header("Location: index.php");
        }
    ?>
</body>
</html>