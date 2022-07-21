<?php

namespace Database\Vin;

class Novabus
{
    const ENGINE = [
        'A' => 'Cummins ISL G',
        'B' => 'Hybrid Cummins ISL - BAE TB-300',
        'J' => 'Detroit Diesel 6V92',
        'K' => 'Cummins 8.3L',
        'L' => 'Cummins L10 G',
        'M' => 'Cummins M11',
        'N' => 'Detroit Diesel Series 50',
        'P' => 'Detroit Diesel Series 40',
        'R' => 'Detroit Diesel Series 50 Propane',
        'S' => 'Cummins ISC',
        'T' => 'No Power Train',
        'U' => 'Cummins ISL/ISL9',
        'V' => 'Cummins ISC Non Transit',
        'W' => 'Hybrid Cummins ISL - Allison EP 40',
        'X' => 'Hybrid Cummins ISB - Allison EP 40',
        'Y' => 'Hybrid Cummins ISL - Allison EP 50',
        'Z' => 'Hybrid Cummins ISB - BAE TB-200 ',
    ];

    const ENGINE_AFTER_2013 = [
        'A' => 'Cummins ISL G',
        'B' => 'Hybrid Cummins ISL - BAE TB-300',
        'J' => 'Cummins ISL9',
        'K' => 'Cummins Westport ISL G',
        'L' => 'Hybrid Cummins ISB6.7 - BAE HDS 200',
        'M' => 'Cummins M11',
        'N' => 'Detroit Diesel Series 50',
        'P' => 'Detroit Diesel Series 40',
        'R' => 'Detroit Diesel Series 50 Propane',
        'S' => 'Cummins ISC',
        'T' => 'No Power Train',
        'U' => 'Cummins ISL/ISL9',
        'V' => 'Cummins ISC Non Transit',
        'W' => 'Hybrid Cummins ISL - Allison EP 40',
        'X' => 'Hybrid Cummins ISB - Allison EP 40',
        'Y' => 'Hybrid Cummins ISL - Allison EP 50',
        'Z' => 'Hybrid Cummins ISB - BAE TB-200 ',
    ];

    const ASSEMBLY = [
        '3' => 'St. Eustache, QC',
        '4' => 'Plattsburgh, NY',
        '9' => 'Plattsburgh, NY',
    ];

    const LENGTH = [
        '8' => 40,
        '9' => 60,
    ];

    const MODEL = [
        'T' => 'Classic',
        'R' => 'Classic Articulated',
        'L' => 'LFS',
        'S' => 'LFS Articulated',
    ];

    const PROPULSION = [];
}
