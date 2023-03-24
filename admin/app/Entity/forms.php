<?php
/**
* @Entity
* @Table(name="forms", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class forms{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="text",  nullable=true) */
    protected $subject;
    /** @Column(type="text",  nullable=true) */
    protected $options;
    /** @Column(type="text",  nullable=true) */
    protected $message;
    /** @Column(type="text",  nullable=true) */
    protected $image;
    /** @Column(type="text",  nullable=true) */
    protected $type;
    /** @Column(type="string",  nullable=true) */
    protected $device_id;
    /** @Column(type="integer",  nullable=true) */
    protected $user;
    /** @Column(type="string",  nullable=true) */
    protected $user_name;
    /** @Column(type="string",  nullable=true) */
    protected $cevap_konu;
    /** @Column(type="text",  nullable=true) */
    protected $cevap_mesaj;
    /** @Column(type="integer",  nullable=true) */
    protected $readed = 0;
    /** @Column(type="integer",  nullable=true) */
    protected $status = 0;
    /** @Column(type="integer",  nullable=true) */
    protected $updated_by;
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
