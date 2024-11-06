<?php

namespace Domain;

class Book {
    public $title;      // Título
    public $author;     // Autor
    public $isbn;       // ISBN
    public $pubYear;    // Año de publicación


    // Constructor
    public function __construct($title, $author, $isbn, $pubYear) {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->pubYear = $pubYear;
    }
}
