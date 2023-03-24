<?php
/**
* @Entity
* @Table(name="devices", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class devices{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="string",  nullable=true) */
    protected $device_id;
    /** @Column(type="string",  nullable=true) */
    protected $brand;
    /** @Column(type="string",  nullable=true) */
    protected $model;
    /** @Column(type="string",  nullable=true) */
    protected $os_type;
    /** @Column(type="string",  nullable=true) */
    protected $os_version;
    /** @Column(type="string",  nullable=true) */
    protected $app_version;
    /** @Column(type="string",  nullable=true) */
    protected $local_language;
    /** @Column(type="string",  nullable=true) */
    protected $push_token;
    /** @Column(type="string",  nullable=true) */
    protected $access_token;
    /** @Column(type="integer",  nullable=true) */
    protected $user;
    /** @Column(type="integer",  nullable=true) */
    protected $logout;
    /** @Column(type="integer",  nullable=true) */
    protected $theme;
    /** @Column(type="integer",  nullable=false) */
    protected $dark_mode = 0;
    /** @Column(type="integer",  nullable=false) */
    protected $notification = 1;
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
