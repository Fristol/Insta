<?php

class createDB
{
    function createDatabase($servername, $username, $password)
    {
        $mysqli = new mysqli($servername, $username, $password);

        if ($mysqli->connect_error) {
            die("Ошибка подключения: " . $mysqli->connect_error);
        }


        $sql = "CREATE DATABASE insta";
        if ($mysqli->query($sql) === TRUE) {
            echo "База данных создана успешно";
        } else {
            echo "Ошибка создания базы данных: " . $mysqli->error;
        }
        $mysqli->close();
    }

    function createTable($servername, $username, $password, $dbname)
    {
        $mysqli = new mysqli($servername, $username, $password, $dbname);

        if ($mysqli->connect_error) {
            die("Ошибка подключения: " . $mysqli->connect_error);
        }
        $sql = "CREATE TABLE currency (id INTEGER AUTO_INCREMENT PRIMARY KEY, valueID VARCHAR(30), numCode VARCHAR(30),charCode VARCHAR(30),value VARCHAR(30),name VARCHAR(50),date VARCHAR(30));";
        if ($mysqli->query($sql) === TRUE) {
            $count = 0;
            $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';
            for ($i = 0; $i < 30; $i++) {
                $date = new DateTime('-' . $i . ' days');
                $date = $url . '' . $date->format('d/m/Y');
                $out = file_get_contents($date);
                $valutes = new SimpleXMLElement($out);
                foreach ($valutes->Valute as $valute) {
                    $query = "INSERT INTO currency (valueID, numCode, charCode, value, name, date) VALUES ('$valute[ID]', '$valute->NumCode', '$valute->CharCode', '$valute->Nominal', '$valute->name', '$valutes[Date]')";
                    if ($mysqli->query($query) === TRUE) $count++;
                }
            }
        } else {
            echo "Ошибка создания таблицы: " . $mysqli->error;
        }
        $mysqli->close();
    }

}

?>