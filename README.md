**Work in progess**

Goal of this app is to display iobroker states and trigger state changes for iobroker based smart home control.

Create an iobroker.php config like the following:

    return [
    
        'server' => [
            'host' => env('IOBROKER_HOST'),
            'port' => env('IOBROKER_PORT'),
        ],
    
        'device_categories' => [
            'heating',
            'windows'
        ],
    
        'devices' => [
            'heating' => [
                'hm-rpc.0.000xxxxxxxxxxx' => 'Heizkörper Büro',
            ],
    
            'windows' => [
                'hm-rpc.0.000xxxxxxxxxxx' => 'Fensterkontakt Büro/Bücherregal',
            ]
        ],
    
        'states' => [
            'heating' => [
                'LOW_BAT' => '.0.LOW_BAT',
                'ACTUAL_TEMPERATURE' => '.1.ACTUAL_TEMPERATURE',
                'BOOST_MODE' => '.1.BOOST_MODE',
                'BOOST_TIME' => '.1.BOOST_TIME',
                'CONTROL_MODE' => '.1.CONTROL_MODE',
                'SET_POINT_TEMPERATURE' => '.1.SET_POINT_TEMPERATURE',
                'WINDOW_STATE' => '.1.WINDOW_STATE',
            ],
    
            'windows' => [
                'LOW_BAT' => '.0.LOW_BAT',
                'STATE' => '.1.STATE',
            ]
        ],
    
    ];
