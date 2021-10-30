<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\UserRequest as Request;
use Illuminate\Http\Request as HttpRequest;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HttpRequest $request)
    {
        return response()->json([
            'data' => $this->userService->fetchAll($request)
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->only(array_keys($request->rules()));
        return response()->json([
            'data' => $this->userService->save($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'data' => $this->userService->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(array_keys($request->rules()));
        $data['password'] = bcrypt($data['password']);
        $data['id'] = $id;

        $this->userService->save($data);
        return response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->delete($id);
        return response()->json([], 204);
    }
}
