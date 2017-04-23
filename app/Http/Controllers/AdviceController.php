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
use Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index($page = "questions")
    {
        if ($page == "questions") {
            $questions = Question::orderBy('updated_at', 'desc')->with('answers','images')->get();
            return view('advice.index', compact('page', 'questions'));
        } else {
            $articles = Article::orderBy('updated_at', 'desc')->with('comments','images')->get();

            return view('advice.index', compact('page', 'articles'));
        }
    }


    public function create_question(Request $request)
    {

        $question_exists = Question::where([
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title')])->exists();


        if ($question_exists) {
            return response()->json([
                'success' => false,
                'msg' => 'You already have a question called ' . $request->input('title')
            ]);
        }

        $new_question = Question::create(request()->except('_token'));

        if ($new_question) {
            $request->request->add(['question_id' => $new_question->id]);
            $picture_status = $this->add_pictures($request, 'question');

            if ($picture_status)
                return response()->json([
                    'success' => true,
                    'question' => $new_question
                ]);
            return response()->json([
                'success' => false,
                'article' => $new_question
            ]);
        } else
            return response()->json([
                'success' => false,
                'msg' => 'Failed to save question'
            ]);
    }

    public function create_article(Request $request)
    {

        $article_exists = Article::where([
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title')])->exists();

        if ($article_exists) {
            return response()->json([
                'success' => false,
                'msg' => 'You already have an article called ' . $request->input('title')
            ]);
        }
        if(!$request->hasFile("image_url"))

            return response()->json([
                "success" => false,
                "msg" => "Please choose at least one image"
            ]);

        $new_article = false;
        if (Auth::user()->role != 'user') {
            $new_article = Article::create(request()->except('_token', 'img_url'));

        }


        if ($new_article) {

            $request->request->add(['article_id' => $new_article->id]);
            $picture_status = $this->add_pictures($request, 'article');

            if ($picture_status)
                return response()->json([
                    'success' => true,
                    'article' => $new_article
                ]);
            return response()->json([
                'success' => false,
                'article' => $new_article
            ]);
        } else
            return response()->json([
                'success' => false,
                'msg' => 'Failed to save article'
            ]);
    }

    public function add_pictures(Request $request, $where = null)
    {

        $image = $request->file("image_url");
        if ($where == "article") {
            $advice_id = $request->input("article_id");
            $real_path = 'advice/article/';
        } else {
            $advice_id = $request->input("question_id");
            $real_path = 'advice/question/';
        }
        if (count($image) < 1) {
            return response()->json([
                "success" => false,
                "msg" => "Please choose at least one image"
            ]);
        }

        $destinationPath = public_path('images/uploads/' . $real_path);

        $img = Image::make($image->getRealPath());
        if (!File::exists($destinationPath)) File::makeDirectory($destinationPath, 0777, true);
        $new_image_name = $advice_id . '-' . time() . '.' . $image->getClientOriginalExtension();

        $img->save($destinationPath . $new_image_name);

        if ($img->width() > 600) {
            $thumb_path = $destinationPath . 'thumbs/';
            if (!File::exists($thumb_path)) File::makeDirectory($thumb_path, 0777, true);
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb_path . $new_image_name,20);
        } else {
            $img->save($destinationPath . 'thumbs/' . $new_image_name,20);
        }


        $house_image = [
            'url' => $new_image_name,
            'placeholder_color' => $img->limitColors(1)->pickColor(0, 0, 'hex'),
            'caption' => "",
            'width' => $img->width(),
            'height' => $img->height()
        ];

        if ($where == "article") {
            $imageable = Article::find($advice_id);
        } else if ($where == "question") {
            $imageable = Question::find($advice_id);
        }

        $new_image = $imageable->images()->create($house_image);

        if (!$new_image) {
            return false;

        }

        return true;
    }

    public function submit_answer(Request $request)
    {
        if (Auth::guest())
            return response()->json(["success" => false]);

        $answer = [
            "user_id" => $request->input('user_id'),
            "question_id" => $request->input('question_id'),
            "content" => $request->input('content')
        ];

        $new_answer = Answer::create($answer);

        if ($new_answer) {
            if (Auth::user()->id != $new_answer->question->user_id)
                User::find($new_answer->question->user_id)->notify(new AnswerReceived($new_answer, $new_answer->user));

            return response()->json([
                "success" => true,
                "answer" => $new_answer,
                "msg" => "Answer successfully sent."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "msg" => "Coulnd't save answer."
            ]);
        }
    }

    public function submit_comment(Request $request)
    {
        if (Auth::guest())
            return response()->json(["success" => false]);

        $answer = [
            "user_id" => $request->input('user_id'),
            "article_id" => $request->input('article_id'),
            "content" => $request->input('content')
        ];

        $new_answer = ArticleComment::create($answer);

        if ($new_answer) {
            if (Auth::user()->id != $new_answer->article->user_id)
                User::find($new_answer->article->user_id)->notify(new ArticleCommentReceived($new_answer, $new_answer->user));

            return response()->json([
                "success" => true,
                "answer" => $new_answer,
                "msg" => "Comment successfully sent."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "msg" => "Coulnd't save comment."
            ]);
        }
    }

    public function remove_comment(Request $request)
    {
        if (Auth::guest())
            return response()->json(["success" => false]);

        $comment = ArticleComment::find($request->input('id'))->where('user_id', Auth::user()->id);


        if ($comment->delete()) {
            return response()->json([
                "success" => true,
                "msg" => "Comment successfully deleted."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "msg" => "Coulnd't delete comment."
            ]);
        }
    }

    public function remove_answer(Request $request)
    {
        if (Auth::guest())
            return response()->json(["success" => false])->where('user_id', Auth::user()->id);

        $comment = Answer::find($request->input('id'));

        if ($comment->delete()) {
            return response()->json([
                "success" => true,
                "msg" => "Answer successfully deleted."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "msg" => "Coulnd't delete answer."
            ]);
        }
    }
}
