<?php
/**
* @Entity
* @Table(name="purchases", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class purchases{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer",  nullable=true) */
    protected $user;
    /** @Column(type="string",  nullable=true) */
    protected $vehicle_id;
    /** @Column(type="string",  nullable=true) */
    protected $drive_id;
    /** @Column(type="integer",  nullable=true) */
    protected $card_id;
    /** @Column(type="integer",  nullable=true) */
    protected $product;
    /** @Column(type="datetime",  nullable=true) */
    protected $start_date;
    /** @Column(type="datetime",  nullable=true) */
    protected $end_date;
    /** @Column(type="integer",  nullable=true) */
    protected $used = 0;
    /** @Column(type="integer",  nullable=true) */
    protected $payment=0;
    /** @Column(type="string",  nullable=true) */
    protected $payment_method;
    /** @Column(type="integer",  nullable=true) */
    protected $added_by = 0;
    /** @Column(type="integer",  nullable=true) */
    protected $updated_by = 0;
    /** @Column(type="float",  nullable=true) */
    protected $custom_price = 0.0;
    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true)
     */
    protected $created_at;
    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true,columnDefinition="timestamp default current_timestamp on update current_timestamp")
     */
    protected $updated_at;
}

//vendor/bin/doctrine orm:schema-tool:create
// bayi içinde ..\vendor\bin\doctrine orm:schema-tool:update --force
