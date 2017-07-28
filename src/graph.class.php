<?php
namespace src;

/**
 * Class for search paths in graph
 */
class Graph
{
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
  public function searchPath($origin, $destination) {
    foreach ($this->graph as $vertex => $adj) {
      $this->visited[$vertex] = false;
    }

    $q = new \SplQueue();
    $q->enqueue($origin);
    $this->visited[$origin] = true;

    // это требуется для записи обратного пути от каждого узла
    $path = [];
    $path[$origin] = new \SplDoublyLinkedList();
    $path[$origin]->setIteratorMode(
      \SplDoublyLinkedList::IT_MODE_FIFO|\SplDoublyLinkedList::IT_MODE_KEEP
    );

    $path[$origin]->push($origin);
    while (!$q->isEmpty() && $q->bottom() != $destination) {
      $t = $q->dequeue();

      if (!empty($this->graph[$t])) {
        // для каждого соседнего узла
        foreach ($this->graph[$t] as $vertex) {
          if (!$this->visited[$vertex]) {
            // если все еще не посещен, то добавим в очередь и отметим
            $q->enqueue($vertex);
            $this->visited[$vertex] = true;
            // добавим узел к текущему пути
            $path[$vertex] = clone $path[$t];
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
}
