<?php
    function text_filter($text){
        return trim(filter_var($text, FILTER_SANITIZE_STRING));
    }

    function text_filter_lowercase($text){
        return trim(strtolower(filter_var($text, FILTER_SANITIZE_STRING)));
    }

    function text_filter_uppercase($text){
        return trim(strtoupper(filter_var($text, FILTER_SANITIZE_STRING)));
    }

    function text_filter_encrypt($text){
        return hash('md5', $text);
    }
    function php_alert($text){
      echo "<script>alert('".$text."')</script>";
    }
?>