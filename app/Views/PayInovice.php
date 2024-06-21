<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
</head>

<body>

    <form class="pt-3" method="POST" action="<?php echo base_url() . "Payment"; ?>" enctype="multipart/form-data">
        <div class="row">

            <div class="col">
                <label>Value to Pay</label>
                <div>
                    <input type="text" class="form-control" name="valueToPay"
                        value="<?= isset($valueToPay) ? $valueToPay : '' ?>" readonly>
                </div>
            </div>

            <div class="col">
                <label>Value</label>
                <div>
                    <input class="typeahead form-control" type="Number" name="Value" placeholder="Value">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <label>Currency</label>
                <div id="the-basics">
                    <select class="typeahead form-control" name="Currency">
                        <?php foreach ($currencies as $currency): ?>
                            <option value="<?= $currency['id']; ?>">
                                <?= $currency['Currency']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col">
                <label>Payment Method</label>
                <div id="the-basics">
                    <select class="typeahead form-control" name="Payment">
                        <?php foreach ($payments as $payment): ?>
                            <option value="<?= $payment['idPaymentMethods']; ?>"
                                data-payment-id="<?= $payment['idPaymentMethods']; ?>">
                                <?= $payment['Method']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Exchange</label>
                <div id="bloodhound">
                    <input class="typeahead form-control" type="Number" name="exchange" value='1.0' id="exchangeInput"
                        placeholder="Exchange Rate">
                </div>
            </div>

            <div class="col">
                <div class="col-sm-9">
                    <input type="hidden" name="client" class="form-control" value="<?= isset($client) ? $client : '' ?>"
                        readonly>
                </div>
            </div>
        </div>
        <input type="hidden" name="idReceipts" value="<?= isset($idReceipts) ? $idReceipts : '' ?>">

        <div class="row" style="margin-top: 1rem;">
            <div class="col">
                <button type="submit" class="btn btn-primary">Pay</button>
            </div>
        </div>
    </form>

    <script src="./public/assets/vendors_s/js/vendor.bundle.base.js"></script>
    <script src="./public/assets/vendors_s/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
    <script src="./public/assets/vendors_s/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="./public/assets/js_s/off-canvas.js"></script>
    <script src="./public/assets/js_s/hoverable-collapse.js"></script>
    <script src="./public/assets/js_s/template.js"></script>
    <script src="./public/assets/js_s/settings.js"></script>
    <script src="./public/assets/js_s/todolist.js"></script>
    <script src="./public/assets/js_s/file-upload.js"></script>
    <script src="./public/assets/js_s/typeahead.js"></script>
    <script src="./public/assets/js_s/select2.js"></script>
</body>

</html>