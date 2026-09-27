<?php
$link = mysqli_connect('mysql-razanatera.alwaysdata.net', 'razanatera', 'Manga49360.', 'razanatera_manga', 3306);
if (!$link) {
    die('Erreur : ' . mysqli_connect_error());
}
echo 'Connexion réussie !';
