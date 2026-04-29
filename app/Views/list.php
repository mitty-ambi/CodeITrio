<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Liste des eleves</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">Notes</div>
        <div class="brand-sub">Gestion eleves</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>
    <a href="/eleves" class="nav-item active">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Eleves
    </a>
    <a href="/eleve/create" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Creation eleve
    </a>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Liste des eleves</div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Eleves</h2>
          <div class="breadcrumb">Accueil / <span>Eleves</span></div>
        </div>
        <a href="/eleve/create" class="btn btn-primary btn-sm">Nouvel eleve</a>
      </div>

      <?php if (!empty($message)): ?>
        <div class="alert alert-info" style="margin-bottom: 16px;"><?= esc($message) ?></div>
      <?php endif; ?>

      <div class="toolbar">
        <form method="get" action="/eleves" class="toolbar-left" style="width:100%;display:flex;gap:12px;">
          <div class="search-box" style="max-width:420px;">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" value="<?= esc($q ?? '') ?>" placeholder="Rechercher par nom, prenom, matricule, parcours" />
          </div>
          <button type="submit" class="btn btn-secondary btn-sm">Rechercher</button>
          <a href="/eleves" class="btn btn-ghost btn-sm">Reinitialiser</a>
        </form>
      </div>

      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Matricule</th>
              <th>Nom</th>
              <th>Prenom</th>
              <th>Parcours</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($eleves)): ?>
              <?php foreach ($eleves as $eleve): ?>
                <?php $id = $eleve['id'] ?? ($eleve['Id'] ?? null); ?>
                <tr>
                  <td><?= esc((string) $id) ?></td>
                  <td><?= esc($eleve['Matricule'] ?? '') ?></td>
                  <td><?= esc($eleve['Nom'] ?? '') ?></td>
                  <td><?= esc($eleve['Prenom'] ?? '') ?></td>
                  <td><?= esc($eleve['Parcours'] ?? '') ?></td>
                  <td>
                    <div class="td-actions" style="display:flex;gap:8px;align-items:center;">
                      <a href="/eleve/update/<?= esc((string) $id) ?>" class="btn btn-secondary btn-sm">Modifier</a>
                      <form action="/eleve/delete/<?= esc((string) $id) ?>" method="post" onsubmit="return confirm('Supprimer cet eleve ?');" style="margin:0;">
                        <button type="submit" class="btn btn-ghost btn-sm" style="color:#b42318;">Supprimer</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" style="text-align:center;color:#667085;">Aucun eleve trouve.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
