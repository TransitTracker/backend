<?php

namespace Database\Vin;

class BaseData
{
    const YEARS = [
        'S' => 1995,
        'T' => 1996,
        'V' => 1997,
        'W' => 1998,
        'X' => 1999,
        'Y' => 2000,
        '1' => 2001,
        '2' => 2002,
        '3' => 2003,
        '4' => 2004,
        '5' => 2005,
        '6' => 2006,
        '7' => 2007,
        '8' => 2008,
        '9' => 2009,
        'A' => 2010,
        'B' => 2011,
        'C' => 2012,
        'D' => 2013,
        'E' => 2014,
        'F' => 2015,
        'G' => 2016,
        'H' => 2017,
        'J' => 2018,
        'K' => 2019,
        'L' => 2020,
        'M' => 2021,
        'N' => 2022,
        'P' => 2023,
        'R' => 2024,
    ];

    /**
     * List originaly based on Wikipedia
     * Original author : Anatoly Fenric
     * Link : https://github.com/sunrise-php/vin/blob/master/data/manufacturers.php
     */
    const MANUFACTURERS = [
        'AAV' => 'Volkswagen',
        'AC5' => 'Hyundai',
        'ADD' => 'Hyundai',
        'AFA' => 'Ford',
        'AHT' => 'Toyota',
        'JA3' => 'Mitsubishi',
        'JA4' => 'Mitsubishi',
        'JA'  => 'Isuzu',
        'JD'  => 'Daihatsu',
        'JF'  => 'Fuji Heavy Industries (Subaru)',
        'JH'  => 'Honda',
        'JK'  => 'Kawasaki (motorcycles)',
        'JL5' => 'Mitsubishi Fuso',
        'JMB' => 'Mitsubishi Motors',
        'JMY' => 'Mitsubishi Motors',
        'JMZ' => 'Mazda',
        'JN'  => 'Nissan',
        'JS'  => 'Suzuki',
        'JT'  => 'Toyota',
        'JY'  => 'Yamaha (motorcycles)',
        'KL'  => 'Daewoo General Motors',
        'KM'  => 'Hyundai',
        'KMY' => 'Daelim (motorcycles)',
        'KM1' => 'Hyosung (motorcycles)',
        'KN'  => 'Kia',
        'KNM' => 'Renault Samsung',
        'KPA' => 'SsangYong',
        'KPT' => 'SsangYong',
        'LAE' => 'Jinan Qingqi Motorcycle',
        'LAN' => 'Changzhou Yamasaki Motorcycle',
        'LBB' => 'Zhejiang Qianjiang Motorcycle (Keeway/Generic)',
        'LBE' => 'Beijing Hyundai',
        'LBM' => 'Zongshen Piaggio',
        'LBP' => 'Chongqing Jainshe Yamaha (motorcycles)',
        'LB2' => 'Geely Motorcycles',
        'LCE' => 'Hangzhou Chunfeng Motorcycles (CFMOTO)',
        'LDC' => 'Dong Feng Peugeot Citroen (DPCA)',
        'LDD' => 'Dandong Huanghai Automobile',
        'LDN' => 'SouEast Motor',
        'LDY' => 'Zhongtong Coach',
        'LET' => 'Jiangling-Isuzu Motors',
        'LE4' => 'Beijing Benz',
        'LFB' => 'FAW (busses)',
        'LFG' => 'Taizhou Chuanl Motorcycle Manufacturing',
        'LFP' => 'FAW (passenger vehicles)',
        'LFT' => 'FAW (trailers)',
        'LFV' => 'FAW-Volkswagen',
        'LFW' => 'FAW JieFang',
        'LFY' => 'Changshu Light Motorcycle Factory',
        'LGB' => 'Dong Feng (DFM)',
        'LGH' => 'Qoros (formerly Dong Feng (DFM))',
        'LGX' => 'BYD Auto',
        'LHB' => 'Beijing Automotive Industry Holding',
        'LH1' => 'FAW-Haima',
        'LJC' => 'JAC',
        'LJ1' => 'JAC',
        'LKL' => 'Suzhou King Long',
        'LL6' => 'Hunan Changfeng Manufacture Joint-Stock',
        'LL8' => 'Linhai (ATV)',
        'LMC' => 'Suzuki Hong Kong (motorcycles)',
        'LPR' => 'Yamaha Hong Kong (motorcycles)',
        'LSG' => 'SAIC General Motors',
        'LSJ' => 'SAIC MG',
        'LSV' => 'SAIC Volkswagen',
        'LSY' => 'Brilliance Zhonghua',
        'LTV' => 'Toyota Tian Jin',
        'LUC' => 'Guangqi Honda',
        'LVS' => 'Ford Chang An',
        'LVV' => 'Chery',
        'LVZ' => 'Dong Feng Sokon Motor Company (DFSK)',
        'LZM' => 'MAN',
        'LZE' => 'Isuzu Guangzhou',
        'LZG' => 'Shaanxi Automobile Group',
        'LZP' => 'Zhongshan Guochi Motorcycle (Baotian)',
        'LZY' => 'Yutong Zhengzhou',
        'LZZ' => 'Chongqing Shuangzing Mech & Elec (Howo)',
        'L4B' => 'Xingyue Group (motorcycles)',
        'L5C' => 'KangDi (ATV)',
        'L5K' => 'Zhejiang Yongkang Easy Vehicle',
        'L5N' => 'Zhejiang Taotao (ATV & motorcycles)',
        'L5Y' => 'Merato Motorcycle Taizhou Zhongneng',
        'L85' => 'Zhejiang Yongkang Huabao Electric Appliance',
        'L8X' => 'Zhejiang Summit Huawin Motorcycle',
        'MAB' => 'Mahindra & Mahindra',
        'MAC' => 'Mahindra & Mahindra',
        'MAJ' => 'Ford',
        'MAK' => 'Honda Siel Cars',
        'MAL' => 'Hyundai',
        'MAT' => 'Tata Motors',
        'MA1' => 'Mahindra & Mahindra',
        'MA3' => 'Suzuki (Maruti)',
        'MA6' => 'GM',
        'MA7' => 'Mitsubishi (formerly Honda)',
        'MBH' => 'Suzuki (Maruti)',
        'MBJ' => 'Toyota',
        'MBR' => 'Mercedes-Benz',
        'MB1' => 'Ashok Leyland',
        'MCA' => 'Fiat',
        'MCB' => 'GM',
        'MC2' => 'Volvo Eicher commercial vehicles limited.',
        'MDH' => 'Nissan',
        'MD2' => 'Bajaj Auto',
        'MD9' => 'Shuttle Cars',
        'MEE' => 'Renault',
        'MEX' => 'Volkswagen',
        'MHF' => 'Toyota',
        'MHR' => 'Honda',
        'MLC' => 'Suzuki',
        'MLH' => 'Honda',
        'MMB' => 'Mitsubishi',
        'MMC' => 'Mitsubishi',
        'MMM' => 'Chevrolet',
        'MMS' => 'Suzuki',
        'MMT' => 'Mitsubishi',
        'MM8' => 'Mazda',
        'MNB' => 'Ford',
        'MNT' => 'Nissan',
        'MPA' => 'Isuzu',
        'MP1' => 'Isuzu',
        'MRH' => 'Honda',
        'MR0' => 'Toyota',
        'MS0' => 'KIA',
        'MS3' => 'Suzuki Motor Co., Ltd.',
        'NLA' => 'Honda',
        'NLE' => 'Mercedes-Benz Truck',
        'NLH' => 'Hyundai Assan',
        'NLT' => 'TEMSA',
        'NMB' => 'Mercedes-Benz Buses',
        'NMC' => 'BMC',
        'NM0' => 'Ford',
        'NM4' => 'Tofaş',
        'NMT' => 'Toyota',
        'NNA' => 'Isuzu',
        'PE1' => 'Ford',
        'PE3' => 'Mazda',
        'PL1' => 'Proton',
        'PNA' => 'NAZA (Peugeot)',
        'R1N' => 'NIU',
        'RA1' => 'Steyr Trucks International FZE',
        'RFB' => 'Kymco',
        'RFG' => 'Sanyang SYM',
        'RFL' => 'Adly',
        'RFT' => 'CPI',
        'RF3' => 'Aeon Motor',
        'RL0' => 'Ford',
        'RL1' => 'Suzuki',
        'RL2' => 'Ford',
        'RL3' => 'Ford',
        'RL4' => 'Toyota',
        'RL5' => 'Lifan',
        'RL6' => 'Piaggio',
        'RL8' => 'Lifan',
        'RLA' => 'Mitsubishi',
        'RLC' => 'Yamaha',
        'RLD' => 'Isuzu',
        'RLE' => 'Isuzu',
        'RLF' => 'BMW',
        'RLG' => 'SYM',
        'RLH' => 'Honda',
        'RLM' => 'Mercedes-Benz',
        'RLS' => 'Suzuki',
        'RP8' => 'Piaggio',
        'SAD' => 'Jaguar (F-Pace)',
        'SAL' => 'Land Rover',
        'SAJ' => 'Jaguar',
        'SAR' => 'Rover',
        'SB1' => 'Toyota',
        'SBM' => 'McLaren',
        'SCA' => 'Rolls Royce',
        'SCB' => 'Bentley',
        'SCC' => 'Lotus Cars',
        'SCE' => 'DeLorean Motor Cars N. Ireland',
        'SCF' => 'Aston',
        'SDB' => 'Peugeot (formerly Talbot)',
        'SED' => 'General Motors Luton Plant',
        'SEY' => 'LDV',
        'SFA' => 'Ford',
        'SFD' => 'Alexander Dennis',
        'SHH' => 'Honda',
        'SHS' => 'Honda',
        'SJN' => 'Nissan',
        'SKF' => 'Vauxhall',
        'SLP' => 'JCB Research',
        'SMT' => 'Triumph Motorcycles',
        'SUF' => 'Fiat Auto',
        'SUL' => 'FSC',
        'SUP' => 'FSO-Daewoo',
        'SUU' => 'Solaris Bus & Coach',
        'SWV' => 'TA-NO',
        'TCC' => 'Micro Compact Car AG (smart 1998-1999)',
        'TDM' => 'QUANTYA Swiss Electric Movement',
        'TK9' => 'SOR buses',
        'TMA' => 'Hyundai Motor Manufacturing',
        'TMB' => 'Škoda',
        'TMK' => 'Karosa',
        'TMP' => 'Škoda trolleybuses',
        'TMT' => 'Tatra',
        'TM9' => 'Škoda trolleybuses',
        'TNE' => 'TAZ',
        'TN9' => 'Karosa',
        'TRA' => 'Ikarus Bus',
        'TRU' => 'Audi',
        'TSE' => 'Ikarus Egyedi Autobuszgyar',
        'TSM' => 'Suzuki',
        'TW1' => 'Toyota Caetano',
        'TYA' => 'Mitsubishi Trucks',
        'TYB' => 'Mitsubishi Trucks',
        'UU1' => 'Renault Dacia',
        'UU3' => 'ARO',
        'UU6' => 'Daewoo',
        'U5Y' => 'Kia Motors',
        'U6Y' => 'Kia Motors',
        'VAG' => 'Magna Steyr Puch',
        'VAN' => 'MAN',
        'VBK' => 'KTM (Motorcycles)',
        'VF1' => 'Renault',
        'VF2' => 'Renault',
        'VF3' => 'Peugeot',
        'VF4' => 'Talbot',
        'VF6' => 'Renault (Trucks & Buses)',
        'VF7' => 'Citroën',
        'VF8' => 'Matra',
        'VF9' => 'Bugatti',
        '795' => 'Bugatti',
        'VG5' => 'MBK (motorcycles)',
        'VLU' => 'Scania',
        'VN1' => 'SOVAB',
        'VNE' => 'Irisbus',
        'VNK' => 'Toyota',
        'VNV' => 'Renault-Nissan',
        'VSA' => 'Mercedes-Benz',
        'VSE' => 'Suzuki (Santana Motors)',
        'VSK' => 'Nissan',
        'VSS' => 'SEAT',
        'VSX' => 'Opel',
        'VS6' => 'Ford',
        'VS7' => 'Citroën',
        'VS9' => 'Carrocerias Ayats',
        'VTH' => 'Derbi (motorcycles)',
        'VTL' => 'Yamaha (motorcycles)',
        'VTT' => 'Suzuki (motorcycles)',
        'VV9' => 'TAURO',
        'VWA' => 'Nissan',
        'VWV' => 'Volkswagen',
        'VX1' => 'Zastava / Yugo Serbia',
        'WAG' => 'Neoplan',
        'WAU' => 'Audi',
        'WA1' => 'Audi SUV',
        'WBA' => 'BMW',
        'WBS' => 'BMW M',
        'WBW' => 'BMW',
        'WBY' => 'BMW',
        'WDA' => 'Daimler',
        'WDB' => 'Mercedes-Benz',
        'WDC' => 'DaimlerChrysler',
        'WDD' => 'Mercedes-Benz',
        'WDF' => 'Mercedes-Benz (commercial vehicles)',
        'WEB' => 'Evobus GmbH (Mercedes-Bus)',
        'WJM' => 'Iveco Magirus',
        'WF0' => 'Ford',
        'WKE' => 'Fahrzeugwerk Bernard Krone GmbH & Co. KG',
        'WKK' => 'Kässbohrer/Setra',
        'WMA' => 'MAN',
        'WME' => 'smart',
        'WMW' => 'MINI',
        'WMX' => 'Mercedes-AMG',
        'WP0' => 'Porsche',
        'WP1' => 'Porsche SUV',
        'W09' => 'RUF',
        'W0L' => 'Opel',
        'W0V' => 'Opel',
        'WUA' => 'quattro GmbH',
        'WVG' => 'Volkswagen MPV/SUV',
        'WVW' => 'Volkswagen',
        'WV1' => 'Volkswagen Commercial Vehicles',
        'WV2' => 'Volkswagen Bus/Van',
        'WV3' => 'Volkswagen Trucks',
        'XLB' => 'Volvo (NedCar)',
        'XLE' => 'Scania',
        'XLR' => 'DAF (trucks)',
        'XL9' => 'Spyker',
        '363' => 'Spyker',
        'XMC' => 'Mitsubishi (NedCar)',
        'XTA' => 'Lada/AvtoVAZ',
        'XTC' => 'KAMAZ',
        'XTH' => 'GAZ',
        'XTT' => 'UAZ/Sollers',
        'XTY' => 'LiAZ',
        'XUF' => 'General Motors',
        'XUU' => 'AvtoTor (General Motors SKD)',
        'XW8' => 'Volkswagen Group',
        'XWB' => 'UZ-Daewoo',
        'XWE' => 'AvtoTor (Hyundai-Kia SKD)',
        'X1M' => 'PAZ',
        'X4X' => 'AvtoTor (BMW SKD)',
        'X7L' => 'Renault AvtoFramos',
        'X7M' => 'Hyundai TagAZ',
        'YBW' => 'Volkswagen',
        'YB1' => 'Volvo Trucks',
        'YCM' => 'Mazda',
        'YE2' => 'Van Hool (buses)',
        'YH2' => 'BRP (Lynx snowmobiles)',
        'YK1' => 'Saab-Valmet',
        'YS2' => 'Scania AB',
        'YS3' => 'Saab',
        'YS4' => 'Scania Bus',
        'YTN' => 'Saab NEVS',
        'YT9' => 'Koenigsegg',
        '007' => 'Koenigsegg',
        '034' => 'Carvia',
        'YU7' => 'Husaberg (motorcycles)',
        'YV1' => 'Volvo Cars',
        'YV4' => 'Volvo Cars',
        'YV2' => 'Volvo Trucks',
        'YV3' => 'Volvo Buses',
        'Y3M' => 'MAZ',
        'Y6D' => 'Zaporozhets/AvtoZAZ',
        'ZAA' => 'Autobianchi',
        'ZAM' => 'Maserati',
        'ZAP' => 'Piaggio/Vespa/Gilera',
        'ZAR' => 'Alfa Romeo',
        'ZBN' => 'Benelli',
        'ZCG' => 'Cagiva SpA / MV Agusta',
        'ZCF' => 'Iveco',
        'ZDM' => 'Ducati Motor Holdings SpA',
        'ZDF' => 'Ferrari Dino',
        'ZD0' => 'Yamaha',
        'ZD3' => 'Beta Motor',
        'ZD4' => 'Aprilia',
        'ZFA' => 'Fiat',
        'ZFC' => 'Fiat V.I.',
        'ZFF' => 'Ferrari',
        'ZGU' => 'Moto Guzzi',
        'ZHW' => 'Lamborghini',
        'ZJM' => 'Malaguti',
        'ZJN' => 'Innocenti',
        'ZKH' => 'Husqvarna Motorcycles',
        'ZLA' => 'Lancia',
        'ZOM' => 'OM',
        'Z8M' => 'Marussia',
        '1B3' => 'Dodge',
        '1C3' => 'Chrysler',
        '1C4' => 'Chrysler',
        '1C6' => 'Chrysler',
        '1D3' => 'Dodge',
        '1FA' => 'Ford Motor Company',
        '1FB' => 'Ford Motor Company',
        '1FC' => 'Ford Motor Company',
        '1FD' => 'Ford Motor Company',
        '1FM' => 'Ford Motor Company',
        '1FT' => 'Ford Motor Company',
        '1FU' => 'Freightliner',
        '1FV' => 'Freightliner',
        '1F9' => 'FWD Corp.',
        '1G'  => 'General Motors',
        '1GC' => 'Chevrolet Truck',
        '1GT' => 'GMC Truck',
        '1G1' => 'Chevrolet',
        '1G2' => 'Pontiac',
        '1G3' => 'Oldsmobile',
        '1G4' => 'Buick',
        '1G6' => 'Cadillac',
        '1G8' => 'Saturn',
        '1GM' => 'Pontiac',
        '1GY' => 'Cadillac',
        '1H'  => 'Honda',
        '1HD' => 'Harley-Davidson',
        '1J4' => 'Jeep',
        '1J8' => 'Jeep',
        '1L'  => 'Lincoln',
        '1ME' => 'Mercury',
        '1M1' => 'Mack Truck',
        '1M2' => 'Mack Truck',
        '1M3' => 'Mack Truck',
        '1M4' => 'Mack Truck',
        '1M9' => 'Mynatt Truck & Equipment',
        '1N'  => 'Nissan',
        '1NX' => 'NUMMI',
        '1P3' => 'Plymouth',
        '1R9' => 'Roadrunner Hay Squeeze',
        '1VW' => 'Volkswagen',
        '1XK' => 'Kenworth',
        '1XP' => 'Peterbilt',
        '1YV' => 'Mazda (AutoAlliance International)',
        '1ZV' => 'Ford (AutoAlliance International)',
        '2A4' => 'Chrysler',
        '2BP' => 'Bombardier Recreational Products',
        '2B3' => 'Dodge',
        '2B7' => 'Dodge',
        '2C3' => 'Chrysler',
        '2CN' => 'CAMI',
        '2D3' => 'Dodge',
        '2FA' => 'Ford Motor Company',
        '2FB' => 'Ford Motor Company',
        '2FC' => 'Ford Motor Company',
        '2FM' => 'Ford Motor Company',
        '2FT' => 'Ford Motor Company',
        '2FU' => 'Freightliner',
        '2FV' => 'Freightliner',
        '2FZ' => 'Sterling',
        '2Gx' => 'General Motors',
        '2G1' => 'Chevrolet',
        '2G2' => 'Pontiac',
        '2G3' => 'Oldsmobile',
        '2G4' => 'Buick',
        '2G9' => 'Gnome Homes',
        '2HG' => 'Honda',
        '2HK' => 'Honda',
        '2HJ' => 'Honda',
        '2HM' => 'Hyundai',
        '2M'  => 'Mercury',
        '2NV' => 'Nova Bus',
        '2P3' => 'Plymouth',
        '2T'  => 'Toyota',
        '2TP' => 'Triple E LTD',
        '2V4' => 'Volkswagen',
        '2V8' => 'Volkswagen',
        '2WK' => 'Western Star',
        '2WL' => 'Western Star',
        '2WM' => 'Western Star',
        '3C4' => 'Chrysler',
        '3D3' => 'Dodge',
        '3D4' => 'Dodge',
        '3FA' => 'Ford Motor Company',
        '3FE' => 'Ford Motor Company',
        '3G'  => 'General Motors',
        '3H'  => 'Honda',
        '3JB' => 'BRP (all-terrain vehicles)',
        '3MD' => 'Mazda',
        '3MZ' => 'Mazda',
        '3N'  => 'Nissan',
        '3P3' => 'Plymouth',
        '3VW' => 'Volkswagen',
        '4F'  => 'Mazda',
        '4JG' => 'Mercedes-Benz',
        '4M'  => 'Mercury',
        '4RK' => 'Nova Bus',
        '4S'  => 'Subaru-Isuzu Automotive',
        '4T'  => 'Toyota',
        '4T9' => 'Lumen Motors',
        '4UF' => 'Arctic Cat Inc.',
        '4US' => 'BMW',
        '4UZ' => 'Frt-Thomas Bus',
        '4V1' => 'Volvo',
        '4V2' => 'Volvo',
        '4V3' => 'Volvo',
        '4V4' => 'Volvo',
        '4V5' => 'Volvo',
        '4V6' => 'Volvo',
        '4VL' => 'Volvo',
        '4VM' => 'Volvo',
        '4VZ' => 'Volvo',
        '538' => 'Zero Motorcycles',
        '5F'  => 'Honda Alabama',
        '5J'  => 'Honda Ohio',
        '5L'  => 'Lincoln',
        '5N1' => 'Nissan',
        '5NP' => 'Hyundai',
        '5T'  => 'Toyota - trucks',
        '5YJ' => 'Tesla, Inc.',
        '6AB' => 'MAN',
        '6F4' => 'Nissan Motor Company',
        '6F5' => 'Kenworth',
        '6FP' => 'Ford Motor Company',
        '6G1' => 'General Motors-Holden (post Nov 2002)',
        '6G2' => 'Pontiac (GTO & G8)',
        '6H8' => 'General Motors-Holden (pre Nov 2002)',
        '6MM' => 'Mitsubishi Motors',
        '6T1' => 'Toyota Motor Corporation',
        '6U9' => 'Privately Imported car',
        '8AD' => 'Peugeot',
        '8AF' => 'Ford Motor Company',
        '8AG' => 'Chevrolet',
        '8AJ' => 'Toyota',
        '8AK' => 'Suzuki',
        '8AP' => 'Fiat',
        '8AW' => 'Volkswagen',
        '8A1' => 'Renault',
        '8GD' => 'Peugeot',
        '8GG' => 'Chevrolet',
        '935' => 'Citroën',
        '936' => 'Peugeot',
        '93H' => 'Honda',
        '93R' => 'Toyota',
        '93U' => 'Audi',
        '93V' => 'Audi',
        '93X' => 'Mitsubishi Motors',
        '93Y' => 'Renault',
        '94D' => 'Nissan',
        '9BD' => 'Fiat',
        '9BF' => 'Ford Motor Company',
        '9BG' => 'Chevrolet',
        '9BM' => 'Mercedes-Benz',
        '9BR' => 'Toyota',
        '9BS' => 'Scania',
        '9BW' => 'Volkswagen',
        '9FB' => 'Renault',
        'WB1' => 'BMW Motorrad of North America',

        /**
         * @see https://github.com/sunrise-php/vin/issues/70
         */
        'W1K' => 'Mercedes',
        'W1V' => 'Mercedes',
        'W1N' => 'Mercedes',
        'WAP' => 'BMW',
        'YAR' => 'Toyota',

        /**
         * Extra added for Transit Tracker
         */
        '15G' => 'Gillig',
        '1BA' => 'Blue Bird',
        '1M8' => 'Motor Coach Industries',
        '1N9' => 'NABI',
        '2MG' => 'Motor Coach Industries',
        '1GB' => 'Chevrolet',
        '2M9' => 'Motor Coach Industries',
        '2PC' => 'Prevost Car',
        '1GD' => 'GMC',
    ];
}
