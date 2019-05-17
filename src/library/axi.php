<?php
class axi {

	public $nascv;

	# structure by fport
	function rx_fport() {
		$struct = array();

		# fport 24
		$struct[ 24 ] = array(

			#packet type
			array( 'packet_type' => 'status_packet' ),

			#main
			array( '_cnf' => array( 'repeat' => false ),
				'module_battery' => array( 'type' => 'uint8', 'unit' => 'index', 'formatter' => ':battery:3.6' ),
				'module_temp' => array( 'type' => 'uint8', 'unit' => '°C' , 'formatter' => '%s%s'),
				'downlink_rssi' => array( 'type' => 'uint8', 'unit' => 'dBm', 'converter' => '*-1' ),
				'state' => array( 'type' => 'byte', 'bits' =>
					array( 'user_triggered_packet' => array( 'no', 'yes' ),
						'error_triggered_packet' => array( 'no', 'yes' ),
						'temperature_triggered_packet' => array( 'no', 'yes' ),
					) ),
				'accumulated_volume' => array( 'type' => 'int32', 'unit' => 'L' ),
				'meter_error' => array( 'type' => 'hex', 'length' => 4 )
			),
		);

        $struct[ 24 ][ 'register_map' ] = array( '_cnf' => array( 'repeat' => false ),
			'register_map' => array( 'type' => 'byte', 'bits' =>
				array( 'accumulated_heat_energy' => array( 'not_sent', 'sent' ),
					'accumulated_cooling_energy' => array( 'not_sent', 'sent' ),
					'accumulated_pulse_1' => array( 'not_sent', 'sent' ),
					'accumulated_pulse_2' => array( 'not_sent', 'sent' ),
					'instant_flow_rate' => array( 'not_sent', 'sent' ),
					'instant_power' => array( 'not_sent', 'sent' ),
					'instant_temp_in' => array( 'not_sent', 'sent' ),
					'instant_temp_out' => array( 'not_sent', 'sent' )
			) ),
			'' => array('type' => 'byte')
	    );

        $struct[ 24 ][ 'reported_registers' ] = array( '_cnf' => array( 'repeat' => false ),
			'accumulated_heat_energy' => array( 'type' => 'int32', 'unit' => 'kWh', 
				'when' => array( array( 'register_map:accumulated_heat_energy' => 1 ) ) ),
			'accumulated_cooling_energy' => array( 'type' => 'int32', 'unit' => 'kWh', 
				'when' => array( array( 'register_map:accumulated_cooling_energy' => 1 ) ) ),
			'accumulated_pulse_1' => array( 'type' => 'int32', 'unit' => 'L', 
				'when' => array( array( 'register_map:accumulated_pulse_1' => 1 ) ) ),
			'accumulated_pulse_2' => array( 'type' => 'int32', 'unit' => 'L', 
				'when' => array( array( 'register_map:accumulated_pulse_2' => 1 ) ) ),
			'instant_flow_rate' => array( 'type' => 'float', 'unit' => 'L/h', 'formatter' => '%.3f %s',
				'when' => array( array( 'register_map:instant_flow_rate' => 1 ) ) ),
			'instant_power' => array( 'type' => 'float', 'unit' => 'kW', 'formatter' => '%.3f %s',
				'when' => array( array( 'register_map:instant_power' => 1 ) ) ),
			'instant_temp_in' => array( 'type' => 'int16', 'unit' => '°C', 'converter' => '/100.0', 'formatter' => '%.2f%s',
				'when' => array( array( 'register_map:instant_temp_in' => 1 ) ) ),
			'instant_temp_out' => array( 'type' => 'int16', 'unit' => '°C', 'converter' => '/100.0', 'formatter' => '%.2f%s',
				'when' => array( array( 'register_map:instant_temp_out' => 1 ) ) )
		);


		# fport 25
		$struct[ 25 ] = array(

			#packet type
			array( 'packet_type' => 'usage_packet' ),
			#main
			array( '_cnf' => array( 'repeat' => false ),
				'accumulated_volume' => array( 'type' => 'int32', 'unit' => 'L' )
			)
		);
		
		$struct[ 25 ][ 'register_map' ] = $struct[ 24 ][ 'register_map' ];
		$struct[ 25 ][ 'reported_registers' ] = $struct[ 24 ][ 'reported_registers' ];


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
				'meter_id' => array( 'type' => 'hex', 'length' => 4 ),
				'meter_type' => array( 'type' => 'hex', 'formatter' => array(
					array( 'value' => '00', 'name' => 'water_meter' ),
					array( 'value' => '01', 'name' => 'heat_meter' )
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