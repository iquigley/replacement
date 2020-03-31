<?php
/**
 * PieceRequestController receives requests from the form and kicks off the process
 * of saving the customer request.
 *
 * @author ike
 */

class PieceRequestController {

    public static function processRequest($post) {
        // Create a new Customer Object
        $customer = Customer::getCustomerFromPost($post["customer"]);
        if (!$customer) {
            error_log("Could not create new customer object.");
            return false;
        }
        // Create a new Request Object
        return $customer->generateNewRequest($post['request']);
    }

}
