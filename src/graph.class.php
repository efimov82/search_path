<?php

namespace src;

/**
 * Class for search paths in graph
 */
class Graph {

  protected $graph;

  public function __construct($graph) {
    $this->graph = $graph;
  }

  /**
   *
   * @param string $origin
   * @param string $destination
   * @return array
   */
  public function searchPath($origin, $destination, $exclude_vertexs = []) {
    $visited = [];
    foreach ($this->graph as $vertex => $adj) {
      $visited[$vertex] = array_key_exists($vertex, array_flip($exclude_vertexs));
    }

    $q                = new \SplQueue();
    $q->enqueue($origin);
    $visited[$origin] = true;

    $path          = [];
    $path[$origin] = new \SplDoublyLinkedList();
    $path[$origin]->setIteratorMode(
      \SplDoublyLinkedList::IT_MODE_FIFO | \SplDoublyLinkedList::IT_MODE_KEEP
    );

    $path[$origin]->push($origin);
    while (!$q->isEmpty() && $q->bottom() != $destination) {
      $t = $q->dequeue();
      if (empty($this->graph[$t]))
        break;

      foreach ($this->graph[$t] as $vertex) {
        if (!isset($visited[$vertex])) { // Fix for vertex don't have childs in graph
          $visited[$vertex] = false;
        }

        if (!$visited[$vertex]) {
          $q->enqueue($vertex);
          $visited[$vertex] = true;

          $path[$vertex] = clone $path[$t];
          $path[$vertex]->push($vertex);
        }
      }
    }

    //print_r($path);

    if (isset($path[$destination])) {
      return $path[$destination];
    } else {
      return [];
    }
  }

  /**
   * Additional search for find variants $origin_path
   *
   * @param string $origin
   * @param string $destination
   * @param array $origin_path
   * @return array paths array | empty array
   */
  public function searchOtherPaths($origin, $destination, $origin_path) {
    $res = [];
    foreach ($origin_path as $vertex) {
      $path = [];
      if (($vertex != $origin) && ($vertex != $destination))
        $path = $this->searchPath($origin, $destination, [$vertex]);

      if (count($path) && !$this->_isPathExist($path, $res))
        $res[] = $path;
    }

    return $res;
  }

  /**
   *
   * @param SplDoublyLinkedList $search_path
   * @param SplDoublyLinkedList[] $arr_paths
   * @return boolean
   */
  protected function _isPathExist($search_path, $arr_paths) {
    //return false;
    foreach ($arr_paths as $path) {
      if ($path == $search_path)
        return true;
    }

    return false;
  }

}
