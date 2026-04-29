<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(isset($message)) {?>
        <p><?= $message ?></p>

    <?php }?>
    <form action="/eleve/create" method="post">
        <p>Nom : <input type="text" name="nom"></p>
        <p>Prenom : <input type="text" name="prenom"></p>
        <p>matricule : <input type="text" name="matricule"></p>
        <p>Parcours : <input type="text" name="parcours"></p>
        <input type="submit" value="Créer">
    </form>
</body>
</html>