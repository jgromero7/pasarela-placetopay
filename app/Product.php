<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    static public function price()
    {
        return 368520;
    }
    public function formattedPrice()
    {
        return number_format($this->price(), 0, '', '.');
    }
    static public function src()
    {
        return asset('/img/shoes.jpg');
    }
    static public function description()
    {
        return 'Zapato Casual';
    }
}
