<?php
require_once(__DIR__ . '/../partials/head.php');
?>
<h1>Mes taches : </h1>
<?php
if ($resultTask) {
    foreach ($resultTask as $myTask) {
?>

        <div class="bgg">
            <h2>Titre : <?= $myTask->getTitle() ?></h2>
            <p>Déscription : <?= $myTask->getContent() ?> </p>
            <p>Date de création <?= $myTask->getCreationDate() ?></p>
            <p>Du : <?= $myTask->getStartTask()  ?> au: <?= $myTask->getStopTask() ?></p>
            <p>Points : <?= $myTask->getPoint() ?></p>
            <a href="/endTask?idTask=<?= $myTask->getId() ?>&idUser=<?= $myTask->getIdKid() ?>&point=<?= $myTask->getPoint() ?>">Tache fini</a>
        </div>
<?php
    }
}
?>
<?php
require_once(__DIR__ . '/../partials/footer.php');
?>