<?php

/**
 * Issu du cours de Pierre-Olivier Lapeyre
 * Cours 73 -- Listes doublement chaînées, partie 1 
 * https://www.youtube.com/watch?v=g9nCpYzdPlE
 */
interface dlist_cell_interface {
    public function display();
    public function getValue();
    public function getNext();
    public function getPrevious();
    public function setValue($value);
    public function setNext($next);
    public function setPrevious($previous);
}

abstract class dlist_cell implements dlist_cell_interface {
    protected $value;
    /* @var dlist_cell */
    protected $next;
    /* @var dlist_cell */
    protected $previous;
    
    abstract public function display();
    
    public function getValue() {
        return $this->value;
    }

    public function getNext() {
        return $this->next;
    }

    public function getPrevious() {
        return $this->previous;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setNext($next) {
        $this->next = $next;
        return $this;
    }

    public function setPrevious($previous) {
        $this->previous = $previous;
        return $this;
    }
}

class dlist_cursor {
    /* @var dlist_cell */
    protected $next;
    /* @var dlist_cell */
    protected $previous;
    
    public function getNext() {
        return $this->next;
    }

    public function getPrevious() {
        return $this->previous;
    }

    public function setNext($next) {
        $this->next = $next;
        return $this;
    }

    public function setPrevious($previous) {
        $this->previous = $previous;
        return $this;
    }
}

abstract class dlist {
    /* @var dlist_cell */
    protected $sentinel;
    /* @var dlist_cursor */
    protected $cursor;
    
    public function __construct() {
        $this->sentinel = new cellule();
        $this->cursor = new dlist_cursor();
        
        $this->sentinel->setNext($this->sentinel);
        $this->sentinel->setPrevious($this->sentinel);
        
        $this->cursor->setNext($this->sentinel);
        $this->cursor->setPrevious($this->sentinel);
    }
    
    abstract public function compare();
    
    public function display($sep) {
        $c = $this->sentinel->getNext();
        echo("L(".$sep);
        while ($c != $this->sentinel) {
            $c->display();
            echo($sep);
            $c = $c->getNext();
        }
        echo(")");
    }
    
    public function insertAfterCursor($data, dlist_cell_interface $cellule) {
        $c = clone($cellule);
        
        $c->setValue($data)
                ->setPrevious($this->cursor->getPrevious())
                ->setNext($this->cursor->getNext());
        $this->cursor->getPrevious()->setNext($c);
        $this->cursor->getNext()->setPrevious($c);
        $this->cursor->setNext($c);
          
        return $c;
    }
    
    public function insertBeforeCursor($data, dlist_cell_interface $cellule) {
        $c = clone($cellule);
        
        $c->setValue($data)
                ->setPrevious($this->cursor->getPrevious())
                ->setNext($this->cursor->getNext());
        $this->cursor->getPrevious()->setNext($c);
        $this->cursor->getNext()->setPrevious($c);
        $this->cursor->setPrevious($c);
        
        return $c;
    }
    
    public function resetCursor() {
        $this->cursor->setPrevious($this->sentinel);
        $this->cursor->setNext($this->sentinel->getNext());
    }
    
    public function getSentinel() {
        return $this->sentinel;
    }

    public function getCursor() {
        return $this->cursor;
    }

    public function setSentinel($sentinel) {
        $this->sentinel = $sentinel;
        return $this;
    }

    public function setCursor($cursor) {
        $this->cursor = $cursor;
        return $this;
    }
}

?>