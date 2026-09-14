

<html>
<head>
  <title>Registration</title>
</head>
<body>
<?php
  $FIDGeschlecht = (isset($_POST["FIDGeschlecht"]) && is_string($_POST["FIDGeschlecht"])) ? $_POST["FIDGeschlecht"] : "";
  $Vorname = (isset($_POST["Vorname"]) && is_string($_POST["Vorname"])) ? $_POST["Vorname"] : "";
  $Nachname = (isset($_POST["Nachname"]) && is_string($_POST["Nachname"])) ? $_POST["Nachname"] : "";
  $Email = (isset($_POST["Email"]) && is_string($_POST["Email"])) ? $_POST["Email"] : "";
  $Password = (isset($_POST["Password"]) && is_string($_POST["Password"])) ? $_POST["Password"] : "";
  $PasswordRepeat = (isset($_POST["PasswordRepeat"]) && is_string($_POST["PasswordRepeat"])) ? $_POST["PasswordRepeat"] : "";
  $GebDatum = (isset($_POST["GebDatum"])) && is_string($_POST["GebDatum"]) ? $_POST["GebDatum"] : "";
  
  $ok = false;
  $fehlerfelder = [];
  if (isset($_POST["Submit"])) {
    $ok = true;
    if (!isset($_POST["FIDGeschlecht"]) ||
      !is_string($_POST["FIDGeschlecht"]) ||
      !in_array($_POST["FIDGeschlecht"], ["1", "2", "3"], true)) {
      $ok = false;
      $fehlerfelder[] = "FIDGeschlecht";
    }
    if (!isset($_POST["Vorname"]) ||
      !is_string($_POST["Vorname"]) || 
        trim($_POST["Vorname"]) == "") {
      $ok = false;
      $fehlerfelder[] = "Vorname";
    }
    if (!isset($_POST["Nachname"]) ||
      !is_string($_POST["Nachname"]) || 
        trim($_POST["Nachname"]) == "") {
      $ok = false;
      $fehlerfelder[] = "Nachname";
    }
    if (!isset($_POST["Email"]) ||
        !is_string($_POST["Email"]) ||
        trim($_POST["Email"]) === "" ||
        !filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)
    ) {
      $ok = false;
      $fehlerfelder[] = "E-Mail";
    }
    if (!isset($_POST["Password"]) ||
      !is_string($_POST["Password"]) ||
        $_POST["Password"] === "" ||
        strlen($_POST["Password"]) < 8
    ) {
      $ok = false;
      $fehlerfelder[] = "Passwort (mindestens 8 Zeichen)";
    }
    if (!isset($_POST["PasswordRepeat"]) ||
      !is_string($_POST["PasswordRepeat"]) ||
          $_POST["PasswordRepeat"] === "" ||
        strlen($_POST["PasswordRepeat"]) < 8 
    ) {
      $ok = false;
      $fehlerfelder[] = "Password";
    }
    if (
        !isset($_POST["GebDatum"]) ||
        !is_string($_POST["GebDatum"]) ||
        $_POST["GebDatum"] === ""
    ) {
        $ok = false;
        $fehlerfelder[] = "Geburtsdatum";
    }
    if ($Password !== $PasswordRepeat) {
        $ok = false;
        $fehlerfelder[] = "Passwörter stimmen nicht überein";
    }
    if ($ok) {
?>
<h1>Formulardaten</h1>
<?php
  $Vorname = htmlspecialchars($Vorname);
  $Nachname = htmlspecialchars($Nachname);
  $Email = htmlspecialchars($Email);
  $passwordHash = password_hash($Password, PASSWORD_DEFAULT);
  $GebDatum = htmlspecialchars($GebDatum);

  echo "<b>Vorname:</b> $Vorname<br />";
  echo "<b>Nachname:</b> $Nachname<br />";
  echo "<b>E-Mail:</b> $Email<br />";
  echo "<b>Geburtsdatum:</b> $GebDatum<br />";
  
  
?>
<?php
    } else {
      echo "<p><b>Formular unvollst&auml;ndig</b></p>";
      echo "<ul><li>";
      echo implode("</li><li>", $fehlerfelder);
      echo "</li></ul>";
    }
  } 
  if (!$ok) {
?>
<h1>Registration seite</h1>
<form method="post" action="">

<input type="radio" name="FIDGeschlecht" value="1" <?php if ($FIDGeschlecht === "1") echo "checked"; ?>/>Weiblich<br />
<input type="radio" name="FIDGeschlecht" value="2" <?php if ($FIDGeschlecht === "2") echo "checked"; ?>/>Männlich<br />
<input type="radio" name="FIDGeschlecht" value="3" <?php if ($FIDGeschlecht === "3") echo "checked"; ?>/>Divers<br />
Vorname <input type="text" name="Vorname" value="<?php
  echo htmlspecialchars($Vorname);
?>" required/><br />
Nachname <input type="text" name="Nachname" value="<?php
  echo htmlspecialchars($Nachname);
?>" required/><br />
E-Mail-Adresse <input type="email" name="Email" value="<?php
  echo htmlspecialchars($Email);
?>" required/><br />
Password <input type="password" name="Password" required/><br />
Password wiederholen <input type="password" name="PasswordRepeat" required><br/>
Geburtsdatum <input type="date" name="GebDatum" value="<?php
  echo htmlspecialchars($GebDatum);
?>" required/><br />
<input type="submit" name="Submit" value="Registrieren" />
</form>
<?php
  }
?>
</body>
</html>