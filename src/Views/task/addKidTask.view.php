<?php
require_once(__DIR__ . '/../partials/head.php');
?>
<h1>Assigné une tâche</h1>
<form method='POST'>
    <div class="col-md-4 mx-auto d-block mt-5">
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="en_attente">En attente</option>
                <option value="en_cours">En cours</option>
                <option value="fini">Fini</option>
            </select>
            <?php if (isset($this->arrayError['status'])) {
            ?>
                <p class='text-danger'><?= $this->arrayError['status'] ?></p>
            <?php
            } ?>
        </div>
        <div class="mb-3">
            <label for="kid">Enfant : </label>
            <select name="kid" id="kid">
                <option value="0">Pas d'assignation</option>
                <?php
                foreach ($myKids as $kid) {
                ?>
                    <option value="<?= $kid->getId() ?>"><?= $kid->getPseudo() ?></option>
                <?php
                }
                ?>
            </select>
            <?php if (isset($this->arrayError['kid'])) {
            ?>
                <p class='text-danger'><?= $this->arrayError['kid'] ?></p>
            <?php
            } ?>
        </div>
        <button type="submit" class='btn btn-success mt-5 mb-5'>Assigner une tâche</button>
    </div>
</form>

<?php
require_once(__DIR__ . '/../partials/footer.php');
?>