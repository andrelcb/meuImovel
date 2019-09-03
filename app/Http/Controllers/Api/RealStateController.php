<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Requests\RealStateRequest;
use App\RealState;
use App\Http\Controllers\Controller;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
       $realState = $this->realState->paginate('10');
       
        return response()->json($realState, 200);
    }

    public function show($id)
    {
        try {
            $realState = $this->realState->with('photos')->findOrFail($id);
            return response()->json([
                    'data' => $realState
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {
            $realState = $this->realState->create($data);
            if ($images) {
                $imagesUploades = [];
                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploades[] = ['photo' => $path, 'is_thumb' => false];
                }
                $realState->photos()->createMany($imagesUploades);
            }
            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }
            return response()->json([
                    'data' => [
                        'msg' => 'Imóvel cadastrado com sucesso',
                    ]
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }

    }

    public function update($id, RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if ($images) {
                $imagesUploades = [];
                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploades[] = ['photo' => $path, 'is_thumb' => false];
                }
                $realState->photos()->createMany($imagesUploades);
            }

            return response()->json([
                    'data' => [
                        'msg' => 'Imóvel atualizado com sucesso',
                    ]
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->delete();
            return response()->json([
                    'data' => [
                        'msg' => 'Imóvel removido com sucesso',
                    ]
                ]
            );
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
