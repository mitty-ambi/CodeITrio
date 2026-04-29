<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tableau de bord</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
<?php
$metrics = $metrics ?? [];
$totalEleves = (int) ($metrics['total_eleves'] ?? 0);
$tauxReussite = (float) ($metrics['taux_reussite'] ?? 0);
$moyennesSemestre = $metrics['moyenne_par_semestre'] ?? [];
$moyennesUE = $metrics['moyenne_par_ue'] ?? [];
$distribution = $metrics['distribution_intervalles'] ?? [];
$parFiliere = $metrics['donnees_par_filiere'] ?? [];
$firstSemestreMoyenne = !empty($moyennesSemestre) ? reset($moyennesSemestre) : 0;
$firstUEMoyenne = !empty($moyennesUE) ? reset($moyennesUE) : 0;
$distributionTotal = array_sum($distribution);
?>

<div class="app">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">Notes</div>
        <div class="brand-sub">Dashboard</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>
    <a href="/dashboard" class="nav-item active">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      Tableau de bord
    </a>
    <a href="/eleves" class="nav-item">
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
      <div class="topbar-title">Tableau de bord</div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Tableau de bord</h2>
          <div class="breadcrumb">Accueil / <span>Tableau de bord</span></div>
        </div>
        <a href="/eleve/create" class="btn btn-primary btn-sm">Nouvel élève</a>
      </div>

      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-header">
            <div class="kpi-label">Nombre d'élèves</div>
            <div class="kpi-icon bg-blue">
              <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
            </div>
          </div>
          <div class="kpi-value"><?= number_format($totalEleves) ?></div>
          <div class="kpi-delta up">Éléves enregistrés</div>
        </div>

        <div class="kpi-card">
          <div class="kpi-header">
            <div class="kpi-label">Taux de réussite</div>
            <div class="kpi-icon bg-green">
              <svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><path d="M12 2l7 4v6c0 5-3.5 9.7-7 10-3.5-.3-7-5-7-10V6l7-4z"/></svg>
            </div>
          </div>
          <div class="kpi-value"><?= htmlspecialchars((string) $tauxReussite) ?>%</div>
          <div class="kpi-delta up">Moyenne générale des élèves</div>
        </div>

        <div class="kpi-card">
          <div class="kpi-header">
            <div class="kpi-label">Moyenne générale par semestre</div>
            <div class="kpi-icon bg-amber">
              <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
          </div>
          <div class="kpi-value"><?= htmlspecialchars((string) $firstSemestreMoyenne) ?></div>
          <div class="kpi-delta up">Premier semestre disponible</div>
        </div>

        <div class="kpi-card">
          <div class="kpi-header">
            <div class="kpi-label">Moyenne par UE</div>
            <div class="kpi-icon bg-green">
              <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
          </div>
          <div class="kpi-value"><?= htmlspecialchars((string) $firstUEMoyenne) ?></div>
          <div class="kpi-delta up">Première UE disponible</div>
        </div>
      </div>

      <div class="dash-grid">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Répartition par filière</div>
          </div>
          <div style="display:flex;flex-direction:column;gap:12px">
            <?php if (!empty($parFiliere)): ?>
              <?php foreach ($parFiliere as $filiere => $count): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px">
                  <span><?= htmlspecialchars((string) $filiere) ?></span>
                  <strong><?= number_format((int) $count) ?></strong>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div style="color:var(--c-muted)">Aucune donnée</div>
            <?php endif; ?>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-title">Étudiants par intervalle de notes</div>
          </div>
          <div style="display:flex;flex-direction:column;gap:12px">
            <?php if (!empty($distribution)): ?>
              <?php foreach ($distribution as $intervalle => $count): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px">
                  <span><?= htmlspecialchars((string) $intervalle) ?></span>
                  <strong><?= number_format((int) $count) ?></strong>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div style="color:var(--c-muted)">Aucune donnée</div>
            <?php endif; ?>
          </div>
          <div style="margin-top:14px;color:var(--c-muted);font-size:12px">Total comptabilisé: <?= number_format((int) $distributionTotal) ?></div>
        </div>
      </div>

      <div class="dash-grid">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Moyenne générale par semestre</div>
          </div>
          <div style="display:flex;flex-direction:column;gap:12px">
            <?php if (!empty($moyennesSemestre)): ?>
              <?php foreach ($moyennesSemestre as $semestre => $moyenne): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px">
                  <span><?= htmlspecialchars((string) $semestre) ?></span>
                  <strong><?= htmlspecialchars((string) $moyenne) ?></strong>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div style="color:var(--c-muted)">Aucune donnée</div>
            <?php endif; ?>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-title">Moyenne par UE</div>
          </div>
          <div style="display:flex;flex-direction:column;gap:12px">
            <?php if (!empty($moyennesUE)): ?>
              <?php foreach ($moyennesUE as $ue => $moyenne): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:13px">
                  <span><?= htmlspecialchars((string) $ue) ?></span>
                  <strong><?= htmlspecialchars((string) $moyenne) ?></strong>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div style="color:var(--c-muted)">Aucune donnée</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
