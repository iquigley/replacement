<?php
/**
 * The CustomerRequest object is created anytime a request is made. It records the
 * time is was created and the Customer that created it.
 * Each CustomerRequest has a number (1...N) of PieceRequests. Each PieceRequest
 * records which Brand/Type/and Amount.
 *
 * @author ike
 * Last Updated 03/31/2020
 */

class CustomerRequest extends DataStoreObject {

    protected static $db_table = "customer_request";
    protected static $data_field_array = array("customer_uuid");

    protected $customer_uuid;


    /**
     * Given a Brand, Piece Type, and number of pieces, this method creates a
     * PieceRequest object to this CustomerRequest object.
     * @param string $brand_uuid
     * @param string $piece_uuid
     * @param ing $number_requested
     * @return PieceRequest
     */
    public function attachNewRequest($brand_uuid, $piece_uuid, $number_requested) {
        return PieceRequest::createNewPieceRequest($this->getUuid(), $brand_uuid, $piece_uuid, $number_requested);
    }

    // ============================= LOADERS =======================================

    /**
     * For this CustomerRequest, load and return all attached PieceRequests.
     * @return [PieceRequest]
     */
    public function loadRequestedItems() {
        return PieceRequest::loadRequestedItemsForCustomerRequest($this->getUuid());
    }

    //============================== GETTERS ==============================

    public function getCustomerUuid() {
        return $this->customer_uuid;
    }

    /**
     * Loads the Customer Object associated with this CustomerRequest object.
     * @return Customer
     */
    public function getCustomerObject() {
        return Customer::loadByUuid($this->getCustomerUuid());
    }

    //============================== SETTERS ==============================

    public function setCustomerUuid($customer_uuid) {
        $this->customer_uuid = $customer_uuid;
        return $this;
    }

}
