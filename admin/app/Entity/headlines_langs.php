<?php
/**
* @Entity
* @Table(name="headlines_langs", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class headlines_langs{
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
    /** @Column(type="text", nullable=true) */
    protected $description;
    /** @Column(type="string", length=500, nullable=true) */
    protected $title;
    /** @Column(type="string", length=500, nullable=true) */
    protected $keywords;
    /** @Column(type="string", length=500, nullable=true) */
    protected $seflink;
    /** @Column(type="text", nullable=true) */
    protected $content;
    /** @Column(type="text", nullable=true) */
    protected $ek_description;

}

//vendor/bin/doctrine orm:schema-tool:create
