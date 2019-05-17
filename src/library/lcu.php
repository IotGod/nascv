<?php

class lcu
{

    public $nascv;

    # structure by fport
    function rx_fport()
    {
        $struct = array();

        /** F24 */
        $struct[ 24 ] = array(

            #packet type
            array( 'packet_type' => 'status_packet' )
        );

        $struct[ 24 ][ 'header' ] = array( '_cnf' => array( 'repeat' => false, 'name' => 'general' ),
            'device_unix_epoch' => array( 'type' => 'uint32', 'formatter' => ':date(d.m.Y H:i:s)' ),
            'status_field' => array( 'type' => 'byte', 'bits' =>
                array( 'dali_error_external' => array( 'ok', 'alert' ),
                    'dali_error_connection' => array( 'ok', 'alert' ),
                    'ldr_state' => array( 'off', 'on' ),
                    'thr_state' => array( 'off', 'on' ),
                    'dig_state' => array( 'off', 'on' ),
                    'hardware_error' => array( 'ok', 'error' ),
                    'software_error' => array( 'ok', 'error' ),
                    'relay_state' => array( 'off', 'on' )
                ) ),
            'downlink_rssi' => array( 'type' => 'int8', 'unit' => 'dBm' )
        );

        $struct[ 24 ][ 'profiles' ] = array( '_cnf' => array( 'repeat' => true, 'name' => 'profiles' ),
            'profile_id' => array( 'type' => 'uint8' ),
            'profile_version' => array( 'type' => 'uint8' ),
            'dali_address_short' => array( 'type' => 'uint8' ),
            'days_active' => array( 'type' => 'byte', 'bits' =>
                array( 'holiday', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) ),
            'dim_level' => array( 'type' => 'uint8', 'unit' => '%' )
        );

        # firmware 0.7.0 updates
        if ($this->nascv->firmware >= 0.7) {

            # adding new lines to main
            $struct[ 24 ][ 'header' ][ 'temp' ] = array( 'type' => 'uint8', 'unit' => 'celsius' );
            $struct[ 24 ][ 'header' ][ 'analog_mapping' ] = array( 'type' => 'byte', 'bits' => array( 'thr' => array( 'not reported', 'reported' ),
                'ldr' => array( 'not reported', 'reported' ) ) );
            $struct[ 24 ][ 'header' ][ 'thr_value' ] = array( 'type' => 'uint8', 'when' => array( array( 'analog_mapping:thr' => 1 ) ) );
            $struct[ 24 ][ 'header' ][ 'ldr_value' ] = array( 'type' => 'uint8', 'when' => array( array( 'analog_mapping:ldr' => 1 ) ) );

        }


        /** F25 */
        $struct[ 25 ] = array(

            #packet type
            array( 'packet_type' => 'usage_packet' ),

            #main
            array( '_cnf' => array( 'repeat' => false ),
                'cumulative_power_consumption' => array( 'type' => 'uint32', 'unit' => 'Wh' ),
                'current_consumption' => array( 'type' => 'uint16', 'unit' => 'W' ),
                'luminaire_burn_time' => array( 'type' => 'uint16', 'unit' => 'h' ),
                'system_voltage' => array( 'type' => 'uint8', 'unit' => 'V' ),
                'system_current' => array( 'type' => 'uint16', 'unit' => 'mA' ),
            )
        );

        if ($this->nascv->firmware >= 0.6) { # 0.6.20

            $struct[ 25 ] = array(
                array( 'packet_type' => 'usage_packet' ),
                array( '_cnf' => array( 'repeat' => true, 'name' => 'consumption_data' ),
                    'dali_address' => array( 'type' => 'hex', 'formatter' => array(
                        array( 'value' => 'ff', 'name' => 'internal_measurement' )
                    ) ),
                    'reported_fields' => array( 'type' => 'byte', 'bits' =>
                        array( 'active_energy_total' => array( 'not sent', 'sent' ),
                            'active_energy_instant' => array( 'not sent', 'sent' ),
                            'load_side_energy_total' => array( 'not sent', 'sent' ),
                            'load_side_energy_instant' => array( 'not sent', 'sent' ),
                            'power_factor_instant' => array( 'not sent', 'sent' ),
                            'system_voltage' => array( 'not sent', 'sent' )
                        ) ),
                    'active_energy_total' => array( 'type' => 'uint32', 'unit' => 'Wh', 'when' => array( array( 'reported_fields:active_energy_total' => 1 ) ) ),
                    'active_energy_instant' => array( 'type' => 'uint16', 'unit' => 'W', 'when' => array( array( 'reported_fields:active_energy_instant' => 1 ) ) ),
                    'load_side_energy_total' => array( 'type' => 'uint32', 'unit' => 'Wh', 'when' => array( array( 'reported_fields:load_side_energy_total' => 1 ) ) ),
                    'load_side_energy_instant' => array( 'type' => 'uint16', 'unit' => 'W', 'when' => array( array( 'reported_fields:load_side_energy_instant' => 1 ) ) ),
                    'power_factor_instant' => array( 'type' => 'uint8', 'converter' => '/100', 'when' => array( array( 'reported_fields:power_factor_instant' => 1 ) ) ),
                    'system_voltage' => array( 'type' => 'uint8', 'unit' => 'V', 'when' => array( array( 'reported_fields:system_voltage' => 1 ) ) )
                )
            );
        }


        /** F50 */
        $struct[ 50 ] = array(

            #packet type
            array( '_cnf' => array( 'repeat' => false, 'name' => 'packet_type', 'formatter' => '{packet_type:packet_type}' ),
                'packet_type' => array( 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '01', 'name' => 'ldr_config_packet' ),
                    array( 'value' => '02', 'name' => 'thr_config_packet' ),
                    array( 'value' => '03', 'name' => 'dig_config_packet' ),
                    array( 'value' => '05', 'name' => 'od_config_packet' ),
                    array( 'value' => '06', 'name' => 'calendar_config_packet' ),
                    array( 'value' => '07', 'name' => 'status_config_packet' ),
                    array( 'value' => '08', 'name' => 'profile_config_packet' ),
                    array( 'value' => '09', 'name' => 'time_config_packet' ),
                    array( 'value' => '0a', 'name' => 'defaults_config_packet' ),
                    array( 'value' => '0b', 'name' => 'usage_config_packet' ),
                    array( 'value' => '0c', 'name' => 'holiday_config_packet' ),
                    array( 'value' => '0d', 'name' => 'boot_delay_config_packet' ),

                ) ),
            ),
        );


        #ldr_config_packet
        $struct[ 50 ][ 'ldr_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'ldr_config_packet' ) ) ),
            array( '_cnf' => array( 'repeat' => false, 'name' => 'switch_thresholds' ),
                'high' => array( 'type' => 'uint8' ),
                'low' => array( 'type' => 'uint8' ),
            ),
            'switch_behaviour' => array( 'type' => 'byte', 'bits' =>
                array( 'switch_lights_on' => array( 'disabled', 'enabled' ),
                ) ),
        );

        #thr_config_packet
        $struct[ 50 ][ 'thr_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'thr_config_packet' ) ) ),
            array( '_cnf' => array( 'repeat' => false, 'name' => 'switch_thresholds' ),
                'high' => array( 'type' => 'uint8' ),
                'low' => array( 'type' => 'uint8' ),
            ),
            'switch_behaviour' => array( 'type' => 'byte', 'bits' =>
                array( 'switch_lights_on' => array( 'disabled', 'enabled' ),
                ) ),
        );

        #dig_config_packet
        $struct[ 50 ][ 'dig_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'dig_config_packet' ) ) ),
            'switch_time' => array( 'type' => 'uint16', 'unit' => 'seconds' ),
            'switch_behaviour' => array( 'type' => 'byte', 'bits' =>
                array( 'switch_lights_on' => array( 'disabled', 'enabled' ),
                ) ),
        );

        #od_config_packet
        $struct[ 50 ][ 'od_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'od_config_packet' ) ) ),
            'profile_id' => array( 'type' => 'uint8' ),
            'profile_version' => array( 'type' => 'uint8' ),
            'days_active' => array( 'type' => 'byte', 'bits' =>
                array( 'holiday', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) ),

            array( '_cnf' => array( 'repeat' => true, 'name' => 'dimming_step' ),
                'step_time' => array( 'type' => 'uint8' ),
                'dim_level' => array( 'type' => 'uint8' ),
            )
        );

        #calendar_config_packet
        $struct[ 50 ][ 'calendar_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'calendar_config_packet' ) ) ),
            'sunrise_offset' => array( 'type' => 'int8' ),
            'sunset_offset' => array( 'type' => 'int8' ),
            'latitude' => array( 'type' => 'int16' ),
            'longitude' => array( 'type' => 'int16' ),

        );

        #status_reporting_interval
        $struct[ 50 ][ 'status_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'status_config_packet' ) ) ),
            'status_interval' => array( 'type' => 'uint32', 'unit' => 'seconds' ),
        );

        #profile_config_packet
        $struct[ 50 ][ 'profile_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'profile_config_packet' ) ) ),
            'profile_id' => array( 'type' => 'uint8' ),
            'profile_version' => array( 'type' => 'uint8' ),
            'dali_address_short' => array( 'type' => 'uint8' ),
            'days_active' => array( 'type' => 'byte', 'bits' =>
                array( 'holiday', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) ),

            array( '_cnf' => array( 'repeat' => true, 'name' => 'dimming_step' ),
                'step_time' => array( 'type' => 'uint8', 'formatter' => ':date10(H:i)' ),
                'dim_level' => array( 'type' => 'uint8' ),
            )
        );

        #time_config_packet
        $struct[ 50 ][ 'time_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'time_config_packet' ) ) ),
            'device_unix_epoch' => array( 'type' => 'uint32', 'formatter' => ':date(d.m.Y H:i:s)' ),
        );


        #defaults_config_packet
        $struct[ 50 ][ 'defaults_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'defaults_config_packet' ) ) ),
            'default_dim' => array( 'type' => 'uint8', 'unit' => '%' ),
            'alert_behaviour' => array( 'type' => 'byte', 'bits' =>
                array( 'ldr_alert' => array( 'disabled', 'enabled' ),
                    'thr_alert' => array( 'disabled', 'enabled' ),
                    'dig_alert' => array( 'disabled', 'enabled' ),
                    'dali_alert' => array( 'disabled', 'enabled' ),
                ) ),
        );


        #usage_config_packet
        $struct[ 50 ][ 'usage_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'usage_config_packet' ) ) ),
            'usage_interval' => array( 'type' => 'uint32', 'unit' => 'seconds' ),
            'system_voltage' => array( 'type' => 'uint8', 'unit' => 'volts' ),
        );

        #holiday_config_packet
        $struct[ 50 ][ 'holiday_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'holiday_config_packet' ) ) ),
            array( '_cnf' => array( 'repeat' => true, 'name' => 'holiday' ),
                'day' => array( 'type' => 'uint16' ),
            )
        );


        #boot_delay_config_packet
        $struct[ 50 ][ 'boot_delay_config_packet' ] = array( '_cnf' => array( 'repeat' => false, 'when' => array( array( 'packet_type' => 'boot_delay_config_packet' ) ) ),
            'boot_delay_range' => array( 'type' => 'uint8', 'unit' => 'seconds' ),
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
                'clock' => array( 'type' => 'uint32', 'unit' => 'UTC', 'formatter' => ':date(d.m.Y H:i:s)' ),
                'hardware_config' => array( 'type' => 'hex', 'formatter' => array(
                    array( 'value' => '00', 'name' => 'DALI only' ),
                    array( 'value' => '01', 'name' => 'DALI & NC relay' ),
                    array( 'value' => '02', 'name' => 'DALI & NO relay' ),
                    array( 'value' => '03', 'name' => '0..10v & NC relay' ),
                    array( 'value' => '04', 'name' => '0..10v & NO relay' ),
                    array( 'value' => '05', 'name' => 'DALI & 0..10V & NC relay' ),
                    array( 'value' => '06', 'name' => 'DALI & 0..10V & NO relay' ),
                    array( 'value' => '07', 'name' => 'DALI & 0..10V & NO relay & NC Relay (NC Active)' ),
                    array( 'value' => '08', 'name' => 'DALI & 0..10V & NO relay & NC Relay (NO Active)' )
                ) ),
                'options' => array( 'type' => 'byte', 'bits' => array(
                    'neutral_out' => array( 'no', 'yes' ),
                    'THR' => array( 'no', 'yes' ),
                    'DIG' => array( 'no', 'yes' ),
                    'LDR' => array( 'no', 'yes' ),
                    'OD' => array( 'no', 'yes' ),
                    'metering' => array( 'no', 'yes' ),
                    'extra_surge_protection' => array( 'no', 'yes' ),
                    'custom_request' => array( 'no', 'yes' )
                ),
                ),
            )

        );


        return $struct;
    }

    /**
     * @return array
     */
    public
    function tx_fport()
    {
        $tx = self::rx_fport();
        return $tx;
    }

}