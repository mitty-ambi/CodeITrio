<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10">
                <h2>Liste des Notes</h2>
                <p><strong><?php echo $eleve['Prenom'] . ' ' . $eleve['Nom']; ?></strong>
                    (<?php echo $eleve['Matricule']; ?>)</p>
                <p><strong>Parcours:</strong> <?php echo $eleve['Parcours']; ?></p>
                <hr>

                <?php foreach ($notesBySemestre as $semestre => $notes): ?>
                    <h4><?php echo $semestre; ?></h4>
                    <table class="table table-striped table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Unité d'Enseignement</th>
                                <th>Matière</th>
                                <th>Crédit</th>
                                <th>Note / 20</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notes as $note): ?>
                                <tr>
                                    <td><?php echo $note['ue_nom'] ?? 'N/A'; ?></td>
                                    <td><?php echo $note['codeMatiere']; ?></td>
                                    <td><?php echo $note['credit']; ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo number_format($note['valeur'], 2); ?>/20</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="table-primary fw-bold">
                                <td colspan="3">Moyenne du semestre</td>
                                <td>
                                    <span class="badge bg-success"><?php echo number_format($moyennesBySemestre[$semestre], 2); ?>/20</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                <?php endforeach; ?>

                <a href="/" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>