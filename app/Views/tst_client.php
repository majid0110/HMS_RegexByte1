<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
</head>

<body>
    <a href="#" id="closeAddClientModal"
        style="position: absolute; top: 10px; right: 10px; font-size: 20px; color: #333;">
        <i class="mdi mdi-close"></i>
    </a>


    <h3>
        <small class="text-muted" style="margin-left: 30rem;">
            ADD CLIENT
        </small>
    </h3>
    <form class="pt-3" method="POST" action="<?php echo base_url() . "saveClient"; ?>" enctype="multipart/form-data">
        <p class="card-description">
            Personal info
        </p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Client Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="cName" required />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Client Contact</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="cphone" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Identification Type</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="idType" />
                        <option>CNIC</option>
                        <option>Passport</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Client CNIC</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="CNIC" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" name="cemail">Client Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="cemail" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" name="gender">Gender</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="gender" required />
                        <option>Male</option>
                        <option>Female</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" name="age">Client Age</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="age" />
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
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="cstatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Def</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="cdef" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Limit Expense</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="expense" Value="0.0" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Discount</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" Value="0.0" name="discount" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <!-- <label class="col-sm-3 col-form-label">Main Client</label>  -->
                    <!-- <div class="col-sm-9"> -->
                    <input type="checkbox" class="form-check-input" name="mclient"
                        style="    margin-left: 9rem; display=flex">
                    <span style="margin-left: 11rem;margin-top: -19px;">Main Client</span>
                    </input>
                    <!-- <label class="col-sm-3 col-form-label">Main Client</label>  -->
                </div>
                <!-- </div> -->
            </div>
        </div>


        <p class="card-description">
            Address Details
        </p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="address" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">City</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="city" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">State</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='state'>
                            <option>Pakistan</option>
                            <option>Others</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="code" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Add a submit button -->
        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            // Close button click event
            $('#closeAddClientModal').click(function (e) {
                e.preventDefault(); // Prevent the default anchor behavior
                // Assuming your form is wrapped in a modal, you can close it like this:
                $('#addClientModal').modal('hide');
            });
        });
    </script>
</body>

</html>