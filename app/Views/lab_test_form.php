<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
</head>

<body>
    <a href="#" id="labTestForm" style="position: absolute; top: 10px; right: 10px; font-size: 20px; color: #333;">
        <i class="mdi mdi-close"></i>
    </a>
    <form class="pt-3" method="POST" action="<?php echo base_url() . "saveLabService"; ?>"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Test-MY Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="ls_name" />
                    </div>
                </div>
            </div>
            <!-- Description input -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="ls_description" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Fee input -->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Fee</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="ls_fee" />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            // Close button functionality
            $('#closeSpecializationForm').click(function (e) {
                e.preventDefault();
                // Since there's no modal, just close the form
                // You might want to add further functionality here if needed
                // For now, just go back to the previous page or close the form
                // Example: window.history.back();
                // Or: $('#testFormContainer').hide(); // if the form is in a container
            });

            // Initialize Select2 for any select elements with the .select2 class
            $('.select2').select2();
        });
    </script>
</body>

</html>