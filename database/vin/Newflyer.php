<?php

namespace Database\Vin;

class Newflyer
{
    const ASSEMBLY = [
        'A' => 'Winnipeg, MB',
        'B' => 'St. Cloud, MN',
        'C' => 'Crookston, MN',
        'D' => 'Winnipeg, MB',
        'E' => 'Winnipeg, MB',
        'F' => 'Anniston, AL',
        'P' => 'Winnipeg, MB',
        'U' => 'St. Cloud, MN',
    ];

    const BODY_TYPE = [
        'A' => 'D40 w/narrow front & rear doors',
        'B' => 'D40 w/narrow front & wide rear doors',
        'C' => 'D40 w/wide front & wide rear doors',
        'D' => 'D40 w/wide front & narrow rear doors',
        'E' => 'D40S',
        'F' => '40/40LF/40LFR/X_40',
        'G' => 'D35',
        'H' => 'D35',
        'J' => 'D35 w/wide front & narrow rear doors',
        'K' => '35/35LF/35LFR',
        'L' => 'D40LF',
        'M' => 'D60 w/2 wide rear doors',
        'N' => 'D60 w/1 wide rear door',
        'P' => 'D60 w/1 narrow rear door',
        'R' => 'D60 w/2 narrow rear doors',
        'S' => 'D35LF',
        'T' => 'D30LF',
        'U' => 'D60LF',
        'V' => '30/30LF/30LFR',
        'W' => '45 ft High Floor',
        'Y' => '60/60LF/60LFR/X_60',
    ];

    const ENGINE = [
        'A' => 'Detroit Diesel 6V71N & Philadelphia ETB',
        'B' => 'Cummins ISL G/L9N 280hp',
        'C' => 'Cummins ISL G/L9N 320hp',
        'D' => 'Detroit Diesel 6V92TA/Cummins ISL G',
        'E' => 'Cummins L10',
        'F' => 'Detroit Diesel 6V71N',
        'G' => 'Detroit Diesel 6V92TA',
        'H' => 'Cummins L10 T-drive',
        'J' => 'Vancouver ETB/Battery Powered (2013-Present)',
        'K' => 'Detroit Diesel Series 50/Series 50 EGR',
        'L' => 'Detroit Diesel Series 50/Series 50 EGR/Series 50G',
        'M' => 'Detroit Diesel Series 50/Series 50 EGR (300hp-320hp)',
        'N' => 'Detroit Diesel Series 40/MaxxForce 9',
        'P' => 'Cummins C8.3/C8.3G/ISC/C Gas',
        'R' => 'Cummins ISB 280hp',
        'S' => 'Cummins M11/ISM',
        'T' => 'Detroit Diesel Series 60',
        'U' => 'Cummins ISL/L9 330hp',
        'V' => 'Cummins ISL/L9 250 or 280hp',
        'W' => 'Caterpillar C9',
        'X' => 'Fuel Cell',
        'Y' => 'Ford Triton V10',
        'Z' => 'John Deere 6081',
    ];

    const LENGTH = [
        'A' => 40,
        'B' => 40,
        'C' => 40,
        'D' => 40,
        'E' => 40,
        'F' => 40,
        'G' => 35,
        'H' => 35,
        'J' => 35,
        'K' => 35,
        'L' => 40,
        'M' => 60,
        'N' => 60,
        'P' => 60,
        'R' => 60,
        'S' => 35,
        'T' => 30,
        'U' => 60,
        'V' => 30,
        'W' => 45,
        'Y' => 60,
    ];

    const PROPULSION = [
        'B' => 'Electric Battery',
        'C' => 'CNG',
        'D' => 'Diesel',
        'E' => 'ETB (Electric Trolley Bus)',
        'F' => 'Fuel Cell',
        'G' => 'CNG Electric (Hybrid)',
        'H' => 'Diesel Electric (Hybrid)',
        'L' => 'LNG',
        'M' => 'Methanol',
        'U' => 'Gasoline Electric (Hybrid)',
    ];

    const SERIES = [
        '1' => 'Early High Floor',
        '2' => 'Later High Floor / Low Floor',
        '3' => 'Invero',
        '4' => 'Low Floor',
        '5' => 'LFR',
        '6' => 'High Floor',
        '7' => 'LFA',
        '8' => 'Xcelsior',
        '9' => 'Midi',
    ];
}
