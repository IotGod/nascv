<?php
/*
 * NAS Converters usage example
 * @author Rauno Avel
 * @copyright NAS 2018
 * @version 7.0 (30.12.2018)
*/

require 'src/nascv.php';
$cv = new nascv;
$msg = array( 'data' => 'SnUOXACfRAIE/zJEBQr/MkQBAv8ARAQI/wBEAwb/AEQGDP8A',
    'fport' => '24',
    'serial' => '4d1b0092',
    'firmware' => '0.5.0' );
$data = $cv->data( $msg );

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>NASCV Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <ul class="nav nav-tabs" id="myTab" role="tablist">

        <li class="nav-item active">
            <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data"
               aria-selected="false">Decoded Data</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="json-tab" data-toggle="tab" href="#json" role="tab" aria-controls="json"
               aria-selected="false">Decoded data (JSON)</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="klm-tab" data-toggle="tab" href="#klm" role="tab" aria-controls="klm"
               aria-selected="false">KLM register</a>
        </li>

    </ul>
    <div class="tab-content pt-3" id="myTabContent">

        <div class="tab-pane fade active show" id="data" role="tabpanel" aria-labelledby="data-tab">
            <?= $cv->toHTML( $data, 'table table-sm' ) ?>
        </div>

        <div class="tab-pane fade" id="json" role="tabpanel" aria-labelledby="json-tab">
            <pre><?php
                echo '# RAW: ' . $cv->rawdata . PHP_EOL;
                echo '# Product: ' . $cv->product . PHP_EOL;
                echo '# Firmware: ' . $cv->firmware . PHP_EOL;
                echo '# Description: ' . $cv->description . PHP_EOL;

                echo '# Type: ' . $cv->type . PHP_EOL;
                echo '# Byte: ' . $cv->byte . PHP_EOL;
                echo '# Unit: ' . $cv->unit . PHP_EOL;

                echo PHP_EOL;
                echo json_encode( $data, JSON_PRETTY_PRINT );

                ?>
                </pre>
        </div>

        <div class="tab-pane fade" id="klm" role="tabpanel" aria-labelledby="klm-tab">
            <pre><?php
                echo json_encode( json_decode( $cv->call_library( 'KLM' )->register ), JSON_PRETTY_PRINT );
                ?></pre>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>