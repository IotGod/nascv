<?php

class oir
{

    public $nascv;

    private $ssi_unit_library = array(
        1 => array( 'bar', '°C', 'n/a', 'n/a' ), // index = 1 then channel 1 -> bar, channel 2 -> °C etc
        2 => array( 'n/a', 'n/a', 'n/a', 'n/a' ), // index = 2 then ...
    );

    /**
     * @return array
     */
    function rx_fport()
    {
        $struct = array();

        # fport 24
        $struct[ 24 ] = array(

            #packet type
            array( 'packet_type' => 'status_packet' ),

            # reported_interfaces
            array( '_cnf' => array( 'repeat' => false ),
                'reported_interfaces' => array( 'type' => 'byte', 'bits' => array(
                    array( 'bit' => 0, 'parameter' => 'digital_1', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 1, 'parameter' => 'digital_2', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 2, 'parameter' => 'analog_1', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 3, 'parameter' => 'analog_2', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 4, 'parameter' => 'ssi', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 5, 'parameter' => 'mbus', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 6, 'parameter' => 'user_triggered_packet', 'formatter' => array( 'no', 'yes' ) ),
                    array( 'bit' => 7, 'parameter' => 'temperature_triggered_packet', 'formatter' => array( 'no', 'yes' ) ),
                ) ),
                'battery' => array( 'type' => 'uint8', 'formatter' => ':battery:3.6' ),
                'mcu_temperature' => array( 'type' => 'int8', 'unit' => '°C', 'formatter' => '%s%s' ),
                'downlink_rssi' => array( 'type' => 'uint8', 'unit' => 'dBm', 'converter' => '*-1' )
            )
        );

        # digital_interface_channel 1
        $struct[ 24 ][ 'digital_1' ] = array( '_cnf' => array( 'when' => array( array( 'reported_interfaces:digital_1' => 1 ) ), 'name' => 'digital_1' ),
            'state' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => 0, 'parameter' => 'input_state' ),
                array( 'bit' => 1, 'parameter' => 'operational_mode', 'formatter' => array( 'pulse_mode', 'trigger_mode' ) ),
                array( 'bit' => 2, 'parameter' => 'alert_state' ),
                array( 'bit' => '4-7', 'parameter' => 'medium_type', 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '01', 'name' => 'pulses' ),
                    array( 'value' => '02', 'name' => 'L_water' ),
                    array( 'value' => '03', 'name' => 'Wh_electricity' ),
                    array( 'value' => '04', 'name' => 'L_gas' ),
                    array( 'value' => '05', 'name' => 'Wh_heat' ),
                    array( 'value' => '0F', 'name' => 'other' ),
                    array( 'value' => '?', 'name' => 'n/a' ),
                ) ),
            ) ),
            'counter' => array( 'type' => 'uint32', 'unit' => '{state:medium_type}' )
        );


        # digital_interface_channel 2
        $struct[ 24 ][ 'digital_2' ] = $struct[ 24 ][ 'digital_1' ];
        $struct[ 24 ][ 'digital_2' ][ '_cnf' ][ 'when' ] = array( array( 'reported_interfaces:digital_2' => 1 ) );
        $struct[ 24 ][ 'digital_2' ][ '_cnf' ][ 'name' ] = 'digital_2';

        # analog_interface_channel 1
        $struct[ 24 ][ 'analog_1' ] = array( '_cnf' => array( 'when' => array( array( 'reported_interfaces:analog_1' => 1 ) ), 'name' => 'analog_1' ),
            'general' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => 0, 'parameter' => 'input_mode', 'formatter' => array( 'voltage_10V', 'current_20mA' ) ),
                array( 'bit' => 1, 'parameter' => 'is_alert', 'formatter' => array( 'no', 'yes' ) ),
                array( 'bit' => 6, 'parameter' => 'instant_value_reported', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 7, 'parameter' => 'average_value_reported', 'formatter' => array( 'not reported', 'reported' ) ),
            ) ),
            'instant_value' => array( 'type' => 'float', 'unit' => '{general:input_mode}' ),
        );


        # analog_interface_channel 2
        $struct[ 24 ][ 'analog_2' ] = $struct[ 24 ][ 'analog_1' ];
        $struct[ 24 ][ 'analog_2' ][ '_cnf' ][ 'when' ] = array( array( 'reported_interfaces:analog_2' => 1 ) );
        $struct[ 24 ][ 'analog_2' ][ '_cnf' ][ 'name' ] = 'analog_2';


        # ssi_interface_channel
        $struct[ 24 ][ 'ssi' ] = array( '_cnf' => array( 'name' => 'ssi', 'when' => array( array( 'reported_interfaces:ssi' => 1 ) ) ),
            'general' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => '0-5', 'type' => 'decimal', 'parameter' => 'ssi_index' ),
                array( 'bit' => 7, 'parameter' => 'is_alert', 'formatter' => array( false, true ) ),
            ) ),
            'reported_parameters' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => 0, 'parameter' => 'channel_1_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 2, 'parameter' => 'channel_2_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 4, 'parameter' => 'channel_3_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 6, 'parameter' => 'channel_4_instant', 'formatter' => array( 'not reported', 'reported' ) ),
            ) ),

            'channel_1_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 0 ),
                'when' => array( array( 'ssi:reported_parameters:channel_1_instant' => 1 ) )
            ),
            'channel_2_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 1 ),
                'when' => array( array( 'ssi:reported_parameters:channel_2_instant' => 1 ) )
            ),
            'channel_3_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 2 ),
                'when' => array( array( 'ssi:reported_parameters:channel_3_instant' => 1 ) )
            ),
            'channel_4_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 3 ),
                'when' => array( array( 'ssi:reported_parameters:channel_4_instant' => 1 ) )
            ),
        );


        # mbus_interface_channel
        $struct[ 24 ][ 'mbus' ] = array( '_cnf' => array( 'name' => 'mbus', 'when' => array( array( 'reported_interfaces:mbus' => 1 ) ) ),
            'state' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => '0-3', 'parameter' => 'last_status', 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '00', 'name' => 'ok' ),
                    array( 'value' => '01', 'name' => 'nothing_requested' ),
                    array( 'value' => '02', 'name' => 'bus_unpowered' ),
                    array( 'value' => '03', 'name' => 'no_response' ),
                    array( 'value' => '04', 'name' => 'empty_response' ),
                    array( 'value' => '05', 'name' => 'invalid_data' )
                ) )
            ) ),

            'mbus_status' => array( 'type' => 'hex', 'when' => array(array('state:last_status' => '00') ) ),

                'data_records' => array( 'type' => 'hex', 'when' => array(array('state:last_status' => '00') ),
                    'byte_order' => 'MSB', 'length' => '*' ),
        );


        # fport 25
        $struct[ 25 ] = array(

            #packet type
            array( 'packet_type' => 'usage_packet' ),

            # reported_interfaces
            array( '_cnf' => array( 'repeat' => false ),
                'reported_interfaces' => array( 'type' => 'byte', 'bits' => array(
                    array( 'bit' => 0, 'parameter' => 'digital_1', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 1, 'parameter' => 'digital_2', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 2, 'parameter' => 'analog_1', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 3, 'parameter' => 'analog_2', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 4, 'parameter' => 'ssi', 'formatter' => array( 'not_sent', 'sent' ) ),
                    array( 'bit' => 5, 'parameter' => 'mbus', 'formatter' => array( 'not_sent', 'sent' ) ),
                ) ),
            )
        );

        # digital_interface_channel 1
        $struct[ 25 ][ 'digital_1' ] = $struct[ 24 ][ 'digital_1' ];

        # digital_interface_channel 2
        $struct[ 25 ][ 'digital_2' ] = $struct[ 24 ][ 'digital_2' ];

        # analog_interface_channel 1
        $struct[ 25 ][ 'analog_1' ] = $struct[ 24 ][ 'analog_1' ];

        # analog_interface_channel 2
        $struct[ 25 ][ 'analog_2' ] = $struct[ 24 ][ 'analog_2' ];

        # ssi_interface_channel
        $struct[ 25 ][ 'ssi' ] = array( '_cnf' => array( 'name' => 'ssi', 'when' => array( array( 'reported_interfaces:ssi' => 1 ) ) ),
            'general' => array( 'type' => 'byte', 'bits' => array(
                /* either */
                array( 'bit' => '0-5', 'type' => 'decimal', 'parameter' => 'ssi_index' ),
                /* or */
                /*
                array( 'bit' => '0-5', 'type'=>'decimal', 'formatter' => array(
                    array('value' => 0, 'parameter' => 'disconnected'),
                    array('value' => '1-63', 'parameter' => 'ssi_index'),
                ) ),
                */
            ) ),

            'reported_parameters' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => 0, 'parameter' => 'channel_1_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 1, 'parameter' => 'channel_1_average', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 2, 'parameter' => 'channel_2_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 3, 'parameter' => 'channel_2_average', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 4, 'parameter' => 'channel_3_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 5, 'parameter' => 'channel_3_average', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 6, 'parameter' => 'channel_4_instant', 'formatter' => array( 'not reported', 'reported' ) ),
                array( 'bit' => 7, 'parameter' => 'channel_4_average', 'formatter' => array( 'not reported', 'reported' ) ),
            ) ),

            'channel_1_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 0 ),
                'when' => array( array( 'ssi:reported_parameters:channel_1_instant' => 1 ) )
            ),
            'channel_2_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 1 ),
                'when' => array( array( 'ssi:reported_parameters:channel_2_instant' => 1 ) )
            ),
            'channel_3_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 2 ),
                'when' => array( array( 'ssi:reported_parameters:channel_3_instant' => 1 ) )
            ),
            'channel_4_instant' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 3 ),
                'when' => array( array( 'ssi:reported_parameters:channel_4_instant' => 1 ) )
            ),

            'channel_1_average' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 0 ),
                'when' => array( array( 'ssi:reported_parameters:channel_1_average' => 1 ) )
            ),
            'channel_2_average' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 1 ),
                'when' => array( array( 'ssi:reported_parameters:channel_2_average' => 1 ) )
            ),
            'channel_3_average' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 2 ),
                'when' => array( array( 'ssi:reported_parameters:channel_3_average' => 1 ) )
            ),
            'channel_4_average' => array( 'type' => 'float', 'unit' => array( 'general:ssi_index', $this->ssi_unit_library, 3 ),
                'when' => array( array( 'ssi:reported_parameters:channel_4_average' => 1 ) )
            ),
        );

        # mbus_interface_channel
        $struct[ 25 ][ 'mbus' ] = $struct[ 24 ][ 'mbus' ];
        unset( $struct[ 25 ][ 'mbus' ][ 'mbus_status' ] );


        # fport 99
        $struct[ 99 ] = array(

            #packet type
            array( '_cnf' => array( 'name' => 'packet_type', 'formatter' => '{packet_type:packet_type}' ),
                'packet_type' => array( 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '00', 'name' => 'boot_packet' ),
                    array( 'value' => '01', 'name' => 'shutdown_packet' ),
                    array( 'value' => '13', 'name' => 'config_failed_packet' ),
                ) ),
            ),

            #boot packet
            array( '_cnf' => array( 'when' => array( array( 'packet_type' => 'boot_packet' ) ) ),
                'device_serial' => array( 'type' => 'hex', 'length' => 4 ),
                array( '_cnf' => array( 'name' => 'firmware_version',
                    'formatter' => '{firmware_version:major}.{firmware_version:minor}.{firmware_version:patch}' ),
                    'major' => array( 'type' => 'uint8' ),
                    'minor' => array( 'type' => 'uint8' ),
                    'patch' => array( 'type' => 'uint8' ),
                ),
                'reset_reason' => array( 'type' => 'byte', 'bits' => array( 'RFU', 'watchdog_reset', 'soft_reset', 'RFU', 'magnet_wakeup', 'RFU', 'RFU', 'nfc_wakeup' ) ),
                'general_info' => array( 'type' => 'byte', 'bits' => array(
                    array( 'bit' => '0-1', 'parameter' => 'battery_type', 'type' => 'decimal', 'formatter' => array(
                        array( 'value' => '2', 'name' => '3V6' ) ) ),
                ) ),
                'hardware_config' => array( 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '00', 'name' => 'digital_only' ),
                    array( 'value' => '01', 'name' => 'digital_+_analog' ),
                    array( 'value' => '02', 'name' => 'digital_+_ssi' ),
                    array( 'value' => '03', 'name' => 'RFU' ),
                    array( 'value' => '04', 'name' => 'digital_+_mbus' ),
                    array( 'value' => '05', 'name' => 'bk-g_pulser' )
                ) )
            ),


            #shutdown_packet
            array( '_cnf' => array( 'when' => array( array( 'packet_type' => 'shutdown_packet' ) ) ),
                'shutdown_reason' => array( 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '20', 'name' => 'hardware_error' ),
                    array( 'value' => '30', 'name' => 'lora_shutdown' ),
                    array( 'value' => '31', 'name' => 'magnet_shutdown' ),
                    array( 'value' => '32', 'name' => 'entering_dfu' ),
                ) ),
                array( '_struct' => $struct[ 24 ] )
            ),

            #config_failed_packet
            array( '_cnf' => array( 'when' => array( array( 'packet_type' => 'config_failed_packet' ) ) ),
                'from_fport' => array( 'type' => 'uint8' ),
                'parser_error_code' => array( 'type' => 'uint8', 'formatter' => array(
                    array( 'value' => '0', 'name' => 'RFU' ),
                    array( 'value' => '1', 'name' => 'RFU' ),
                    array( 'value' => '2', 'name' => 'unknown_fport' ),
                    array( 'value' => '3', 'name' => 'packet_size_short' ),
                    array( 'value' => '4', 'name' => 'packet_size_long' ),
                    array( 'value' => '5', 'name' => 'value_error' ),
                    array( 'value' => '6', 'name' => 'mbus_parse_error' ),
                    array( 'value' => '7', 'name' => 'reserved_flag_set' ),
                    array( 'value' => '8', 'name' => 'invalid_flag_combination' ),
                    array( 'value' => '9', 'name' => 'unavailable_feature_request' ),
                    array( 'value' => '10', 'name' => 'unsupported_header' ),
                    array( 'value' => '11', 'name' => 'unavailable_hw_request' ),
                ) )
            )

        ); 

        # mbus connect packet
        $struct[ 53 ] = array(

            #packet type
            array( 'packet_type' => 'mbus_connect_packet' ),

            # interface
            array( '_cnf' => array( 'repeat' => false ),
                'interface' => array( 'type' => 'hex' )
            ),

            # reported_interfaces
            array( '_cnf' => array( 'when' => array( array( 'interface' => '01' ) ) ),
                'header' => array( 'type' => 'byte', 'bits' => array(
                    array( 'bit' => '0-2', 'parameter' => 'packet_number', 'type' => 'decimal' ),
                    array( 'bit' => 3, 'parameter' => 'more_to_follow', 'type' => 'decimal' ),
                    array( 'bit' => 6, 'parameter' => 'fixed_data_header', 'formatter' => array('not sent', 'sent') ),
                    array( 'bit' => 7, 'parameter' => 'data_record_headers_only', 'formatter' => array('with data', 'headers only') ),
                ) ),
            ),

            array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'header:fixed_data_header' => true ) ) ),
                'mbus_fixed_header' => array( 'type' => 'hex', 'byte_order' => 'MSB', 'length' => 12,
                ),

                array( '_cnf' => array( 'when' => array( array( 'header:data_record_headers_only' => true ) ) ),
                    'record_headers' => array( 'type' => 'hex', 'byte_order' => 'MSB', 'length' => '*'
                         ),
                ),

                array( '_cnf' => array( 'when' => array( array( 'header:data_record_headers_only' => false ) ) ),
                    'records' => array( 'type' => 'hex', 'byte_order' => 'MSB'
                        , 'length' => '*' ),
                ),
            )
        );

        $struct[ 49 ] = array(
            # packet_type
            array( '_cnf' => array( 'repeat' => false, 'name'=>'packet_type', 'formatter'=>'{packet_type:packet_type}' ),
            'packet_type' => array( 'type' => 'hex', 'formatter' => array(
                array( 'value' => '00', 'name' => 'general_config_response' ),
                array( 'value' => '01', 'name' => 'mbus_config_response' ),
                array( 'value' => '*', 'name' => 'unknown_packet' ),
            ) ),
            ),
        );

        # reporting_config_packet
        $struct[ 49 ][ 'conf_reporting' ] = array(
             '_cnf' => array( 'when' => array( array( 'packet_type' => 'general_config_response' ) ) ),

            'usage_interval' => array( 'type' => 'uint16', 'unit' => 'minutes'

            ),
            'status_interval' => array( 'type' => 'uint16', 'unit' => 'minutes'

            ),
            'usage_behaviour' => array( 'type' => 'byte', 'bits' =>
                array( 'send_always' => array('only_when_fresh_data', 'always' ) ), 'unit' => 'minutes'

            ),
        );

        # input_config_packet
        $struct[ 49 ][ 'conf_general' ] = array( 
            array('_cnf' => array( 'when' => array( array( 'packet_type' => 'general_config_response' ) ) ),
                'configured_interfaces' => array( 'type' => 'byte', 'bits' =>
                    array( 'digital_1' => array( 'not_sent', 'sent' ),
                        'digital_2' => array( 'not_sent', 'sent' ),
                        'analog_1' => array( 'not_sent', 'sent' ),
                        'analog_2' => array( 'not_sent', 'sent' ),
                        'ssi' => array( 'not_sent', 'sent' ),
                        'mbus' => array( 'not_sent', 'sent' ),
                    ) )
            ),
        );



        #digital_interface_channel_configuration
        $struct[ 49 ][ 'conf_general' ]['digital_1'] = array( 
            '_cnf' => array( 'name' => 'digital_1', 'when' => array( array( 'configured_interfaces:digital_1' => 1 )

                 ) ),
            'configured_parameters' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => 0, 'parameter' => 'interface_enabled', 'formatter' =>
                    array( 'disable and reset', 'enabled' ) ),
                array( 'bit' => 1, 'parameter' => 'mode', 'formatter' =>
                    array( 'not_sent', 'sent' ) ),
                array( 'bit' => 2, 'parameter' => 'multiplier', 'formatter' =>
                    array( 'not_sent', 'sent' ) ),
                array( 'bit' => 3, 'parameter' => 'true_reading', 'formatter' =>
                    array( 'not_sent', 'sent' ) ),
                array( 'bit' => '4-7', 'parameter' => 'medium_type', 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '01', 'name' => 'pulses' ),
                    array( 'value' => '02', 'name' => 'L_water' ),
                    array( 'value' => '03', 'name' => 'Wh_electricity' ),
                    array( 'value' => '04', 'name' => 'L_gas' ),
                    array( 'value' => '05', 'name' => 'Wh_heat' ),
                    array( 'value' => '0F', 'name' => 'other' ),
                    array( 'value' => '?', 'name' => 'n/a' ),
                ) ),
            ) ),
            'mode' => array( 'type' => 'byte', 'bits' => array(
                array( 'bit' => 0, 'parameter' => 'operational_mode', 'formatter' =>
                    array( 'pulse_mode', 'trigger_mode' ) ),
                array( 'bit' => '6-7', 'parameter' => 'trigger_time', 'type' => 'hex', 'when' => array(array('mode:operational_mode' => 'trigger_mode' )), 'formatter' => array(
                    array( 'value' => '00', 'name' => '1_sec' ),
                    array( 'value' => '01', 'name' => '10_sec' ),
                    array( 'value' => '02', 'name' => '1_min' ),
                    array( 'value' => '03', 'name' => '1_h' )
                ) ) ) ),
            'multiplier' => array( 'type' => 'float', 'when' => array(array('configured_parameters:multiplier' => 1))),
            'true_reading' => array( 'type' => 'uint32', 'when' => array(array('configured_parameters:true_reading' => 1)), 
                'unit' => array( 'configured_parameters:medium_type' ) ),
        );

        $struct[ 49 ][ 'conf_general' ][ 'digital_2' ] = $struct[ 49 ][ 'conf_general' ][ 'digital_1' ];
        $struct[ 49 ][ 'conf_general' ][ 'digital_2' ][ '_cnf' ]['when'] = array(array( 'configured_interfaces:digital_2' => 1 ));
        $struct[ 49 ][ 'conf_general' ][ 'digital_2' ][ '_cnf' ]['name'] = 'digital_2';        


        #analog_interface_channel_configuration
        $struct[ 49 ][ 'conf_general' ]['analog_1'] = array( 
            '_cnf' => array( 'name' => 'analog_1', 'when' => array( array( 'configured_interfaces:analog_1' => 1 )

                 ) ),
           'configured_parameters' => array( 'type' => 'byte', 'bits' =>
               array( 'interface_enabled' => array( 'disabled', 'enabled' ),
                   'general' => array( 'not_sent', 'sent' ),
                   'reporting' => array( 'not_sent', 'sent' ) ) ),
           'general' => array( 'type' => 'byte', 'when' => array(array('analog:configured_parameters:general')),
               'bits' => array( 
                   'sampling_rate' => array( '1_min', '1_sec' ),
                   'input_mode' => array( 'voltage_10V', 'current_20mA' ) ) ),
           'reporting' => array( 'type' => 'byte', 'when' => array(array('analog:configured_parameters:reporting')),
               'bits' => array(
               array( 'bit' => 0, 'parameter' => 'alert_enabled', 'formatter' =>
                   array( 'disabled', 'enabled' ) ),
               array( 'bit' => 1, 'parameter' => 'alert_limiting_thresholds', 'formatter' =>
                   array( 'not_sent', 'sent' ) ),
               array( 'bit' => 2, 'parameter' => 'instant_value_in_usage', 'formatter' =>
                   array( 'do_not_report ', 'report' ) ),
               array( 'bit' => 3, 'parameter' => 'average_value_in_usage', 'formatter' =>
                   array( 'do_not_report ', 'report' ) ),
               array( 'bit' => '6-7', 'parameter' => 'alert_triggered_after', 'type' => 'hex', 'formatter' =>
                   array( 'value' => '00', 'name' => '1_sample' ),
                   array( 'value' => '01', 'name' => '3_samples' ),
                   array( 'value' => '02', 'name' => '10_samples' ),
                   array( 'value' => '03', 'name' => '100_samples' )
               ) ) ),

           'alert_low_threshold' => array( 'type' => 'float', 'unit' => 'general:input_mode', 'when' => array(array('reporting:alert_limiting_thresholds'))),
           'alert_high_threshold' => array( 'type' => 'float', 'unit' => 'general:input_mode', 'when' => array(array('reporting:alert_limiting_thresholds'))),
        );

        $struct[ 49 ][ 'conf_general' ][ 'analog_2' ] = $struct[ 49 ][ 'conf_general' ][ 'analog_1' ];
        $struct[ 49 ][ 'conf_general' ][ 'analog_2' ][ '_cnf' ]['when'] = array(array( 'configured_interfaces:analog_2' => 1 ));
        $struct[ 49 ][ 'conf_general' ][ 'analog_2' ][ '_cnf' ]['name'] = 'analog_2';        


        #ssi_interface_configuration
        $struct[ 49 ][ 'conf_general' ]['ssi'] = array( 
            '_cnf' => array( 'name' => 'ssi', 'when' => array( array( 'configured_interfaces:ssi' => 1 )

                 ) ),
           'configured_parameters' => array( 'type' => 'byte', 'bits' =>
               array( 'interface_enabled' => array( 'disabled', 'enabled' ),
                   'general' => array( 'not_sent', 'sent' ),
                   'channel_1' => array( 'not_sent', 'sent' ),
                   'channel_2' => array( 'not_sent', 'sent' ),
                   'channel_3' => array( 'not_sent', 'sent' ),
                   'channel_4' => array( 'not_sent', 'sent' ) ) ),
           'general' => array( 'type' => 'byte', 'when' => array(array('configured_parameters:general')),
                'bits' => array( 'sampling_rate' => array( 'slow', 'fast' ) ) ),
           'channel_1' => array( 'type' => 'float', 'when' => array(array('configured_parameters:channel_1'))),
           'channel_2' => array( 'type' => 'float', 'when' => array(array('configured_parameters:channel_2'))),
           'channel_3' => array( 'type' => 'float', 'when' => array(array('configured_parameters:channel_3'))),
           'channel_4' => array( 'type' => 'float', 'when' => array(array('configured_parameters:channel_4'))),


        );

        #mbus_interface_configuration
        $struct[ 49 ][ 'conf_general' ]['mbus'] = array( 
            '_cnf' => array( 'name' => 'mbus', 'when' => array( array( 'configured_interfaces:mbus' => 1 )

                 ) ),
            'mbus_device_serial' => array( 'type' => 'hex', 'length' => 4,
                'formatter' => array( array( 'value' => 'ffffffff', 'name' => 'no device found' ) )
            ),


           'configured_parameters' => array( 'type' => 'byte', 'bits' => array(
               array( 'bit' => 0, 'parameter' => 'interface_enabled', 'formatter' => array( 'disabled', 'enabled' ) ),
               array( 'bit' => 0, 'parameter' => 'data_records_in_usage', 'formatter' => array( 'not configured', 'configured' ) ),
               array( 'bit' => 0, 'parameter' => 'data_records_in_status', 'formatter' => array( 'not configured', 'configured' ) ),
           ) ),

           'data_records_for_packets' => array( 'type' => 'byte', 'bits' => array(
               array( 'bit' => '0-3', 'parameter' => 'count_in_usage', 'type' => 'decimal',
                   'formatter' => array( 'value' => 0, 'name' => 'not sent' ) ),
               array( 'bit' => '4-7', 'parameter' => 'count_in_status', 'type' => 'decimal',
                   'formatter' => array( 'value' => 0, 'name' => 'not sent' ) ),
           ) ),

           'records' => array( 'type' => 'hex', 'byte_order' => 'MSB', 'length' => '*'
               
           ),
        );

        return $struct;
    }

    /**
     * @return array
     */
    public function tx_fport()
    {
        $rx = self::rx_fport();

        $struct = array();

        # fport 50
        $struct[ 50 ] = array(

            # packet_type
            array( '_cnf' => array( 'repeat' => false ),
                'packet_type' => array( 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '00', 'name' => 'reporting_config_packet' ),
                    array( 'value' => '01', 'name' => 'input_config_packet' ),
                    array( 'value' => '*', 'name' => 'unknown_packet' ),),
            ) ),
        );



        return $struct;
    }
}

?>