<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use Auth;
use App\Models\Notification;

class CommentController extends Controller
{
    public function store(Request $request){
        $data = $request->validate([
            'comment' => 'required',
            'user_id' => 'string',
            'company_id' => 'string',
        ]);

        // Process the form data
        $comment = new Comment();
        $comment->company_id = $data['company_id'];
        $comment->user_id = $data['user_id'];
        $comment->comment = $data['comment'];
        $comment->save();
        $comments = Comment::where('company_id', $request->company_id)->get();
        $commentListHTML = '';
        foreach ($comments as $comment) {
            $user = User::find($comment->user_id);
            $comment->user_name = $user->name;
            $commentListHTML .= "<div class='comment-main-div'><div class='comment-name-date'><div class='user-name'>{$comment->user_name}</div><h6>{$comment->created_at->format('M d, Y')}</h6></div><h5>{$comment->comment}</h5></div>";
        }

        if($comment){
            return response()->json(['success'=>'true','msg' => 'Comment Added Successfully','data'=>$commentListHTML]);
        }else{
            return response()->json(['success'=>'false','msg' => 'Something Went Wrong','data'=>$commentListHTML]);
        }
        return response()->json(['success'=>'false','msg' => 'Something Went Wrong','data'=>$commentListHTML]);

    }

    public function fetchComments($companyId)
    {
        $comments = Comment::where('company_id', $companyId)->get();
        foreach ($comments as $comment) {
            $user = User::find($comment->user_id);
            $comment->user_name = $user->name;
        }

        return response()->json(['comments' => $comments]);
    }
}
