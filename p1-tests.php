
<?php

class MyDestructableClass 
{
    function __construct() {
        print "In constructor\n" . "<br />";
    }

    function __destruct() {
        print "Destroying " . __CLASS__ . "\n" . "<br />";
    }

    function ecrire() {
        echo("Je suis un objet qui écrit des trucs");
    }
}

$obj = new MyDestructableClass();
$obj->ecrire();
