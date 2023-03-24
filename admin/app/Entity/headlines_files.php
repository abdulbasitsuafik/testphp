<?php
/**
* @Entity
* @Table(name="headlines_files", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class headlines_files{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="string",  nullable=true) */
    protected $file_path;
    /** @Column(type="string",  nullable=true) */
    protected $head_id;
    /** @Column(type="string",  nullable=true) */
    protected $file_type;
    /** @Column(type="integer",  nullable=true) */
    protected $rank;
    /** @Column(type="string",  nullable=true) */
    protected $title;
    /** @Column(type="string",  nullable=true) */
    protected $code;

    /** @Column(type="integer",  nullable=false) */
    protected $status = 1;
    /** @Column(type="integer",  nullable=false) */
    protected $updated_by = 0;
    /** @Column(type="string",  nullable=true) */
    protected $created_at;
    /** @Column(type="string",  nullable=true) */
    protected $updated_at;


}

//vendor/bin/doctrine orm:schema-tool:create
