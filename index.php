<?php

require_once(__DIR__ . "/extlibs/vendor/autoload.php");
require_once(__DIR__ . "/libs/srp6.php");
require_once(__DIR__ . "/libs/db.php");


echo "<pre>";

$user = "martin";
$pass = "martin";

$account = db::realm()->for_table("account")->where("username", $user)->find_one();

$srp = new srp6();
$rI = srp6::calculate_sha_passhash($user, $pass);

if ($srp->calculate_verifier($rI, $account["s"]))
{
    if ($srp->proof_verifier($account["v"]))
    {
        echo "authed";
    }
    else
    {
        echo "not authed";
    }
}

echo "</pre>";
