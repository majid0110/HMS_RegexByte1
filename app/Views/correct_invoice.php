<?php include 'include_common/head1.php'; ?>
<?php include 'include_common/navbar.php'; ?>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <?php include 'include_common/sidebar.php'; ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Correct Invoice</h4>
                                <form class="forms-sample"
                                    action="<?= base_url('SalesController/updateInvoice/' . $invoice['idReceipts']); ?>"
                                    method="POST">
                                    <div class="form-group">
                                        <label for="client">Client</label>
                                        <input type="text" class="form-control" id="client" name="client"
                                            value="<?= $invoice['client']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact"
                                            value="<?= $invoice['contact']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <a href="<?= base_url('SalesController/viewInvoice/' . $invoice['idReceipts']); ?>"
                                        class="btn btn-light">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'include_common/footer.php'; ?>