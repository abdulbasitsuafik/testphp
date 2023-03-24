<?php
/**
* @Entity
* @Table(name="headlines", options={"collate":"utf8_general_ci", "charset":"utf8"})
**/
class headlines{
    /**
     * @var int
     *
     * @Column(name="id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @Column(type="integer",  nullable=true) */
    protected $top_head_id;
    /** @Column(type="integer",  nullable=true) */
    protected $main_head;
    /** @Column(type="integer",  nullable=true) */
    protected $ranks;
    /** @Column(type="string",  nullable=true) */
    protected $galery_id;
    /** @Column(type="integer",  nullable=true) */
    protected $slide_id;
    /** @Column(type="integer",  nullable=true) */
    protected $form_id;
    /** @Column(type="integer",  nullable=true) */
    protected $popup_id;
    /** @Column(type="integer",  nullable=true) */
    protected $bottom_status;
    /** @Column(type="string",  nullable=true) */
    protected $ek;
    /** @Column(type="string",  nullable=true) */
    protected $link;
    /** @Column(type="string",  nullable=true) */
    protected $inlink_type;
    /** @Column(type="string",  nullable=true) */
    protected $link_selected;
    /** @Column(type="string",  nullable=true) */
    protected $link_opening;
    /** @Column(type="integer",  nullable=true) */
    protected $first_bottom_head;
    /** @Column(type="string",  nullable=true) */
    protected $image;
    /** @Column(type="string",  nullable=true) */
    protected $image_new;

    /** @Column(type="integer",  nullable=true) */
    protected $status = 1;
    /** @Column(type="integer",  nullable=true) */
    protected $updated_by = 0;
    /** @Column(type="string",  nullable=true) */
    protected $created_at;
    /** @Column(type="string",  nullable=true) */
    protected $updated_at;

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }
}

//vendor/bin/doctrine orm:schema-tool:create
// bayi içinde ..\vendor\bin\doctrine orm:schema-tool:update --force
