<?php

namespace App\Http\Controllers;
use App\Answer;
use App\ArticleComment;
use App\Notifications\AnswerReceived;
use App\Notifications\ArticleCommentReceived;
use App\Question;
use App\Article;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index($page = "questions")
    {
    	if($page == "questions"){
    		$questions = Question::with('answers')->get();
    		return view('advice.index', compact('page', 'questions'));
    	}else{
    		$articles = Article::with('comments')->get();
    		return view('advice.index', compact('page', 'articles'));
    	}
    }

	public function submit_answer(Request $request){
		if(Auth::guest())
			return response()->json(["success" => false]);

		$answer = [
			"user_id" => $request->input('user_id'),
			"question_id" => $request->input('question_id'),
			"content" => $request->input('content')
		];

		$new_answer = Answer::create($answer);

		if($new_answer){
			if(Auth::user()->id != $new_answer->question->user_id)
				User::find($new_answer->question->user_id)->notify(new AnswerReceived($new_answer, $new_answer->user));

			return response()->json([
				"success" => true,
				"answer" => $new_answer,
				"msg" => "Answer successfully sent."
			]);
		}else{
			return response()->json([
				"success" => false,
				"msg" => "Coulnd't save answer."
			]);
		}
	}

	public function submit_comment(Request $request){
		if(Auth::guest())
			return response()->json(["success" => false]);

		$answer = [
				"user_id" => $request->input('user_id'),
				"article_id" => $request->input('article_id'),
				"content" => $request->input('content')
		];

		$new_answer = ArticleComment::create($answer);

		if($new_answer){
			if(Auth::user()->id != $new_answer->article->user_id)
				User::find($new_answer->article->user_id)->notify(new ArticleCommentReceived($new_answer, $new_answer->user));

			return response()->json([
					"success" => true,
					"answer" => $new_answer,
					"msg" => "Comment successfully sent."
			]);
		}else{
			return response()->json([
					"success" => false,
					"msg" => "Coulnd't save comment."
			]);
		}
	}

	public function remove_comment(Request $request){
		if(Auth::guest())
			return response()->json(["success" => false]);

		 $comment = ArticleComment::find($request->input('id'))->where('user_id',Auth::user()->id);


		if($comment->delete()){
			return response()->json([
					"success" => true,
					"msg" => "Comment successfully deleted."
			]);
		}else{
			return response()->json([
					"success" => false,
					"msg" => "Coulnd't delete comment."
			]);
		}
	}

	public function remove_answer(Request $request){
		if(Auth::guest())
			return response()->json(["success" => false])->where('user_id',Auth::user()->id);

		$comment = Answer::find($request->input('id'));

		if($comment->delete()){
			return response()->json([
					"success" => true,
					"msg" => "Answer successfully deleted."
			]);
		}else{
			return response()->json([
					"success" => false,
					"msg" => "Coulnd't delete answer."
			]);
		}
	}
}
