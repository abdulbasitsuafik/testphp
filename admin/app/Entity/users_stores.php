<?php
/**
* @Entity
* @Table(name="users_stores", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class users_stores{
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
    protected $store_id;
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
