<?php
class lac {

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
				  'status'=>array('type'=>'byte', 'bits'=>array('lock'=>array('open','close'))),
				  'rssi'=>array('type'=>'uint8', 'unit'=>'dBm', 'converter'=>'*-1'),
				  'temp'=>array('type'=>'uint8', 'unit'=>'C'),
				  'card_count'=>array('type'=>'uint16'),
				  )
		);

		# fport 25
		$struct[ 25 ] = array(

			#packet type
			array( 'packet_type' => 'usage_packet' ),

			#main
			array( '_cnf' => array( 'repeat' => false ),
				  'status'=>array('type' => 'byte', 'bits'=>
								  array('allowed'=>array('no','yes'),
										'command'=>array('no','yes'))),
				  'card_number'=>array('type' => 'hex', 'length' => 3),
				  'time_closed'=>array('type'=>'uint16', 'unit'=>'minutes'),
				  )
		);

		# fport 50
		$struct[ 50 ] = array(

			#packet type
			array( 'packet_type' => 'configuration_packet' ),

			#header
			array( '_cnf' => array( 'repeat' => false ),
				  'header'=>array('type'=>'hex')
				),

			#Status interval
			array( '_cnf' => array( 'repeat' => false , 'when'=>array(array('header'=>'00'))),
				  'status_interval'=>array('type'=>'uint16','unit'=>'minutes')
				),

			#Open alert timer
			array( '_cnf' => array( 'repeat' => false , 'when'=>array(array('header'=>'01'))),
				  'open_alert_timer'=>array('type'=>'uint8','unit'=>'minutes')
				),
 			#Open time
			array( '_cnf' => array( 'repeat' => false , 'when'=>array(array('header'=>'02'))),
				  'open_time'=>array('type'=>'uint16','unit'=>'seconds')
				),
			#Direction
			array( '_cnf' => array( 'repeat' => false , 'when'=>array(array('header'=>'03'))),
				 'direction'=>array('type'=>'hex', 'length'=>1, 'formatter'=>array(array('value'=>'00', 'name'=>'default_signal_on','value'=>'01', 'name'=>'default_signal_off'))),
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
                'card_count'=>array('type'=>'uint16'),
                'switch_direction'=>array('type'=>'hex')
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