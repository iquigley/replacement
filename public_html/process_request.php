<?php require_once("autoloader.php"); ?>
<?php require_once("../lib/settings.php"); ?>

<?php $request = PieceRequestController::processRequest($_POST); ?>

<?php if (!$request) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else { ?>

<html>
    <?php require_once("common/common_header.php"); ?>
    <body>
        <br/>
        <div class="container">
            <div class='col-md-10 col-md-offset-1'>
                <h2 class="request-heading">Request a Piece</h2>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='alert-success'>
                            Thank you for your request. We will be in touch as soon as your requested items have arrived.
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <?php $customer = $request->getCustomerObject(); ?>
                    
                    <div class='col-sm-3 col-xs-12'>
                        Name: <?php echo $customer->getName(); ?>
                    </div>
                    <div class='col-sm-3 col-xs-12'>
                        Email: <?php echo $customer->getEmail(); ?>
                    </div>
                    <div class='col-sm-3 col-xs-12'>
                        Name: <?php echo $customer->getPhone(); ?>
                    </div>
                </div>
                <div class='row'>
                    <h3>Requested Items</h3>
                    <table class='table table-striped table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Type</th>
                                <th>Number Requested</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($request->loadRequestedItems() as $item) { ?>
                                <tr>
                                    <td><?php echo $item->getBrandTypeObject()->getName(); ?></td>
                                    <td><?php echo $item->getPieceTypeObject()->getName(); ?></td>
                                    <td><?php echo $item->getNumberRequested(); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

<?php require_once("common/common_footer.php"); ?>


<?php } ?>