<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencyListTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currency_list')->delete();
        
        \DB::table('currency_list')->insert(array (
            0 => 
            array (
                'id' => 1,
                'country' => 'Albania',
                'currency_list' => 'Leke',
                'code' => 'ALL',
                'symbol' => 'Lek',
            ),
            1 => 
            array (
                'id' => 2,
                'country' => 'America',
                'currency_list' => 'Dollars',
                'code' => 'USD',
                'symbol' => '$',
            ),
            2 => 
            array (
                'id' => 3,
                'country' => 'Afghanistan',
                'currency_list' => 'Afghanis',
                'code' => 'AFN',
                'symbol' => '?',
            ),
            3 => 
            array (
                'id' => 4,
                'country' => 'Argentina',
                'currency_list' => 'Pesos',
                'code' => 'ARS',
                'symbol' => '$',
            ),
            4 => 
            array (
                'id' => 5,
                'country' => 'Aruba',
                'currency_list' => 'Guilders',
                'code' => 'AWG',
                'symbol' => 'ƒ',
            ),
            5 => 
            array (
                'id' => 6,
                'country' => 'Australia',
                'currency_list' => 'Dollars',
                'code' => 'AUD',
                'symbol' => '$',
            ),
            6 => 
            array (
                'id' => 7,
                'country' => 'Azerbaijan',
                'currency_list' => 'New Manats',
                'code' => 'AZN',
                'symbol' => '???',
            ),
            7 => 
            array (
                'id' => 8,
                'country' => 'Bahamas',
                'currency_list' => 'Dollars',
                'code' => 'BSD',
                'symbol' => '$',
            ),
            8 => 
            array (
                'id' => 9,
                'country' => 'Barbados',
                'currency_list' => 'Dollars',
                'code' => 'BBD',
                'symbol' => '$',
            ),
            9 => 
            array (
                'id' => 10,
                'country' => 'Belarus',
                'currency_list' => 'Rubles',
                'code' => 'BYR',
                'symbol' => 'p.',
            ),
            10 => 
            array (
                'id' => 11,
                'country' => 'Belgium',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            11 => 
            array (
                'id' => 12,
                'country' => 'Beliz',
                'currency_list' => 'Dollars',
                'code' => 'BZD',
                'symbol' => 'BZ$',
            ),
            12 => 
            array (
                'id' => 13,
                'country' => 'Bermuda',
                'currency_list' => 'Dollars',
                'code' => 'BMD',
                'symbol' => '$',
            ),
            13 => 
            array (
                'id' => 14,
                'country' => 'Bolivia',
                'currency_list' => 'Bolivianos',
                'code' => 'BOB',
                'symbol' => '$b',
            ),
            14 => 
            array (
                'id' => 15,
                'country' => 'Bosnia and Herzegovina',
                'currency_list' => 'Convertible Marka',
                'code' => 'BAM',
                'symbol' => 'KM',
            ),
            15 => 
            array (
                'id' => 16,
                'country' => 'Botswana',
                'currency_list' => 'Pula',
                'code' => 'BWP',
                'symbol' => 'P',
            ),
            16 => 
            array (
                'id' => 17,
                'country' => 'Bulgaria',
                'currency_list' => 'Leva',
                'code' => 'BGN',
                'symbol' => '??',
            ),
            17 => 
            array (
                'id' => 18,
                'country' => 'Brazil',
                'currency_list' => 'Reais',
                'code' => 'BRL',
                'symbol' => 'R$',
            ),
            18 => 
            array (
                'id' => 19,
            'country' => 'Britain (United Kingdom)',
                'currency_list' => 'Pounds',
                'code' => 'GBP',
                'symbol' => '£',
            ),
            19 => 
            array (
                'id' => 20,
                'country' => 'Brunei Darussalam',
                'currency_list' => 'Dollars',
                'code' => 'BND',
                'symbol' => '$',
            ),
            20 => 
            array (
                'id' => 21,
                'country' => 'Cambodia',
                'currency_list' => 'Riels',
                'code' => 'KHR',
                'symbol' => '?',
            ),
            21 => 
            array (
                'id' => 22,
                'country' => 'Canada',
                'currency_list' => 'Dollars',
                'code' => 'CAD',
                'symbol' => '$',
            ),
            22 => 
            array (
                'id' => 23,
                'country' => 'Cayman Islands',
                'currency_list' => 'Dollars',
                'code' => 'KYD',
                'symbol' => '$',
            ),
            23 => 
            array (
                'id' => 24,
                'country' => 'Chile',
                'currency_list' => 'Pesos',
                'code' => 'CLP',
                'symbol' => '$',
            ),
            24 => 
            array (
                'id' => 25,
                'country' => 'China',
                'currency_list' => 'Yuan Renminbi',
                'code' => 'CNY',
                'symbol' => '¥',
            ),
            25 => 
            array (
                'id' => 26,
                'country' => 'Colombia',
                'currency_list' => 'Pesos',
                'code' => 'COP',
                'symbol' => '$',
            ),
            26 => 
            array (
                'id' => 27,
                'country' => 'Costa Rica',
                'currency_list' => 'Colón',
                'code' => 'CRC',
                'symbol' => '?',
            ),
            27 => 
            array (
                'id' => 28,
                'country' => 'Croatia',
                'currency_list' => 'Kuna',
                'code' => 'HRK',
                'symbol' => 'kn',
            ),
            28 => 
            array (
                'id' => 29,
                'country' => 'Cuba',
                'currency_list' => 'Pesos',
                'code' => 'CUP',
                'symbol' => '?',
            ),
            29 => 
            array (
                'id' => 30,
                'country' => 'Cyprus',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            30 => 
            array (
                'id' => 31,
                'country' => 'Czech Republic',
                'currency_list' => 'Koruny',
                'code' => 'CZK',
                'symbol' => 'K?',
            ),
            31 => 
            array (
                'id' => 32,
                'country' => 'Denmark',
                'currency_list' => 'Kroner',
                'code' => 'DKK',
                'symbol' => 'kr',
            ),
            32 => 
            array (
                'id' => 33,
                'country' => 'Dominican Republic',
                'currency_list' => 'Pesos',
                'code' => 'DOP ',
                'symbol' => 'RD$',
            ),
            33 => 
            array (
                'id' => 34,
                'country' => 'East Caribbean',
                'currency_list' => 'Dollars',
                'code' => 'XCD',
                'symbol' => '$',
            ),
            34 => 
            array (
                'id' => 35,
                'country' => 'Egypt',
                'currency_list' => 'Pounds',
                'code' => 'EGP',
                'symbol' => '£',
            ),
            35 => 
            array (
                'id' => 36,
                'country' => 'El Salvador',
                'currency_list' => 'Colones',
                'code' => 'SVC',
                'symbol' => '$',
            ),
            36 => 
            array (
                'id' => 37,
            'country' => 'England (United Kingdom)',
                'currency_list' => 'Pounds',
                'code' => 'GBP',
                'symbol' => '£',
            ),
            37 => 
            array (
                'id' => 38,
                'country' => 'Euro',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            38 => 
            array (
                'id' => 39,
                'country' => 'Falkland Islands',
                'currency_list' => 'Pounds',
                'code' => 'FKP',
                'symbol' => '£',
            ),
            39 => 
            array (
                'id' => 40,
                'country' => 'Fiji',
                'currency_list' => 'Dollars',
                'code' => 'FJD',
                'symbol' => '$',
            ),
            40 => 
            array (
                'id' => 41,
                'country' => 'France',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            41 => 
            array (
                'id' => 42,
                'country' => 'Ghana',
                'currency_list' => 'Cedis',
                'code' => 'GHC',
                'symbol' => '¢',
            ),
            42 => 
            array (
                'id' => 43,
                'country' => 'Gibraltar',
                'currency_list' => 'Pounds',
                'code' => 'GIP',
                'symbol' => '£',
            ),
            43 => 
            array (
                'id' => 44,
                'country' => 'Greece',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            44 => 
            array (
                'id' => 45,
                'country' => 'Guatemala',
                'currency_list' => 'Quetzales',
                'code' => 'GTQ',
                'symbol' => 'Q',
            ),
            45 => 
            array (
                'id' => 46,
                'country' => 'Guernsey',
                'currency_list' => 'Pounds',
                'code' => 'GGP',
                'symbol' => '£',
            ),
            46 => 
            array (
                'id' => 47,
                'country' => 'Guyana',
                'currency_list' => 'Dollars',
                'code' => 'GYD',
                'symbol' => '$',
            ),
            47 => 
            array (
                'id' => 48,
            'country' => 'Holland (Netherlands)',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            48 => 
            array (
                'id' => 49,
                'country' => 'Honduras',
                'currency_list' => 'Lempiras',
                'code' => 'HNL',
                'symbol' => 'L',
            ),
            49 => 
            array (
                'id' => 50,
                'country' => 'Hong Kong',
                'currency_list' => 'Dollars',
                'code' => 'HKD',
                'symbol' => '$',
            ),
            50 => 
            array (
                'id' => 51,
                'country' => 'Hungary',
                'currency_list' => 'Forint',
                'code' => 'HUF',
                'symbol' => 'Ft',
            ),
            51 => 
            array (
                'id' => 52,
                'country' => 'Iceland',
                'currency_list' => 'Kronur',
                'code' => 'ISK',
                'symbol' => 'kr',
            ),
            52 => 
            array (
                'id' => 53,
                'country' => 'India',
                'currency_list' => 'Rupees',
                'code' => 'INR',
                'symbol' => 'Rp',
            ),
            53 => 
            array (
                'id' => 54,
                'country' => 'Indonesia',
                'currency_list' => 'Rupiahs',
                'code' => 'IDR',
                'symbol' => 'Rp',
            ),
            54 => 
            array (
                'id' => 55,
                'country' => 'Iran',
                'currency_list' => 'Rials',
                'code' => 'IRR',
                'symbol' => '?',
            ),
            55 => 
            array (
                'id' => 56,
                'country' => 'Ireland',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            56 => 
            array (
                'id' => 57,
                'country' => 'Isle of Man',
                'currency_list' => 'Pounds',
                'code' => 'IMP',
                'symbol' => '£',
            ),
            57 => 
            array (
                'id' => 58,
                'country' => 'Israel',
                'currency_list' => 'New Shekels',
                'code' => 'ILS',
                'symbol' => '?',
            ),
            58 => 
            array (
                'id' => 59,
                'country' => 'Italy',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            59 => 
            array (
                'id' => 60,
                'country' => 'Jamaica',
                'currency_list' => 'Dollars',
                'code' => 'JMD',
                'symbol' => 'J$',
            ),
            60 => 
            array (
                'id' => 61,
                'country' => 'Japan',
                'currency_list' => 'Yen',
                'code' => 'JPY',
                'symbol' => '¥',
            ),
            61 => 
            array (
                'id' => 62,
                'country' => 'Jersey',
                'currency_list' => 'Pounds',
                'code' => 'JEP',
                'symbol' => '£',
            ),
            62 => 
            array (
                'id' => 63,
                'country' => 'Kazakhstan',
                'currency_list' => 'Tenge',
                'code' => 'KZT',
                'symbol' => '??',
            ),
            63 => 
            array (
                'id' => 64,
            'country' => 'Korea (North)',
                'currency_list' => 'Won',
                'code' => 'KPW',
                'symbol' => '?',
            ),
            64 => 
            array (
                'id' => 65,
            'country' => 'Korea (South)',
                'currency_list' => 'Won',
                'code' => 'KRW',
                'symbol' => '?',
            ),
            65 => 
            array (
                'id' => 66,
                'country' => 'Kyrgyzstan',
                'currency_list' => 'Soms',
                'code' => 'KGS',
                'symbol' => '??',
            ),
            66 => 
            array (
                'id' => 67,
                'country' => 'Laos',
                'currency_list' => 'Kips',
                'code' => 'LAK',
                'symbol' => '?',
            ),
            67 => 
            array (
                'id' => 68,
                'country' => 'Latvia',
                'currency_list' => 'Lati',
                'code' => 'LVL',
                'symbol' => 'Ls',
            ),
            68 => 
            array (
                'id' => 69,
                'country' => 'Lebanon',
                'currency_list' => 'Pounds',
                'code' => 'LBP',
                'symbol' => '£',
            ),
            69 => 
            array (
                'id' => 70,
                'country' => 'Liberia',
                'currency_list' => 'Dollars',
                'code' => 'LRD',
                'symbol' => '$',
            ),
            70 => 
            array (
                'id' => 71,
                'country' => 'Liechtenstein',
                'currency_list' => 'Switzerland Francs',
                'code' => 'CHF',
                'symbol' => 'CHF',
            ),
            71 => 
            array (
                'id' => 72,
                'country' => 'Lithuania',
                'currency_list' => 'Litai',
                'code' => 'LTL',
                'symbol' => 'Lt',
            ),
            72 => 
            array (
                'id' => 73,
                'country' => 'Luxembourg',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            73 => 
            array (
                'id' => 74,
                'country' => 'Macedonia',
                'currency_list' => 'Denars',
                'code' => 'MKD',
                'symbol' => '???',
            ),
            74 => 
            array (
                'id' => 75,
                'country' => 'Malaysia',
                'currency_list' => 'Ringgits',
                'code' => 'MYR',
                'symbol' => 'RM',
            ),
            75 => 
            array (
                'id' => 76,
                'country' => 'Malta',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            76 => 
            array (
                'id' => 77,
                'country' => 'Mauritius',
                'currency_list' => 'Rupees',
                'code' => 'MUR',
                'symbol' => '?',
            ),
            77 => 
            array (
                'id' => 78,
                'country' => 'Mexico',
                'currency_list' => 'Pesos',
                'code' => 'MXN',
                'symbol' => '$',
            ),
            78 => 
            array (
                'id' => 79,
                'country' => 'Mongolia',
                'currency_list' => 'Tugriks',
                'code' => 'MNT',
                'symbol' => '?',
            ),
            79 => 
            array (
                'id' => 80,
                'country' => 'Mozambique',
                'currency_list' => 'Meticais',
                'code' => 'MZN',
                'symbol' => 'MT',
            ),
            80 => 
            array (
                'id' => 81,
                'country' => 'Namibia',
                'currency_list' => 'Dollars',
                'code' => 'NAD',
                'symbol' => '$',
            ),
            81 => 
            array (
                'id' => 82,
                'country' => 'Nepal',
                'currency_list' => 'Rupees',
                'code' => 'NPR',
                'symbol' => '?',
            ),
            82 => 
            array (
                'id' => 83,
                'country' => 'Netherlands Antilles',
                'currency_list' => 'Guilders',
                'code' => 'ANG',
                'symbol' => 'ƒ',
            ),
            83 => 
            array (
                'id' => 84,
                'country' => 'Netherlands',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            84 => 
            array (
                'id' => 85,
                'country' => 'New Zealand',
                'currency_list' => 'Dollars',
                'code' => 'NZD',
                'symbol' => '$',
            ),
            85 => 
            array (
                'id' => 86,
                'country' => 'Nicaragua',
                'currency_list' => 'Cordobas',
                'code' => 'NIO',
                'symbol' => 'C$',
            ),
            86 => 
            array (
                'id' => 87,
                'country' => 'Nigeria',
                'currency_list' => 'Nairas',
                'code' => 'NGN',
                'symbol' => '?',
            ),
            87 => 
            array (
                'id' => 88,
                'country' => 'North Korea',
                'currency_list' => 'Won',
                'code' => 'KPW',
                'symbol' => '?',
            ),
            88 => 
            array (
                'id' => 89,
                'country' => 'Norway',
                'currency_list' => 'Krone',
                'code' => 'NOK',
                'symbol' => 'kr',
            ),
            89 => 
            array (
                'id' => 90,
                'country' => 'Oman',
                'currency_list' => 'Rials',
                'code' => 'OMR',
                'symbol' => '?',
            ),
            90 => 
            array (
                'id' => 91,
                'country' => 'Pakistan',
                'currency_list' => 'Rupees',
                'code' => 'PKR',
                'symbol' => '?',
            ),
            91 => 
            array (
                'id' => 92,
                'country' => 'Panama',
                'currency_list' => 'Balboa',
                'code' => 'PAB',
                'symbol' => 'B/.',
            ),
            92 => 
            array (
                'id' => 93,
                'country' => 'Paraguay',
                'currency_list' => 'Guarani',
                'code' => 'PYG',
                'symbol' => 'Gs',
            ),
            93 => 
            array (
                'id' => 94,
                'country' => 'Peru',
                'currency_list' => 'Nuevos Soles',
                'code' => 'PEN',
                'symbol' => 'S/.',
            ),
            94 => 
            array (
                'id' => 95,
                'country' => 'Philippines',
                'currency_list' => 'Pesos',
                'code' => 'PHP',
                'symbol' => 'Php',
            ),
            95 => 
            array (
                'id' => 96,
                'country' => 'Poland',
                'currency_list' => 'Zlotych',
                'code' => 'PLN',
                'symbol' => 'z?',
            ),
            96 => 
            array (
                'id' => 97,
                'country' => 'Qatar',
                'currency_list' => 'Rials',
                'code' => 'QAR',
                'symbol' => '?',
            ),
            97 => 
            array (
                'id' => 98,
                'country' => 'Romania',
                'currency_list' => 'New Lei',
                'code' => 'RON',
                'symbol' => 'lei',
            ),
            98 => 
            array (
                'id' => 99,
                'country' => 'Russia',
                'currency_list' => 'Rubles',
                'code' => 'RUB',
                'symbol' => '???',
            ),
            99 => 
            array (
                'id' => 100,
                'country' => 'Saint Helena',
                'currency_list' => 'Pounds',
                'code' => 'SHP',
                'symbol' => '£',
            ),
            100 => 
            array (
                'id' => 101,
                'country' => 'Saudi Arabia',
                'currency_list' => 'Riyals',
                'code' => 'SAR',
                'symbol' => '?',
            ),
            101 => 
            array (
                'id' => 102,
                'country' => 'Serbia',
                'currency_list' => 'Dinars',
                'code' => 'RSD',
                'symbol' => '???.',
            ),
            102 => 
            array (
                'id' => 103,
                'country' => 'Seychelles',
                'currency_list' => 'Rupees',
                'code' => 'SCR',
                'symbol' => '?',
            ),
            103 => 
            array (
                'id' => 104,
                'country' => 'Singapore',
                'currency_list' => 'Dollars',
                'code' => 'SGD',
                'symbol' => '$',
            ),
            104 => 
            array (
                'id' => 105,
                'country' => 'Slovenia',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            105 => 
            array (
                'id' => 106,
                'country' => 'Solomon Islands',
                'currency_list' => 'Dollars',
                'code' => 'SBD',
                'symbol' => '$',
            ),
            106 => 
            array (
                'id' => 107,
                'country' => 'Somalia',
                'currency_list' => 'Shillings',
                'code' => 'SOS',
                'symbol' => 'S',
            ),
            107 => 
            array (
                'id' => 108,
                'country' => 'South Africa',
                'currency_list' => 'Rand',
                'code' => 'ZAR',
                'symbol' => 'R',
            ),
            108 => 
            array (
                'id' => 109,
                'country' => 'South Korea',
                'currency_list' => 'Won',
                'code' => 'KRW',
                'symbol' => '?',
            ),
            109 => 
            array (
                'id' => 110,
                'country' => 'Spain',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            110 => 
            array (
                'id' => 111,
                'country' => 'Sri Lanka',
                'currency_list' => 'Rupees',
                'code' => 'LKR',
                'symbol' => '?',
            ),
            111 => 
            array (
                'id' => 112,
                'country' => 'Sweden',
                'currency_list' => 'Kronor',
                'code' => 'SEK',
                'symbol' => 'kr',
            ),
            112 => 
            array (
                'id' => 113,
                'country' => 'Switzerland',
                'currency_list' => 'Francs',
                'code' => 'CHF',
                'symbol' => 'CHF',
            ),
            113 => 
            array (
                'id' => 114,
                'country' => 'Suriname',
                'currency_list' => 'Dollars',
                'code' => 'SRD',
                'symbol' => '$',
            ),
            114 => 
            array (
                'id' => 115,
                'country' => 'Syria',
                'currency_list' => 'Pounds',
                'code' => 'SYP',
                'symbol' => '£',
            ),
            115 => 
            array (
                'id' => 116,
                'country' => 'Taiwan',
                'currency_list' => 'New Dollars',
                'code' => 'TWD',
                'symbol' => 'NT$',
            ),
            116 => 
            array (
                'id' => 117,
                'country' => 'Thailand',
                'currency_list' => 'Baht',
                'code' => 'THB',
                'symbol' => '?',
            ),
            117 => 
            array (
                'id' => 118,
                'country' => 'Trinidad and Tobago',
                'currency_list' => 'Dollars',
                'code' => 'TTD',
                'symbol' => 'TT$',
            ),
            118 => 
            array (
                'id' => 119,
                'country' => 'Turkey',
                'currency_list' => 'Lira',
                'code' => 'TRY',
                'symbol' => 'TL',
            ),
            119 => 
            array (
                'id' => 120,
                'country' => 'Turkey',
                'currency_list' => 'Liras',
                'code' => 'TRL',
                'symbol' => '£',
            ),
            120 => 
            array (
                'id' => 121,
                'country' => 'Tuvalu',
                'currency_list' => 'Dollars',
                'code' => 'TVD',
                'symbol' => '$',
            ),
            121 => 
            array (
                'id' => 122,
                'country' => 'Ukraine',
                'currency_list' => 'Hryvnia',
                'code' => 'UAH',
                'symbol' => '?',
            ),
            122 => 
            array (
                'id' => 123,
                'country' => 'United Kingdom',
                'currency_list' => 'Pounds',
                'code' => 'GBP',
                'symbol' => '£',
            ),
            123 => 
            array (
                'id' => 124,
                'country' => 'United States of America',
                'currency_list' => 'Dollars',
                'code' => 'USD',
                'symbol' => '$',
            ),
            124 => 
            array (
                'id' => 125,
                'country' => 'Uruguay',
                'currency_list' => 'Pesos',
                'code' => 'UYU',
                'symbol' => '$U',
            ),
            125 => 
            array (
                'id' => 126,
                'country' => 'Uzbekistan',
                'currency_list' => 'Sums',
                'code' => 'UZS',
                'symbol' => '??',
            ),
            126 => 
            array (
                'id' => 127,
                'country' => 'Vatican City',
                'currency_list' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ),
            127 => 
            array (
                'id' => 128,
                'country' => 'Venezuela',
                'currency_list' => 'Bolivares Fuertes',
                'code' => 'VEF',
                'symbol' => 'Bs',
            ),
            128 => 
            array (
                'id' => 129,
                'country' => 'Vietnam',
                'currency_list' => 'Dong',
                'code' => 'VND',
                'symbol' => '?',
            ),
            129 => 
            array (
                'id' => 130,
                'country' => 'Yemen',
                'currency_list' => 'Rials',
                'code' => 'YER',
                'symbol' => '?',
            ),
            130 => 
            array (
                'id' => 131,
                'country' => 'Zimbabwe',
                'currency_list' => 'Zimbabwe Dollars',
                'code' => 'ZWD',
                'symbol' => 'Z$',
            ),
        ));
        
        
    }
}