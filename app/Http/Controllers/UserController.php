<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Vinícius Sarmento
 * @link https://github.com/ViniciusSCS
 * @date 2024-08-23 21:48:54
 * @copyright UniEVANGÉLICA
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::select('id', 'name', 'email')->paginate('5');

        return [
            'status' => 200,
            'menssagem' => 'Usuários encontrados!!',
            'user' => $user
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return [
            'status' => 200,
            'menssagem' => 'Usuário cadastrado com sucesso!!',
            'user' => $user
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|max:255',
            'password'=> 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'Usuário não localizado.'
            ], 404);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')){
            $user->password = bcrypt($request->input('password'));
        }
       $user->save();

       return response()->json([
        'status' => 200,
        'message'=> 'Usuário foi atualizado.',
        'user' => $user
       ]);
    }

        
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Usuário não encontrado.'
            ], 404);
        }
    
        $user->delete();
    
        return response()->json([
            'status' => 200,
            'message' => 'Usuário foi deletado com sucesso.'
        ], 200);
    }
}