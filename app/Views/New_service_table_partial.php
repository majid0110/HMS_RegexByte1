<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
    <style>
        .item-list-container {
            width: 95%;
            margin-top: 10px;
            /* overflow-y: auto; */
        }

        .item-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            height: 255px;
        }

        .item {
            width: calc(33.33% - 10px);
            height: 6rem;
            box-sizing: border-box;
            padding: 3px;
            font-size: small;
            background-color: whitesmoke;
            border: 1px solid #ddd;
            text-align: center;
            border-radius: 15px;
            cursor: pointer;
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
</body>

</html>