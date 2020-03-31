<?php
/**
 * Every CustomerRequest as 1..N PieceRequests. A PieceRequest is made up of the brand
 * of the piece requested, the type, and the number requested.
 *
 * @author ike
 * Last Updated: 03/31/2020
 */

class PieceRequest extends DataStoreObject {

    protected static $db_table = "request_with_pieces";
    protected static $data_field_array = array("request_uuid", "piece_type_uuid", "brand_type_uuid", "number_requested");

    protected $request_uuid;
    protected $piece_type_uuid;
    protected $brand_type_uuid;
    protected $number_requested;


    /**
     * Factory method for generating a new Piece request given the associated CustomerRequest Uuid,
     * the Brand Type, the Piece Type, and the number of pieces requested.
     * @param string $request_uuid
     * @param string $brand_type_uuid
     * @param string $piece_type_uuid
     * @param int $number_requested
     * @return \PieceRequest
     */
    public static function createNewPieceRequest(string $request_uuid, string $brand_type_uuid, string $piece_type_uuid, int $number_requested) {
        $pieceRequest = new PieceRequest();
        $pieceRequest->setRequestUuid($request_uuid);
        $pieceRequest->setBrandTypeUuid($brand_type_uuid);
        $pieceRequest->setPieceTypeUuid($piece_type_uuid);
        $pieceRequest->setNumberRequested($number_requested);
        $pieceRequest->save();
        return $pieceRequest;
    }

    /**
     * Factory method for returning all the PieceRequest objects given a
     * customer request uuid.
     * @param type $customer_request_uuid
     * @return type
     */
    public static function loadRequestedItemsForCustomerRequest($customer_request_uuid) {
       $adapterClass = static::getAdapterClass();
       $condition = array("request_uuid"=>$customer_request_uuid);
       return $adapterClass::readAll($condition, static::getDataBaseTable(), get_called_class());
    }

    //============================== GETTERS ==============================

    public function getRequestUuid() {
        return $this->request_uuid;
    }

    public function getPieceTypeUuid() {
        return $this->piece_type_uuid;
    }

    public function getPieceTypeObject() {
        return PieceType::loadByUuid($this->piece_type_uuid);
    }

    public function getBrandTypeUuid() {
        return $this->brand_type_uuid;
    }

    public function getBrandTypeObject() {
        return BrandType::loadByUuid($this->brand_type_uuid);
    }

    public function getNumberRequested() {
        return $this->number_requested;
    }

    //============================== SETTERS ==============================

    public function setRequestUuid($request_uuid) {
        $this->request_uuid = $request_uuid;
        return $this;
    }

    public function setPieceTypeUuid($piece_type_uuid) {
        $this->piece_type_uuid = $piece_type_uuid;
        return $this;
    }

    public function setBrandTypeUuid($brand_type_uuid) {
        $this->brand_type_uuid = $brand_type_uuid;
        return $this;
    }

    public function setNumberRequested($number_requested) {
        $this->number_requested = $number_requested;
        return $this;
    }

}
