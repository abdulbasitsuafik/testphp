<?php
/**
* @Entity
* @Table(name="headlines_plugins", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class headlines_plugins{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer", nullable=true) */
    protected $head_id;
    /** @Column(type="string", length=500,  nullable=true) */
    protected $tpl_path;
    /** @Column(type="integer", nullable=true) */
    protected $rank;
    /** @Column(type="text", nullable=true) */
    protected $json;
    /** @Column(type="string", length=500,  nullable=true) */
    protected $folder;
    /** @Column(type="integer", nullable=true) */
    protected $common_plugin;

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
