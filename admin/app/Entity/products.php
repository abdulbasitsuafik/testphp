<?php
/**
* @Entity
* @Table(name="products", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class products{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false,columnDefinition="INT AUTO_INCREMENT UNIQUE")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id = null;
    /** @Column(type="string",  nullable=true) */
    protected $name;
    /** @Column(type="string",  nullable=true) */
    protected $type;
    /** @Column(type="text",  nullable=true) */
    protected $description;
    /** @Column(type="float",  nullable=true) */
    protected $price;
    /** @Column(type="float",  nullable=true) */
    protected $per_price;
    /** @Column(type="integer",  nullable=true) */
    protected $period;
    /** @Column(type="integer",  nullable=true) */
    protected $ios_id;
    /** @Column(type="string",  nullable=true) */
    protected $sku;
    /** @Column(type="string",  nullable=true) */
    protected $image;
    /** @Column(type="string",  nullable=true) */
    protected $color;
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
