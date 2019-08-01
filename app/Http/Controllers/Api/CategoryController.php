<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = $this->category->paginate('10');
        return response()->json($categorys, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        try {

            $categorys = $this->category->create($data);
            return response()->json([
                    'data' => [
                        'msg' => 'Categoria cadastrado com sucesso',
                    ]
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $categorys = $this->category->findOrFail($id);
            return response()->json([
                    'data' => $categorys
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        try {
            $categorys = $this->category->findOrFail($id);
            $categorys->update($data);
            return response()->json([
                    'data' => [
                        'msg' => 'Categoria atualizado com sucesso',
                    ]
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $categorys = $this->category->findOrFail($id);
            $categorys->delete();
            return response()->json([
                    'data' => [
                        'msg' => 'Categoria removido com sucesso',
                    ]
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function realState($id)
    {
        try {
            $categorys = $this->category->findOrFail($id);
            return response()->json([
                    'data' => $categorys->realStates,
            ] , 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
