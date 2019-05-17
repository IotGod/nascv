<?php
/*
 * NAS Converters
 * @author Rauno Avel
 * @copyright NAS 2018
 * @version 7.7
 */

class nascv
{
    public $version = 7.7; // NAS converter version

    public $unit = ''; // message unit
    public $type = ''; // message converting type
    public $byte = ''; // message byte order
    public $rawdata = ''; // message rawdata
    public $data = ''; // message data
    public $description = ''; // message description
    public $product = ''; // Product type
    public $overwrite = false; // if true, then can set library manually
    public $firmware = ''; // device firmware
    public $show_hex = true; // show-ing hex in status parsers
    public $hex = '';
    public $fport = '';
    public $direction = 'rx'; //packet direction RX or TX


    private $nas = '70b3d5b02'; // Nordic Automation Systems prefix
    private $apc = array(); // caching
    private $lib; // library
    private $obj; // need for cache struct objects

    /**
     * nascv constructor.
     */
    function __construct()
    {
        $lib = array();
        require __DIR__ . '/library.php';
        foreach ($lib as $k => $v) {
            $lib[ $k ] = json_decode( $v, true );
        }
        $this->lib = $lib;
    }

    /**
     * NAS Data converter
     * @param $msg
     * @return array|bool|string
     */
    public

    function data( $msg )
    {

        #clean cach
        $this->obj = array();

        # if no data, then do not start decode
        if (!isset( $msg[ 'data' ] )) {
            return NULL;
        }

        $library = 'other';
        if (isset( $msg[ 'serial' ] )) {
            $library = self::find_library( strtolower( $msg[ 'serial' ] ) );
        }
        if (isset( $msg[ 'library' ] )) {
            $library = self::find_library( strtolower( $msg[ 'library' ] ) );
        }
        if (isset( $msg[ 'direction' ] )) {
            $this->direction = strtolower( $msg[ 'direction' ] );
        }

        # there is 2 way's how fport is named
        $this->fport = (isset( $msg[ 'fPort' ] ) ? $msg[ 'fPort' ] : $msg[ 'fport' ]);

        # set rawdata
        $this->rawdata = $msg[ 'data' ];

        # decode from base64
        if (base64_encode( base64_decode( $msg[ 'data' ] ) ) === $msg[ 'data' ]) {
            $data = base64_decode( $msg[ 'data' ] );
        } else {
            $data = $msg[ 'data' ];
        }

        #if fport have specified
        $s = self::getfPort( $this->fport );
        if ($s and count( $s ) > 0) {
            $this->type = ($this->type == '' || !$this->overwrite ? $s[ 'data_type' ] : $this->type);
            $this->byte = ($this->byte == '' || !$this->overwrite ? $s[ 'byte_order' ] : $this->byte);
            $this->unit = ($this->unit == '' || !$this->overwrite ? $s[ 'unit' ] : $this->unit);
            $this->description = $s[ 'description' ];

        }

        # if error hex then return only hex
        if ('ff ff ff ff' === $this->data = self::ascii2hex( $data, $this->byte )) {
            $this->unit = 'hex';
            $this->type = 'error';
            $this->description = 'not readable value';
            return $this->data;
        }

        # set firmware if isset firmware data (from v5.7)
        $this->firmware = '';
        if (isset( $msg[ 'firmware' ] )) {
            $this->firmware = $msg[ 'firmware' ];
        }

        # start parsering data by given library structure
        $l = $this->call_library( $library );
        if ($this->type == 'hex') {
            $struct = ($this->direction == 'rx' ? $l->rx_fport() : $l->tx_fport());
            if (isset( $struct[ $this->fport ] )) {
                $this->hex = $hex = self::ascii2hex( $data, 'MSB' );
                return $this->data = $this->parser_hex( $hex, $struct[ $this->fport ] );
            }
        }

        # if did not find structure, then try parse data by type
        $func = $this->lib[ 'functions' ][ $this->type ];
        if ($func == '') {
            return $this->data = $data;
        }
        return $this->data = $this->$func( $data, $this->byte );

    }


    /**
     * HEX parser
     * @param $hex
     * @param $struct
     * @param bool $sub
     * @param string $_id
     * @return array
     */
    private

    function parser_hex( & $hex, $struct, $sub = false, $_id = '' )
    {
        if ($_id == '') $_id = uniqid();
        $return = array();
        $hex = str_replace( ' ', '', $hex ); // remove spaces
        $ohex = $hex;
        $previous_hex = '';
        $repeat = array();
        $got_data = array();
        if (!is_array( $struct )) return array();
        foreach ($struct as $oi => $object) {
            $object_r = array();
            $show_object = true;
            $struct_formatter = '';
            if (is_array( $object )) {
                foreach ($object as $k => $v) {
                    if (isset( $v[ 'repeat' ] ) and is_array( $v[ 'repeat' ] )) {
                        foreach ($v[ 'repeat' ] as $repeats) {
                            if (self::control_values( array( $repeats ), $_id )) {
                                $add = $this->parser_hex( $hex, array( $v ), true, $_id );
                                if (is_array( $add )) {
                                    $object_r = array_merge_recursive( $object_r, $add );
                                }
                            } else {
                                $object_r = array();
                            }
                        }
                        continue;
                    } elseif (isset( $v[ 'repeat' ] ) and is_numeric( $v[ 'repeat' ] )) {
                        $obj = $object[ 0 ];
                        $repeat_result = array();
                        for ($i = 1; $i <= $v[ 'repeat' ]; $i++) {
                            $length = (isset( $v[ 'length' ] ) ? $v[ 'length' ] : 1);
                            $data = self::bite_hex( $hex, $obj[ 'type' ], '', $length );
                            if ($data == '' and $previous_hex != '') {
                                $data = $previous_hex;
                            }
                            $data = $this->parsering( $data, $obj, $_id );
                            if ($data != NULL) {
                                $repeat_result[] = $data;
                            }
                        }
                        array_push( $got_data, $v[ 'name' ] );
                        $return[ $v[ 'name' ] ] = $repeat_result;
                    } elseif (is_array( $v ) and isset( $v[ '_cnf' ] )) {
                        if ($show_object) {
                            $object_r = array_merge_recursive( $object_r, $this->parser_hex( $hex, array( $v ), true, $_id ) );
                        }
                    } else {
                        if (!is_array( $k ) and $k == '_struct' and is_array( $v )) {
                            unset( $v[ '_struct' ][ 0 ] );
                            if (is_array( $v ) and count( $v ) > 0) {
                                $object_r = array_merge_recursive( $object_r, $this->parser_hex( $hex, $v, true ) );
                            }
                        } else {

                            if ($k == '_cnf') {

                                if (isset( $v[ 'repeat' ] ) and $v[ 'repeat' ] === true) {
                                    $repeat[] = $object;
                                }
                                if (isset( $v[ 'byte_order' ] )) {
                                    $this->byte = $v[ 'byte_order' ];
                                } else {
                                    $this->byte = 'LSB';
                                }
                                if (isset( $v[ 'when' ] )) {
                                    $show_object = false;
                                    if (self::control_values( $v[ 'when' ], $_id )) {
                                        $show_object = true;
                                    } else {

                                        $previous_hex = $hex;
                                    }
                                }
                                if (isset( $v[ 'formatter' ] )) {
                                    $struct_formatter = $v[ 'formatter' ];
                                }

                            } else {

                                if ($show_object) {

                                    $length = (isset( $v[ 'length' ] ) ? $v[ 'length' ] : 1);
                                    if (is_array( $length )) {
                                        $length = hexdec( self::find_attr( $length, 'value', $_id ) );
                                    }
                                    if ($length == '*') {
                                        $length = strlen( $hex ) / 2;
                                    }
                                    if (isset( $v[ 'when' ] )) {
                                        if (self::control_values( $v[ 'when' ], $_id )) {
                                            $data = self::bite_hex( $hex, $v[ 'type' ], '', $length );
                                            $data = $this->parsering( $data, $v, $_id );
                                            if ($data != NULL) {
                                                if ($k != '') {
                                                    $object_r[ $k ] = $data;
                                                }
                                            }
                                        }
                                    } else {
                                        if (isset( $v[ 'type' ] )) {
                                            $data = self::bite_hex( $hex, $v[ 'type' ], '', $length );
                                            if ($data == ''
                                                and $previous_hex != '') {
                                                $data = $previous_hex;
                                            }
                                            $data = $this->parsering( $data, $v, $_id );
                                            if ($data != NULL) {

                                                if ($k != '') {
                                                    if (is_numeric( $k )) {
                                                        $object_r[] = $data;
                                                        $this->obj[ $_id ][ '_' ][] = $data;
                                                    } else {
                                                        $object_r[ $k ] = $data;
                                                        $this->obj[ $_id ][ '_' ][ $k ] = $data;
                                                    }
                                                }
                                            }
                                        } else {
                                            if (!is_array( $v )) {
                                                if (is_numeric( $k )) {
                                                    $object_r[] = $v;
                                                } else {
                                                    $object_r[ $k ] = $v;
                                                    $this->obj[ $_id ][ '_' ][ $k ] = $v;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($show_object) {
                if (isset( $object[ '_cnf' ] ) and isset( $object[ '_cnf' ][ 'name' ] )) {
                    $array = false;
                    $name = $object[ '_cnf' ][ 'name' ];
                    if (strstr( $name, '[]' )) {
                        $array = true;
                        $name = str_replace( '[]', '', $name );
                    }


                    if ($struct_formatter != '') {
                        $new_value = $struct_formatter;
                        preg_match_all( '~\{([^}]*)\}~', $struct_formatter, $matches );
                        foreach ($matches[ 1 ] as $sf_v) {
                            $val = @trim( self::find_attr( array( $sf_v ), 'formatted', $_id ) );
                            $new_value = str_replace( '{' . $sf_v . '}', $val, $new_value );
                            $f_key = array_values( array_slice( explode( ':', $sf_v ), -1 ) )[ 0 ];
                            $this->obj[ $_id ][ '_' ][ $f_key ] = $val;
                        }
                        $object_r = $new_value;
                    }


                    if (isset( $object[ '_cnf' ][ 'repeat' ] ) and $object[ '_cnf' ][ 'repeat' ] == true) {
                        if (!in_array( $object[ '_cnf' ][ 'name' ], $got_data ))
                            $return[ $object[ '_cnf' ][ 'name' ] ][] = $object_r;
                    } else {
                        if ($array) {
                            $return[ $name ][] = $object_r;
                        } else {
                            $return[ $name ] = $object_r;
                        }
                        $this->obj[ $_id ][ $object[ '_cnf' ][ 'name' ] ] = $object_r;
                    }
                } else {
                    $this->obj[ $_id ] = $return = array_merge_recursive( $return, $object_r );
                }
            }
            if ($hex == ''
                and $previous_hex == '') {
                break;
            }
        }
        if ($hex != '' and is_array( $repeat ) and count( $repeat ) > 0) {
            $return = array_merge_recursive( $return, $this->parser_hex( $hex, $repeat, false, $_id ) );
        }

        if (!$sub and $this->show_hex) {
            $return[ 'hex' ] = $ohex;
        }
        unset( $this->obj[ $_id ][ '_' ] );
        return $return;
    }


    /**
     * Control values and return boolean (IF function)
     * @param $when
     * @param $_id
     * @return bool|mixed
     */
    private

    function control_values( $when, $_id )
    {
        $bools = array();
        foreach ($when as $ci => $_and) {
            $_or_bool = false;
            foreach ($_and as $_or_key => $_or_value) {
                $find = '';
                $ffind = '';
                if (substr( $_or_key, 0, 1 ) == '{') {
                    $h = explode( ' ', $this->hex );
                    $find = self::addZero( dechex( count( $h ) ) );
                } else {
                    $_key = explode( ':', $_or_key );
                    for ($i = 0; $i < count( $_key ); $i++) {
                        $key = $_key[ $i ];
                        if (isset( $this->obj[ $_id ][ '_' ][ $key ] )) {
                            $find = $this->obj[ $_id ][ '_' ][ $key ];
                        } else {
                            if (is_array( $find )) {
                                $find = (isset( $find[ $key ] ) ? $find[ $key ] : '');
                            } else {
                                $find = (isset( $this->obj[ $_id ][ $key ] ) ? $this->obj[ $_id ][ $key ] : '');
                            }
                        }
                        if (isset( $find[ 'value' ] )) {
                            $find = $find[ 'value' ];
                        }
                        if (isset( $find[ 'formatted' ] )) {
                            $ffind = $find[ 'formatted' ];
                        }
                    }
                }
                if (is_array( $_or_value )) {
                    $_or_bool = (in_array( $find, $_or_value ) || in_array( $ffind, $_or_value ));
                } else {
                    $_or_bool = ($find == $_or_value || $ffind == $_or_value);
                    if (in_array( substr( $_or_value, 0, 1 ), array( '<', '>', '!' ) )) {
                        $mark = substr( $_or_value, 0, 1 );
                        $_or_value = intval( substr( $_or_value, 1 ), 16 );
                        if ($mark == '<'
                            and intval( $find, 16 ) <= $_or_value) {
                            $_or_bool = true;
                        }
                        if ($mark == '>'
                            and intval( $find, 16 ) >= $_or_value) {
                            $_or_bool = true;
                        }
                        if ($mark == '!'
                            and intval( $find, 16 ) != $_or_value) {
                            $_or_bool = true;
                        }
                    }
                }
            }
            $bools[] = $_or_bool;
        }
        $bool = true;
        foreach ($bools as $b) {
            $bool = $b;
        }
        return $bool;

    }

    /**
     * Main processing object
     * @param $data
     * @param $v
     * @param $_id
     * @return array|string|null
     */
    private

    function parsering( $data, $v, $_id )
    {
        if ($data == '') return NULL;
        if ($v[ 'type' ] == 'byte') {
            $bin = self::hex2bin( $data, false );
            $i = 1;
            if (isset( $v[ 'bits' ] )) {
                $r = array();

                foreach ($v[ 'bits' ] as $byte_name => $byte_obj) {
                    if (is_array( $byte_obj )) {
                        if (isset( $byte_obj[ 'bit' ] )) {
                            # advanced bit description array(array('bit'=>'', 'name'=>'', 'value'=>''))
                            $bit_length = 1;
                            $bit_start = @((( int )$byte_obj[ 'bit' ]) + 1);
                            if (strstr( $byte_obj[ 'bit' ], '-' )) {
                                $bits = explode( '-', $byte_obj[ 'bit' ] );
                                $bit_length = $bits[ 1 ] - $bits[ 0 ] + 1;
                                $bit_start = $bits[ 1 ] + 1;
                            }
                            $val = substr( $bin, -$bit_start, $bit_length );
                            if (isset( $byte_obj[ 'type' ] )) {
                                if ($byte_obj[ 'type' ] == 'hex') {
                                    $val = self::bin2hex( $val );
                                }
                                if ($byte_obj[ 'type' ] == 'decimal') {
                                    $val = bindec( $val );
                                }
                            }
                            $r[ $byte_obj[ 'parameter' ] ] = array( 'value' => $val );
                            if (isset( $byte_obj[ 'formatter' ] )) {
                                $f = $byte_obj[ 'formatter' ];
                                if (isset( $f[ 0 ][ 'value' ] )) {
                                    $form = '';
                                    foreach ($f as $forms) {
                                        if ($forms[ 'value' ] == '?' or $forms[ 'value' ] == '*') {
                                            $form = $forms[ 'name' ];
                                        }
                                        if ($forms[ 'value' ] == $val) {
                                            $form = $forms[ 'name' ];
                                            break;
                                        }
                                    }
                                    $r[ $byte_obj[ 'parameter' ] ][ 'formatted' ] = $form;
                                } else {
                                    if (isset( $f[ $val ] ))
                                        $r[ $byte_obj[ 'parameter' ] ][ 'formatted' ] = $f[ $val ];
                                }
                            }
                        } else {
                            # simple bit description array(false,true);
                            $val = substr( $bin, -$i, 1 );
                            $r[ $byte_name ] = array( 'value' => $val );
                            if (isset( $byte_obj[ substr( $bin, -$i, 1 ) ] )) {
                                $r[ $byte_name ][ 'formatted' ] = $byte_obj[ substr( $bin, -$i, 1 ) ];
                            }
                        }
                    } else {
                        if (substr( $bin, -$i, 1 ) == '1') {
                            $r[] = $byte_obj;
                        }
                    }
                    $i++;
                }
                return $r;
            } else {
                return $this->hex2bin( $data, $this->byte );
            }
        } else {
            # convert data by type
            if (isset( $v[ 'byte_order' ] ) and $v[ 'byte_order' ] == 'MSB'
                and $this->byte != 'LSB') {
                $data = self::byte_order_reverse( $data );
            }

            if (strstr( $v[ 'type' ], 'uint' )) {
                $data = $this->hex2dec( $data, $this->byte );
            } elseif (strstr( $v[ 'type' ], 'int' )) {
                $data = $this->hex2dec( $data, $this->byte, true );
            } elseif (strstr( $v[ 'type' ], 'float' )) {
                $data = $this->hex2float( $data, $this->byte );
            } elseif (strstr( $v[ 'type' ], 'hex' )) {
                if ($this->byte == 'LSB' and !isset( $v[ 'byte_order' ] )) {
                    $data = self::byte_order_reverse( $data );
                }
                if (isset( $v[ 'ext' ] )) {
                    $ext_opt = $v[ 'ext' ];
                    $ext = self::call_ext( $ext_opt[ 0 ] );
                    $options = array();
                    foreach ($ext_opt[ 1 ] as $k => $v) {
                        if (substr( $v, 0, 1 ) == '{' and substr( $v, -1 ) == '}') {
                            $options[ $k ] = self::find_attr( array( str_replace( '}', '', str_replace( '{', '', $v ) ) ), 'value', $_id );
                        } else {
                            $options[ $k ] = $v;
                        }
                    }
                    $ext->convert( $data, $options );
                    return $ext->results;
                }
                if (!isset( $v[ 'formatter' ] )) return $data;
            }

            #converting
            if (isset( $v[ 'converter' ] )) {
                $data = self::value_converter( $data, $v[ 'converter' ] );
            }
            # default value
            $return = array( 'value' => $data, 'unit' => '' );
            if (isset( $v[ 'unit' ] )) {
                if (is_array( $v[ 'unit' ] )) {
                    $unit_arr = $v[ 'unit' ];
                    if (isset( $unit_arr[ 1 ] ) and is_array( $unit_arr[ 1 ] )) {
                        $index = self::find_unit( array( $unit_arr[ 0 ] ), $_id );
                        $unit = '';
                        if (isset( $index[ "value" ] )) {
                            $unit = $unit_arr[ 1 ][ $index[ "value" ] ];
                        }
                        if (is_array( $unit )) {
                            $unit = $unit[ $unit_arr[ 2 ] ];
                        }
                        $return[ 'unit' ] = $unit;
                    } else {
                        $return[ 'unit' ] = self::find_unit( $unit_arr, $_id );
                    }
                } else if (substr( $v[ 'unit' ], 0, 1 ) == '{' and substr( $v[ 'unit' ], -1 ) == '}') {
                    $return[ 'unit' ] = self::find_unit( array( str_replace( '}', '', str_replace( '{', '', $v[ 'unit' ] ) ) ), $_id );
                } else {
                    $return[ 'unit' ] = $v[ 'unit' ];
                }
            }
            if (is_array( $return[ 'unit' ] )) {
                $return[ 'unit' ] = 'n/a';
            }
            #formatting
            if (isset( $v[ 'formatter' ] ) and is_array( $v[ 'formatter' ] )) {
                foreach ($v[ 'formatter' ] as $f_k => $f_v) {
                    if ($f_v[ 'value' ] == '?' or $f_v[ 'value' ] == '*') {
                        $return[ 'formatted' ] = sprintf( $f_v[ 'name' ], $return[ 'value' ], $return[ 'unit' ] );
                    }
                    if ($f_v[ 'value' ] == $return[ 'value' ]) {
                        $return[ 'formatted' ] = $f_v[ 'name' ];
                        foreach ($f_v as $fvk => $fvv) {
                            if ($fvk == 'name') continue;
                            $return[ $fvk ] = $fvv;
                        }
                        break;
                    }
                }
            } else {
                $return[ 'formatted' ] = sprintf( (isset( $v[ 'formatter' ] ) ? $v[ 'formatter' ] : '%s %s'), $return[ 'value' ], $return[ 'unit' ] );
                if (substr( $return[ 'formatted' ], 0, 1 ) == ':') {
                    $function = explode( ':', $return[ 'formatted' ] );
                    if ($function[ 1 ] == 'battery') {
                        $return[ 'unit' ] = 'V';
                        $return[ 'value_raw' ] = $return[ 'value' ];
                        $return[ 'value' ] = self::battery( $return[ 'value' ], (isset( $function[ 2 ] ) ? $function[ 2 ] : '3.6') );
                        $return[ 'formatted' ] = $return[ 'value' ] . ' ' . $return[ 'unit' ];
                    }

                    if (substr( $function[ 1 ], 0, 5 ) == 'date(') {
                        preg_match_all( "/\((.+)\)/", $return[ 'formatted' ], $m );
                        $return[ 'value_raw' ] = $return[ 'value' ];
                        $return[ 'value' ] = gmdate( $m[ 1 ][ 0 ], $return[ 'value' ] );
                        $return[ 'formatted' ] = $return[ 'value' ] . ' ' . $return[ 'unit' ];
                    }

                    if (substr( $function[ 1 ], 0, 6 ) == 'date10') {
                        preg_match_all( "/\((.+)\)/", $return[ 'formatted' ], $m );
                        $value = $return[ 'value' ] * 10 * 60;
                        $return[ 'value_raw' ] = $return[ 'value' ];
                        $return[ 'value' ] = gmdate( $m[ 1 ][ 0 ], $value );
                        $return[ 'formatted' ] = $return[ 'value' ] . ' ' . $return[ 'unit' ];
                    }

                }
            }
            return $return;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    private function call_ext( $name )
    {
        $file = dirname( __DIR__ ) . '/ext/' . $name . '/' . $name . '.php';
        $class_name = str_replace( '-', '_', $name );
        if (file_exists( $file )) {
            require_once $file;
            if (class_exists( $class_name )) {
                return new $class_name;
            }
        }
        return false;
    }

    /**
     * Find unit
     * @param string|array $where
     * @param string $_id
     * @return string
     */
    private

    function find_unit( $where, $_id )
    {

        $parameter = 'formatted';
        if (strstr( $where[ 0 ], '>' )) {
            $e = explode( '>', $where[ 0 ] );
            $where = array( $e[ 0 ] );
            $parameter = $e[ 1 ];
        }
        return self::find_attr( $where, $parameter, $_id );
    }

    /**
     * Find attribute value
     * @param array $where
     * @param string $attr
     * @param string $_id
     * @return string
     */
    private

    function find_attr( $where, $attr, $_id )
    {
        $find = '';
        foreach ($where as $key) {
            $_key = explode( ':', $key );
            $find = '';
            for ($i = 0; $i < count( $_key ); $i++) {
                $key = $_key[ $i ];
                if (isset( $this->obj[ $_id ][ '_' ][ $key ] )) {
                    $find = $this->obj[ $_id ][ '_' ][ $key ];
                } else {
                    if (is_array( $find )) {
                        $find = (isset( $find[ $key ] ) ? $find[ $key ] : '');
                    } else {
                        $find = (isset( $this->obj[ $_id ][ $key ] ) ? $this->obj[ $_id ][ $key ] : '');
                    }
                }
                if (isset( $find[ $attr ] )) {
                    $find = $find[ $attr ];
                }
            }
        }
        return $find;
    }

    /**
     * Converter values
     * @param string $data
     * @param string $f
     * @return string
     */
    private

    function value_converter( $data, $f )
    {

        # dividing
        if (substr( $f, 0, 1 ) == '/') {
            if (is_numeric( $data ))
                $data /= substr( $f, 1 );
        }

        # multiple
        if (substr( $f, 0, 1 ) == '*') {
            if (is_numeric( $data ))
                $data *= substr( $f, 1 );
        }

        # minus
        if (substr( $f, 0, 1 ) == '-') {
            if (is_numeric( $data ))
                $data -= substr( $f, 1 );
        }

        # add
        if (substr( $f, 0, 1 ) == '+') {
            if (is_numeric( $data ))
                $data += substr( $f, 1 );
        }

        return $data;
    }

    /**
     * Bite hex
     * @param $hex
     * @param $type
     * @param string $bite
     * @param int $length
     * @return bool|string
     */

    private

    function bite_hex( & $hex, $type, $bite = '', $length = 1 )
    {
        if (strstr( $type, 'uint' )) {
            $byte = str_replace( 'uint', '', $type ) / 8;
            $bite = substr( $hex, 0, $byte * 2 );
            $hex = substr( $hex, $byte * 2 );
        } elseif (strstr( $type, 'int' )) {
            $byte = str_replace( 'int', '', $type ) / 8;
            $bite = substr( $hex, 0, $byte * 2 );
            $hex = substr( $hex, $byte * 2 );
        } elseif (strstr( $type, 'float' )) {
            $bite = substr( $hex, 0, 4 * 2 );
            $hex = substr( $hex, 4 * 2 );
        } elseif (strstr( $type, 'byte' )) {
            $bite = substr( $hex, 0, $length * 2 );
            $hex = substr( $hex, $length * 2 );
        } elseif (strstr( $type, 'hex' )) {
            $bite = substr( $hex, 0, $length * 2 );
            $hex = substr( $hex, $length * 2 );
        }
        return $bite;
    }


    /**
     * Call library
     * @param $library
     * @param bool $bool
     * @return bool
     */
    public

    function call_library( $library, $bool = false )
    {
        $library = strtolower( $library );
        $file = __DIR__ . '/library/' . $library . '.php';
        if (file_exists( $file )) {
            if ($bool) return true;
            require_once $file;
            if (class_exists( $library )) {
                $this->$library = new $library;
                $this->$library->nascv = $this;
                return $this->$library;
            } else {
                die( 'Library "' . $library . '" class is not finded' );
            }
        } else {
            if ($bool) return false;
            die( 'Did not find library: ' . $library );
        }
    }

    /**
     * find type by serial
     * @param $str
     * @return string
     */
    public

    function find_library( $str )
    {
        $str = strtolower( $str );
        foreach ($this->lib[ 'ipd_list' ] as $lib => $obj) {
            if (isset( $obj[ 'hex' ] )) {
                if ($obj[ 'hex' ] == substr( $str, 0, 2 ) . '0' . substr( $str, 3, 1 ) or $lib == strtoupper( $str )) {
                    $this->product = $lib;
                    return strtolower( $lib );
                }
            } else {
                foreach ($obj as $k => $v) {
                    if ($v[ 'hex' ] == substr( $str, 0, 2 ) . '0' . substr( $str, 3, 1 ) or $lib == strtoupper( $str )) {
                        $this->product = $lib;
                        return strtolower( $lib );
                    }
                }
            }
        }
        return 'other';
    }


    /**
     * getProduct
     * @return array
     */
    public

    function getProducts()
    {
        return $this->lib[ 'ipd_list' ];
    }

    /**
     * get Libraries
     * @return array
     */
    public

    function getLibrarys()
    {
        $lib = $this->lib[ 'ipd_list' ];
        $library = array();
        foreach ($lib as $code => $data) {
            if (self::call_library( strtolower( $code ), true )) {
                foreach ($data as $k => $v) {
                    $library[] = array( 'library' => $code, 'name' => $v[ 'name' ], 'upn' => $v[ 'upn' ] );
                }

            }
        }
        usort( $library, function ( $a, $b ) {
            if (isset( $a[ 'upn' ] ) and isset( $b[ 'upn' ] )) {
                return strcmp( $a[ "upn" ], $b[ "upn" ] );
            } else {
                return false;
            }
        } );
        return $library;
    }

    /**
     * getfPort data
     * @param $id
     * @return bool|mixed|string
     */
    public

    function getfPort( $id )
    {
        if (self::apc_fetch( 'fport_' . $id )) {
            return self::apc_fetch( 'fport_' . $id );
        }
        $fport = self::search( $this->lib[ 'fport_list' ], 'fport', $id );
        if (isset( $fport[ 0 ] )) {
            self::apc_store( 'fport_' . $id, $fport[ 0 ] );
            if (isset( $fport[ 0 ] ) and count( $fport[ 0 ] ) > 0) {
                return $fport[ 0 ];
            }
        }
        return false;
    }


    /**
     * get ports
     * @return mixed
     */
    public

    function getfPorts()
    {
        return $this->lib[ 'fport_list' ];
    }


    /**
     * apc_fetch
     * @param string $id
     * @return string
     */
    private

    function apc_fetch( $id )
    {
        if (!isset( $this->apc[ $id ] )) return false;
        return $this->apc[ $id ];
    }


    /**
     * apc store
     * @param string $id
     * @param string $val
     * @return boolean
     */
    private

    function apc_store( $id, $val )
    {
        $this->apc[ $id ] = $val;
        return true;
    }


    /**
     * is NAS
     * @param string $eui
     * @return boolean
     */
    public

    function isNAS( $eui )
    {
        return (substr( strtolower( $eui ), 0, strlen( $this->nas ) ) == $this->nas);
    }


    /**
     * Battery converter
     * @param $offset
     * @param string $nominal_v
     * @return float|string
     */
    private

    function battery( $offset, $nominal_v = '3.6' )
    {
        if ($offset == 255) return 'no battery info';
        if ($offset == 0) return 'line power';
        if ($nominal_v == '3.6') {
            $start_value = 4.0;
            $HIGH = 254;
            $MED = 247;
            $LOW = 18;
            $low_i = max( 0, $LOW - $offset );
            $med_i = max( 0, $MED - $offset - $low_i );
            $high_i = max( 0, $HIGH - $offset - $low_i - max( 0, ($MED - $offset - $low_i) ) );
            return $start_value - $high_i * 0.05 - $med_i * 0.004 - $low_i * 0.05;
        } else if ($nominal_v == '3.0') {
            $start_value = 3.6;
            $HIGH = 254;
            $MED = 245;
            $LOW = 16;
            $low_i = max( 0, $LOW - $offset );
            $med_i = max( 0, $MED - $offset - $low_i );
            $high_i = max( 0, $HIGH - $offset - $low_i - max( 0, ($MED - $offset - $low_i) ) );
            return $start_value - $high_i * 0.05 - $med_i * 0.004 - $low_i * 0.05;
        } else {
            return 'invalid battery chemistry';
        }
    }

    /**
     * Multi row search
     * @param array $array
     * @param string $key
     * @param string $value
     * @return array
     */
    private

    function search( $array, $key, $value )
    {
        $results = array();
        if (is_array( $array )) {
            if (isset( $array[ $key ] ) && $array[ $key ] == $value) {
                $results[] = $array;
            }
            foreach ($array as $subarray) {
                $results = array_merge( $results, self::search( $subarray, $key, $value ) );
            }
        }
        return $results;
    }


## CONVERTERS

    /**
     * byte order reversed
     * @param $str
     * @param int $step
     * @return string
     */
    private

    function byte_order_reverse( $str, $step = 2 )
    {
        return implode( '', array_reverse( str_split( str_replace( ' ', '', trim( $str ) ), $step ) ) );
    }


    /**
     * hex to bin conversion
     * @param $hex
     * @param bool $signed
     * @return string
     */
    public

    function hex2bin( $hex, $signed = false )
    {
        $bin = decbin( self::hex2dec( $hex, 'LSB', $signed ) );
        return str_pad( $bin, 8, 0, STR_PAD_LEFT );
    }

    /**
     * bin to hex conversion
     * @param string $bin
     * @return string reversed str
     */
    public

    function bin2hex( $bin )
    {
        return str_pad( dechex( bindec( str_pad( $bin, 8, 0, STR_PAD_LEFT ) ) ), 2, 0, STR_PAD_LEFT );
    }


    /**
     * str to json conversion
     * @param string $str
     * @return string reversed str
     */
    public

    function str2json( $str, $byte_order = 'LSB' )
    {
        return json_encode( $str );
    }


    /**
     * dec to hex conversion
     * @param string $dec
     * @return string
     */
    public

    function dec2hex( $dec, $byte_order = 'MSB' )
    {
        $hex = dechex( $dec );
        if ($byte_order == 'LSB') {
            $hex = self::byte_order_reverse( $hex );
        }
        return $hex;
    }

    /**
     * Ascii to HEX conversion
     * @param string $ascii
     * @param string $byte_order
     * @return string HEX
     */
    public

    function ascii2hex( $ascii, $byte_order = 'LSB' )
    {
        if (ctype_xdigit( $ascii ) and $this->type == 'hex') {
            return substr( chunk_split( $ascii, 2, ' ' ), 0, -1 );
        }
        $hex = unpack( 'H*', $ascii )[ 1 ];
        if ($byte_order == 'LSB') {
            $hex = self::byte_order_reverse( $hex );
        }
        return substr( chunk_split( $hex, 2, ' ' ), 0, -1 );
    }

    /**
     * hex to dec conversion
     * @param string $hex
     * @param string $byte_order
     * @param bool $signed
     * @return number dec
     */
    public

    function hex2dec( $hex, $byte_order = 'LSB', $signed = false )
    {
        $hex = preg_replace( '/[^0-9A-Fa-f]/', '', trim( $hex ) );
        if ($byte_order == 'LSB') {
            $hex = self::byte_order_reverse( $hex );
        }
        $dec = hexdec( $hex );
        $max = pow( 2, 4 * (strlen( $hex ) + (strlen( $hex ) % 2)) );
        $_dec = $max - $dec;
        if ($signed) {
            return $dec > $_dec ? -$_dec : $dec;
        } else {
            return $dec;
        }
    }

    /**
     * Ascii to DEC conversion
     * @param string $ascii
     * @param string $byte_order
     * @param bool $signed
     * @return string DEC
     */
    public

    function ascii2dec( $ascii, $byte_order = 'LSB', $signed = true )
    {
        $hex = self::ascii2hex( $ascii, 'MSB' );
        $dec = self::hex2dec( $hex, $byte_order, $signed );
        return $dec;
    }

    /**
     * Ascii to float conversion
     * @param $ascii
     * @param string $byte_order
     * @return string
     */
    public

    function ascii2float( $ascii, $byte_order = 'LSB' )
    {
        if ($byte_order == 'LSB') {
            $ascii = self::byte_order_reverse( $ascii );
        }
        $f = @unpack( 'f*', $ascii )[ 1 ];
        return number_format( $f, 2 );
    }

    /**
     * str to bin conversion
     * @param $str
     * @param string $byte_order
     * @return string
     */
    public

    function str2bin( $str, $byte_order = 'LSB' )
    {
        if ($byte_order == 'LSB') {
            $str = self::byte_order_reverse( $str );
        }
        $str = unpack( 'H*', $str );
        $chunks = str_split( $str[ 1 ], 2 );
        $ret = '';
        foreach ($chunks as $chunk) {
            $temp = base_convert( $chunk, 16, 2 );
            $ret .= str_repeat( "0", 8 - strlen( $temp ) ) . $temp;
        }
        return $ret;
    }

    /**
     * ascii to gps conversion
     * @param $ascii
     * @param string $byte_order
     * @return string
     */
    public

    function ascii2gps( $ascii, $byte_order = 'LSB' )
    {
        if ($byte_order == 'LSB') {
            $ascii = self::byte_order_reverse( $ascii );
        }
        $data = unpack( 'C*', $ascii );
        $lat = ($data[ 1 ] + ($data[ 2 ] << 8) + ($data[ 3 ] << 16)) / 100000;
        $lon = ($data[ 4 ] + ($data[ 5 ] << 8) + ($data[ 6 ] << 16)) / 100000;
        return $lat . ', ' . $lon;
    }

    /**
     * ascii to double hex conversion
     * @param $ascii
     * @param string $byte_order
     * @return string
     */
    public

    function ascii2dhex( $ascii, $byte_order = 'LSB' )
    {
        $hex = self::ascii2hex( $ascii, $byte_order );
        $hex = explode( ' ', $hex );
        $first = $second = '';
        for ($i = 0; $i < 16; $i++) {
            if ($i < 8) {
                $first .= @$hex[ $i ];
            }
            if ($i > 7) {
                $second .= @$hex[ $i ];
            }
        }
        return hexdec( $first ) . '/' . hexdec( $second );
    }

    /**
     * string to ascii conversion
     * @param $string
     * @return int|null
     */
    public

    function string2ascii( $string )
    {
        $ascii = NULL;
        for ($i = 0; $i < strlen( $string ); $i++) {
            $ascii += ord( $string[ $i ] );
        }
        return ($ascii);
    }

    /**
     * hex to base64 conversion
     * @param $hex
     * @return string
     */
    public

    function hex2base64( $hex )
    {
        return base64_encode( pack( 'H*', $hex ) );
    }


    /**
     * base64 to hex conversion
     * @param $base64
     * @param bool $msb
     * @return string
     */
    public

    function base642hex( $base64, $msb = false )
    {
        return self::ascii2hex( base64_decode( $base64, true ), $msb );
    }


    /**
     * hex to float conversion
     * @param $hex
     * @param string $byte_order
     * @return mixed
     */
    public

    function hex2float( $hex, $byte_order = 'LSB' )
    {
        $hex = preg_replace( '/[^0-9A-Fa-f]/', '', trim( $hex ) );
        if ($byte_order == 'LSB') {
            $hex = self::byte_order_reverse( $hex );
        }
        if (( int )phpversion() >= 7) {
            return @unpack( "G", pack( 'H*', $hex ) )[ 1 ];
        } else {
            $hex = self::byte_order_reverse( $hex );
            return @unpack( "f", pack( 'H*', $hex ) )[ 1 ];
        }
    }


    /**
     * add Zeros to number
     * @param $nr
     * @param int $range
     * @param bool $left
     * @param string $char
     * @return string
     */
    public

    function addZero( $nr, $range = 2, $left = true, $char = "0" )
    {
        $nr = trim( $nr );
        if ($left) {
            $method = STR_PAD_LEFT;
        } else {
            $method = STR_PAD_RIGHT;
        }
        return str_pad( $nr, $range, $char, $method );
    }


    /**
     * Parsered data array to HTML
     * @param $data
     * @param string $class
     * @param int $width
     * @return bool|string
     */
    public

    function toHTML( $data, $class = 'table', $width = 20 )
    {
        $width_second = 100 - $width;
        if (is_array( $data )) {
            /** if data is array */
            $html = '<table class="' . $class . '">';
            $unit = (isset( $data[ 'unit' ] ));
            foreach ($data as $k => $v) {
                /** make data loop */
                $k = str_replace( '_', ' ', $k );
                if (is_array( $v )) {
                    /** is array */
                    if (isset( $v[ 'formatted' ] )) {
                        /** is formatted value */
                        if (is_bool( $v[ 'formatted' ] )) {
                            $v[ 'formatted' ] = ($v[ 'formatted' ] ? 'true' : 'false');
                        } else {
                            $v[ 'formatted' ] = str_replace( '_', ' ', $v[ 'formatted' ] );
                        }
                        $html .= '<tr>';
                        if (!is_numeric( $k )) {
                            $html .= '<td class="text-right" style="width:' . $width . '%">' . $k . '</td>';
                        }
                        $html .= '<td class="text-left"><b>' . $v[ 'formatted' ] . '</b></td>';
                        $html .= '</tr>';
                    } elseif (count( $v ) == 2 and isset( $v[ 'unit' ] ) and isset( $v[ 'value' ] )) {
                        /** if there is only unit and value */
                        $html .= '<tr>';
                        if (!is_numeric( $k ) and strlen( $k ) > 2) {
                            $html .= '<td class="text-right" style="width:' . $width . '%">' . $k . '</td>';
                        }
                        $html .= '<td class="text-left"><b>' . $v[ 'value' ] . ' ' . $v[ 'unit' ] . '</b></td>';
                        $html .= '</tr>';
                    } else {
                        /** make a new loop */
                        if (is_numeric( $k ) and strlen( $k ) < 3) {
                            $width = '5';
                            $width_second = 100 - $width;
                        }
                        $html .= '<tr>';
                        $html .= '<td style="width:' . $width . '%" class="text-right">' . $k . '</td>';
                        $html .= '<td style="width:' . $width_second . '%" class="text-wrap">';
                        $check_v = $v;
                        reset( $check_v );
                        if (isset( $v[ 0 ] ) and !is_array( $v[ 0 ] ) and key( $check_v ) == '0') {
                            $html .= '<b>' . implode( ', ', $v ) . '</b>';
                        } else {
                            $html .= self::toHTML( $v, 'table table-bordered', $width + ($width < 20 ? 25 : 10) );
                        }
                        $html .= '</td>';
                        $html .= '</tr>';
                    }
                } else {
                    /** if loop data is not array */
                    if (is_bool( $v )) {
                        $v = ($v ? 'true' : 'false');
                    } else {
                        $v = str_replace( '_', ' ', $v );
                    }
                    if ($k == 'clock' || $k == 'timestamp') {
                        if (is_numeric( $v ))
                            $v = gmdate( 'd.m.Y H:i:s', $v ) . ' (UTC)';
                    }
                    if ($unit) {
                        if ($k == 'unit') continue;
                        if ($k == 'value') $v = $v . ' ' . ($data[ 'unit' ] != '-' ? $data[ 'unit' ] : '');
                    }
                    if ($k != 'hex') $v = '<b>' . $v . '</b>';
                    $html .= '<tr>';
                    if (!is_numeric( $k ) and strlen( $k ) > 2) {
                        $html .= '<td style="width:' . $width . '%" class="text-right">' . $k . '</td>';
                    }
                    $html .= '<td style="width:' . $width_second . '%" class="text-wrap">' . $v . '</td>';
                    $html .= '</tr>';
                }
            }
            $html .= '</table>';
            return $html;
        } else {
            /** if data is not array */
            if ($this->unit != '') {
                $html = '<table class="' . $class . '">';
                $html .= '<tr>';
                $html .= '<td><b>' . $data . ' ' . $this->unit . '</b></td>';
                $html .= '</tr>';
                $html .= '</table>';
                return $html;
            }
            return false;
        }
    }

    /**
     * Convert data to Metering array
     * @param $data
     * @return array
     */
    public function toMetering( $data )
    {
        $returnChannels = [];

        $r = array(
            'product' => (!empty( $this->product ) ? $this->product : 'unknown'),
            'main' => null );

        if (is_array( $data ) && !empty( $data ) and $this->fport != '99') {

            /**
             * OIR
             */
            if ($this->product === 'OIR') {
                $activeChannels = [];

                if (!empty( $data )) {
                    // Ignored indexes in data array
                    $ignoredChannels = [ 'ssi', 'user_triggered_packet', 'temperature_triggered_packet' ];

                    // MAIN
                    if (isset( $data[ 'reported_interfaces' ] )) {
                        $c = 0;
                        foreach ($data[ 'reported_interfaces' ] as $key => $value) {
                            if ($value[ 'formatted' ] === 'sent' && !in_array( $key, $ignoredChannels )) {
                                $name = ucfirst( str_replace( '_', ' ', $key ) );

                                $activeChannels[ $c ] = $data[ $key ];

                                if (isset( $activeChannels[ $c ][ 'counter' ] )) {
                                    $channel = $activeChannels[ $c ];
                                    $returnChannels[ $c ] = array(
                                        'name' => $name,
                                        'value' => $channel[ 'counter' ][ 'value' ],
                                        'unit' => explode( '_', $channel[ 'counter' ][ 'unit' ] )[ 0 ],
                                    );
                                    if (isset( $channel[ 'state' ][ 'medium_type' ][ 'formatted' ] )) {
                                        $medium_type = explode( '_', $channel[ 'state' ][ 'medium_type' ][ 'formatted' ] );
                                        $returnChannels[ $c ][ 'medium_type' ] = isset( $medium_type[ 1 ] ) ? $medium_type[ 1 ] : $medium_type[ 0 ];
                                    }
                                }

                                if (isset( $activeChannels[ $c ][ 'instant_value' ] )) {
                                    $returnChannels[ $c ] = array(
                                        'name' => $name,
                                        'value' => round( $activeChannels[ $c ][ 'instant_value' ][ 'value' ], 3 ),
                                        'unit' => $activeChannels[ $c ][ 'instant_value' ][ 'unit' ],
                                        'medium_type' => 'unknown',
                                    );
                                }

                                // Mbus
                                if (isset( $activeChannels[ $c ][ 'data_records' ] )) {
                                    foreach ($activeChannels[ $c ][ 'data_records' ] as $k => $v) {
                                        if (isset( $v[ 'unit' ] )) {
                                            $returnChannels[ $c ] = array(
                                                'name' => $name,
                                                'value' => $v[ 'value' ],
                                                'unit' => $v[ 'unit' ],
                                                'medium_type' => 'water',
                                            );
                                        }
                                    }
                                }
                                $c++;
                            }
                        }
                        $r[ 'main' ] = $returnChannels;
                    }

                    // EXTRA
                    foreach ($data as $k => $v) {
                        if (isset( $v[ 'unit' ] )) {
                            $unit = explode( '_', $v[ 'unit' ] );
                            if (!empty( $unit[ 0 ] ) && $unit[ 0 ] === 'Wh') {
                                $unit[ 0 ] = 'kWh';
                                $v[ 'value' ] = $v[ 'value' ] / 1000;
                            }

                            if (isset( $v[ 'value' ] )) {
                                $r[ 'extra' ][] = array(
                                    'value' => $v[ 'value' ],
                                    'unit' => $v[ 'unit' ],
                                    'name' => (str_replace( '_', ' ', $k ))
                                );
                            }
                        }
                    }
                }
            }

            /**
             * GM1
             */
            if ($this->product === 'GM1') {
                if (!empty( $data[ 'gas' ] ) && !empty( $data[ 'gas' ][ 'counter' ] )) {
                    $c = 0;
                    // MAIN
                    $unit = explode( '_', $data[ 'gas' ][ 'counter' ][ 'unit' ] );
                    $returnChannels[ $c ] = array(
                        'name' => 'Gas',
                        'value' => $data[ 'gas' ][ 'counter' ][ 'value' ],
                        'unit' => isset( $unit[ 1 ] ) ? $unit[ 1 ] : $unit[ 0 ]
                    );

                    if (isset( $data[ 'gas' ][ 'settings' ][ 'medium_type' ][ 'formatted' ] )) {
                        $medium_type = explode( '_', $data[ 'gas' ][ 'settings' ][ 'medium_type' ][ 'formatted' ] );
                        $returnChannels[ $c ][ 'medium_type' ] = isset( $medium_type[ 1 ] ) ? $medium_type[ 1 ] : $medium_type[ 0 ];
                    }
                    $r[ 'main' ] = $returnChannels;

                    // EXTRA
                    foreach ($data as $k => $v) {
                        if ($k === 'gas') continue;
                        if (isset( $v[ 'unit' ] )) {
                            if (isset( $v[ 'value' ] )) {
                                $r[ 'extra' ][] = array(
                                    'value' => $v[ 'value' ],
                                    'unit' => $v[ 'unit' ],
                                    'name' => (str_replace( '_', ' ', $k ))
                                );
                            }
                        }
                    }
                }
            }

            /**
             * AXI
             */
            if ($this->product === 'AXI') {
                $c = 0;
                $type = '';
                if (isset( $data[ 'register_map' ][ 'accumulated_heat_energy' ] ) && $data[ 'register_map' ][ 'accumulated_heat_energy' ][ 'formatted' ] === 'sent') {
                    $type = 'heat';
                    $returnChannels[ $c ][ 'name' ] = 'Accumulated heat energy';
                    $returnChannels[ $c ][ 'value' ] = $data[ 'accumulated_heat_energy' ][ 'value' ];
                    $returnChannels[ $c ][ 'unit' ] = $data[ 'accumulated_heat_energy' ][ 'unit' ];
                    $returnChannels[ $c ][ 'medium_type' ] = 'heat';
                } elseif (isset( $data[ 'accumulated_volume' ] ) && isset( $data[ 'accumulated_volume' ][ 'unit' ] )) {
                    $type = 'volume';
                    $returnChannels[ $c ][ 'name' ] = 'Accumulated volume';
                    $returnChannels[ $c ][ 'value' ] = $data[ 'accumulated_volume' ][ 'value' ];
                    $returnChannels[ $c ][ 'unit' ] = $data[ 'accumulated_volume' ][ 'unit' ];
                    $returnChannels[ $c ][ 'medium_type' ] = 'water';
                }

                // EXTRA
                foreach ($data as $key => $value) {
                    if (isset( $value[ 'value' ] )) {
                        $r[ 'extra' ][] = array(
                            'value' => ($type == 'heat' ? round( $value[ 'value' ], 3 ) : $value[ 'value' ]),
                            'unit' => $value[ 'unit' ],
                            'name' => (str_replace( '_', ' ', $key )) );
                    }
                }
                $r[ 'main' ] = $returnChannels;
            }

            /**
             * MLM
             */
            if ($this->product === 'MLM') {
                if (isset( $data[ 'metering_data' ] )) {
                    $c = 0;
                    $returnChannels[ $c ] = array(
                        'name' => 'Metering data',
                        'value' => $data[ 'metering_data' ][ 'value' ],
                        'unit' => $data[ 'metering_data' ][ 'unit' ],
                        'medium_type' => 'water'
                    );
                    // EXTRA
                    foreach ($data as $k => $v) {
                        if ($k === 'metering_data') continue;
                        if (isset( $v[ 'unit' ] )) {
                            if (isset( $v[ 'value' ] )) {
                                $r[ 'extra' ][] = array(
                                    'value' => $v[ 'value' ],
                                    'unit' => $v[ 'unit' ],
                                    'name' => (str_replace( '_', ' ', $k ))
                                );
                            }
                        }
                    }
                    $r[ 'main' ] = $returnChannels;
                }
            }

            /**
             * KLM
             */
            if ($this->product === 'KLM' && $this->fport) {
                $c = 0;
                if (is_array( $data )) {
                    foreach ($data[ 'register' ] as $uk => $uv) {
                        foreach ($uv as $k => $v) {
                            $register_value = (isset( $uv[ 'register_value' ] ) ? $uv[ 'register_value' ] : array( 'value' => 'n/a', 'unit' => 'n/a' ));
                            // MAIN
                            if (isset( $v[ 'formatted' ] )) {
                                $value = null;
                                if (in_array( $v[ 'formatted' ], array( 'E1', 'E1-E2' ) )) {
                                    if (!empty( $uv[ 'register_value' ][ 'value' ] )) {
                                        if (empty( $r[ 'main' ] )) {
                                            $returnChannels[ $c ] = array(
                                                'name' => !empty( $v[ 'description' ] ) ? $v[ 'description' ] : $v[ 'formatted' ],
                                                'value' => $register_value[ 'value' ],
                                                'unit' => $register_value[ 'unit' ],
                                                'medium_type' => 'heat'
                                            );
                                        }
                                    }
                                } elseif ($v[ 'formatted' ] === 'V1') {
                                    $value = round( $register_value[ 'value' ] );
                                } elseif ($v[ 'formatted' ] === 'T1') {
                                    $value = round( $register_value[ 'value' ] );
                                    $register_value[ 'unit' ] = '°C';
                                } elseif ($v[ 'formatted' ] === 'T2') {
                                    $value = round( $register_value[ 'value' ] );
                                    $register_value[ 'unit' ] = '°C';
                                } elseif ($v[ 'formatted' ] === 'HR') {
                                    $value = round( $register_value[ 'value' ] );
                                    $register_value[ 'unit' ] = 'h';
                                } else {
                                    $value = round( $register_value[ 'value' ], 2 );
                                }

                                // EXTRA
                                if ($value != null) {
                                    if (!empty( $v[ 'description' ] )) {
                                        $r[ 'extra' ][] = array(
                                            'value' => $value,
                                            'unit' => !empty( $register_value[ 'unit' ] ) ? $register_value[ 'unit' ] : '-',
                                            'name' => !empty( $v[ 'description' ] ) ? $v[ 'description' ] : '-',
                                        );
                                    }
                                }
                            }
                        }
                    }

                }
                $r[ 'main' ] = $returnChannels;
            }

            /**
             * PMG
             */
            if ($this->product == 'PMG') {
                $c = 0;
                // MAIN
                $returnChannels[ $c ] = array(
                    'name' => 'Accumulated energy',
                    'value' => $data[ 'accumulated_energy' ][ 'value' ],
                    'unit' => $data[ 'accumulated_energy' ][ 'unit' ],
                    'medium_type' => 'electricity'
                );

                // EXTRA
                if (!empty( $data )) {
                    foreach ($data as $uk => $uv) {
                        if ($uk === 'instant') {
                            foreach ($uv as $key => $v) {
                                $r[ 'extra' ][] = array(
                                    'value' => $v[ 'value' ],
                                    'unit' => $v[ 'unit' ],
                                    'name' => $key,
                                );
                            }
                        } elseif ($uk === 'RSSI') {
                            $r[ 'extra' ][] = array(
                                'value' => $uv[ 'value' ],
                                'unit' => $uv[ 'unit' ],
                                'name' => $uk
                            );
                        }

                        if ($uk === 'power') {
                            $r[ 'extra' ][] = array(
                                'value' => $uv[ 'value' ],
                                'unit' => $uv[ 'unit' ],
                                'name' => $uk
                            );
                        }
                    }
                }
                $r[ 'main' ] = $returnChannels;
            }

            /**
             * LCU
             */
            if ($this->product == 'LCU' && $this->fport == 25) {
                $c = 0;

                // MAIN
                if (isset( $data[ 'cumulative_power_consumption' ] )) {
                    $returnChannels[ $c ] = array(
                        'name' => 'Cumulative power consumption',
                        'value' => $data[ 'cumulative_power_consumption' ][ 'value' ],
                        'unit' => $data[ 'cumulative_power_consumption' ][ 'unit' ],
                        'medium_type' => 'electricity'
                    );

                    foreach ($data as $uk => $uv) {
                        if ($uk === 'cumulative_power_consumption') {
                            continue;
                        }
                        if (isset( $uv[ 'unit' ] ) && isset( $uv[ 'value' ] )) {
                            if (!empty( $uv[ 'unit' ] ) && !empty( $uv[ 'value' ] )) {
                                $r[ 'extra' ][] = array(
                                    'value' => $uv[ 'value' ],
                                    'unit' => $uv[ 'unit' ],
                                    'name' => $uk,
                                );
                            }
                        }
                    }
                } else {
                    foreach ($data[ 'consumption_data' ] as $k => $v) {
                        $returnChannels[ $c ] = array(
                            'name' => 'Active energy total',
                            'value' => $v[ 'active_energy_total' ][ 'value' ],
                            'unit' => $v[ 'active_energy_total' ][ 'unit' ],
                            'medium_type' => 'electricity'
                        );

                        foreach ($v as $ei => $ev) {
                            if ($ei == 'active_energy_total') continue;
                            if (isset( $ev[ 'unit' ] ))
                                $r[ 'extra' ][ $c ][] = array(
                                    'value' => $ev[ 'value' ],
                                    'unit' => $ev[ 'unit' ],
                                    'name' => $ei,
                                );
                        }
                        $c++;
                    }
                }
                $r[ 'main' ] = $returnChannels;
            }

        } else {
            if ($this->fport == 14 || $this->fport == 16) {
                if (is_numeric( $data )) {
                    $c = 0;

                    $description = $this->description;
                    $medium_type = '';
                    if (!empty( $description )) {
                        $medium_type = explode( ",", $description );
                        $medium_type = explode( "(", $medium_type[ 0 ] );
                        $medium_type = $medium_type[ 1 ];
                    }

                    if ($this->product === 'MLM') {
                        $name = 'Metering data';
                    } elseif (!empty( $medium_type )) {
                        $name = ucfirst( $medium_type );
                    } else {
                        $name = 'Channel ' . ($c + 1);
                    }

                    $returnChannels[ $c ] = array(
                        'name' => $name,
                        'value' => $data,
                        'unit' => isset( $this->unit ) ? $this->unit : '-'
                    );
                    $returnChannels[ $c ][ 'medium_type' ] = $medium_type;

                    $r[ 'main' ] = $returnChannels;
                }
            }
        }

        /**
         * Convert data and set new units
         */
        if (!empty( $r[ 'main' ] ) && $r[ 'main' ] != null) {
            foreach ($r[ 'main' ] as $key => $value) {
                $channel = $r[ 'main' ][ $key ];
                if (is_numeric( $channel[ 'value' ] )) {

                    // do something if unit is SYS
                    if ($value[ 'unit' ] === 'SYS') {
                        $channel[ 'value' ] = 'NULL';
                        $channel[ 'unit' ] = 'NULL';
                        continue;
                    }

                    // HEAT
                    // kWh => mWh
                    if ($channel[ 'medium_type' ] === 'heat' && $value[ 'unit' ] === 'kWh') {
                        $channel[ 'unit' ] = 'MWh';
                        $channel[ 'value' ] = number_format( (($value[ 'value' ]) / 1000), 3, '.', '' );
                    }

                    // ELECTRICITY
                    // Wh => kWh
                    if ($channel[ 'medium_type' ] === 'electricity') {
                        if ($value[ 'unit' ] === 'Wh') {
                            $channel[ 'unit' ] = 'kWh';
                            $channel[ 'value' ] = number_format( (($value[ 'value' ]) / 1000), 3, '.', '' );
                        }

                        if ($value[ 'unit' ] === 'kWh') {
                            $channel[ 'value' ] = number_format( ($value[ 'value' ]), 3, '.', '' );
                        }
                    }

                    // WATER & GAS
                    // liter/L => m³
                    if ($value[ 'unit' ] === 'liter' || $value[ 'unit' ] === 'L') {
                        $channel[ 'unit' ] = 'm³';
                        $channel[ 'value' ] = number_format( (($value[ 'value' ]) / 1000), 3, '.', '' );
                    }
                } else {
                    $channel[ 'value' ] = 'Not a number';
                    $channel[ 'unit' ] = 'NULL';
                }

                $r[ 'main' ][ $key ] = $channel;
            }

        } else {
            $r[ 'main' ] = 'not converted';
            $r[ 'received_data' ] = $data;
        }

        return $r;
    }

    /**
     * @param $library
     * @return string
     */
    public function generateEncoder( $library )
    {
        //TODO
        $lib = self::call_library( $library );
        $html = $lib;
        return $html;
    }

}

?>