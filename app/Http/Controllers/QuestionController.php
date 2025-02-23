<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Question;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        // Count questions by status
        $pending_count = Question::where('status', 'pending')->count();
        $validated_count = Question::where('status', 'validated')->count();
        $processed_count = Question::where('status', 'processed')->count();
        $rejected_count = Question::where('status', 'rejected')->count();

        // Retrieve questions by status with relations
        $pending_questions = Question::where('status', 'pending')->with(['communication', 'speaker'])->get();
        $validated_questions = Question::where('status', 'validated')->with(['communication', 'speaker'])->get();
        $processed_questions = Question::where('status', 'processed')->with(['communication', 'speaker'])->get();
        $rejected_questions = Question::where('status', 'rejected')->with(['communication', 'speaker'])->get();

        return view('questions.index', compact(
            'pending_count',
            'validated_count',
            'processed_count',
            'rejected_count',
            'pending_questions',
            'validated_questions',
            'processed_questions',
            'rejected_questions'
        ));
    }

    public function create(Request $request)
    {
        $communications = Communication::all();
        $speakers = Speaker::all();

        return view('questions.create', compact('communications', 'speakers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'communication_id' => 'required|exists:communications,id',
            'speaker_id' => 'nullable|exists:speakers,id',
        ]);

        Question::create(array_merge($validated, ['status' => 'pending', 'user_id' => Auth::user()->id]));

        return redirect()->route('questions.index')->with('success', 'Your question has been submitted.');
    }

    public function validateQuestion($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return redirect()->back()->with('error', 'Question not found.');
        }

        $question->status = 'validated';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'Question validated successfully.');
    }

    public function reject($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return redirect()->back()->with('error', 'Question not found.');
        }

        $question->status = 'rejected';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'Question rejected successfully.');
    }

    public function process($id)
    {
        $question = Question::find($id);

        if (!$question || $question->status != 'validated') {
            return redirect()->back()->with('error', 'Cannot mark this question as processed.');
        }

        $question->status = 'processed';
        $question->answer = 'Answered verbally by the speaker.';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'The question has been processed and the response recorded.');
    }

    public function updateRejected(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question || $question->status != 'rejected') {
            return redirect()->back()->with('error', 'Cannot modify this question.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $question->content = $validated['content'];
        $question->status = 'validated';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'The question has been updated and validated.');
    }

    public function respond(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question || $question->status != 'validated') {
            return redirect()->back()->with('error', 'Cannot respond to this question.');
        }

        $validated = $request->validate([
            'answer' => 'required|string',
        ]);

        $question->answer = $validated['answer'];
        $question->status = 'processed';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'The question has been processed and the response recorded.');
    }
    public function update(Request $request, Question $question)
    {

        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $question->update([
            'content' => $request->content,
            'status' => 'validated',

        ]);

        return redirect()->back()->with('success', __('interface.question_updated'));
    }
}
