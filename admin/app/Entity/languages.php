<?php
/**
* @Entity
* @Table(name="languages", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class languages{

    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="string", length=255, nullable=true) */
    protected $name;
    /** @Column(type="string", length=255, nullable=true) */
    protected $code;
    /** @Column(type="integer", nullable=true) */
    protected $rank;
    /** @Column(type="integer", nullable=true) */
    protected $ranks;

    /** @Column(type="integer",  nullable=true) */
    protected $status = 1;
    /** @Column(type="integer",  nullable=true) */
    protected $updated_by = 0;
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
