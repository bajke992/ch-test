<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Repositories\PollRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminPollController extends Controller
{

    /**
     * @var PollRepositoryInterface
     */
    private $pollRepo;

    public function __construct(PollRepositoryInterface $pollRepo)
    {
        $this->pollRepo = $pollRepo;
    }

    public function index()
    {
        $polls = $this->pollRepo->getAll();

        return view('admin.polls.list', [
            'polls' => $polls
        ]);
    }

    public function view($id)
    {
        $poll = $this->pollRepo->findOrFail($id);

        return view('admin.polls.view', ['poll' => $poll]);
    }

    public function create()
    {
        $poll = new Poll();

        return view('admin.polls.form', ['poll' => $poll]);
    }

    public function createPost(Request $request)
    {
        $input = $request->only([
            'title',
            'visibility',
            'status'
        ]);

        $poll = Poll::make(
            $input['title'],
            $input['visibility'],
            $input['status']
        );

        $this->pollRepo->save($poll);

        return redirect()->route('admin.poll.list');
    }

    public function update($id)
    {
        $poll = $this->pollRepo->findOrFail($id);

        return view('admin.polls.form', ['poll' => $poll]);
    }

    public function updatePost(Request $request, $id)
    {
        $input = $request->only([
            'title',
            'visibility',
            'status'
        ]);

        $poll = $this->pollRepo->findOrFail($id);

        $poll->setTitle($input['title']);
        $poll->setVisibility($input['visibility']);
        $poll->setStatus($input['status']);

        $this->pollRepo->save($poll);

        return redirect()->route('admin.poll.list');
    }

    public function archive($id)
    {
        $poll = $this->pollRepo->findOrFail($id);
        $this->pollRepo->archive($poll);

        return redirect()->route('admin.poll.list');
    }

    public function delete($id)
    {
        $poll = $this->pollRepo->findOrFail($id);
        $this->pollRepo->delete($poll);

        return redirect()->route('admin.poll.list');
    }
}
