<?php
namespace App\Contracts;

interface SaleConfig {
   const PRODUCT_TYPES = [
        'TROUSERS',
        'HARRINGTON_JACKET',
        'SHIRT',
   ];

   const PRODUCT_KEY_TYPES = [
    'TROUSERS' => 'TS',
    'HARRINGTON_JACKET' => 'HJ',
    'SHIRT' => 'ST',
];

const SIZES = [
    'VAI',
    'NGỰC',
    'EO',
    'DÀI ÁO',
    'DÀI TAY',
    'EO QUẦN',
    'ĐÁY',
    'ĐÙI',
    'DÀI QUẦN',
    'ỐNG',
    'DƯ LAI',
  
];

const ORDER_STATUSES = [
    'NEW',
    'READY FOR SHIPPING',
    'COMPLETED',
];
}
