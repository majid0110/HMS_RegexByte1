<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
    <style>
        .item-list-container {
            width: 95%;
            margin-top: 10px;
            overflow-y: hidden;
        }

        .item-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            height: 255px;
        }
    </style>
</head>

<body>
    <div class="item-list-container">
        <div class="item-list">
            <?php foreach ($services as $service): ?>
                <div class="item" data-service-id="<?= $service['idArtMenu']; ?>"
                    data-service-price="<?= $service['Price']; ?>" data-service-tax="<?= $service['idTVSH']; ?>">
                    <div style="font-weight: bolder;"><?= $service['Name']; ?></div>
                    <div style="margin-bottom:auto; font-size: small;"><?= $service['Price']; ?> pkr</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>

</body>

</html>