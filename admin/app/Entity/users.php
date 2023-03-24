<?php
/**
* @Entity
* @Table(name="users", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class users{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="string",  nullable=true) */
    protected $username;
    /** @Column(type="string",  nullable=true) */
    protected $email;
    /** @Column(type="string",  nullable=true) */
    protected $password;
    /** @Column(type="string",  nullable=true) */
    protected $resetPasswordToken;
    /** @Column(type="integer",  nullable=true) */
    protected $confirmed=0;
    /** @Column(type="integer",  nullable=true) */
    protected $blocked=0;
    /** @Column(type="string",  nullable=true) */
    protected $full_name;
    /** @Column(type="string",  nullable=true) */
    protected $name;
    /** @Column(type="string",  nullable=true) */
    protected $surname;
    /** @Column(type="string",  nullable=true) */
    protected $phone_number;
    /** @Column(type="string",  nullable=true) */
    protected $city;
    /** @Column(type="string",  nullable=true) */
    protected $avatar;
    /** @Column(type="integer",  nullable=true) */
    protected $town=0;
    /** @Column(type="string",  nullable=true) */
    protected $ref_no;
    /** @Column(type="string",  nullable=true) */
    protected $my_ref_code;
    /** @Column(type="string",  nullable=true) */
    protected $tc;
    /** @Column(type="datetime",  nullable=true) */
    protected $born_date;

    /** @Column(type="string",  nullable=false) */
    protected $language ="en";
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
