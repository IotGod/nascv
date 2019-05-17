<?php

class gm1 {

	public $nascv;

	# structure by fport
	function rx_fport() {
		$struct = array();

		# fport 25
		$struct[ 25 ] = array(
			#packet type
			array( 'packet_type' => 'usage_packet' ),

			#header
			array( '_cnf' => array( 'repeat' => false ),
				'interface' => array( 'type' => 'hex' )
			)
		);

		# gas
        $struct[ 25 ][ 'gas' ] = array( '_cnf' => array( 'repeat' => false, 'name' => 'gas', 'when' => array( array( 'interface' => '03' ) )),
			'settings' => array( 'type' => 'byte', 'bits' => array(
				array( 'bit' => 0, 'parameter' => 'input_state', 'formatter' =>
					array( false, true ) ),
				array( 'bit' => 1, 'parameter' => 'operational_mode', 'formatter' =>
					array( 'counter', 'n/a' ) ),
				array( 'bit' => '4-7', 'parameter' => 'medium_type', 'type' => 'hex', 'formatter' => array(
					array( 'value' => '04', 'name' => '_gas' ),
					array( 'value' => '?', 'name' => 'n/a' ) ) ),
			) ),
			'counter' => array( 'type' => 'uint32', 'unit' => 'L' )
		);

        # tamper
        $struct[ 25 ][ 'tamper' ] = array( '_cnf' => array( 'repeat' => false, 'name' => 'tamper', 'when' => array( array( 'interface' => '03' ) )),
			'settings' => array( 'type' => 'byte', 'bits' => array(
				array( 'bit' => 0, 'parameter' => 'input_state', 'formatter' =>
					array( false, true ) ),
				array( 'bit' => 1, 'parameter' => 'operational_mode', 'formatter' =>
					array( 'n/a', 'trigger_mode' ) ),
				array( 'bit' => 2, 'parameter' => 'is_alert', 'formatter' =>
					array( 'no', 'yes' ) ),
				array( 'bit' => '4-7', 'parameter' => 'medium_type', 'type' => 'hex', 'formatter' => array(
					array( 'value' => '01', 'name' => 'events_' ),
					array( 'value' => '?', 'name' => 'n/a' ) ) ),
			) ),
			'counter' => array( 'type' => 'uint32', 'unit' => 'events' )
		);

		# fport 24
		$struct[ 24 ] = array(

			#packet type
			array( 'packet_type' => 'status_packet' ),

			#main
			array( '_cnf' => array( 'repeat' => false),
				'header' => array( 'type' => 'byte', 'bits' => array(
	                array( 'bit' => '0-5', 'parameter' => 'interface', 'type' => 'hex', 'formatter' => array(
	                    array( 'value' => '03', 'name' => 'gas meter' ),
	                    array( 'value' => '?', 'name' => 'strange packet' ),
	                ) ),
                    array( 'bit' => 6, 'parameter' => 'user_triggered_packet', 'formatter' => array( 'no', 'yes' ) ),
                    array( 'bit' => 7, 'parameter' => 'temperature_triggered_packet', 'formatter' => array( 'no', 'yes' ) )
                ) ),
                'battery_index' => array( 'type' => 'uint8', 'unit' => 'index', 'formatter' => ':battery:3.6' ),
                'mcu_temp' => array( 'type' => 'int8', 'unit' => '°C' , 'formatter' => '%s%s'),
                'downlink_rssi' => array( 'type' => 'uint8', 'unit' => 'dBm', 'converter' => '*-1' )
			),

		);


		# gas
		$struct[ 24 ][ 'gas' ] = $struct[ 25 ][ 'gas' ];
		$struct[ 24 ][ 'gas' ][ '_cnf' ][ 'when' ] = array( array( 'header:interface' => '03' ) );
		# tamper
		$struct[ 24 ][ 'tamper' ] = $struct[ 25 ][ 'tamper' ];
		$struct[ 24 ][ 'tamper' ][ '_cnf' ][ 'when' ] = array( array( 'header:interface' => '03' ) );

		# fport 50
		$struct[ 50 ] = array(

			#main
			array( '_cnf' => array( 'repeat' => false ),
				'packet_type' => array( 'type' => 'hex' )
			),

			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => '00' ) ) ),
				'configured_parameters' => array( 'type' => 'byte', 'bits' => array(
					array( 'usage_interval' => array( 'not_configured', 'configured' ) ),
					array( 'status_interval' => array( 'not_configured', 'configured' ) ),
					array( 'usage_behaviour' => array( 'not_configured', 'configured' ) ),
				) ),
				'usage_interval' => array( 'type' => 'uint16', 'unit' => 'minutes' ),
				'status_interval' => array( 'type' => 'uint16', 'unit' => 'minutes' ),
				'usage_behaviour' => array( 'type' => 'byte', 'bits' =>
					array( 'only_when_fresh_data', 'always' ) ),
			),

			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => '02' ) ) ),
				'multiplier' => array( 'type' => 'byte', 'bits' =>
					array( '10_L', '100_L', '1000_L' ) ),
			),
			'true_reading' => array( 'type' => 'uint32', 'unit' => 'L', ) );


		# fport 99
		$struct[ 99 ] = array(

			#packet type
			array( '_cnf' => array( 'repeat' => false, 'name' => 'packet_type', 'formatter' => '{packet_type:packet_type}' ),
				'packet_type' => array( 'type' => 'hex', 'formatter' => array(
					array( 'value' => '00', 'name' => 'boot_packet' ),
					array( 'value' => '01', 'name' => 'shutdown_packet' ),
					array( 'value' => '13', 'name' => 'config_failed_packet' ),
				) ),
			),

			#boot packet
			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'boot_packet' ) ) ),
				'device_serial' => array( 'type' => 'hex', 'length' => 4 ),
				array( '_cnf' => array( 'repeat' => false, 'name' => 'firmware_version',
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
			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'shutdown_packet' ) ) ),
				'shutdown_reason' => array( 'type' => 'hex', 'formatter' => array(
					array( 'value' => '20', 'name' => 'hardware_error' ),
					array( 'value' => '30', 'name' => 'lora_shutdown' ),
					array( 'value' => '31', 'name' => 'magnet_shutdown' ),
					array( 'value' => '32', 'name' => 'entering_dfu' ),
				) ),
				array( '_struct' => $struct[ 24 ] )
			),

			#config_failed_packet
			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'config_failed_packet' ) ) ),
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


		return $struct;
	}


    /**
     * @return array
     */
    public function tx_fport()
    {
        $tx = self::rx_fport();
        return $tx;
    }

}

?>