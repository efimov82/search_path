<?php

/*
 * Test cases for search paths
 */

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
include __DIR__.'/../src/graph.class.php';
include __DIR__.'/../src/functions.php';

use src\Graph;

class TestSearchPath extends UnitTestCase {
  protected $graph;

  function __construct() {
    parent::__construct();

    $data = \src\createData(__DIR__.'/testCards.txt');
    $this->graph = new Graph($data['paths']);
  }


  function TestSearchNotExistPath() {
    $res = $this->graph->searchPath('A', 'Z');

    $this->assertEqual($res, []);
  }


  function TestSearchPathSimpleWay() {
    $res = $this->graph->searchPath('A', 'B');
    $this->assertEqual($this->_pathToArray($res), ['A', 'B']);
  }


  function TestExistSearchPath() {
    $res = $this->graph->searchPath('A', 'E');
    $this->assertEqual($this->_pathToArray($res), ['A', 'D', 'E']);
  }


  function TestSearchPathFromStartToEndDataCards() {
    $res = $this->graph->searchPath('A', 'R');
    $this->assertEqual($this->_pathToArray($res), ['A', 'D', 'R']);
  }


  function TestSearchPathFromMidlePoints() {
    $res = $this->graph->searchPath('C', 'F');
    $this->assertEqual($this->_pathToArray($res), ['C', 'D', 'E', 'F']);
  }


  function TestSearchOtherPathForEmptyOriginPath() {
    $res = $this->graph->searchOtherPaths('B', 'R', []);
    $this->assertEqual(count($res), 0);
  }


  function TestSearchOtherPath() {
    $firstPath = $this->graph->searchPath('B', 'R');
    $this->assertEqual($this->_pathToArray($firstPath), ['B', 'C', 'D', 'R']);

    $res = $this->graph->searchOtherPaths('B', 'R', $firstPath);
    $this->assertEqual(count($res), 1);
    $this->assertEqual($this->_pathToArray($res[0]), ['B', 'F', 'G', 'R']);
  }

  /**
   * service function
   *
   * @param type $list
   * @return type
   */
  function _pathToArray($list) {
    $res = [];
    foreach ($list as $num=>$vertex)
      $res[] = $vertex;

    return $res;
  }

}
