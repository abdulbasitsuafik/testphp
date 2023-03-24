<?php
/**
* @Entity
* @Table(name="notifications", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class notifications{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false,columnDefinition="INT AUTO_INCREMENT UNIQUE")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id = null;
    /** @Column(type="string",  nullable=true) */
    protected $title;
    /** @Column(type="string",  nullable=true) */
    protected $description;
    /** @Column(type="text",  nullable=true) */
    protected $body;
    /** @Column(type="string",  nullable=true) */
    protected $image;
    /** @Column(type="integer",  nullable=true) */
    protected $readed = 0;
    /** @Column(type="integer",  nullable=true) */
    protected $store_id = 0;
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
