<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use Validator;

class BookController extends Controller
{
    protected $book;

    public function __construct(BookRepository $book)
    {
        $this->book = $book;
    }
    /**
     * @OA\GET(
     *     path="/api/v1/book",
     *     tags={"Book API"},
     *     summary="Book list",
     *     description="API for getting Book list, can return with/out pagination, filter selected column, sort by column",
     *     operationId="index",
     *     @OA\Parameter(
     *         description="Search by book title or author name",
     *         in="query",
     *         name="search",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Order by column",
     *         in="query",
     *         name="order_by",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Sort by asc/desc",
     *         in="query",
     *         name="sort",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Paginate the data",
     *         in="query",
     *         name="is_paginate",
     *         @OA\Schema(
     *           type="string",
     *           enum={"true", "false"},
     *           default="true"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Limit data per page",
     *         in="query",
     *         name="per_page",
     *         @OA\Schema(
     *           type="string",
     *           default="15"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Selected column of the data",
     *         in="query",
     *         name="select_field",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success getting data",
     *         @OA\JsonContent(
     *           example={"status": 200, "success": true, "message": "Book retrieved successfully", "errors": null, "data": { "current_page": 1, "data": { { "id": 2, "author_id": 2, "name": "Takeshi Maekawa", "title": "Kung Fu Boy", "created_at": "2020-02-15 02:21:47", "updated_at": "2020-02-15 02:21:47" } }, "first_page_url": "http:\/\/127.0.0.1:8000\/api\/v1/book?page=1", "from": 1, "last_page": 3, "last_page_url": "http:\/\/127.0.0.1:8000\/api\/v1/book?page=3", "next_page_url": "http:\/\/127.0.0.1:8000\/api\/v1\/book?page=2", "path": "http:\/\/127.0.0.1:8000\/api\/v1\/book", "per_page": "1", "prev_page_url": null, "to": 1, "total": 3}}
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $orderBy = checkInArr($request->order_by, Book::fields()) ?: 'books.id';
        $sort = checkInSort($request->sort);
        $isPaginate = $request->is_paginate;
        $perPage = $request->per_page;
        $selectField = str_replace(' ', '', $request->select_field) ?: toStrColumn(Book::fields());
        $fields = explode(',', $selectField);
        $auth_id=$request->auth_id;
        $fields = checkArrInArr($fields, Book::fields(), Book::aliases());
   
        if ($isPaginate == 'true')
        {
            $data = $this->book->getPaginate($fields, $perPage, $search, $orderBy, $sort,$auth_id);
        } else {
            $data = $this->book->get($fields, $perPage, $search, $orderBy, $sort,$auth_id);
        }
   
     
        return $this->sendResponse(200, true, 'Book retrieved successfully', null, $data);
    }

    /**
     * @OA\POST(
     *     path="/api/v1/book",
     *     tags={"Book API"},
     *     summary="Book create",
     *     description="API for creating Book",
     *     operationId="store",
     *     @OA\RequestBody(
     *         request="Book",
     *         description="Book object that needs to be added to the body",
     *         required=true,
     *         @OA\JsonContent(
     *           example={"author_id": 2, "title": "Kung Fu Boy"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success creating data",
     *         @OA\JsonContent(
     *           example={"status": 201, "success": true, "message": "Book created successfully", "errors": null, "data": { "author_id": 2, "title": "Kung Fu Boy", "updated_at": "2020-02-15 12:26:08", "created_at": "2020-02-15 12:26:08", "id": 4}}
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid request data",
     *         @OA\JsonContent(
     *           example={"status": 400, "success": false, "message": "There's something wrong with your request", "errors": { "title": { "The title field is required." } }, "data": null}
     *         )
     *     )
     * )
     */
    public function store(BookRequest $request)
    {
        $input = $request->all();
   
      
   
        $book = $this->book->create($input);
      //  dd($request->all());
if($request->imgDataUrl){
   
    $book->addMediaFromBase64($request->imgDataUrl)->usingFileName('image'.time().'.png')->toMediaCollection('image');
}
        return $this->sendResponse(201, true, 'Book created successfully', null, $book);
    }

    /**
     * @OA\GET(
     *     path="/api/v1/book/{id}",
     *     tags={"Book API"},
     *     summary="Book detail",
     *     description="API for getting Book detail, filter selected column",
     *     operationId="show",
     *     @OA\Parameter(
     *         description="Book ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Selected column of the data",
     *         in="query",
     *         name="select_field",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success getting data",
     *         @OA\JsonContent(
     *           example={"status": 200, "success": true, "message": "Book retrieved successfully", "errors": null, "data": { "id": 1, "author_id": 1, "name": "Masashi Ueda", "title": "Kariage Kun", "created_at": "2020-02-11 22:23:10", "updated_at": "2020-02-11 22:23:12"}}
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Data not found",
     *         @OA\JsonContent(
     *           example={"status": 404, "success": false, "message": "Book not found", "errors": null, "data": null}
     *         )
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        if (!is_numeric($id))
        {
            return $this->sendResponse(404, false, 'Book not found', null, null);
        }

        $selectField = str_replace(' ', '', $request->select_field) ?: toStrColumn(Book::fields());
        $fields = explode(',', $selectField);
        $fields = checkArrInArr($fields, Book::fields(), Book::aliases());

        $data = Book::with('author','media')->find($id);//$this->book->findById($id, $fields);
//dd($data);
        if (is_null($data))
        {
            return $this->sendResponse(404, false, 'Book not found', null, null);
        }

        return $this->sendResponse(200, true, 'Book retrieved successfully', null, $data);
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/book/{id}",
     *     tags={"Book API"},
     *     summary="Book update",
     *     description="API for updating Book",
     *     operationId="update",
     *     @OA\Parameter(
     *         description="Book ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         request="Book",
     *         description="Book object that needs to be added to the body",
     *         required=true,
     *         @OA\JsonContent(
     *           example={"author_id": 1, "title": "Bakeru Kun"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success updating data",
     *         @OA\JsonContent(
     *           example={"status": 200, "success": true, "message": "Book updated successfully", "errors": null, "data": { "id": 1, "title": "bhehehe", "author_id": 1, "created_at": "2020-02-11 22:23:10", "updated_at": "2020-02-15 12:20:34", "deleted_at": null}}
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid request data",
     *         @OA\JsonContent(
     *           example={"status": 400, "success": false, "message": "There's something wrong with your request", "errors": { "title": { "The title field is required." } }, "data": null}
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Data not found",
     *         @OA\JsonContent(
     *           example={"status": 404, "success": false, "message": "Book not found", "errors": null, "data": null}
     *         )
     *     )
     * )
     */
    public function update(BookRequest $request, $id)
    {
        if (!is_numeric($id))
        {
            return $this->sendResponse(404, false, 'Book not found', null, null);
        }

        $input = $request->all();
   
       

        $data = $this->book->findById($id, Book::fields());

        if (is_null($data))
        {
            return $this->sendResponse(404, false, 'Book not found', null, null);
        }
   
        $update['author_id'] = $input['author_id'];
        $data->author_id = $input['author_id'];
        $update['title'] = $input['title'];
        $update['subject'] = $input['subject'];
        $update['version_date'] = $input['version_date'];
        $update['serial_number'] = $input['serial_number'];
        $update['description'] = $input['description'];
        $data->title = $input['title'];

        $this->book->update($id, $update);
        $book=Book::find($id);
        if($request->imgDataUrl){
   $book->clearMediaCollection('image');
            $book->addMediaFromBase64($request->imgDataUrl)->usingFileName('image'.time().'.png')->toMediaCollection('image');
    //  dd($book);
        }
        return $this->sendResponse(200, true, 'Book updated successfully', null, $data);
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/book/{id}",
     *     tags={"Book API"},
     *     summary="Book delete",
     *     description="API for deleting Book",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         description="Book ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success deleting data",
     *         @OA\JsonContent(
     *           example={"status": 200, "success": true, "message": "Book deleted successfully", "errors": null, "data": null}
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Data not found",
     *         @OA\JsonContent(
     *           example={"status": 404, "success": false, "message": "Book not found", "errors": null, "data": null}
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        if (!is_numeric($id))
        {
            return $this->sendResponse(404, false, 'Book not found', null, null);
        }

        $this->book->delete($id);
        return $this->sendResponse(200, true, 'Book deleted successfully', null, null);
    }
}
