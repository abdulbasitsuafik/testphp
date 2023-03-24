<?php
/**
* @Entity
* @Table(name="admin_users", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class admin_users{
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
    protected $username;
    /** @Column(type="string",  nullable=true) */
    protected $password;
    /** @Column(type="string",  nullable=true) */
    protected $email;
    /** @Column(type="string",  nullable=true) */
    protected $phone;
    /** @Column(type="string",  nullable=true) */
    protected $image;

    /** @Column(type="integer",  nullable=true) */
    protected $authority;
    /** @Column(type="string",  nullable=true) */
    protected $authority_name;
    /** @Column(type="text",  nullable=true) */
    protected $user_authority;
    /** @Column(type="text",  nullable=true) */
    protected $group_authority;
    /** @Column(type="integer",  nullable=true) */
    protected $status;
    /** @Column(type="text",  nullable=true) */
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
