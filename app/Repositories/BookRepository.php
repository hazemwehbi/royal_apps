<?php

namespace App\Repositories;

use App\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{

	protected $book;

	public function __construct(Book $book)
	{
	    $this->book = $book;
	}

	public function getPaginate($fields, $perPage, $search, $orderBy, $sort,$auth_id=null)
	{
		 $this->book
				->select($fields)
				->join('authors', 'authors.id', '=', 'books.author_id')
            	->where('title', 'like', '%'.$search.'%')
           	 	->orWhere('name', 'like', '%'.$search.'%');
				if($auth_id){
					$this->book = $this->book->where('author_id',$auth_id);
				   }
				   $this->book= $this->book->orderBy($orderBy, $sort)
				   ->paginate($perPage);
				   return $this->book;
	}

	public function get($fields, $perPage, $search, $orderBy, $sort,$auth_id=null)
	{
		 $this->book
				->select($fields)
				->join('authors', 'authors.id', '=', 'books.author_id')
            	->where('title', 'like', '%'.$search.'%')
           	 	->orWhere('name', 'like', '%'.$search.'%');
				
				if($auth_id){
					$this->book = $this->book->where('author_id',$auth_id);
					
				   }
				   $this->book= $this->book->orderBy($orderBy, $sort)
				   ->limit($perPage)
				   ->get();
				   return $this->book;
	}

	public function create($input)
	{
		return $this->book
				->create($input);
	}

	public function update($id, $input)
	{
		 $this->book
				->where('id', $id)
				->update($input);
				return $this->book;
	}

	public function findById($id, $fields)
	{
		return $this->book
				->join('authors', 'authors.id', '=', 'books.author_id')
				->find($id, $fields);
	}

	public function delete($id)
	{
		return $this->book
				->where('id', $id)
				->delete();
	}
}
