<!-- Items_modal.php -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['idItem']; ?></td>
                    <td><?= $item['Code']; ?></td>
                    <td><?= $item['Name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>