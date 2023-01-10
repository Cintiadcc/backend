<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'                    => 'required',
            'tanggal_pelaksanaan'     => 'required',
            'jam_mulai'               => 'required',
            'jam_berakhir'            => 'required',
            'contact_person'          => 'required',
            'rating'                  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Post::create([
            'nama'                  => $request->nama,
            'tanggal_pelaksanaan'   => $request->tanggal_pelaksanaan,
            'jam_mulai'             => $request->jam_mulai,
            'jam_berakhir'          => $request->jam_berakhir,
            'contact_person'        => $request->contact_person,
            'rating'                => $request->rating,
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
        
    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Post $post)
    {
        //return single post as a resource
        return new PostResource(true, 'Data Post Ditemukan!', $post);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Post $post)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'                    => 'required',
            'tanggal_pelaksanaan'     => 'required',
            'jam_mulai'               => 'required',
            'jam_berakhir'            => 'required',
            'contact_person'          => 'required',
            'rating'                  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

            //update post 
            $post->update([
            'nama'                  => $request->nama,
            'tanggal_pelaksanaan'   => $request->tanggal_pelaksanaan,
            'jam_mulai'             => $request->jam_mulai,
            'jam_berakhir'          => $request->jam_berakhir,
            'contact_person'        => $request->contact_person,
            'rating'                => $request->rating,
            ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }

 /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy(Post $post)
    {

        //delete post
        $post->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }

}