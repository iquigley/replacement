<?php
/**
 * The Customer class tracks all customers of the site.
 *
 * @author ike
 * Last Updated 03/31/2020
 */

class Customer extends DataStoreObject {

    protected static $db_table = "customer";
    protected static $data_field_array = array("email", "phone");

    protected $email;
    protected $phone;


    /**
     * Given an input post, this method checks to see if the customer already exists
     * in the database using the given email address. If so, it returns that record.
     * If not, then it creates a new record.
     * @param [string] $post
     * @return Customer
     */
    public static function getCustomerFromPost($post) {
        // Does this customer exist in the DB already?
        $customer = static::loadByEmail($post['email']);
        if (!$customer) {
            // Create a new one.
            $customer = new Customer();
            $customer->setName($post['name']);
            $customer->setEmail($post['email']);
            $customer->setPhone($post['phone']);
            $customer->save();
        }
        return $customer;
    }


    /**
     * Entry point for creating new requests. Given an array of request objects from
     * the input form, this method generates a new CustomerRequest object, and attaches
     * to that object each requested replacement.
     * @param [string] $requests
     * @return CustomerRequest
     */
    public function generateNewRequest(array $requests) {
        // Generate a Request Object for this customer.
        $customerRequest = new CustomerRequest();
        $customerRequest->setCustomerUuid($this->getUuid());
        $customerRequest->save();
        // Attach the individual requested items.
        foreach ($requests as $requestInfo) {
            if ($requestInfo['number_requested'] != 0) {
                $customerRequest->attachNewRequest($requestInfo['brand'], $requestInfo['piece_type'], $requestInfo['number_requested']);
            }
        }
        return $customerRequest;
    }

    // ============================= LOADERS =======================================

    /**
     * Loads a Customer object given an email address.
     * @param string $email
     * @return Customer
     */
    public static function loadByEmail($email) {
        $adapterClass = static::getAdapterClass();
        $condition = array("email"=>$email);
        return $adapterClass::read($condition, static::getDataBaseTable(), get_called_class());
    }

    //============================== GETTERS ==============================


    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    //============================== SETTERS ==============================

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }


}
