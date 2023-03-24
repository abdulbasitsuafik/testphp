<?php
/**
* @Entity
* @Table(name="categories", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class categories{

    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer",  nullable=true) */
    protected $category_id;
    /** @Column(type="string", length=255, nullable=true) */
    protected $name;

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
