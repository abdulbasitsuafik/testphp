<?php
/**
* @Entity
* @Table(name="headlines_detail_plugins", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class headlines_detail_plugins{
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

}

//vendor/bin/doctrine orm:schema-tool:create
