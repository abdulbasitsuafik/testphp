<?php
/**
* @Entity
* @Table(name="coupons", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/

class coupons{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer",  nullable=true) */
    protected $coupon_id;
    /** @Column(type="string",  nullable=true) */
    protected $name;
    /** @Column(type="string",  nullable=true) */
    protected $short_name;
    /** @Column(type="text",  nullable=true) */
    protected $description;

    /** @Column(type="string",  nullable=true) */
    protected $promocode;
    /** @Column(type="string",  nullable=true) */
    protected $promolink;
    /** @Column(type="integer",  nullable=false) */
    protected $used_total = 0;
    /** @Column(type="string",  nullable=true) */
    protected $discount;
    /** @Column(type="integer",  nullable=false) */
    protected $discountInt = 0;
    /** @Column(type="string",  nullable=true) */
    protected $species;
    /** @Column(type="string",  nullable=true) */
    protected $code_type;
    /** @Column(type="string",  nullable=true) */
    protected $cashback;
    /** @Column(type="string",  nullable=true) */
    protected $source;
    /** @Column(type="string",  nullable=true) */
    protected $regions;
    /** @Column(type="string",  nullable=true) */
    protected $categories;
    /** @Column(type="integer",  nullable=true) */
    protected $store_id;
    /** @Column(type="string",  nullable=true) */
    protected $rating;
    /** @Column(type="string",  nullable=true) */
    protected $exclusive;
    /** @Column(type="string",  nullable=true) */
    protected $language;
    /** @Column(type="string",  nullable=true) */
    protected $types;
    /** @Column(type="string",  nullable=true) */
    protected $image;

    /** @Column(type="integer",  nullable=true) */
    protected $status = 1;
    /** @Column(type="integer",  nullable=true) */
    protected $updated_by = 0;


    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true)
     */
    protected $used_last;
    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true)
     */
    protected $start_date;

    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true)
     */
    protected $end_date;

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
