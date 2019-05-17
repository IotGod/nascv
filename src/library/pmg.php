<?php
class pmg {

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
				'general' => array( 'type' => 'byte', 'bits' => array(
					'relay_state' => array( 'off', 'on' ),
					'relay_switched_packet' => array( false, true ),
					'counter_reset_packet' => array( false, true )
				) ),
				'accumulated_energy' => array( 'type' => 'float', 'unit' => 'kWh', 'formatter' => '%.3f %s' ),
				array( '_cnf' => array( 'repeat' => false, 'name' => 'instant'),
					'frequency' => array( 'type' => 'uint16', 'unit' => 'Hz', 'converter' => '/1000' ),
					'voltage' => array( 'type' => 'uint16', 'unit' => 'V', 'converter' => '/100' ),
					'power' => array( 'type' => 'uint16', 'unit' => 'W', 'converter' => '/10' ),
				),
				'rssi' => array( 'type' => 'int8', 'unit' => 'dBm', 'converter' => '*-1' ),
			),

			# Extension module data
			array( '_cnf' => array( 'repeat' => true, 'name' => 'extension' ),
				'device_type' => array( 'type' => 'hex' ),

				# swithc
				array( '_cnf' => array( 'repeat' => false, 'name' => 'switch', 'when' => array( array( 'device_type' => '00' ) ) ),
					'channel_map' => array( 'type' => 'byte', 'bits' => array(
						'channel_0' => array( 'off', 'on' ),
						'channel_1' => array( 'off', 'on' ),
						'channel_2' => array( 'off', 'on' ),
						'channel_3' => array( 'off', 'on' ),
						'channel_4' => array( 'off', 'on' ),
						'channel_5' => array( 'off', 'on' ),
						'channel_6' => array( 'off', 'on' ),
						'channel_7' => array( 'off', 'on' ),
					), )
				),

				# meter
				array( '_cnf' => array( 'repeat' => false, 'name' => 'meter', 'when' => array( array( 'device_type' => '01' ) ) ),
					'channel_map' => array( 'type' => 'byte', 'bits' => array(
						'channel_0' => array( 'diconnected', 'connected' ),
						'channel_1' => array( 'diconnected', 'connected' ),
						'channel_2' => array( 'diconnected', 'connected' ),
						'channel_3' => array( 'diconnected', 'connected' ),
						'channel_4' => array( 'diconnected', 'connected' ),
						'channel_5' => array( 'diconnected', 'connected' ),
						'channel_6' => array( 'diconnected', 'connected' ),
						'channel_7' => array( 'diconnected', 'connected' ),
					), ),
					'channel_x' => array( 'type' => 'float', 'unit' => 'kWh' ),
					'channel_n' => array( 'type' => 'float', 'unit' => 'kWh' ),
				)
			)

		);



		# fport 25
		$struct[ 25 ] = array(
			
			#packet type
			array( 'packet_type' => 'usage_packet' ),

			#main
			array( '_cnf' => array( 'repeat' => false ),
				'accumulated_energy' => array( 'type' => 'float', 'unit' => 'kWh', 'formatter' => '%0.3f %s' ),
				'power' => array( 'type' => 'uint16', 'unit' => 'W', 'converter' => '/10' ),
			),

			array( '_cnf' => array( 'repeat' => true, 'name' => 'extension' ),
				'device_type' => array( 'type' => 'hex' ),

				# meter
				array( '_cnf' => array( 'repeat' => false, 'name' => 'meter', 'when' => array( array( 'device_type' => '01' ) ) ),
					'channel_map' => array( 'type' => 'byte', 'bits' => array(
						'channel_0' => array( 'diconnected', 'connected' ),
						'channel_1' => array( 'diconnected', 'connected' ),
						'channel_2' => array( 'diconnected', 'connected' ),
						'channel_3' => array( 'diconnected', 'connected' ),
						'channel_4' => array( 'diconnected', 'connected' ),
						'channel_5' => array( 'diconnected', 'connected' ),
						'channel_6' => array( 'diconnected', 'connected' ),
						'channel_7' => array( 'diconnected', 'connected' ),
					), ),
					'channel_x' => array( 'type' => 'float', 'unit' => 'kWh' ),
					'channel_n' => array( 'type' => 'float', 'unit' => 'kWh' ),
				)
			)

		);

		# fport 50
		$struct[ 50 ] = array(
			
			#packet type
			array( 'packet_type' => 'configuration_packet' ),

			#main
			array( '_cnf' => array( 'repeat' => false ),
				'header' => array( 'type' => 'hex' )
			),

			#Reporting intervals
			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'header' => '00' ) ) ),
				'usage_interval' => array( 'type' => 'uint16', 'unit' => 'minutes' ),
				'status_interval' => array( 'type' => 'uint16', 'unit' => 'minutes' ),
			),

			#Metering module config
			array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'header' => '01' ) ) ),

				'device' => array( 'type' => 'byte', 'bits' => array(
					'device_0' => array( 'not selected', 'selected' ),
					'device_1' => array( 'not selected', 'selected' )
				) ),

				'channel' => array( 'type' => 'byte', 'bits' => array(
					'channel_0' => array( 'not selected', 'selected' ),
					'channel_1' => array( 'not selected', 'selected' ),
					'channel_2' => array( 'not selected', 'selected' ),
					'channel_3' => array( 'not selected', 'selected' ),
					'channel_4' => array( 'not selected', 'selected' ),
					'channel_5' => array( 'not selected', 'selected' ),
					'channel_6' => array( 'not selected', 'selected' ),
					'channel_7' => array( 'not selected', 'selected' )
				) ),

				'transformer' => array( 'type' => 'hex', 'formatter' => array(
					array( 'value' => '00', 'type' => 'disabled' ),
					array( 'value' => '01', 'type' => 'closed_loop' ),
					array( 'value' => '02', 'type' => "open_loop" ),
					array( 'value' => '02', 'type' => "3rd_party" )
				) ),

				'amp_rating' => array( 'type' => 'uint8', 'unit' => 'amp' ),
				'twist_count' => array( 'type' => 'uint16' ),
			),
		);

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
                'extension_module_0'=>array('type'=>'hex', 'formatter'=>array(
                    array('value'=>'00', 'name'=>'switch'),
                    array('value'=>'01', 'name'=>'meter'),
                    array('value'=>'ff', 'name'=>'not connected')
                )),
                'extension_module_1'=>array('type'=>'hex', 'formatter'=>array(
                    array('value'=>'00', 'name'=>'switch'),
                    array('value'=>'01', 'name'=>'meter'),
                    array('value'=>'ff', 'name'=>'not connected')
                )),
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