<?php
include('./data.php'); 
session_start();

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

function getRandomWord() {
    global $words;
    $randomIndex = array_rand($words);
    return $words[$randomIndex];
}