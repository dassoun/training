<?php

require_once('./dlist.inc.php');

class cellule extends dlist_cell {
    public function display() {
        echo($this->value);
    }   
}

class liste extends dlist {
    public function compare($c1, $c2) {
        return ($c1->getValue() - $c2->getValue());
    }
}


$maListe2 = new liste("cellule");
$c = new cellule();
$maListe2->insertAfterCursor(789, $c);
$maListe2->insertAfterCursor(999, $c);
$maListe2->insertAfterCursor(345, $c);
$maListe2->insertAfterCursor(12, $c);
$maListe2->insertAfterCursor(854, $c);

//$maListe2->insertBeforeCursor(789, $c);
//$maListe2->insertBeforeCursor(999, $c);
//$maListe2->insertBeforeCursor(345, $c);
//$maListe2->insertBeforeCursor(12, $c);

$maListe2->display("/");
//var_dump($maListe2);

//$maListe2->resetCursor();
//$maListe2->display("/");
//var_dump($maListe2);

var_dump("=== Memory ===");
var_dump(memory_get_usage(true));

var_dump("=== Cursor ===");
var_dump($maListe2->getCursor());
var_dump("=== Cursor Move to Next ===");
$maListe2->cursorMoveToNext();
var_dump("=== Cursor ===");
var_dump($maListe2->getCursor());
var_dump("=== Cell Remove ===");
$c->remove();
var_dump("=== Memory ===");
var_dump(memory_get_usage(true));
var_dump("=== List ===");
var_dump($maListe2);
var_dump("=== Remove before cursor ===");
var_dump($maListe2->removeBeforeCursor());
var_dump("=== List ===");
var_dump($maListe2);
var_dump("=== Move cursor to tail ===");
$maListe2->cursorMoveToTail();
var_dump("=== Remove after cursor ===");
var_dump($maListe2->removeAfterCursor());
var_dump("=== Move cursor to previous ===");
$maListe2->cursorMoveToPrevious();
var_dump("=== Remove after cursor ===");
var_dump($maListe2->removeAfterCursor());
var_dump("=== List ===");
var_dump($maListe2);

?>