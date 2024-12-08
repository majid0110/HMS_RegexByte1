<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
</head>

<body>

    <form class="pt-3" method="POST" action="<?php echo base_url() . "saveitems"; ?>" enctype="multipart/form-data">
        <p class="card-description">
            Items Details
        </p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">BarCode</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="bcode" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="code" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" required />
                    </div>
                </div>
            </div>
        </div>

        <p class="card-description">
            Price Details
        </p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Cost</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="cost" Value="0" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Minimun</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" Value="0" name="min" />
                    </div>
                </div>
            </div>
        </div>

        <p class="card-description">
            Other Details
        </p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="category">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['idCatArt'] ?>">
                                    <?= $category['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Notes</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="notes" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Units</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="Unit">
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= $unit['idUnit'] ?>">
                                    <?= $unit['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Warehouse</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="warehouse">
                            <?php foreach ($warehouse as $warehouse): ?>
                                <option value="<?= $warehouse['idWarehouse'] ?>">
                                    <?= $warehouse['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Taxes</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="tax">
                            <?php foreach ($tax as $taxes): ?>
                                <option value="<?= $taxes['tax_id'] ?>">
                                    <?= $taxes['value'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="cstatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Characteristic1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="char_1" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Characteristic2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="char_2" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Inventory</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="inventory" />
                        </div>
                    </div>
                </div>

                <?php if ($isExpiry == 1): ?>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Item Expiry</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="expiryField" name="expiry" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
    </form>

    <script>
        window.onload = function () {
            var expiryField = document.getElementById("expiryField");
            var isExpiry = <?php echo $isExpiry; ?>; 

            if (isExpiry === 1) {
                expiryField.required = true;
            } else {
                expiryField.required = false;
            }
        }
    </script>
</body>

</html>