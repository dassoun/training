<?php

require_once('./dlist.inc.php');

class cellule extends dlist_cell {
    public function display() {
        echo($this->value);
    }   
}

class liste extends dlist {
    public function compare() {
        return 1;
    }
}


$maListe2 = new liste();
$c = new cellule();
$maListe2->insertAfterCursor(789, $c);
$maListe2->insertAfterCursor(999, $c);
$maListe2->insertAfterCursor(345, $c);
$maListe2->insertAfterCursor(12, $c);

//$maListe2->insertBeforeCursor(789, $c);
//$maListe2->insertBeforeCursor(999, $c);
//$maListe2->insertBeforeCursor(345, $c);
//$maListe2->insertBeforeCursor(12, $c);

$maListe2->display("/");
var_dump($maListe2);

$maListe2->resetCursor();
$maListe2->display("/");
var_dump($maListe2);
?>