<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SysInfo - Modification eleve</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>

<?php $eleveId = $eleve['id'] ?? ($eleve['Id'] ?? null); ?>

<div class="app">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div>
                <div class="brand-name">SysInfo</div>
                <div class="brand-sub">v2.4.0</div>
            </div>
        </div>

        <div class="sidebar-section">Navigation</div>
        <a href="/" class="nav-item">Accueil</a>
        <a href="/eleve/create" class="nav-item">Creation eleve</a>
        <a href="/eleve/update/<?= $eleveId ?>" class="nav-item active">Modification eleve</a>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title">Gestion des eleves</div>
        </div>

        <div class="content">
            <div class="page-header">
                <div>
                    <h2>Modification d'un eleve</h2>
                    <div class="breadcrumb">Accueil / <span>Eleves</span> / Modification</div>
                </div>
            </div>

            <?php if (isset($message) && $message !== ''): ?>
                <div class="alert alert-info">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                    <span><?= esc($message) ?></span>
                </div>
            <?php endif; ?>

            <form action="/eleve/update/<?= $eleveId ?>" method="post">
                <div class="form-card section-gap">
                    <div class="form-section-title">Informations eleve</div>

                    <div class="form-grid">
                        <div>
                            <label class="field-label">Nom <span class="required">*</span></label>
                            <input type="text" name="nom" value="<?= esc(old('nom', $eleve['Nom'])) ?>" required>
                        </div>
                        <div>
                            <label class="field-label">Prenom <span class="required">*</span></label>
                            <input type="text" name="prenom" value="<?= esc(old('prenom', $eleve['Prenom'])) ?>" required>
                        </div>
                        <div>
                            <label class="field-label">Matricule <span class="required">*</span></label>
                            <input type="text" name="matricule" value="<?= esc(old('matricule', $eleve['Matricule'])) ?>" required>
                        </div>
                        <div>
                            <label class="field-label">Parcours <span class="required">*</span></label>
                            <input type="text" name="parcours" value="<?= esc(old('parcours', $eleve['Parcours'])) ?>" required>
                        </div>
                    </div>

                    <div class="form-footer">
                        <a href="/eleve/create" class="btn btn-secondary">Retour</a>
                        <button type="submit" class="btn btn-primary">Mettre a jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>