<?php

namespace Domain;

use PDO;

class BookRepository {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create(Book $book) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, isbn, pubYear) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$book->title, $book->author, $book->isbn, $book->pubYear]);
    }

    public function update(Book $book, $oldIsbn) {
        $stmt = $this->db->prepare("UPDATE books SET title = ?, author = ?, pubYear = ?, isbn = ? WHERE isbn = ?");
        return $stmt->execute([$book->title, $book->author, $book->pubYear, $book->isbn, $oldIsbn,]);
    }

    public function delete($isbn) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE isbn = ?");
        $stmt->execute([$isbn]);
    }

    public function findByTitleOrAuthor($search) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
        $stmt->execute([$search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByIsbn($isbn) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE isbn = ?");
        $stmt->execute([$isbn]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateIsbn($isbn) {
        return preg_match('/^97[89]\d{10}$/', $isbn);
    }
}
