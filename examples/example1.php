<?php

require(dirname(__DIR__).'/vendor/autoload.php');

use Frisbee\Frisbee;

$frisbee = new Frisbee(array(
	'host'=>'localhost',
	'port'=>8182,
	'debug'=>false
));

var_dump($frisbee->get()->graphs());
$frisbee->get()->setGraph('titanexample');

echo PHP_EOL.PHP_EOL.'GRAPH()'.PHP_EOL;
var_dump($frisbee->get()->graph());
echo PHP_EOL.PHP_EOL.'EDGES()'.PHP_EOL;
var_dump($frisbee->get()->edges());
echo PHP_EOL.PHP_EOL.'KEYINDICES()'.PHP_EOL;
var_dump($frisbee->get()->keyindices());
echo PHP_EOL.PHP_EOL.'EDGEKEYS()'.PHP_EOL;
var_dump($frisbee->get()->edgeKeys());
echo PHP_EOL.PHP_EOL.'VERTEXKEYS()'.PHP_EOL;
var_dump($frisbee->get()->vertexKeys());
echo PHP_EOL.PHP_EOL.'VERTICES()'.PHP_EOL;
var_dump($frisbee->get()->vertices());
