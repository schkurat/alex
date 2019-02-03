<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShopProduct
 *
 * @author Глеб
 */
class ShopProduct {
    public $kod;
    public $title;
    public $provider;
    public $group;
    public $price_opt;
    public $price;
    
    function __construct($title,$provider,$group) {
        $this->title=$title;
        $this->provider=$provider;
        $this->group=$group;
    }
}
