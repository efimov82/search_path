<?php

/**
 * Main API script.
 * Find path from start point to end point.
 *
 * @autor Danil Efimov  <efimov82@gmail.com>
 * @data 28.07.2017
 *
 * Usage: php ./index.php 'Barcelona' 'New York JFK'
 */
include './src/graph.class.php';
include './src/functions.php';

use src\Graph;

$data = \src\createData('./listCard.txt');
if (!$data)
  die('wrong data file');

// Input params
$start  = isset($argv[1]) ? $argv[1] : '';
$finish = isset($argv[2]) ? $argv[2] : '';

if (!$start || !$finish)
  die("You need set start and finish params. \n");

$graph = new Graph($data['paths']);

$path   = $graph->searchPath($start, $finish);
$result = \src\createResult($path, $data);
if (!$result)
  die('No find path from ' . $start . ' to ' . $finish . "\n");

\src\printResults($start, $finish, $result);

// debug
//\src\printRawResults($result);

exit(1);
