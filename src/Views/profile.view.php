<?php
require_once(__DIR__ . '/partials/head.php');
?>
<h1>Task'N'Kids</h1>
<?php
if ($myUser) {
?>
  <h2>Pseudo : <?= $myUser->getPseudo() ?></h2>
  <h2>Mail :<?= $myUser->getMail() ?></h2>
  <h2>Point : <?= $myUser->getScore() ? $myUser->getScore() : 0 ?></h2>
<?php
}
?>
<?php

require_once(__DIR__ . '/partials/footer.php');
?>