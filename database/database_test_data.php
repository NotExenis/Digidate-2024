<?php
include '../private/conn.php';
//Languages Checker
$sql_data_language = 'SELECT * FROM tbl_languages';
$sth_data_language = $conn->prepare($sql_data_language);
$sth_data_language->execute();
$count_language = $sth_data_language->fetchColumn();

if ($count_language == 0) {
    fill_database_languages();
}
//Education Checker
$sql_data_education = 'SELECT * FROM tbl_education';
$sth_data_education = $conn->prepare($sql_data_education);
$sth_data_education->execute();
$count_education = $sth_data_education->fetchColumn();

if ($count_language == 0) {
    fill_database_education();
}

function fill_database_languages() {
    include '../private/connection.php';

    $languagesComplete = file_get_contents('../languages.json');
    $decoded_json = json_decode($languagesComplete, true);


    foreach($decoded_json as $language) {
        echo '<pre>'. print_r($language); echo '<pre>';

        $code = $language['code'];
        $name = $language['name'];

        $sql = "INSERT INTO tbl_languages (languages_name, languages_code) VALUES (:language, :code)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(":language", $name);
        $sth->bindParam(":code", $code);
        $sth->execute();


    }
}
function fill_database_education() {
    include '../private/connection.php';

    $education = ['basisonderwijs' ,'vmbo', 'mbo 1', 'avo', 'havo', 'vwo', 'mbo 2', 'mbo 3', 'mbo 4', 'hbo', 'wo bachelor', 'wo master', 'wo doctor' ];

    foreach($education as $key => $value) {
        echo $value;
        $sql = "INSERT INTO tbl_education (education_name) VALUES (:education)";
        $sth = $conn->prepare($sql);
        $sth->bindParam(":education", $value);
        $sth->execute();
    }
}

//echo '<pre>'. print_r($decoded_json); echo '<pre>';

//$code = $decoded_json['code'];
