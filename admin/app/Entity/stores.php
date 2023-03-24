<?php
/**
* @Entity
* @Table(name="stores", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class stores{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer",  nullable=true) */
    protected $store_id;
    /** @Column(type="string",  nullable=true) */
    protected $name;
    /** @Column(type="text",  nullable=true) */
    protected $description;
    /** @Column(type="string",  nullable=true) */
    protected $logo;
    /** @Column(type="string",  nullable=true) */
    protected $image;
    /** @Column(type="string",  nullable=true) */
    protected $large_image;
    /** @Column(type="string",  nullable=true) */
    protected $currency;
    /** @Column(type="string",  nullable=true) */
    protected $site_url;
    /** @Column(type="string",  nullable=true) */
    protected $rating;
    /** @Column(type="string",  nullable=true) */
    protected $categories;
    /** @Column(type="string",  nullable=true) */
    protected $regions;

    /** @Column(type="integer",  nullable=true) */
    protected $status = 1;
    /** @Column(type="integer",  nullable=true) */
    protected $updated_by = 0;

    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true)
     */
    protected $activation_date;
    /**
     * @var DateTime
     * @Column(type="datetime",  nullable=true)
     */
    protected $modified_date;
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
