<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
</head>

<body>
    <a href="#" id="closecatModal" style="position: absolute; top: 10px; right: 10px; font-size: 20px; color: #333;">
        <i class="mdi mdi-close"></i>
    </a>
    <form class="pt-3" method="POST" action="<?php echo base_url() . "saveCatart"; ?>" enctype="multipart/form-data">
        <p class="card-description">
            Sector Details
        </p>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sector Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" required />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Print Output</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="printOutput" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">TVSH</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="TVSH" required />
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('#closecatModal').click(function (e) {
                e.preventDefault();
                $('#addcatModal').modal('hide');
            });
        });
    </script>
</body>

</html>