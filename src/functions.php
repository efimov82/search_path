<?php

namespace src;
/**
 * Service functions
 */


/**
 * Create final Result from paths and data from input file
 *
 * @param array $arr_paths [A, B,..,F] array vertex from start to finish
 * @param array $data
 * @return array [from, to, transport, seat, info, cost, time]
 */
function createResult($arr_paths, $data) {
  $res = [];
  foreach ($arr_paths as $num=>$path) {
    $res[] = _createPathResult($path, $data);
  }
  return $res;
}

/*
 * @param array path [A, B,..,F] array vertex from start to finish
 * @param array $data
 * @return array [from, to, transport, seat, info, cost, time]
 */
function _createPathResult($path, $data) {
  $res        = [];
  $from       = '';
  $infos      = $data['info'];
  $total_cost = 0;
  foreach ($path as $vertex) {
    if ($from) {
      $info  = $infos[$from][$vertex];
      # from;to;time;transport;cost;seat;info
      $res[] = ['from'      => $from,
          'to'        => $vertex,
          'transport' => $info[3],
          'seat'      => $info[5],
          'info'      => $info[6],
          'cost'      => $info[4],
          'time'      => $info[2]
      ];
    }
    $from = $vertex;
  }
  return $res;
}

/**
 * Read RAW data from file
 * File format: from;to;time;transport;cost;seat;info
 *
 * @param string $filename
 * @return array ['paths' - [vertex]=>[vertexes around]
 * ,              'info' - [from][to] => info]
 */
function createData($filename) {
  $handle = fopen($filename, 'r');
  $res    = [];
  $info   = [];
  while (!feof($handle)) {
    $str = trim(fgets($handle));

    if (!$str || $str{0} == '#')
      continue;

    $arr = explode(';', $str);
    $from = trim($arr[0]);
    $to = trim($arr[1]);
    $res[$from][] = $to;
    $info[$from][$to] = $arr;
  }

  return ['paths' => $res, 'info' => $info];
}

/**
 * Print results to console
 *
 * @param string $start
 * @param string $finish
 * @param array $data
 */
function printResults($start, $finish, $arr_paths) {
  echo("\nDetails your journey from '$start' to '$finish': \n");
  foreach($arr_paths as $num=>$path) {
    if ($path) {
      echo("Variant #$num \n");
      printDetailPath($path);
    } else
      echo('No way');

  }

}


function printDetailPath($path_data) {
  $total_cost = 0;
  $total_time = 0;
  foreach ($path_data as $num => $arr) {
    echo "#{$num}: Take " . $arr['transport'] . " from '" . $arr['from'] . '" to "' . $arr['to'] . '". Seat: ' . $arr['seat'] . ' , Additional info:' . $arr['info'] . "\n";
    $total_cost += (int) $arr['cost'];
    $total_time += (int) $arr['time'];
  }
  echo "Total cost: $total_cost$ \n";
  echo "Time in road: $total_time min \n";
  echo "----------------------------------\n";
}

function printRawResults($result) {
  echo("Raw results: \n");
  print_r($result);
}
