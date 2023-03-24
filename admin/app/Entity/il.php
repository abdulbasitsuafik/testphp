<?php
/**
* @Entity
* @Table(name="il", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class il{
    /**
     * @var int
     *
     * @Column(name="IL_ID", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $IL_ID;
    /** @Column(type="string",  nullable=true) */
    protected $PLAKA;
    /** @Column(type="string",  nullable=true) */
    protected $IL_ADI_BUYUK;
    /** @Column(type="string",  nullable=true) */
    protected $IL_ADI;
    /** @Column(type="string",  nullable=true) */
    protected $IL_ADI_KUCUK;
}

//vendor/bin/doctrine orm:schema-tool:create
