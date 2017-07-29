<?php

namespace src;

/**
 * Class for search paths in graph
 */
class Graph {

  protected $graph;
  protected $visited = array();

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
    foreach ($this->graph as $vertex => $adj) {
      $this->visited[$vertex] = array_key_exists($vertex, array_flip($exclude_vertexs));
    }

    $q = new \SplQueue();
    $q->enqueue($origin);
    $this->visited[$origin] = true;

    // это требуется для записи обратного пути от каждого узла
    $path          = [];
    $path[$origin] = new \SplDoublyLinkedList();
    $path[$origin]->setIteratorMode(
      \SplDoublyLinkedList::IT_MODE_FIFO | \SplDoublyLinkedList::IT_MODE_KEEP
    );

    $path[$origin]->push($origin);
    while (!$q->isEmpty() && $q->bottom() != $destination) {
      $t = $q->dequeue();
      if (!empty($this->graph[$t])) {
        // для каждого соседнего узла
        foreach ($this->graph[$t] as $vertex) {

          if (isset($this->visited[$vertex]) && !$this->visited[$vertex]) {
            // если все еще не посещен, то добавим в очередь и отметим
            $q->enqueue($vertex);
            $this->visited[$vertex] = true;
            // добавим узел к текущему пути
            $path[$vertex]          = clone $path[$t];
            $path[$vertex]->push($vertex);
          }
        }
      }
    }

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
   * @return array parths array | empty array
   */
  public function searchOtherPaths($origin, $destination, $origin_path) {
    $res = [];
    foreach ($origin_path as $vertex) {
      $path = [];
      if (($vertex != $origin) && ($vertex != $destination))
        $path = $this->searchPath($origin, $destination, [$vertex]);

      if (count($path))
        $res[] = $path;
    }

    return $res;
  }

}
