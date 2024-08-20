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
                    <label class="col-sm-3 col-form-label">Test Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="ls_name" />
                    </div>
                </div>
            </div>
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
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Fee</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="ls_fee" />
                    </div>
                </div>
            </div>
        </div>

        <!-- New section for lab report attributes -->
        <div id="attributesContainer">
            <div class="attribute-row">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="attribute_title[]" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Reference Value</label>
                            <input type="text" class="form-control" name="attribute_reference_value[]" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" class="form-control" name="attribute_unit[]" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-attribute">Remove</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="addMoreAttribute" class="btn btn-secondary">Add More</button>

        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('#closeSpecializationForm').click(function (e) {
                e.preventDefault();
            });

            $('.select2').select2();
            $('#addMoreAttribute').click(function () {
                var newRow = $('.attribute-row:first').clone();
                newRow.find('input').val('');
                $('#attributesContainer').append(newRow);
            });
            $('#attributesContainer').on('click', '.remove-attribute', function () {
                if ($('.attribute-row').length > 1) {
                    $(this).closest('.attribute-row').remove();
                }
            });
        });
    </script>
</body>

</html>