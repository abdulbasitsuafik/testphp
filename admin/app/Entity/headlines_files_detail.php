<?php
/**
* @Entity
* @Table(name="headlines_files_detail", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class headlines_files_detail{
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
    /** @Column(type="integer", nullable=true) */
    protected $lang;
    /** @Column(type="string", length=500,  nullable=true) */
    protected $code;
    /** @Column(type="string", length=500,  nullable=true) */
    protected $title;
    /** @Column(type="text", nullable=true) */
    protected $content;

}

//vendor/bin/doctrine orm:schema-tool:create
//..\vendor\bin\doctrine orm:schema-tool:update --force
