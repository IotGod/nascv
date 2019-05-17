<?php

class lwm
{

    public $nascv;

    # structure by fport
    function rx_fport()
    {
        $struct = array();

        # fport 24
        $struct[ 24 ] = array(

            #packet type
            array( 'packet_type' => 'status_packet' ),

            #main
            array( '_cnf' => array( 'repeat' => false ),
                'metering_data' => array( 'type' => 'uint32', 'unit' => 'L', 'formatter' => array(
                    array( 'value' => 4294967295, 'name' => 'n/a' ),
                    array( 'value' => '*', 'name' => '%s %s' )
                ) ),
                'battery' => array( 'type' => 'uint8', 'formatter' => ':battery:3.6' ),
                'temperature' => array( 'type' => 'int8', 'unit' => '°C', 'formatter' => '%s%s' ),
                'rssi' => array( 'type' => 'int8', 'unit' => 'dBm' ),
                'mode' => array( 'type' => 'byte' ),
                'alerts' => array( 'type' => 'byte' ),
                'noise' => array( 'type' => 'uint8' ),
                'accumulated_delta' => array( 'type' => 'uint16' ),
            ),

            array( '_cnf' => array( 'repeat' => 2, 'name' => 'dec' ),
                array( 'type' => 'uint16' ),
            ),


            array( '_cnf' => array( 'repeat' => false, 'name' => 'afe_1' ),
                'min' => array( 'type' => 'uint16' ),
                'max' => array( 'type' => 'uint16' )
            ),

            array( '_cnf' => array( 'repeat' => false, 'name' => 'afe_2' ),
                'min' => array( 'type' => 'uint16' ),
                'max' => array( 'type' => 'uint16' )
            )
        );


        # fport 25
        $struct[ 25 ] = array(

            #packet type
            array( 'packet_type' => 'usage_packet' ),

            #main
            array( '_cnf' => array( 'repeat' => false ),

            )
        );

        # fport 50
        $struct[ 50 ] = array(

            #packet type
            array( 'packet_type' => 'configuration_packet' ),

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
                'reset_reason' => array( 'type' => 'byte', 'bits' => array( 'RFU', 'watchdog_reset', 'soft_reset', 'RFU', 'magnet_wakeup', 'RFU', 'RFU', 'nfc_wakeup' ) ),
                'calibration_debug ' => array( 'type' => 'hex', 'length' => 8, 'byte_order' => 'LSB' ),
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