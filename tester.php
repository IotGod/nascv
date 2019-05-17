<?php
/*
 * NAS Converters TESTER
 * @author Rauno Avel
 * @copyright NAS 2018
 * @version 7.0 (30.12.2018)
 */

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

ini_set( 'memory_limit', '256M' );

$tests = array(


    /**
     *
     * LCU
     *
     */

    'LCU f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'SnUOXACfRAIE/zJEBQr/MkQBAv8ARAQI/wBEAwb/AEQGDP8A', 'fport' => '24', 'serial' => '4d1b0092' ),
        'results' =>
            '{"packet_type":"status_packet","general":{"device_unix_epoch":{"value":"10.12.2018 14:16:42","unit":"","formatted":"10.12.2018 14:16:42 ","value_raw":1544451402},"status_field":{"dali_error_external":{"value":"0","formatted":"ok"},"dali_error_connection":{"value":"0","formatted":"ok"},"ldr_state":{"value":"0","formatted":"off"},"thr_state":{"value":"0","formatted":"off"},"dig_state":{"value":"0","formatted":"off"},"hardware_error":{"value":"0","formatted":"ok"},"software_error":{"value":"0","formatted":"ok"},"relay_state":{"value":"0","formatted":"off"}},"downlink_rssi":{"value":-97,"unit":"dBm","formatted":"-97 dBm"}},"profiles":[{"profile_id":{"value":68,"unit":"","formatted":"68 "},"profile_version":{"value":2,"unit":"","formatted":"2 "},"dali_address_short":{"value":4,"unit":"","formatted":"4 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dim_level":{"value":50,"unit":"%","formatted":"50 %"}},{"profile_id":{"value":68,"unit":"","formatted":"68 "},"profile_version":{"value":5,"unit":"","formatted":"5 "},"dali_address_short":{"value":10,"unit":"","formatted":"10 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dim_level":{"value":50,"unit":"%","formatted":"50 %"}},{"profile_id":{"value":68,"unit":"","formatted":"68 "},"profile_version":{"value":1,"unit":"","formatted":"1 "},"dali_address_short":{"value":2,"unit":"","formatted":"2 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dim_level":{"value":0,"unit":"%","formatted":"0 %"}},{"profile_id":{"value":68,"unit":"","formatted":"68 "},"profile_version":{"value":4,"unit":"","formatted":"4 "},"dali_address_short":{"value":8,"unit":"","formatted":"8 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dim_level":{"value":0,"unit":"%","formatted":"0 %"}},{"profile_id":{"value":68,"unit":"","formatted":"68 "},"profile_version":{"value":3,"unit":"","formatted":"3 "},"dali_address_short":{"value":6,"unit":"","formatted":"6 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dim_level":{"value":0,"unit":"%","formatted":"0 %"}},{"profile_id":{"value":68,"unit":"","formatted":"68 "},"profile_version":{"value":6,"unit":"","formatted":"6 "},"dali_address_short":{"value":12,"unit":"","formatted":"12 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dim_level":{"value":0,"unit":"%","formatted":"0 %"}}],"hex":"4a750e5c009f440204ff3244050aff32440102ff00440408ff00440306ff0044060cff00"}' ),

    'LCU f25 (usage_packet)' => array( 'request' =>
        array( 'data' => '8ksDADMAVhM=', 'fport' => '25', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"usage_packet","cumulative_power_consumption":{"value":216050,"unit":"Wh","formatted":"216050 Wh"},"current_consumption":{"value":51,"unit":"W","formatted":"51 W"},"luminaire_burn_time":{"value":4950,"unit":"h","formatted":"4950 h"},"hex":"f24b030033005613"}' ),

    'LCU f25 (usage_packet) fw0.6.20' => array( 'request' =>
        array( 'data' => '/wMAAAAAAAAEA80PAAAAAAUDcg4AAAAABgM+DgAAAAAHAwsOAAAAAA==', 'fport' => '25', 'serial' => '4e1500bc', 'firmware' => '0.6.20' ),
        'results' => '{"packet_type":"usage_packet","consumption_data":[{"dali_address":{"value":"ff","unit":"","formatted":"internal_measurement"},"reported_fields":{"active_energy_total":{"value":"1","formatted":"sent"},"active_energy_instant":{"value":"1","formatted":"sent"},"load_side_energy_total":{"value":"0","formatted":"not sent"},"load_side_energy_instant":{"value":"0","formatted":"not sent"},"power_factor_instant":{"value":"0","formatted":"not sent"},"system_voltage":{"value":"0","formatted":"not sent"}},"active_energy_total":{"value":0,"unit":"Wh","formatted":"0 Wh"},"active_energy_instant":{"value":0,"unit":"W","formatted":"0 W"}},{"dali_address":{"value":"04","unit":""},"reported_fields":{"active_energy_total":{"value":"1","formatted":"sent"},"active_energy_instant":{"value":"1","formatted":"sent"},"load_side_energy_total":{"value":"0","formatted":"not sent"},"load_side_energy_instant":{"value":"0","formatted":"not sent"},"power_factor_instant":{"value":"0","formatted":"not sent"},"system_voltage":{"value":"0","formatted":"not sent"}},"active_energy_total":{"value":4045,"unit":"Wh","formatted":"4045 Wh"},"active_energy_instant":{"value":0,"unit":"W","formatted":"0 W"}},{"dali_address":{"value":"05","unit":""},"reported_fields":{"active_energy_total":{"value":"1","formatted":"sent"},"active_energy_instant":{"value":"1","formatted":"sent"},"load_side_energy_total":{"value":"0","formatted":"not sent"},"load_side_energy_instant":{"value":"0","formatted":"not sent"},"power_factor_instant":{"value":"0","formatted":"not sent"},"system_voltage":{"value":"0","formatted":"not sent"}},"active_energy_total":{"value":3698,"unit":"Wh","formatted":"3698 Wh"},"active_energy_instant":{"value":0,"unit":"W","formatted":"0 W"}},{"dali_address":{"value":"06","unit":""},"reported_fields":{"active_energy_total":{"value":"1","formatted":"sent"},"active_energy_instant":{"value":"1","formatted":"sent"},"load_side_energy_total":{"value":"0","formatted":"not sent"},"load_side_energy_instant":{"value":"0","formatted":"not sent"},"power_factor_instant":{"value":"0","formatted":"not sent"},"system_voltage":{"value":"0","formatted":"not sent"}},"active_energy_total":{"value":3646,"unit":"Wh","formatted":"3646 Wh"},"active_energy_instant":{"value":0,"unit":"W","formatted":"0 W"}},{"dali_address":{"value":"07","unit":""},"reported_fields":{"active_energy_total":{"value":"1","formatted":"sent"},"active_energy_instant":{"value":"1","formatted":"sent"},"load_side_energy_total":{"value":"0","formatted":"not sent"},"load_side_energy_instant":{"value":"0","formatted":"not sent"},"power_factor_instant":{"value":"0","formatted":"not sent"},"system_voltage":{"value":"0","formatted":"not sent"}},"active_energy_total":{"value":3595,"unit":"Wh","formatted":"3595 Wh"},"active_energy_instant":{"value":0,"unit":"W","formatted":"0 W"}}],"hex":"ff030000000000000403cd0f000000000503720e0000000006033e0e0000000007030b0e00000000"}' ),


     'LCU f50 (configuration_packet - ldr_config_packet)' => array( 'request' =>
        array( 'data' => 'Af4y', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"ldr_config_packet","switch_thresholds":{"high":{"value":254,"unit":"","formatted":"254 "},"low":{"value":50,"unit":"","formatted":"50 "}},"hex":"01fe32"}' ),

    'LCU f50 (configuration_packet - profile_config_packet)' => array( 'request' =>
        array( 'data' => 'CAIGDP9LMngUigA=', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"profile_config_packet","profile_id":{"value":2,"unit":"","formatted":"2 "},"profile_version":{"value":6,"unit":"","formatted":"6 "},"dali_address_short":{"value":12,"unit":"","formatted":"12 "},"days_active":["holiday","mon","tue","wed","thu","fri","sat","sun"],"dimming_step":[{"step_time":{"value":"12:30","unit":"","formatted":"12:30 ","value_raw":75},"dim_level":{"value":50,"unit":"","formatted":"50 "}},{"step_time":{"value":"20:00","unit":"","formatted":"20:00 ","value_raw":120},"dim_level":{"value":20,"unit":"","formatted":"20 "}},{"step_time":{"value":"23:00","unit":"","formatted":"23:00 ","value_raw":138},"dim_level":{"value":0,"unit":"","formatted":"0 "}}],"hex":"0802060cff4b3278148a00"}' ),

    'LCU f50 (configuration_packet - calendar_config_packet)' => array( 'request' =>
        array( 'data' => 'BuIeORecCQ==', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"calendar_config_packet","sunrise_offset":{"value":-30,"unit":"","formatted":"-30 "},"sunset_offset":{"value":30,"unit":"","formatted":"30 "},"latitude":{"value":5945,"unit":"","formatted":"5945 "},"longitude":{"value":2460,"unit":"","formatted":"2460 "},"hex":"06e21e39179c09"}' ),


    'LCU f50 (configuration_packet - time_config_packet)' => array( 'request' =>
        array( 'data' => 'CXBPp1w=', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"time_config_packet","device_unix_epoch":{"value":"05.04.2019 12:52:00","unit":"","formatted":"05.04.2019 12:52:00 ","value_raw":1554468720},"hex":"09704fa75c"}' ),


    'LCU f50 (configuration_packet - dig_config_packet)' => array( 'request' =>
        array( 'data' => 'AwoAAQ==', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"dig_config_packet","switch_time":{"value":10,"unit":"seconds","formatted":"10 seconds"},"switch_behaviour":{"switch_lights_on":{"value":"1","formatted":"enabled"}},"hex":"030a0001"}' ),

    'LCU f50 (configuration_packet - status_config_packet)' => array( 'request' =>
        array( 'data' => 'BwgHAAA=', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"status_config_packet","status_interval":{"value":1800,"unit":"seconds","formatted":"1800 seconds"},"hex":"0708070000"}' ),

    'LCU f50 (configuration_packet - usage_config_packet)' => array( 'request' =>
        array( 'data' => 'CwgHAADm', 'fport' => '50', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"usage_config_packet","usage_interval":{"value":1800,"unit":"seconds","formatted":"1800 seconds"},"system_voltage":{"value":230,"unit":"volts","formatted":"230 volts"},"hex":"0b08070000e6"}' ),


    'LCU f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'APQAHE0ABYkPFVRcAa0=', 'fport' => '99', 'serial' => '4d1b0092' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4d1c00f4","firmware_version":"0.5.137","clock":{"value":"01.02.2019 09:44:47","unit":"UTC","formatted":"01.02.2019 09:44:47 UTC","value_raw":1549014287},"hardware_config":{"value":"01","unit":"","formatted":"DALI & NC relay"},"options":{"neutral_out":{"value":"1","formatted":"yes"},"THR":{"value":"0","formatted":"no"},"DIG":{"value":"1","formatted":"yes"},"LDR":{"value":"1","formatted":"yes"},"OD":{"value":"0","formatted":"no"},"metering":{"value":"1","formatted":"yes"},"extra_surge_protection":{"value":"0","formatted":"no"},"custom_request":{"value":"1","formatted":"yes"}},"hex":"00f4001c4d0005890f15545c01ad"}' ),


    /**
     *
     * PMG
     *
     */
    'PMG f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'AZqpnkNJw+hdAAAA', 'fport' => '24', 'serial' => '34103412' ),
        'results' => '{"packet_type":"status_packet","general":{"relay_state":{"value":"1","formatted":"on"},"relay_switched_packet":{"value":"0","formatted":false},"counter_reset_packet":{"value":"0","formatted":false}},"accumulated_energy":{"value":317.32501220703,"unit":"kWh","formatted":"317.325 kWh"},"instant":{"frequency":{"value":49.993,"unit":"Hz","formatted":"49.993 Hz"},"voltage":{"value":240.4,"unit":"V","formatted":"240.4 V"},"power":{"value":0,"unit":"W","formatted":"0 W"}},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"hex":"019aa99e4349c3e85d000000"}' ),

    'PMG f25 (usage_packet)' => array( 'request' =>
        array( 'data' => 'LlJ7R2wA', 'fport' => '25', 'serial' => '34103412' ),
        'results' => '{"packet_type":"usage_packet","accumulated_energy":{"value":64338.1796875,"unit":"kWh","formatted":"64338.180 kWh"},"power":{"value":10.8,"unit":"W","formatted":"10.8 W"},"hex":"2e527b476c00"}' ),

    'PMG f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'AP////8AAgD//w==', 'fport' => '99', 'serial' => '34103412' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"ffffffff","firmware_version":"0.2.0","extension_module_0":{"value":"ff","unit":"","formatted":"not connected"},"extension_module_1":{"value":"ff","unit":"","formatted":"not connected"},"hex":"00ffffffff000200ffff"}' ),


    /**
     *
     * GM1
     *
     */

    'GM1 f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'A48UfECB9QgCEgAAAAA=', 'fport' => '24', 'serial' => '4E1B0018' ),
        'results' => '{"packet_type":"status_packet","header":{"interface":{"value":"03","formatted":"gas meter"},"user_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"battery_index":{"value":3.234,"unit":"V","formatted":"3.234 V","value_raw":143},"mcu_temp":{"value":20,"unit":"\u00b0C","formatted":"20\u00b0C"},"downlink_rssi":{"value":-124,"unit":"dBm","formatted":"-124 dBm"},"gas":{"settings":{"input_state":{"value":"0","formatted":false},"operational_mode":{"value":"0","formatted":"counter"},"medium_type":{"value":"04","formatted":"_gas"}},"counter":{"value":34141569,"unit":"L","formatted":"34141569 L"}},"tamper":{"settings":{"input_state":{"value":"0","formatted":false},"operational_mode":{"value":"1","formatted":"trigger_mode"},"is_alert":{"value":"0","formatted":"no"},"medium_type":{"value":"01","formatted":"events_"}},"counter":{"value":0,"unit":"events","formatted":"0 events"}},"hex":"038f147c4081f508021200000000"}' ),


    'GM1 f25 (usage_packet)' => array( 'request' =>
        array( 'data' => 'A0CwxZwBEgAAAAA=', 'fport' => '25', 'serial' => '4E1B0018' ),
        'results' => '{"packet_type":"usage_packet","interface":"03","gas":{"settings":{"input_state":{"value":"0","formatted":false},"operational_mode":{"value":"0","formatted":"counter"},"medium_type":{"value":"04","formatted":"_gas"}},"counter":{"value":27051440,"unit":"L","formatted":"27051440 L"}},"tamper":{"settings":{"input_state":{"value":"0","formatted":false},"operational_mode":{"value":"1","formatted":"trigger_mode"},"is_alert":{"value":"0","formatted":"no"},"medium_type":{"value":"01","formatted":"events_"}},"counter":{"value":0,"unit":"events","formatted":"0 events"}},"hex":"0340b0c59c011200000000"}' ),


    'GM1 f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'ACAAG04ABx8QAgA=', 'fport' => '99', 'serial' => '4E1B0018' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4e1b0020","firmware_version":"0.7.31","reset_reason":["magnet_wakeup"],"general_info":{"battery_type":{"value":2,"formatted":"3V6"}},"hardware_config":{"value":"00","unit":"","formatted":"digital_only"},"hex":"0020001b4e00071f100200"}' ),


    'GM1 f99 (shutdown_packet)' => array( 'request' =>
        array( 'data' => 'ATEDLxJwQDwAAAASAAAAAA==', 'fport' => '99', 'serial' => '4E1B0018' ),
        'results' => '{"packet_type":"shutdown_packet","shutdown_reason":{"value":"31","unit":"","formatted":"magnet_shutdown"},"header":{"interface":{"value":"03","formatted":"gas meter"},"user_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"battery_index":{"value":2.85,"unit":"V","formatted":"2.85 V","value_raw":47},"mcu_temp":{"value":18,"unit":"\u00b0C","formatted":"18\u00b0C"},"downlink_rssi":{"value":-112,"unit":"dBm","formatted":"-112 dBm"},"gas":{"settings":{"input_state":{"value":"0","formatted":false},"operational_mode":{"value":"0","formatted":"counter"},"medium_type":{"value":"04","formatted":"_gas"}},"counter":{"value":60,"unit":"L","formatted":"60 L"}},"tamper":{"settings":{"input_state":{"value":"0","formatted":false},"operational_mode":{"value":"1","formatted":"trigger_mode"},"is_alert":{"value":"0","formatted":"no"},"medium_type":{"value":"01","formatted":"events_"}},"counter":{"value":0,"unit":"events","formatted":"0 events"}},"hex":"0131032f1270403c0000001200000000"}' ),


    /**
     *
     * LAC
     *
     */
    'LAC f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'AEMAVQI=', 'fport' => '24', 'serial' => '4E09000A' ),
        'results' => '{"packet_type":"status_packet","status":{"lock":{"value":"0","formatted":"open"}},"rssi":{"value":-67,"unit":"dBm","formatted":"-67 dBm"},"temp":{"value":0,"unit":"C","formatted":"0 C"},"card_count":{"value":597,"unit":"","formatted":"597 "},"hex":"0043005502"}' ),

    'LAC f25 (usage_packet)' => array( 'request' =>
        array( 'data' => 'AawtIAoA', 'fport' => '25', 'serial' => '4E09000A' ),
        'results' => '{"packet_type":"usage_packet","status":{"allowed":{"value":"1","formatted":"yes"},"command":{"value":"0","formatted":"no"}},"card_number":"202dac","time_closed":{"value":10,"unit":"minutes","formatted":"10 minutes"},"hex":"01ac2d200a00"}' ),

    'LAC f50 (configuration_packet)' => array( 'request' =>
        array( 'data' => 'AQE=', 'fport' => '50', 'serial' => '4E09000A' ),
        'results' => '{"packet_type":"configuration_packet","header":"01","open_alert_timer":{"value":1,"unit":"minutes","formatted":"1 minutes"},"hex":"0101"}' ),


    'LAC f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'AAQACU4AAQ66AAA=', 'fport' => '99', 'serial' => '4E09000A' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4e090004","firmware_version":"0.1.14","card_count":{"value":186,"unit":"","formatted":"186 "},"switch_direction":"00","hex":"000400094e00010eba0000"}' ),


    /**
     *
     * AXI
     *
     */
    'AXI f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'lQ5rAJJ7AAAAAAAAAAA=', 'fport' => '24', 'serial' => '4D130024' ),
        'results' => '{"packet_type":"status_packet","module_battery":{"value":3.258,"unit":"V","formatted":"3.258 V","value_raw":149},"module_temp":{"value":14,"unit":"\u00b0C","formatted":"14\u00b0C"},"downlink_rssi":{"value":-107,"unit":"dBm","formatted":"-107 dBm"},"state":{"user_triggered_packet":{"value":"0","formatted":"no"},"error_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"accumulated_volume":{"value":31634,"unit":"L","formatted":"31634 L"},"meter_error":"00000000","register_map":{"accumulated_heat_energy":{"value":"0","formatted":"not_sent"},"accumulated_cooling_energy":{"value":"0","formatted":"not_sent"},"accumulated_pulse_1":{"value":"0","formatted":"not_sent"},"accumulated_pulse_2":{"value":"0","formatted":"not_sent"},"instant_flow_rate":{"value":"0","formatted":"not_sent"},"instant_power":{"value":"0","formatted":"not_sent"},"instant_temp_in":{"value":"0","formatted":"not_sent"},"instant_temp_out":{"value":"0","formatted":"not_sent"}},"hex":"950e6b00927b0000000000000000"}' ),

    'AXI f25 (usage_packet heat)' => array( 'request' =>
        array( 'data' => 'OKoIAPMAf08AAAAAAADy8c5ChP/JPyUS+ww=', 'fport' => '25', 'serial' => '4D130024' ),
        'results' => '{"packet_type":"usage_packet","accumulated_volume":{"value":567864,"unit":"L","formatted":"567864 L"},"register_map":{"accumulated_heat_energy":{"value":"1","formatted":"sent"},"accumulated_cooling_energy":{"value":"1","formatted":"sent"},"accumulated_pulse_1":{"value":"0","formatted":"not_sent"},"accumulated_pulse_2":{"value":"0","formatted":"not_sent"},"instant_flow_rate":{"value":"1","formatted":"sent"},"instant_power":{"value":"1","formatted":"sent"},"instant_temp_in":{"value":"1","formatted":"sent"},"instant_temp_out":{"value":"1","formatted":"sent"}},"accumulated_heat_energy":{"value":20351,"unit":"kWh","formatted":"20351 kWh"},"accumulated_cooling_energy":{"value":0,"unit":"kWh","formatted":"0 kWh"},"instant_flow_rate":{"value":103.47254943847656,"unit":"L\/h","formatted":"103.473 L\/h"},"instant_power":{"value":1.5781102180480957,"unit":"kW","formatted":"1.578 kW"},"instant_temp_in":{"value":46.45,"unit":"\u00b0C","formatted":"46.45\u00b0C"},"instant_temp_out":{"value":33.23,"unit":"\u00b0C","formatted":"33.23\u00b0C"},"hex":"38aa0800f3007f4f000000000000f2f1ce4284ffc93f2512fb0c"}' ),


    'AXI f25 (usage_packet)' => array( 'request' =>
        array( 'data' => 'lX4AABAAAAAAAA==', 'fport' => '25', 'serial' => '4D130024' ),
        'results' => '{"packet_type":"usage_packet","accumulated_volume":{"value":32405,"unit":"L","formatted":"32405 L"},"register_map":{"accumulated_heat_energy":{"value":"0","formatted":"not_sent"},"accumulated_cooling_energy":{"value":"0","formatted":"not_sent"},"accumulated_pulse_1":{"value":"0","formatted":"not_sent"},"accumulated_pulse_2":{"value":"0","formatted":"not_sent"},"instant_flow_rate":{"value":"1","formatted":"sent"},"instant_power":{"value":"0","formatted":"not_sent"},"instant_temp_in":{"value":"0","formatted":"not_sent"},"instant_temp_out":{"value":"0","formatted":"not_sent"}},"instant_flow_rate":{"value":0,"unit":"L\/h","formatted":"0.000 L\/h"},"hex":"957e0000100000000000"}' ),

    'AXI f25 (usage_packet - full)' => array( 'request' =>
        array( 'data' => '/IICAPMhNwAAAAAAAAAAAAAAAAAAxLw8QtxGA0I=', 'fport' => '25', 'serial' => '4D130024', 'firmware' => '0.7.63' ),
        'results' => '{"packet_type":"usage_packet","accumulated_volume":{"value":164604,"unit":"L","formatted":"164604 L"},"register_map":{"accumulated_heat_energy":{"value":"1","formatted":"sent"},"accumulated_cooling_energy":{"value":"1","formatted":"sent"},"accumulated_pulse_1":{"value":"0","formatted":"not_sent"},"accumulated_pulse_2":{"value":"0","formatted":"not_sent"},"instant_flow_rate":{"value":"1","formatted":"sent"},"instant_power":{"value":"1","formatted":"sent"},"instant_temp_in":{"value":"1","formatted":"sent"},"instant_temp_out":{"value":"1","formatted":"sent"}},"accumulated_heat_energy":{"value":55,"unit":"kWh","formatted":"55 kWh"},"accumulated_cooling_energy":{"value":0,"unit":"kWh","formatted":"0 kWh"},"instant_flow_rate":{"value":0,"unit":"L\/h","formatted":"0.000 L\/h"},"instant_power":{"value":-512,"unit":"kW","formatted":"-512.000 kW"},"instant_temp_in":{"value":155.48,"unit":"\u00b0C","formatted":"155.48\u00b0C"},"instant_temp_out":{"value":-91.5,"unit":"\u00b0C","formatted":"-91.50\u00b0C"},"hex":"fc820200f321370000000000000000000000000000c4bc3c42dc460342"}' ),


    'AXI f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'ACQAE00AAwUQiRQIAAA=', 'fport' => '99', 'serial' => '4D130024' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4d130024","firmware_version":"0.3.5","reset_reason":["magnet_wakeup"],"meter_id":"00081489","meter_type":{"value":"00","unit":"","formatted":"water_meter"},"hex":"002400134d000305108914080000"}' ),

    'AXI f99 (shutdown_packet)' => array( 'request' =>
        array( 'data' => 'ATGIGGIAAAAAAAQEAAAAAA==', 'fport' => '99', 'serial' => '4D130024' ),
        'results' => '{"packet_type":"shutdown_packet","shutdown_reason":{"value":"31","unit":"","formatted":"magnet_shutdown"},"module_battery":{"value":3.206,"unit":"V","formatted":"3.206 V","value_raw":136},"module_temp":{"value":24,"unit":"\u00b0C","formatted":"24\u00b0C"},"downlink_rssi":{"value":-98,"unit":"dBm","formatted":"-98 dBm"},"state":{"user_triggered_packet":{"value":"0","formatted":"no"},"error_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"accumulated_volume":{"value":0,"unit":"L","formatted":"0 L"},"meter_error":"00000404","register_map":{"accumulated_heat_energy":{"value":"0","formatted":"not_sent"},"accumulated_cooling_energy":{"value":"0","formatted":"not_sent"},"accumulated_pulse_1":{"value":"0","formatted":"not_sent"},"accumulated_pulse_2":{"value":"0","formatted":"not_sent"},"instant_flow_rate":{"value":"0","formatted":"not_sent"},"instant_power":{"value":"0","formatted":"not_sent"},"instant_temp_in":{"value":"0","formatted":"not_sent"},"instant_temp_out":{"value":"0","formatted":"not_sent"}},"hex":"01318818620000000000040400000000"}' ),


    /**
     *
     * WML
     *
     */

    'WML f24 (status_packet - payload)' => array( 'request' =>
        array( 'data' => 'Af/ESzFELSwWmBRpHASNIG7YOdgiRiB62UwfYi/xXrNKD26++drYGw135vvGYQ6z1qVLE1lL', 'fport' => '24', 'serial' => '4c1d0224' ),
        'results' => '{"packet_type":"status_packet","header":"01","device":{"time":{"value":255,"unit":"","formatted":"255 "},"time_diff":{"value":-60,"unit":"min","formatted":"-60 min"},"rssi":{"value":-75,"unit":"dBm","formatted":"-75 dBm"},"wm_bus":{"length":"31","c_field":"44","man_id":"2c2d","serial":"69149816","version":"1c","type":"04","payload":"4b59134ba5d6b30e61c6fbe6770d1bd8daf9be6e0f4ab35ef12f621f4cd97a204622d839d86e208d"}},"hex":"01ffc44b31442d2c169814691c048d206ed839d82246207ad94c1f622ff15eb34a0f6ebef9dad81b0d77e6fbc6610eb3d6a54b13594b"}' ),

    'WML f24 (status_packet - error)' => array( 'request' =>
        array( 'data' => 'Af8AbDFELSxjAJNpHAQc', 'fport' => '24', 'serial' => '4c1d0224' ),
        'results' => '{"packet_type":"status_packet","header":"01","device":{"time":{"value":255,"unit":"","formatted":"255 "},"time_diff":{"value":0,"unit":"min","formatted":"0 min"},"rssi":{"value":-108,"unit":"dBm","formatted":"-108 dBm"},"wm_bus":{"length":"31","c_field":"44","man_id":"2c2d","serial":"69930063","version":"1c","type":"04","status":{"maximum_sf":{"value":12},"sf_too_low":{"value":"1","formatted":true},"communication_lost":{"value":"0","formatted":false}}}},"hex":"01ff006c31442d2c630093691c041c"}' ),

    'WML f24 (status_packet - bridge)' => array( 'request' =>
        array( 'data' => 'AJIobzgAE/8AAwI=', 'fport' => '24', 'serial' => '4c1d0224' ),
        'results' => '{"packet_type":"status_packet","header":"00","bridge":{"time":{"value":946808978,"unit":"UTC","formatted":"946808978 UTC"},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"temp":{"value":19,"unit":"C","formatted":"19 C"},"battery":{"value":255,"unit":"","formatted":"255 "},"status":{"grid_power":{"value":"0","formatted":false}},"connected_devices":{"value":3,"unit":"","formatted":"3 "},"available devices":{"value":2,"unit":"","formatted":"2 "}},"hex":"0092286f380013ff000302"}' ),

    'WML f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'ABUAHUwAAQoA', 'fport' => '99', 'serial' => '4c1d0224' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4c1d0015","firmware_version":"0.1.10","connected_devices":{"value":0,"unit":"","formatted":"0 "},"hex":"0015001d4c00010a00"}' ),


    /**
     *
     * OIR
     *
     */

    'OIR f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'AAcAEU0ABxkQAgQ=', 'fport' => '99', 'serial' => '4D110007' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4d110007","firmware_version":"0.7.25","reset_reason":["magnet_wakeup"],"general_info":{"battery_type":{"value":2,"formatted":"3V6"}},"hardware_config":{"value":"04","unit":"","formatted":"digital_+_mbus"},"hex":"000700114d000719100204"}' ),

    'OIR f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'AawXcCCPeSUA', 'fport' => '24', 'serial' => '4C1600FF' ),
        'results' => '{"packet_type":"status_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"0","formatted":"not_sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"0","formatted":"not_sent"},"user_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"battery":{"value":3.35,"unit":"V","formatted":"3.35 V","value_raw":172},"mcu_temperature":{"value":23,"unit":"\u00b0C","formatted":"23\u00b0C"},"downlink_rssi":{"value":-112,"unit":"dBm","formatted":"-112 dBm"},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"02","formatted":"L_water"}},"counter":{"value":2455951,"unit":"L_water","formatted":"2455951 L_water"}},"hex":"01ac1770208f792500"}' ),

    'OIR f24 (status_packet - 2x digital)' => array( 'request' =>
        array( 'data' => 'QxEXXxAAAAAAQhAAAJE=', 'fport' => '24', 'serial' => '4C1600FF' ),
        'results' => '{"packet_type":"status_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"1","formatted":"sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"0","formatted":"not_sent"},"user_triggered_packet":{"value":"1","formatted":"yes"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"battery":{"value":2.684,"unit":"V","formatted":"2.684 V","value_raw":17},"mcu_temperature":{"value":23,"unit":"\u00b0C","formatted":"23\u00b0C"},"downlink_rssi":{"value":-95,"unit":"dBm","formatted":"-95 dBm"},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"digital_2":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"1","formatted":"trigger_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"04","formatted":"L_gas"}},"counter":{"value":2432696336,"unit":"L_gas","formatted":"2432696336 L_gas"}},"hex":"4311175f10000000004210000091"}' ),

    'OIR f24 (status_packet - mbus)' => array( 'request' =>
        array( 'data' => 'oxABchAAAAAAEAAAAAAAAAx4ITkTAAwUZAAAAA==', 'fport' => '24', 'serial' => '4C1600FF' ),
        'results' => '{"packet_type":"status_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"1","formatted":"sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"1","formatted":"sent"},"user_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"1","formatted":"yes"}},"battery":{"value":2.634,"unit":"V","formatted":"2.634 V","value_raw":16},"mcu_temperature":{"value":1,"unit":"\u00b0C","formatted":"1\u00b0C"},"downlink_rssi":{"value":-114,"unit":"dBm","formatted":"-114 dBm"},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"digital_2":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"mbus":{"state":{"last_status":{"value":"00","formatted":"ok"}},"mbus_status":"00","data_records":{"1":{"_function":"instant value","value_type":"fabrication number","_encoding":"8 digit BCD","_header_raw":"0c78","_data_raw":"21391300","value":133921},"2":{"_function":"instant value","value_type":"volume","unit":" m\u00b3","_exp":-2,"_encoding":"8 digit BCD","_header_raw":"0c14","_data_raw":"64000000","value":0.64,"_value_raw":64}}},"hex":"a31001721000000000100000000000000c78213913000c1464000000"}' ),


    'OIR f24 (status_packet - mbus empty)' => array( 'request' =>
        array( 'data' => 'o3QDchAAAAAAEAAAAAABAAA=', 'fport' => '24', 'serial' => '4C1600FF' ),
        'results' => '{"packet_type":"status_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"1","formatted":"sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"1","formatted":"sent"},"user_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"1","formatted":"yes"}},"battery":{"value":3.126,"unit":"V","formatted":"3.126 V","value_raw":116},"mcu_temperature":{"value":3,"unit":"\u00b0C","formatted":"3\u00b0C"},"downlink_rssi":{"value":-114,"unit":"dBm","formatted":"-114 dBm"},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"digital_2":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"mbus":{"state":{"last_status":{"value":"01","formatted":"nothing_requested"}}},"hex":"a374037210000000001000000000010000"}' ),


    'OIR f24 (status_packet - ssi)' => array( 'request' =>
        array( 'data' => 'EfcaZBAAAAAAgQULRrU/9ijOQQ==', 'fport' => '24', 'serial' => '4d880060' ),
        'results' => '{"packet_type":"status_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"0","formatted":"not_sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"1","formatted":"sent"},"mbus":{"value":"0","formatted":"not_sent"},"user_triggered_packet":{"value":"0","formatted":"no"},"temperature_triggered_packet":{"value":"0","formatted":"no"}},"battery":{"value":3.65,"unit":"V","formatted":"3.65 V","value_raw":247},"mcu_temperature":{"value":26,"unit":"\u00b0C","formatted":"26\u00b0C"},"downlink_rssi":{"value":-100,"unit":"dBm","formatted":"-100 dBm"},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"ssi":{"general":{"ssi_index":{"value":1},"is_alert":{"value":"1","formatted":true}},"reported_parameters":{"channel_1_instant":{"value":"1","formatted":"reported"},"channel_2_instant":{"value":"1","formatted":"reported"},"channel_3_instant":{"value":"0","formatted":"not reported"},"channel_4_instant":{"value":"0","formatted":"not reported"}},"channel_1_instant":{"value":1.416200041770935,"unit":"bar","formatted":"1.4162000417709 bar"},"channel_2_instant":{"value":25.770000457763672,"unit":"\u00b0C","formatted":"25.770000457764 \u00b0C"}},"hex":"11f71a64100000000081050b46b53ff628ce41"}' ),


    'OIR f25 (usage_packet)' => array( 'request' =>
        array( 'data' => 'ASDw2yUA', 'fport' => '25', 'serial' => '4D110007' ),
        'results' => '{"packet_type":"usage_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"0","formatted":"not_sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"0","formatted":"not_sent"}},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"02","formatted":"L_water"}},"counter":{"value":2481136,"unit":"L_water","formatted":"2481136 L_water"}},"hex":"0120f0db2500"}' ),


    'OIR f25 (usage_packet - mbus)' => array( 'request' =>
        array( 'data' => 'IxAAAAAAEAAAAAAADBZhdQEA', 'fport' => '25', 'serial' => '4D110007' ),
        'results' => '{"packet_type":"usage_packet","reported_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"1","formatted":"sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"1","formatted":"sent"}},"digital_1":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"digital_2":{"state":{"input_state":{"value":"0"},"operational_mode":{"value":"0","formatted":"pulse_mode"},"alert_state":{"value":"0"},"medium_type":{"value":"01","formatted":"pulses"}},"counter":{"value":0,"unit":"pulses","formatted":"0 pulses"}},"mbus":{"state":{"last_status":{"value":"00","formatted":"ok"}},"data_records":{"1":{"_function":"instant value","value_type":"volume","unit":" m\u00b3","_exp":0,"_encoding":"8 digit BCD","_header_raw":"0c16","_data_raw":"61750100","value":17561}}},"hex":"2310000000001000000000000c1661750100"}' ),


    'OIR f53 (mbus_connect_packet)' => array( 'request' =>
        array( 'data' => 'AcA0E5cj1iVAB8QAAAAMeAwW', 'fport' => '53', 'serial' => '4D110007' ),
        'results' => '{"packet_type":"mbus_connect_packet","interface":"01","header":{"packet_number":{"value":0},"more_to_follow":{"value":0},"fixed_data_header":{"value":"1","formatted":"sent"},"data_record_headers_only":{"value":"1","formatted":"headers only"}},"mbus_fixed_header":{"id":"23971334","manufacturer":"INV","version":64,"medium":"water","access_number":196,"status":0,"signature":0},"record_headers":{"1":{"_function":"instant value","value_type":"fabrication number","_encoding":"8 digit BCD","_header_raw":"0c78"},"2":{"_function":"instant value","value_type":"volume","unit":" m\u00b3","_exp":0,"_encoding":"8 digit BCD","_header_raw":"0c16"}},"hex":"01c034139723d6254007c40000000c780c16"}' ),


    'OIR f49 (general_config_response)' => array( 'request' =>
        array( 'data' => 'ADwAoAUAIxMAEwA0E5cjByEMFgwWDHg=', 'fport' => '49', 'serial' => '4D110007' ),
        'results' => '{"packet_type":"general_config_response","usage_interval":{"value":60,"unit":"minutes","formatted":"60 minutes"},"status_interval":{"value":1440,"unit":"minutes","formatted":"1440 minutes"},"usage_behaviour":{"send_always":{"value":"0","formatted":"only_when_fresh_data"}},"configured_interfaces":{"digital_1":{"value":"1","formatted":"sent"},"digital_2":{"value":"1","formatted":"sent"},"analog_1":{"value":"0","formatted":"not_sent"},"analog_2":{"value":"0","formatted":"not_sent"},"ssi":{"value":"0","formatted":"not_sent"},"mbus":{"value":"1","formatted":"sent"}},"digital_1":{"configured_parameters":{"interface_enabled":{"value":"1","formatted":"enabled"},"mode":{"value":"1","formatted":"sent"},"multiplier":{"value":"0","formatted":"not_sent"},"true_reading":{"value":"0","formatted":"not_sent"},"medium_type":{"value":"01","formatted":"pulses"}},"mode":{"operational_mode":{"value":"0","formatted":"pulse_mode"},"trigger_time":{"value":"00","formatted":"1_sec"}}},"digital_2":{"configured_parameters":{"interface_enabled":{"value":"1","formatted":"enabled"},"mode":{"value":"1","formatted":"sent"},"multiplier":{"value":"0","formatted":"not_sent"},"true_reading":{"value":"0","formatted":"not_sent"},"medium_type":{"value":"01","formatted":"pulses"}},"mode":{"operational_mode":{"value":"0","formatted":"pulse_mode"},"trigger_time":{"value":"00","formatted":"1_sec"}}},"mbus":{"mbus_device_serial":{"value":"23971334","unit":""},"configured_parameters":{"interface_enabled":{"value":"1","formatted":"enabled"},"data_records_in_usage":{"value":"1","formatted":"configured"},"data_records_in_status":{"value":"1","formatted":"configured"}},"data_records_for_packets":{"count_in_usage":{"value":1},"count_in_status":{"value":2}},"records":{"usage":[{"_function":"instant value","value_type":"volume","unit":" m\u00b3","_exp":0,"_encoding":"8 digit BCD","_header_raw":"0c16"}],"status":[{"_function":"instant value","value_type":"volume","unit":" m\u00b3","_exp":0,"_encoding":"8 digit BCD","_header_raw":"0c16"},{"_function":"instant value","value_type":"fabrication number","_encoding":"8 digit BCD","_header_raw":"0c78"}]}},"hex":"003c00a0050023130013003413972307210c160c160c78"}' ),


    /**
     *
     * MLM
     *
     */

    'MLM f24 (status_packet)' => array( 'request' =>
        array( 'data' => '7FEAAKUHAAAA', 'fport' => '24', 'serial' => '4C11004D' ),
        'results' => '{"packet_type":"status_packet","metering_data":{"value":20972,"unit":"L","formatted":"20972 L"},"battery":{"value":2.83,"unit":"V","formatted":"2.83 V","value_raw":165},"temperature":{"value":7,"unit":"\u00b0C","formatted":"7\u00b0C"},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"mode":"00000000","alerts":"00000000","hex":"ec510000a507000000"}' ),

    'MLM f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'AE0CEUwABgECBAB5AGUBAAAAAA==', 'fport' => '99', 'serial' => '4C11004D' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4c11024d","firmware_version":"0.6.1","reset_reason":["watchdog_reset"],"calibration_debug ":"0400790065010000","hex":"004d02114c0006010204007900650100000000"}' ),

    'MLM f99 (shutdown_packet)' => array( 'request' =>
        array( 'data' => 'ATGbAAAAxxcAAAA=', 'fport' => '99', 'serial' => '4C11004D' ),
        'results' => '{"packet_type":"shutdown_packet","shutdown_reason":{"value":"31","unit":"","formatted":"magnet_shutdown"},"metering_data":{"value":155,"unit":"L","formatted":"155 L"},"battery":{"value":2.966,"unit":"V","formatted":"2.966 V","value_raw":199},"temperature":{"value":23,"unit":"\u00b0C","formatted":"23\u00b0C"},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"mode":"00000000","alerts":"00000000","hex":"01319b000000c717000000"}' ),


    /**
     *
     * KLM
     *
     */

    'KLM f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'ABMAHk0ACAKrG8UEAHetAAA2AQAYGBQAGwIAAAEwZQlc', 'fport' => '99', 'serial' => '4D1E0013' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4d1e0013","firmware_version":"0.8.2","kamstrup_meter_id":{"value":80026539,"unit":"","formatted":"80026539 "},"kamstrup_config_a":"00ad7700","kamstrup_config_b":"14181800013600","kamstrup_type":"00021b00","device_mode":"00000000","clock":{"value":157626369,"unit":"","formatted":"157626369 "},"hex":"0013001e4d000802ab1bc5040077ad0000360100181814001b020000013065095c"}' ),


    'KLM f24 (status_packet) fw0.8.2' => array( 'request' =>
        array( 'data' => 'dwv1VVz/AAIAAAAADQAAAAATAHiTRRcK18dBGKRwx0EbzMxMPR4AAAAAIAAAAAA=', 'fport' => '24', 'serial' => '4D1E0013', 'firmware' => '0.8.2' ),
        'results' => '{"packet_type":"status_packet","measuring_time":{"value":119,"unit":"","formatted":"119 "},"clock":{"value":"02.02.2019 19:52:43","unit":"UTC","formatted":"02.02.2019 19:52:43 UTC","value_raw":1549137163},"battery":{"value":"no battery info","unit":"V","formatted":"no battery info V","value_raw":255},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"register":[{"register_id":{"value":"2","unit":"kWh","formatted":"E1","description":"Energy register 1: Heat energy"},"register_value":{"value":0,"unit":"kWh","formatted":"0 kWh"}},{"register_id":{"value":"13","unit":"m3","formatted":"V1","description":"Volume register V1"},"register_value":{"value":0,"unit":"m3","formatted":"0 m3"}},{"register_id":{"value":"19","unit":"","formatted":"HR","description":"Operational hour counter"},"register_value":{"value":4719,"unit":"","formatted":"4719 "}},{"register_id":{"value":"23","unit":"\u00b0C","formatted":"T1","description":"Current flow temperature"},"register_value":{"value":24.979999542236,"unit":"\u00b0C","formatted":"24.979999542236 \u00b0C"}},{"register_id":{"value":"24","unit":"\u00b0C","formatted":"T2","description":"Current return flow temperature"},"register_value":{"value":24.930000305176,"unit":"\u00b0C","formatted":"24.930000305176 \u00b0C"}},{"register_id":{"value":"27","unit":"\u00b0C","formatted":"T1-T2","description":"Current temperature difference"},"register_value":{"value":0.049999997019768,"unit":"\u00b0C","formatted":"0.049999997019768 \u00b0C"}},{"register_id":{"value":"30","unit":"l\/h","formatted":"FLOW1","description":"Current flow in flow"},"register_value":{"value":0,"unit":"l\/h","formatted":"0 l\/h"}},{"register_id":{"value":"32","unit":"kW","formatted":"EFFEKT1 (POWER)","description":"Current power calculated on the basis of V1-T1-T2"},"register_value":{"value":0,"unit":"kW","formatted":"0 kW"}}],"hex":"770bf5555cff0002000000000d000000001300789345170ad7c74118a470c7411bcccc4c3d1e000000002000000000"}' ),


    'KLM f25 (usage_packet) fw0.8.2' => array( 'request' =>
        array( 'data' => 'AP8Ne7TLQwIBsDpFEwDwpEUX4Xo1Qhh7FBxCHgBAD0QgMzODQBYAAAAAHAAAAAA=', 'fport' => '25', 'serial' => '4D1E0013', 'firmware' => '0.8.2' ),
        'results' => '{"packet_type":"usage_packet","header":"00","measuring_time":{"value":255,"unit":"","formatted":"255 "},"register":[{"register_id":{"value":"13","unit":"m3","formatted":"V1","description":"Volume register V1"},"register_value":{"value":407.4100036621094,"unit":"m3","formatted":"407.410 m3"}},{"register_id":{"value":"2","unit":"kWh","formatted":"E1","description":"Energy register 1: Heat energy"},"register_value":{"value":2987.000244140625,"unit":"kWh","formatted":"2987.000 kWh"}},{"register_id":{"value":"19","unit":"","formatted":"HR","description":"Operational hour counter"},"register_value":{"value":5278,"unit":"","formatted":"5278.000 "}},{"register_id":{"value":"23","unit":"\u00b0C","formatted":"T1","description":"Current flow temperature"},"register_value":{"value":45.369998931884766,"unit":"\u00b0C","formatted":"45.370 \u00b0C"}},{"register_id":{"value":"24","unit":"\u00b0C","formatted":"T2","description":"Current return flow temperature"},"register_value":{"value":39.02000045776367,"unit":"\u00b0C","formatted":"39.020 \u00b0C"}},{"register_id":{"value":"30","unit":"l\/h","formatted":"FLOW1","description":"Current flow in flow"},"register_value":{"value":573,"unit":"l\/h","formatted":"573.000 l\/h"}},{"register_id":{"value":"32","unit":"kW","formatted":"EFFEKT1 (POWER)","description":"Current power calculated on the basis of V1-T1-T2"},"register_value":{"value":4.099999904632568,"unit":"kW","formatted":"4.100 kW"}},{"register_id":{"value":"22","unit":"","formatted":"INFO","description":"Infocode register, current"},"register_value":{"value":0,"unit":"","formatted":"0.000 "}},{"register_id":{"value":"28","unit":"Bar","formatted":"P1","description":"Pressure in flow"},"register_value":{"value":0,"unit":"Bar","formatted":"0.000 Bar"}}],"hex":"00ff0d7bb4cb430201b03a451300f0a44517e17a3542187b141c421e00400f44203333834016000000001c00000000"}' ),


    /*'KLM f24 (usage_packet) fw0.5.2' => array( 'request' =>
        array( 'data' => 'eg8AAAAADAAAAAARzdrNRwYAAAAAHwAAAAAaCtcjPAGA2DlIMwAAlkI1AAAAAA==', 'fport' => '24', 'serial' => '4D1E0013', 'firmware' => '0.5.2' ),
        'results' => '{}' ),*/

    'KLM f25 (usage_packet) fw0.5.2' => array( 'request' =>
        array( 'data' => 'AA0azc9HAuFCZ0UTAH4MRxd7lKRCGM3MQkIeAMDARSCaGW5DFgAAAAAcAAAAAA==', 'fport' => '25', 'serial' => '4D1E0013', 'firmware' => '0.5.2' ),
        'results' => '{"packet_type":"usage_packet","header":"00","register":[{"register_id":{"value":"13","unit":"m3","formatted":"V1","description":"Volume register V1"},"register_value":{"value":106394.203125,"unit":"m3","formatted":"106394.203 m3"}},{"register_id":{"value":"2","unit":"kWh","formatted":"E1","description":"Energy register 1: Heat energy"},"register_value":{"value":3700.179931640625,"unit":"kWh","formatted":"3700.180 kWh"}},{"register_id":{"value":"19","unit":"","formatted":"HR","description":"Operational hour counter"},"register_value":{"value":35966,"unit":"","formatted":"35966.000 "}},{"register_id":{"value":"23","unit":"\u00b0C","formatted":"T1","description":"Current flow temperature"},"register_value":{"value":82.29000091552734,"unit":"\u00b0C","formatted":"82.290 \u00b0C"}},{"register_id":{"value":"24","unit":"\u00b0C","formatted":"T2","description":"Current return flow temperature"},"register_value":{"value":48.70000076293945,"unit":"\u00b0C","formatted":"48.700 \u00b0C"}},{"register_id":{"value":"30","unit":"l\/h","formatted":"FLOW1","description":"Current flow in flow"},"register_value":{"value":6168,"unit":"l\/h","formatted":"6168.000 l\/h"}},{"register_id":{"value":"32","unit":"kW","formatted":"EFFEKT1 (POWER)","description":"Current power calculated on the basis of V1-T1-T2"},"register_value":{"value":238.10000610351562,"unit":"kW","formatted":"238.100 kW"}},{"register_id":{"value":"22","unit":"","formatted":"INFO","description":"Infocode register, current"},"register_value":{"value":0,"unit":"","formatted":"0.000 "}},{"register_id":{"value":"28","unit":"Bar","formatted":"P1","description":"Pressure in flow"},"register_value":{"value":0,"unit":"Bar","formatted":"0.000 Bar"}}],"hex":"000d1acdcf4702e142674513007e0c47177b94a44218cdcc42421e00c0c045209a196e4316000000001c00000000"}' ),


    /**
     *
     * WMR
     *
     */

    'WMR f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'vgAAADwOiUwA', 'fport' => '24', 'serial' => '35100076' ),
        'results' => '{"packet_type":"status_packet","metering_data":{"value":190,"unit":"L","formatted":"190 L"},"battery":{"value":2.902,"unit":"V","formatted":"2.902 V","value_raw":60},"temp":{"value":14,"unit":"C","formatted":"14 C"},"rssi":{"value":-137,"unit":"dBm","formatted":"-137 dBm"},"mode":"01001100","alerts":"00000000","hex":"be0000003c0e894c00"}' ),


    'WMR f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'AHYAEDUAApg=', 'fport' => '99', 'serial' => '35100076' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"35100076","firmware_version":"0.2.152","hex":"0076001035000298"}' ),


    /**
     *
     * LGM
     *
     */

    'LGM f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'AJ0AkksABAAARJg5OBYDAAA=', 'fport' => '99', 'serial' => '4b92009d' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4b92009d","firmware_version":"0.4.0","card_count":{"value":17408,"unit":"","formatted":"17408 "},"switch_direction":"98","hex":"009d00924b000400004498393816030000"}' ),


    /**
     *
     * LWM
     *
     */

    'LWM f24 (status_packet)' => array( 'request' =>
        array( 'data' => 'AQAAAPUPAAAACQAAfgeQB2MHqwdyB6YH', 'fport' => '24', 'serial' => '4c12002c' ),
        'results' => '{"packet_type":"status_packet","metering_data":{"value":1,"unit":"L","formatted":"1 L"},"battery":{"value":3.642,"unit":"V","formatted":"3.642 V","value_raw":245},"temperature":{"value":15,"unit":"\u00b0C","formatted":"15\u00b0C"},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"mode":"00000000","alerts":"00000000","noise":{"value":9,"unit":"","formatted":"9 "},"accumulated_delta":{"value":0,"unit":"","formatted":"0 "},"dec":[{"value":1918,"unit":"","formatted":"1918 "},{"value":1936,"unit":"","formatted":"1936 "}],"afe_1":{"min":{"value":1891,"unit":"","formatted":"1891 "},"max":{"value":1963,"unit":"","formatted":"1963 "}},"afe_2":{"min":{"value":1906,"unit":"","formatted":"1906 "},"max":{"value":1958,"unit":"","formatted":"1958 "}},"hex":"01000000f50f0000000900007e0790076307ab077207a607"}' ),


    'LWM f24 (status_packet - first)' => array( 'request' =>
        array( 'data' => '/////98SAAAABAAA/////wEHBwf/////', 'fport' => '24', 'serial' => '4c12002c' ),
        'results' => '{"packet_type":"status_packet","metering_data":{"value":4294967295,"unit":"L","formatted":"n\/a"},"battery":{"value":3.554,"unit":"V","formatted":"3.554 V","value_raw":223},"temperature":{"value":18,"unit":"\u00b0C","formatted":"18\u00b0C"},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"mode":"00000000","alerts":"00000000","noise":{"value":4,"unit":"","formatted":"4 "},"accumulated_delta":{"value":0,"unit":"","formatted":"0 "},"dec":[{"value":65535,"unit":"","formatted":"65535 "},{"value":65535,"unit":"","formatted":"65535 "}],"afe_1":{"min":{"value":1793,"unit":"","formatted":"1793 "},"max":{"value":1799,"unit":"","formatted":"1799 "}},"afe_2":{"min":{"value":65535,"unit":"","formatted":"65535 "},"max":{"value":65535,"unit":"","formatted":"65535 "}},"hex":"ffffffffdf12000000040000ffffffff01070707ffffffff"}' ),


    'LWM f99 (shutdown_packet)' => array( 'request' =>
        array( 'data' => 'ATEZAAAA6xEAAAAIAACTB6MHiwerB5IHsgc=', 'fport' => '99', 'serial' => '4c12002c' ),
        'results' => '{"packet_type":"shutdown_packet","shutdown_reason":{"value":"31","unit":"","formatted":"magnet_shutdown"},"metering_data":{"value":25,"unit":"L","formatted":"25 L"},"battery":{"value":3.602,"unit":"V","formatted":"3.602 V","value_raw":235},"temperature":{"value":17,"unit":"\u00b0C","formatted":"17\u00b0C"},"rssi":{"value":0,"unit":"dBm","formatted":"0 dBm"},"mode":"00000000","alerts":"00000000","noise":{"value":8,"unit":"","formatted":"8 "},"accumulated_delta":{"value":0,"unit":"","formatted":"0 "},"dec":[{"value":1939,"unit":"","formatted":"1939 "},{"value":1955,"unit":"","formatted":"1955 "}],"afe_1":{"min":{"value":1931,"unit":"","formatted":"1931 "},"max":{"value":1963,"unit":"","formatted":"1963 "}},"afe_2":{"min":{"value":1938,"unit":"","formatted":"1938 "},"max":{"value":1970,"unit":"","formatted":"1970 "}},"hex":"013119000000eb110000000800009307a3078b07ab079207b207"}' ),

    'LWM f99 (boot_packet)' => array( 'request' =>
        array( 'data' => 'ACwAEkwAAQgQAAAAAAAAAAAAAA==', 'fport' => '99', 'serial' => '4c12002c' ),
        'results' => '{"packet_type":"boot_packet","device_serial":"4c12002c","firmware_version":"0.1.8","reset_reason":["magnet_wakeup"],"calibration_debug ":"0000000000000000","hex":"002c00124c0001081000000000000000000000"}' ),


);


/*
 * TESTER
 */


require 'src/nascv.php';
$cv = new nascv;

function array_diff_assoc_recursive( $array1, $array2 )
{
    if (!is_array( $array1 )) return array( 'error' => 'very different' );
    foreach ($array1 as $key => $value) {
        if (is_array( $value )) {
            if (!isset( $array2[ $key ] )) {
                $difference[ $key ] = $value;
            } elseif (!is_array( $array2[ $key ] )) {
                $difference[ $key ] = $value;
            } else {
                $new_diff = array_diff_assoc_recursive( $value, $array2[ $key ] );
                if ($new_diff != FALSE) {
                    $difference[ $key ] = $new_diff;
                }
            }
        } elseif (!isset( $array2[ $key ] ) || $array2[ $key ] != $value) {
            $difference[ $key ] = $value;
        }
    }
    return !isset( $difference ) ? 0 : $difference;
}

function correct_array( $array )
{
    foreach ($array as $k => $v) {
        if (is_array( $v )) {
            $array[ $k ] = correct_array( $v );
        } else {
            if (is_bool( $v )) {
                $array[ $k ] = ($v ? 'true' : 'false');
            }
            if (is_float( $v )) {
                $array[ $k ] = "$v";
            }
        }
    }
    return $array;
}

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NASCV v<?= $cv->version ?> tester</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style type="text/css">
        td {
            word-break: break-all;
        }
    </style>
</head>

<body>
<?php

ksort( $tests );
foreach ($tests as $type => $v) {
    echo '<table class="table table-sm table-bordered" style="margin-bottom:0px;">';
    $got = $cv->data( $v[ 'request' ] );
    $need = json_decode( $v[ 'results' ], true );
    if (correct_array( $need ) == correct_array( $got )) {
        echo '<tr class="bg-success"><td colspan="2"><h5 style="display:inline-block;margin-top:5px;margin-bottom:0px;font-size:20px;font-family: monospace;">' . $type . '</h5>' . PHP_EOL;
    } else {
        echo '<tr class="bg-danger"><td colspan="2"><h5 style="display:inline-block;margin-top:5px;margin-bottom:0px;font-size:20px;font-family: monospace;">' . $type . '</h5>';
        echo '<h6>DIFF: </h6><code style="color:black">';
        var_dump( array_diff_assoc_recursive( $got, $need ) ) . PHP_EOL;
        echo '</code>';
    }
    echo ' <button class="btn btn-sm btn-warning float-right ml-2" data-id="' . sha1( $type ) . '">Library</button>';
    echo ' <button class="btn btn-sm btn-dark float-right ml-2" data-id="' . sha1( $type ) . '">Metering</button> ';
    echo ' <button class="btn btn-sm btn-primary float-right" data-id="' . sha1( $type ) . '">Results</button></td><tr>';
    echo '<tr style="display:none;" class="originals" data-id="' . sha1( $type ) . '"><td>';
    echo '<h6>CONVERTED: </h6>';
    echo '<pre>';
    print_r( correct_array( $got ) );
    echo '</pre>';
    echo '<code>JSON: ';
    echo json_encode( $got );
    echo '</code>';
    echo '</td><td>';
    echo '<h6>NEEDED:</h6> ';
    echo '<pre>';
    print_r( correct_array( $need ) );
    echo '</pre>';
    echo '<code>JSON: ';
    echo json_encode( $need );
    echo '</code>';
    echo '</td></tr>';


    echo '<tr style="display:none;" class="originals" data-id="' . sha1( $type ) . '-metering"><td>';
    echo '<h6>CONVERTED: </h6>';
    echo '<pre>';
    print_r( correct_array( $cv->toMetering( $got ) ) );
    echo '</pre>';
    echo '<code>JSON: ';
    echo json_encode( $cv->toMetering( $got ) );
    echo '</code>';
    echo '</td><td>';
    echo '<h6>NEEDED:</h6> ';
    echo '<pre>';
    print_r( correct_array( $cv->toMetering( $need ) ) );
    echo '</pre>';
    echo '<code>JSON: ';
    echo json_encode( $cv->toMetering( $need ) );
    echo '</code>';
    echo '</td></tr>';

    echo '<tr style="display:none;" class="originals" data-id="' . sha1( $type ) . '-library"><td colspan="2">';
    echo '<pre>';
    print_r( correct_array( $cv->call_library( $cv->product )->rx_fport()[ $cv->fport ] ) );
    echo '</pre>';
    echo '<code>';
    echo '</td></tr>';

    echo '</table>';
}

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    $(function () {
        $('.btn-primary').click(function () {
            $('.originals[data-id="' + $(this).data('id') + '"]').toggle('fast');
        });
        $('.btn-dark').click(function () {
            $('.originals[data-id="' + $(this).data('id') + '-metering"]').toggle('fast');
        });
        $('.btn-warning').click(function () {
            $('.originals[data-id="' + $(this).data('id') + '-library"]').toggle('fast');
        });
        $('table').width($(window).innerWidth());
        $('td').css('max-width', ($(window).innerWidth() / 2));
    })
</script>
</body>
</html>