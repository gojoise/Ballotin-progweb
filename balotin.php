<!DOCTYPE html>
<html>
<head>
  <title>Balotin</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <style type="text/css">
    body{
  
  height: 100%;
  background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(0,255,239,1) 100%);
    
} 
  </style>
<div class= "box">
  <h1> L3 Informatique </h1>
  <form action="balotin" method="post">
    <div>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="user_name">
    </div>
    <div>
        <label for="mail">e-mail :</label>
        <input type="email" id="mail" name="user_mail">
    </div>
    <div>
        <label for="password">Mot-de-passe :</label>
        <input type="password" id="pass" name="password"
           minlength="8" required>
    </div>
    <div class="button">
        <button type="submit">Connecter-vous</button>
    </div>
</form>
  
</div>

</body>
</html>