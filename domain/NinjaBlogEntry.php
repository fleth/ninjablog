<?php

namespace domain;

class NinjaBlogEntry {
    private $text_format;
    private $category_id;
    private $open_flg;
    private $entry_content;
    private $cm_receipt_flg;
    private $title;

    public function __construct($text_format, $category_id, $open_flg, $entry_content, $cm_receipt_flg, $title){
        $this->text_format = $text_format;
        $this->category_id = $category_id;
        $this->open_flg = $open_flg;
        $this->entry_content = $entry_content;
        $this->cm_receipt_flg = $cm_receipt_flg;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTextFormat()
    {
        return $this->text_format;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @return mixed
     */
    public function getOpenFlg()
    {
        return $this->open_flg;
    }

    /**
     * @return mixed
     */
    public function getEntryContent()
    {
        return $this->entry_content;
    }

    /**
     * @return mixed
     */
    public function getCmReceiptFlg()
    {
        return $this->cm_receipt_flg;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function toArray(){
        return [
            "text_format" => $this->getTextFormat(),
            "category_id" => $this->getCategoryId(),
            "open_flg" => $this->getOpenFlg(),
            "entry_content" => $this->getEntryContent(),
            "cm_receipt_flg" => $this->getCmReceiptFlg(),
            "title" => $this->getTitle()
        ];
    }
}