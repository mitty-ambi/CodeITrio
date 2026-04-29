<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>liste des eleves </title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Liste des élèves</h1>
    <?php $eleves = $eleves ?? []; ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Matricule</th>
            <th>Parcours</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($eleves as $eleve): ?>
        <?php /** @var array<string, mixed> $eleve */ ?>
        <tr>
            <td><?= $eleve['id'] ?></td>
            <td><?= esc((string) ($eleve['Nom'] ?? '')) ?></td>
            <td><?= esc((string) ($eleve['Prenom'] ?? '')) ?></td>
            <td><?= esc((string) ($eleve['Matricule'] ?? '')) ?></td>
            <td><?= esc((string) ($eleve['Parcours'] ?? '')) ?></td>
            <td>
                <a href="/eleve/update/<?= $eleve['id'] ?>">Modifier</a>
                <form action="/eleve/delete/<?= $eleve['id'] ?>" method="post" style="display:inline;">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>    

</body>
</html>