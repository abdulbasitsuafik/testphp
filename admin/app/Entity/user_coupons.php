<?php
/**
* @Entity
* @Table(name="user_coupons", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class user_coupons{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer",  nullable=true) */
    protected $user_id;
    /** @Column(type="integer",  nullable=true) */
    protected $coupon_id;
    /** @Column(type="integer",  nullable=true) */
    protected $used;
    /** @Column(type="integer",  nullable=true) */
    protected $favorite;

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
