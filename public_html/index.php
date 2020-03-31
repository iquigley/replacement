<?php require_once("autoloader.php"); ?>
<?php require_once("../lib/settings.php"); ?>
<html>
    <?php require_once("common/common_header.php"); ?>
    <body>
        <br/>
        <div class="container">
            <form class="form-request-replacement" method="post" action="process_request.php">
                <h2 class="request-heading">Request a Piece</h2>

                <label for="customer_name" class="sr-only">Name</label>
                <input type="text" id="customer_name" class="form-control" name='customer[name]' placeholder="Your Name" required autofocus>

                <label for="customer_email" class="sr-only">Email address</label>
                <input type="email" id="customer_email" class="form-control" name='customer[email]' placeholder="Email" required>

                <label for="customer_phone" class="sr-only">Phone Number</label>
                <input type="phone" id="inputPassword" class="form-control" name='customer[phone]' placeholder="Phone Number" >

                <h2 class="request-heading">Piece Request (limit <?php echo MAX_REQUESTS; ?>)</h2>
            <?php for($i = 0; $i < MAX_REQUESTS; $i++) { ?>
                <div class="row">
                    <div class="col-sm-1">
                        <h4><?php echo $i + 1; ?></h4>
                    </div>
                    <div class="col-md-4">
                        <select name="request[<?php echo $i; ?>][brand]" class="form-control input-md">
                            <option value="">Please Select</option>
                            <option disabled>_________</option>
                            <?php $brands = BrandType::loadAll(); ?>
                            <?php foreach ($brands as $brand) { ?>
                            <option value="<?php echo $brand->getUuid(); ?>"><?php echo $brand->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="request[<?php echo $i; ?>][piece_type]" class="form-control input-md">
                            <option value="">Please Select</option>
                            <option disabled>_________</option>
                            <?php $pieces = PieceType::loadAll(); ?>
                            <?php foreach ($pieces as $piece) { ?>
                            <option value="<?php echo $piece->getUuid(); ?>"><?php echo $piece->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="1" class='form-control input-md' name="request[<?php echo $i; ?>][number_requested]" value="0"/>
                    </div>
                </div>
            <?php } ?>
                <br/>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>

<?php require_once("common/common_footer.php"); ?>


