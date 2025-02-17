<?php
include('./data.php'); 
session_start();

function finishGame() {
    $all_size = strlen($_SESSION['word_to_find']);
    $find_size = strlen($_SESSION['word_find']);
    $score = $find_size . '/' . $all_size;

    $score_j1;
    $score_j2;

    if(isset($_SESSION['scorej1'])) {
        $score_j1 = $_SESSION['scorej1'];
    } else {
        $score_j1 = $score;
    }

    if(isset($_SESSION['scorej2'])) {
        $score_j2 = $_SESSION['scorej2'];
    } else if(empty($_SESSION['scorej2']) && isset($_SESSION['scorej1'])){
        $score_j2 = $score;    
    }

    session_destroy();
    session_start();

    $_SESSION['scorej1'] = $score_j1;
    $_SESSION['scorej2'] = $score_j2;  


    $_SESSION['word_to_find'] = getRandomWord(find_words($size));
    $_SESSION['error_count'] = 0;
    $_SESSION['word_find'] = '';
}

function find_words($size){
    global $words;
    $new_words = [];
    for ($i=0; $i < count($words); $i++) { 
       if (strlen($words[$i]==$size)) {
        array_push($new_words,$words[$i]);
       }
    }
    return $new_words;
}

function isFinish() {
    $to_find = strtolower($_SESSION['word_to_find']);        
    $find = strtolower($_SESSION['word_find']);

    if(empty($find)) {
        return false;
    }

    for ($i=0; $i < strlen($to_find); $i++) {
        $match = false;
        for ($j=0; $j < strlen($find); $j++) { 
            if(strtolower($find[$i]) == strtolower($to_find[$j])) {
                $match = true;
                break;
            }    
        }
        if($match == false) {
            return false;
        }
    }
    return true;
}

function process() {
    $word_to_find = $_SESSION['word_to_find'];
    $word_input = $_SESSION['word_input'];

    $word_find = '';

    for($i = 0; $i < strlen($word_to_find); $i++) {
        for($j = 0; $j < strlen($word_input); $j++) {
            if(strtolower($word_input[$j]) == strtolower($word_to_find[$i])) {
                $word_find .= strtoupper($word_input[$j]);
                break;
            }
        }
    }
    $_SESSION['word_find'] = $word_find;
    $_SESSION['error_count'] = calcError($word_to_find, $word_input);
}

function calcError($to_find, $input) {
    $error = 0;
    for($i = 0; $i < strlen($input); $i++) {
        $match = false; 
        for($j=0; $j < strlen($to_find); $j++) {
            if(strtolower($input[$i]) == strtolower($to_find[$j])) {
                $match = true;
                break;
            }    
        }
        if($match == false) {
            $error++;
        }
    }
    return $error;
}



function setWordInput($letter_input) {
    if (!isset($_SESSION['word_input'])) {
        $_SESSION['word_input'] = '';
    }

    if($letter_input && strpos($_SESSION['word_input'], $letter_input) === false) {
        $_SESSION['word_input'] .= strtolower($letter_input);
    }    
    
    return $_SESSION['word_input'];
}

function getRandomWord($words) { 
    return $words[rand(0, count($words) - 1)];
}
