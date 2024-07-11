<form class="pt-3" method="POST" action="<?php echo base_url() . "save_expense"; ?>" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Date of Expense</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" name="date_exp" value="<?= date('Y-m-d'); ?>" required />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-9">
                    <select class="form-control" name="category">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>">
                                <?= $category['title'] ?>
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
                <label class="col-sm-3 col-form-label">Amount</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="amount" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Project</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="project" />
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="title" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" name="cemail">Description</label>
                <div class="col-sm-9">
                    <textarea type="text" class="form-control" name="description" ?></textarea>
                </div>
            </div>
        </div>


        <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Client</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="client" />
                                                    </div>
                                                </div>
                                            </div> -->
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Client Name</label>
                <div class="col-sm-9">
                    <select class="form-control" name="client">
                        <?php foreach ($client_names as $client): ?>
                            <option value="<?= $client['idClient']; ?>">
                                <?= $client['clientUniqueId']; ?> -
                                <?= $client['client']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Team Member</label>
                <div class="col-sm-9">
                    <select class="form-control" name="teamMember">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['ID'] ?>">
                                <?= $user['fName'] ?>
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
                <label class="col-sm-3 col-form-label">TAX</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="tax_1" Value="0.0" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Secound TAX</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="tax_2" Value="0.0" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <input type="checkbox" class="form-check-input" name="recurring"
                    style="    margin-left: 9rem; display=flex">
                <span style="margin-left: 11rem;margin-top: -19px;">Recurring</span>
                </input>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <input type="file" class="form-control-file" name="image" />
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