<?php

class klm
{

    public $nascv;

    public $register = '[{"description":"","name":"RFU","unit":"","value":"0"},{"description":"Current date (YY-MM-DD)","name":"DATE","unit":"","value":"1", "formatter":"YY-MM-DD"},{"description":"Energy register 1: Heat energy","name":"E1","unit":"kWh","value":"2"},{"description":"Energy register 2: Control energy","name":"E2","unit":"kWh","formatter":"%.3f %s","value":"3"},{"description":"Energy register 3: Cooling energy","name":"E3","unit":"kWh","value":"4"},{"description":"Energy register 4: Flow energy","name":"E4","unit":"kWh","value":"5"},{"description":"Energy register 5: Return flow energy","name":"E5","unit":"kWh","value":"6"},{"description":"Energy register 6: Tap water energy","name":"E6","unit":"kWh","value":"7"},{"description":"Energy register 7: Heat energy Y","name":"E7","unit":"kWh","value":"8"},{"description":"Energy register 8: [m3 • T1]","name":"E8","unit":"","value":"9"},{"description":"Energy register 9: [m3 • T2]","name":"E9","unit":"","value":"10"},{"description":"Tariff register 2","name":"TA2","unit":"","value":"11"},{"description":"Tariff register 3","name":"TA3","unit":"","value":"12"},{"description":"Volume register V1","name":"V1","unit":"m3","value":"13"},{"description":"Volume register V2","name":"V2","unit":"m3","value":"14"},{"description":"Input register VA","name":"VA","unit":"","value":"15"},{"description":"Input register VB","name":"VB","unit":"","value":"16"},{"description":"Mass register V1","name":"M1","unit":"ton","value":"17"},{"description":"Mass register V2","name":"M2","unit":"ton","value":"18"},{"description":"Operational hour counter","name":"HR","unit":"","value":"19"},{"description":"Info-event counter","name":"INFOEV","unit":"","value":"20"},{"description":"Current time (hhmmss)","name":"CLOCK","unit":"","value":"21"},{"description":"Infocode register, current","name":"INFO","unit":"","value":"22"},{"description":"Current flow temperature","name":"T1","unit":"°C","value":"23"},{"description":"Current return flow temperature","name":"T2","unit":"°C","value":"24"},{"description":"Current temperature T3","name":"T3","unit":"°C","value":"25"},{"description":"Current temperature T4","name":"T4","unit":"°C","value":"26"},{"description":"Current temperature difference","name":"T1-T2","unit":"°C","value":"27"},{"description":"Pressure in flow","name":"P1","unit":"Bar","value":"28"},{"description":"Pressure in return flow","name":"P2","unit":"Bar","value":"29"},{"description":"Current flow in flow","name":"FLOW1","unit":"l/h","value":"30"},{"description":"Current flow in return flow","name":"FLOW2","unit":"l/h","value":"31"},{"description":"Current power calculated on the basis of V1-T1-T2","name":"EFFEKT1 (POWER)","unit":"kW","value":"32"},{"description":"Date for max. this year","name":"MAXFLOW1DATE/Y","unit":"l/h","value":"33"},{"description":"Max. value this year","name":"MAXFLOW1/Y","unit":"l/h","value":"34"},{"description":"Date for min. this year","name":"MINFLOW1DATE/Y","unit":"l/h","value":"35"},{"description":"Min. value this year","name":"MINFLOW1/Y","unit":"l/h","value":"36"},{"description":"Date for max. this year","name":"MAXEFFEKT1DATE/Y","unit":"kW","value":"37"},{"description":"Max. value this year","name":"MAXEFFEKT1/Y","unit":"kW","value":"38"},{"description":"Date for min. this year","name":"MINEFFEKT1DATE/Y","unit":"kW","value":"39"},{"description":"Min. value this year","name":"MINEFFEKT1/Y","unit":"kW","value":"40"},{"description":"Date for max. this year","name":"MAXFLOW1DATE/M","unit":"l/h","value":"41"},{"description":"Max. value this year","name":"MAXFLOW1/M","unit":"l/h","value":"42"},{"description":"Date for min. this month","name":"MINFLOW1DATE/M","unit":"l/h","value":"43"},{"description":"Min. value this month","name":"MINFLOW1/M","unit":"l/h","value":"44"},{"description":"Date for max. this month","name":"MAXEFFEKT1DATE/M","unit":"kW","value":"45"},{"description":"Max. value this month","name":"MAXEFFEKT1/M","unit":"kW","value":"46"},{"description":"Date for min. this month","name":"MINEFFEKT1DATE/M","unit":"kW","value":"47"},{"description":"Min. value this month","name":"MINEFFEKT1/M","unit":"kW","value":"48"},{"description":"Year-to-date average for T1","name":"AVR T1/Y","unit":"°C","value":"49"},{"description":"Year-to-date average for T2","name":"AVR T2/Y","unit":"°C","value":"50"},{"description":"Month-to-date average for T1","name":"AVR T1/M","unit":"°C","value":"51"},{"description":"Month-to-date average for T2","name":"AVR T2/M","unit":"°C","value":"52"},{"description":"Tariff limit 2","name":"TL2","unit":"","value":"53"},{"description":"Tariff limit 3","name":"TL3","unit":"","value":"54"},{"description":"Target date (reading date)","name":"XDAY","unit":"","value":"55"},{"description":"Program no. ABCCCCCC","name":"PROG NO","unit":"","value":"56"},{"description":"Config no. DDDEE","name":"CONFIG NO 1","unit":"","value":"57"},{"description":"Config no. FFGGMN","name":"CONFIG NO 2","unit":"","value":"58"},{"description":"Serial no. (unique number for each meter) (or custom. num)","name":"SERIAL NO","unit":"","value":"59"},{"description":"Customer number (8 most important digits)","name":"METER NO 2","unit":"","value":"60"},{"description":"Customer number (8 less important digits)","name":"METER NO 1","unit":"","value":"61"},{"description":"Meter no. for VA","name":"METER NO VA","unit":"","value":"62"},{"description":"Meter no. for VB","name":"METER NO VB","unit":"","value":"63"},{"description":"Software edition","name":"METER TYPE","unit":"","value":"64"},{"description":"Software check sum","name":"CHECK SUM 1","unit":"","value":"65"},{"description":"High-resolution energy register for testing purposes","name":"HIGH RES","unit":"","value":"66"},{"description":"ID number for top module ( only mc 601 )","name":"TOPMODUL ID","unit":"","value":"67"},{"description":"ID number for base module","name":"BOTMODUL ID","unit":"","value":"68"},{"description":"Error hour counter","name":"ERRORHOURCOUNTER","unit":"","value":"69"},{"description":"Liter/imp value for input A","name":"INA LITERIMP","unit":"","value":"70"},{"description":"Liter/imp value for input B","name":"INB LITERIMP","unit":"","value":"71"},{"description":"","name":"E1-E2","unit":"kWh","value":"72"},{"description":"High resolution measuring unit for heat energy 1","name":"QSUM1","unit":"","value":"73"},{"description":"High resolution measuring unit for heat energy 2","name":"QSUM2","unit":"","value":"74"},{"description":"-","name":"PRE COUNTER 1","unit":"","value":"75"},{"description":"-","name":"PRE COUNTER 2","unit":"","value":"76"},{"description":"-","name":"E_COLD","unit":"kWh","value":"77"},{"description":"-","name":"M3TF","unit":"","value":"78"},{"description":"-","name":"M3TR","unit":"","value":"79"},{"description":"-","name":"CALENDAR","unit":"","value":"80"},{"description":"Peak power current period","name":"P POWER ACT","unit":"kW","value":"81"},{"description":"Annual peak power","name":"P POWER YEAR","unit":"kW","value":"82"},{"description":"When this is sent, then queries will be emptied","name":"Disable all registers","unit":"If unit is none, then the register is not converted.","value":"255"}]';

    # structure by fport
    function rx_fport()
    {
        $struct = array();


        # firmware 0.5.0 updates
        $struct[ 24 ] = array(

            #packet type
            array( 'packet_type' => 'status_packet' ),

            #main
            array( '_cnf' => array( 'repeat' => false ),
                'rssi' => array( 'type' => 'int8', 'unit' => 'dBm', 'converter' => '*-1' ),
            ),

            array( '_cnf' => array( 'repeat' => true, 'name' => 'register' ),
                'register_id' => array( 'type' => 'uint8', 'formatter' => json_decode( $this->register, true ) ),
                'register_value' => array( 'type' => 'uint32', 'unit' => '{register_id>unit}', 'formatter'=>'%.3f %s' ),
            )
        );

        # firmware 0.6.0 updates
        if ($this->nascv->firmware >= 0.6) {
            $struct[ 24 ][ 1 ] = array( '_cnf' => array( 'repeat' => false ),
                'measuring_time' => array( 'type' => 'uint8' ),
                'clock' => array( 'type' => 'uint32', 'unit' => 'UTC', 'formatter' => ':date(d.m.Y H:i:s)', 'when' => array( array( 'measuring_time' => '<255' ) ) ),
                'rssi' => array( 'type' => 'int8', 'unit' => 'dBm', 'converter' => '*-1' ),
            );

        }

        # firmware 0.7.0 updates
        if ($this->nascv->firmware >= 0.7) {
            $struct[ 24 ][ 1 ] = array( '_cnf' => array( 'repeat' => false ),
                'measuring_time' => array( 'type' => 'uint8' ),
                'clock' => array( 'type' => 'uint32', 'unit' => 'UTC', 'formatter' => ':date(d.m.Y H:i:s)', 'when' => array( array( 'measuring_time' => '<255' ) ) ),
                'battery' => array( 'type' => 'uint8', 'formatter' => ':battery' ),
                'rssi' => array( 'type' => 'int8', 'unit' => 'dBm', 'converter' => '*-1' ),
            );

            $struct[ 24 ][ 2 ] = array( '_cnf' => array( 'repeat' => true, 'name' => 'register' ),
                'register_id' => array( 'type' => 'uint8', 'formatter' => json_decode( $this->register, true ) ),
                'register_value' => array( 'type' => 'float', 'unit' => '{register_id>unit}' ),
            );

        }

        # firmware 0.5.0 updates
        $struct[ 25 ] = array(

            #packet type
            array( 'packet_type' => 'usage_packet' ),

            #main
            array( '_cnf' => array( 'repeat' => false ),
                'header' => array( 'type' => 'hex' ),
            ),

            array( '_cnf' => array( 'repeat' => true, 'name' => 'register', 'when' => array( array( 'header' => '00' ) ) ),
                'register_id' => array( 'type' => 'uint8', 'formatter' => json_decode( $this->register, true ) ),
                'register_value' => array( 'type' => 'float', 'unit' => '{register_id>unit}', 'formatter'=>'%.3f %s' ),
            ),

            array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'header' => '02' ) ) ),
                'measuring_time' => array( 'type' => 'uint8' ),
                array( '_cnf' => array( 'repeat' => false, 'pulse_count' ),
                    '1' => array( 'type' => 'uint32' ),
                    '2' => array( 'type' => 'uint32' ),
                )
            )
        );


        # firmware 0.7.0
        if ($this->nascv->firmware >= 0.7) {
            $mesuring = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'header' => '00' ) ) ),
                'measuring_time' => array( 'type' => 'uint8' )
            );
            array_splice( $struct[ 25 ], 2, 0, array($mesuring) );

        }


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
                'kamstrup_meter_id' => array( 'type' => 'uint32' ),
                'kamstrup_config_a' => array( 'type' => 'hex', 'length' => 4 ),
                'kamstrup_config_b' => array( 'type' => 'hex', 'length' => 7, ),
                'kamstrup_type' => array( 'type' => 'hex', 'length' => 4, ),
                'device_mode' => array( 'type' => 'byte' ),
                'clock' => array( 'type' => 'uint32' ),
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