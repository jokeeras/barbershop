<?php 

// define variables and set to empty values
$Nume_error = $Email_error = $Telefon_error = "";
$Nume = $Email = $Telefon = $Mesaj = $success = "";

//form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  if (empty($_POST["Nume"])) {
    $Nume_error = "Numele este necesar!";
  } else {
    $Nume = test_input($_POST["Nume"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$Nume)) {
      $Nume_error = "Doar litere si spatiu este permis!"; 
    }
  }

  if (empty($_POST["Email"])) {
    $Email_error = "Email-ul este necesar!";
  } else {
    $Email = test_input($_POST["Email"]);
    // check if e-mail address is well-formed
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
      $Email_error = "Forma invalida de email!"; 
    }
  }
  
  if (empty($_POST["Telefon"])) {
    $Telefon_error = "Numarul de telefon este necesar!";
  } else {
    $Telefon = test_input($_POST["Telefon"]);
    // check if e-mail address is well-formed
    if (!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$Telefon)) {
      $Telefon_error = "Numar de telefon invalid!"; 
    }
  }

  if (empty($_POST["Mesaj"])) {
    $Mesaj = "";
  } else {
    $Mesaj = test_input($_POST["Mesaj"]);
  }
  
  if ($Nume_error == '' and $Email_error == '' and $Telefon_error == ''){
      $message_body = '';
      unset($_POST['submit']);
      foreach ($_POST as $key => $value){
          $message_body .=  "$key: $value\n";
      }
    
      // sending the post to the e-mail // 
      $to = 'jokeeras@yahoo.com';
      $subject = 'Formular de Programare';
      if (mail($to, $subject, $message_body)){
          $success = "Formularul a fost trimis cu succes, in 24h vezi primi un mesaj de confirmare a programari!";
          $Nume = $Email = $Telefon = $Mesaj = '';
      }
  }
    
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}