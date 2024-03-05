<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Response;
use App\Models\Comments;

class commentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comments::with('product','user')->get();
        return response()->json(['message' => $comments], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $comments = $request->validated();
        $addComment = Comments::create($comments);
        if ($addComment) {
            return response()->json(['message'=> "Comment added successfully", 'comment_id' => $addComment->id], Response::HTTP_CREATED);
        } else {
            return response()->json(['error'=> "Error adding comments"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comments::with('user','product')->find($id);
        if ($comment) {
            return response()->json(['message'=>$comment], Response::HTTP_OK);
        }else{
            return response()->json(['error'=> "comment not found"], Response::HTTP_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, int $id)
    {
        $comment = $request->validated();
        $update = Comments::find($id);
        if (!$update) {
            return response()->json(['error'=> "comments not found"], Response::HTTP_NOT_FOUND);
        }

        if ($comment['user_id'] !== auth()->user()->id) {
        return response()->json(['error'=> "Unauthorized to update this comment"], Response::HTTP_FORBIDDEN);
        }

        $update->update(['comment' => $comment['comment']]);

        if ($update->wasChanged()) {
            return response()->json(['message'=> "Comment updated successfully", 'comment'=> $comment['comment']], Response::HTTP_OK);
        } else {
            return response()->json(['message'=> "No changes were made to the comment"], Response::HTTP_OK);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comments::find($id);
        if (!$comment) {
            return response()->json(['error'=> "comment not found"], Response::HTTP_NOT_FOUND);
        }
        if($comment->user_id === auth()->user()->id){
            if ($comment->delete()) {
                return response()->json(['message'=> "comment deleted"], Response::HTTP_OK);
            } else {
                return response()->json(['error'=> "Error deleting comment"], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }else{
            return response()->json(['error'=> "Na wa for you oo"], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }
}
