<?php

require_once(__DIR__ . "/../extlibs/vendor/autoload.php");
require_once(__DIR__ . "/db.php");


class srp6
{
    private $N;
    private $g;
    private $v;

    public function __construct()
    {
        $this->N = gmp_init("0x894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7");
        $this->g = gmp_init(7);
    }

    public function calculate_verifier(string $rI, string $salt)
    {
        $s = gmp_init("0x".$salt);
        if ($s == gmp_init(0))
        {
            return false;
        }

        $I = gmp_init("0x".$rI);
        $x = gmp_import(strrev(sha1(strrev(gmp_export($s)) . gmp_export($I), true)));
        $this->v = gmp_powm($this->g, $x, $this->N);

        return true;
    }

    public function proof_verifier(string $verifier)
    {
        return gmp_init("0x".$verifier) == $this->v;
    }

    public static function calculate_sha_passhash(string $username, string $password)
    {
        return sha1(self::normalize_string($username) . ":" . self::normalize_string($password));
    }

    private static function normalize_string(string $s)
    {
        return strtoupper($s);
    }
}
