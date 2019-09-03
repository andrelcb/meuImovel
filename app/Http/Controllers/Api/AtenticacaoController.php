<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AtenticacaoController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth:api')->except(['login', 'store']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'data' =>  ['msg' => 'Usuário ou senha inválidos!']
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json('Falha interna.' . $e->getMessage(), 500);
        }

        //Pegar o usuários autenticado
        $user = auth()->user();

        return response()->json(compact('token', 'user'));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json([]);
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        return JWTAuth::refresh($token);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('É necessário informar uma senha para o usuário...');
            return response()->json($message->getMessage(), 401);
        }

        Validator::make($data, [
            'phone' => 'required',
            'mobile_phone' => 'required',
        ])->validate();

        try {
            $data['password'] = bcrypt($data['password']);

            $user = $this->user->create($data);

            $user->profile()->create([
                'phone' => $data['phone'],
                'mobile_phone' => $data['mobile_phone']
            ]);
            return response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso',
                ]
            ]);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
