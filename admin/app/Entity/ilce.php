<?php
/**
* @Entity
* @Table(name="ilce", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class ilce{
    /**
     * @var int
     *
     * @Column(name="ILCE_ID", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $ILCE_ID;
    /** @Column(type="integer",  nullable=true) */
    protected $IL_ID;
    /** @Column(type="string",  nullable=true) */
    protected $ILCE_ADI_BUYUK;
    /** @Column(type="string",  nullable=true) */
    protected $ILCE_ADI;
    /** @Column(type="string",  nullable=true) */
    protected $ILCE_ADI_KUCUK;

}

//vendor/bin/doctrine orm:schema-tool:create
