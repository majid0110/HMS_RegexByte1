<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
    <style>
        #serviceTableBodyContainer {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <div id="serviceTableBodyContainer">
        <table class="table" id="serviceTypeList">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th> <!-- Empty header for the button column -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr data-service-type-id="<?= $service['idArtMenu']; ?>">
                        <td class="title">
                            <?= $service['Name']; ?>
                        </td>
                        <td class="fee" contenteditable="true">
                            <?= $service['Price']; ?>
                        </td>
                        <td><span class="badge badge-primary badge-pill hover-effect" onclick="addService()">ADD</span></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>