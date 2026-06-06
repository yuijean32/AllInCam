<?php
// views/admin/dashboard.php
$mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin"];
$gains_taxe = [150000, 220000, 180000, 350000, 400000, 520000];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Tableau de Bord 📊</h1>
    <div style="width:60vw; margin:auto;"><canvas id="graphiqueGains"></canvas></div>
    <script>
        const lesMois = <?php echo json_encode($mois); ?>;
        const lesGains = <?php echo json_encode($gains_taxe); ?>;
    </script>
    <script src="../../public/js/dashboard.js"></script>
</body>
</html>