<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\FileAdder\FileAdder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request)
    {
        DB::beginTransaction();;
        $data = $request->all();
        $this->validate($request, [
            'title' => 'required|string',
            'short_description' => 'required|string|min:5',
            'description' => 'required|string|min:5',
            'files' => 'nullable|array'
        ]);
        $data['user_id'] = $request->user('api')->id;
        $post = Post::create($data);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (in_array($file->getClientOriginalExtension(), ['mp4', 'mov', 'webm'])) {
                    $post->addMedia($file)->toMediaCollection('videos');
                } else {
                    $post->addMedia($file)->toMediaCollection('images');
                }
            }
        }
        DB::commit();
        return response()->json(['data' => $post]);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
