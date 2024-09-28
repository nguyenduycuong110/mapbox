<?php 
namespace App\Enums;


enum SlideEnum: string {
    
    const BANNER = 'banner';
    const MAIN = 'main-slide';
    const CUSTOMER = 'customer';
    const PARTNER = 'partner';

    public static function toArray(){
        return [
            self::BANNER => 'banner',
            self::MAIN => 'main-slide',
            self::CUSTOMER => 'customer',
            self::PARTNER => 'partner'
        ];
    }

}