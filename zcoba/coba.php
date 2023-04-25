<?php 

$named_array = array(
    "data" => array(
        array(
            "nrpdisini"=> "c14567218673",
            "namadisini" => "bar",
            "nilai" => "80",
            "nilai2" => "90",
            "nilai3" => "70",
        ),

        array(
            "nrpdisini"=> "c2339564568",
            "namadisini" => "bar",
            "nilai" => "30",
            "nilai2" => "20",
            "nilai3" => "40",
        ),
    )
);
echo json_encode($named_array);

?>