<?php
trait AdresseIp
{
    // fonction qui retourne l'adresse IP de l'utilisateur
    public function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    // Cette fonction retourne un input contenant le nom d'hôte sur lequel l'utilisateur c'est connecté
    public function inputAdressIp($hostname)
    {
        return "<form method=" . "\"post\"" . "><input id='adresse_ip' type='hidden' value=" . "\"$hostname\"" . "/></form>";
    }
}