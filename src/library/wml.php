<?php
class wml {

	public $nascv;

	# structure by fport
	function rx_fport() {
		$struct = array();

		# fport 24
		$struct[ 24 ] = array(
			
			#packet type
			array( 'packet_type' => 'status_packet' ),
			
			#header
			array( '_cnf' => array( 'repeat' => false ),
				'header' => array( 'type' => 'hex' )
			),

			#Payload bridge
			array( '_cnf' => array( 'repeat' => false, 'name' => 'bridge', 'when' => array( array( 'header' => '00' ) ) ),
				'time' => array( 'type' => 'uint32', 'unit' => 'UTC' ),
				'rssi' => array( 'type' => 'uint8', 'unit' => 'dBm', 'converter' => '*-1' ),
				'temp' => array( 'type' => 'int8', 'unit' => 'C' ),
				'battery' => array( 'type' => 'uint8', 'unit' => '' ),
				'status' => array( 'type' => 'byte', 'bits' => array(
					'grid_power' => array( false, true ) ) ),
				'connected_devices' => array( 'type' => 'uint8', 'unit' => '' ),
				'available devices' => array( 'type' => 'uint8', 'unit' => '' ),
			),

			#Payload devices
			array( '_cnf' => array( 'repeat' => false, 'name' => 'device', 'when' => array( array( 'header' => '01' ) ) ),
				'time' => array( 'type' => 'uint8', 'unit' => '' ),
				'time_diff' => array( 'type' => 'int8', 'unit' => 'min' ),
				'rssi' => array( 'type' => 'uint8', 'unit' => 'dBm', 'converter' => '*-1' ),

				#WM-BUS
				array( '_cnf' => array( 'repeat' => false, 'name' => 'wm_bus' ),
					'length' => array( 'type' => 'hex' ),
					'c_field' => array( 'type' => 'hex' ),
					'man_id' => array( 'type' => 'hex', 'length' => 2 ),
					'serial' => array( 'type' => 'hex', 'length' => 4 ),
					'version' => array( 'type' => 'hex' ),
					'type' => array( 'type' => 'hex' ),

					# NOT  
					'status' => array( 'type' => 'byte', 'bits' => array(
						array( 'bit' => '0-3', 'type' => 'decimal', 'parameter' => 'maximum_sf' ),
						array( 'bit' => 4, 'parameter' => 'sf_too_low', 'formatter' => array( false, true ) ),
						array( 'bit' => 5, 'parameter' => 'communication_lost', 'formatter' => array( false, true ) ),
					), 'when' => array( array( '{packet_length}' => '0f' ) ) ),

					# OK   
					'payload' => array( 'type' => 'hex', 'length' => array( 'device:wm_bus:length' ),
						'when' => array( array( '{packet_length}' => '>0f' ) ) ),

				),

			),


		);

		# fport 25
		$struct[ 25 ] = array(

			#main
			array( '_cnf' => array( 'repeat' => false ),

			)
		);

		# fport 50
		$struct[ 50 ] = array(

			#main
			array( '_cnf' => array( 'repeat' => false ),

			)
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
                'connected_devices'=>array('type'=>'uint8'),
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