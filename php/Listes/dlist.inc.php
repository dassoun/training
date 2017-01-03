<?php

/**
 * Issu du cours de Pierre-Olivier Lapeyre
 * Cours 73 -- Listes doublement chaînées, partie 1 
 * https://www.youtube.com/watch?v=g9nCpYzdPlE
 */
abstract class dlist_cell {
    protected $value;
    /* @var dlist_cell */
    protected $next;
    /* @var dlist_cell */
    protected $previous;
    
    abstract public function display();
    
    public function remove() {
        unset($this);
    }
    
    public function getValue() {
        return $this->value;
    }
    
    /* @return dlist_cell */
    public function getNext() {
        return $this->next;
    }

    /* @return dlist_cell */
    public function getPrevious() {
        return $this->previous;
    }

    /* @return dlist_cell */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /* @return dlist_cell */
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
    
    /* @return dlist_cell */
    public function getNext() {
        return $this->next;
    }

    /* @return dlist_cell */
    public function getPrevious() {
        return $this->previous;
    }
    
    /* @return dlist_cursor */
    public function setNext($next) {
        $this->next = $next;
        return $this;
    }
    
    /* @return dlist_cursor */
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
    protected $len;
    
    /*
     * @var $cellClass : nom de la classe 
     */
    public function __construct(dlist_cell $cellule) {
        $this->sentinel = $cellule;
        $this->cursor = new dlist_cursor();
        
        $this->sentinel->setNext($this->sentinel);
        $this->sentinel->setPrevious($this->sentinel);
        
        $this->cursor->setNext($this->sentinel);
        $this->cursor->setPrevious($this->sentinel);
        
        $this->len = 0;
    }
    
    abstract public function compare($c1, $c2);
    
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
    
    public function insertAfterCursor($data, dlist_cell $cellule) {
        $c = clone($cellule);
        
        $c->setValue($data)
                ->setPrevious($this->cursor->getPrevious())
                ->setNext($this->cursor->getNext());
        $this->cursor->getPrevious()->setNext($c);
        $this->cursor->getNext()->setPrevious($c);
        $this->cursor->setNext($c);
        
        $this->len++;
          
        return $c;
    }
    
    public function insertBeforeCursor($data, dlist_cell $cellule) {
        $c = clone($cellule);
        
        $c->setValue($data)
                ->setPrevious($this->cursor->getPrevious())
                ->setNext($this->cursor->getNext());
        $this->cursor->getPrevious()->setNext($c);
        $this->cursor->getNext()->setPrevious($c);
        $this->cursor->setPrevious($c);
        
        $this->len++;
        
        return $c;
    }
    
    public function resetCursor() {
        $this->cursor->setPrevious($this->sentinel);
        $this->cursor->setNext($this->sentinel->getNext());
    }
    
    public function cursorMoveToNext() {
        $this->cursor->setPrevious($this->cursor->getNext());
        $this->cursor->setNext($this->cursor->getNext()->getNext());
    }
    
    public function cursorMoveToPrevious() {
        $this->cursor->setNext($this->cursor->getPrevious());
        $this->cursor->setPrevious($this->cursor->getPrevious()->getPrevious());
    }
    
    public function cursorIsAtHead() {
        return ($this->cursor->getPrevious() === $this->sentinel);
    }
    
    public function cursorIsAtTail() {
        return ($this->cursor->getNext() === $this->sentinel);
    }
    
    public function cursorMoveToHead() {
        $this->cursor->setPrevious($this->sentinel);
        $this->cursor->setNext($this->sentinel->getNext());
    }
    
    public function cursorMoveToTail() {
        $this->cursor->setPrevious($this->sentinel->getPrevious());
        $this->cursor->setNext($this->sentinel);
    }
    
    public function removeAfterCursor() {
        if ($this->cursor->getNext() === $this->sentinel) {
            return false;
        } else {
            $c = clone($this->cursor);
            
            $this->cursor->getPrevious()->setNext($this->cursor->getNext()->getNext());
            $this->cursor->getNext()->getNext()->setPrevious($this->cursor->getPrevious());
            
            // Mise à jour du Curseur
            $this->cursor->setNext($c->getNext()->getNext());
            unset($c);
            $this->cursor->getNext()->remove();
            
            $this->len--;
            
            return true;
        }
    }
    
    public function removeBeforeCursor() {
        if ($this->cursor->getPrevious() === $this->sentinel) {
            return false;
        } else {
            $c = clone($this->cursor);
            
            $this->cursor->getPrevious()->getPrevious()->setNext($this->cursor->getNext());
            $this->cursor->getNext()->setPrevious($this->cursor->getPrevious()->getPrevious());
            
            // Mise à jour du Curseur
            $this->cursor->setPrevious($c->getPrevious()->getPrevious());
            unset($c);
            $this->cursor->getPrevious()->remove();
            
            $this->len--;
            
            return true;
        }
    }
    
    public function getAfterCursor() {
        return $this->cursor->getNext()->getValue();
    }
    
    public function getBeforeCursor() {
        return $this->cursor->getPrevious()->getValue();
    }
    
    public function getSentinel() {
        return $this->sentinel;
    }

    public function getCursor() {
        return $this->cursor;
    }
    
    public function getLen() {
        return $this->len;
    }
    
    /* @return dlist */
    public function setSentinel($sentinel) {
        $this->sentinel = $sentinel;
        return $this;
    }
    
    /* @return dlist */
    public function setCursor($cursor) {
        $this->cursor = $cursor;
        return $this;
    }
    
    /* @return dlist */
    public function setLen($len) {
        $this->len = $len;
        return $this;
    }
}

?>