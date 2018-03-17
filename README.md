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
                'hm-rpc.0.000xxxxxxxxxxx' => 'Heater Office',
            ],
    
            'windows' => [
                'hm-rpc.0.000xxxxxxxxxxx' => 'Window contact Office',
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
        
        'virtual_devices' => [             // whole scene id could be: some.scene.id.part.normal_mode
            'some.scene.id.part' => [     // part of state id before last dot
                'label' => 'Scene 123',
                'states' => [
                    'normal_mode' => [    // part of state id after last dot
                        'label' => 'Heater mode',
                        'key' => 'MODE',
                    ],
                    'trigger_on_off' => [
                        'label' => 'Heater on/off',
                        'key' => 'TRIGGER_ON_OFF'
                    ]
                ]
            ],
        ],
        
        'redis' => [
            'ttl' => '600',
            'key_prefix' => ''
        ],
    
    ];
