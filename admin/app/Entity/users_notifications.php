<?php
/**
* @Entity
* @Table(name="users_notifications", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class users_notifications{
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
    protected $notification_id;
    /** @Column(type="integer",  nullable=true) */
    protected $favorite = 0;
    /** @Column(type="integer",  nullable=true) */
    protected $readed = 0;
}

//vendor/bin/doctrine orm:schema-tool:create
// bayi içinde ..\vendor\bin\doctrine orm:schema-tool:update --force
