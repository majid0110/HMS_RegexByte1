<div class="table-responsive">
    <form method="post" action="">
        <input type="hidden" name="idArtMenu" value="<?= $service['idArtMenu']; ?>">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Ratio</th>
                    <th>Choose</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <?= $item['idItem']; ?>
                            <input type="hidden" name="items[<?= $item['idItem']; ?>][idItem]"
                                value="<?= $item['idItem']; ?>">
                        </td>
                        <td>
                            <?= $item['Code']; ?>
                            <input type="hidden" name="items[<?= $item['idItem']; ?>][Code]" value="<?= $item['Code']; ?>">
                        </td>
                        <td>
                            <?= $item['Name']; ?>
                            <input type="hidden" name="items[<?= $item['idItem']; ?>][Name]" value="<?= $item['Name']; ?>">
                        </td>
                        <td>
                            <input type="number" style="width:4rem" name="ratio" value="1" min="1" step="any">
                        </td>
                        <td>
                            <input type="checkbox" name="selected_items[]" value="<?= $item['idItem']; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>