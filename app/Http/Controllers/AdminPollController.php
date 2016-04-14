<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Http\Requests;
use App\Models\Poll;
use App\Repositories\PollRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminPollController extends Controller
{

    /**
     * @var PollRepositoryInterface
     */
    private $pollRepo;

    /**
     * AdminPollController constructor.
     *
     * @param PollRepositoryInterface $pollRepo
     */
    public function __construct(PollRepositoryInterface $pollRepo)
    {
        $this->pollRepo = $pollRepo;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $polls = $this->pollRepo->getAll();

        return view('admin.polls.list', [
            'polls' => $polls
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function view($id)
    {
        $poll = $this->pollRepo->findOrFail($id);

        return view('admin.polls.view', ['poll' => $poll]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        $poll = new Poll();

        return view('admin.polls.form', ['poll' => $poll]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws InvalidArgumentException
     */
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

    /**
     * @param $id
     *
     * @return Response
     */
    public function update($id)
    {
        $poll = $this->pollRepo->findOrFail($id);

        if ($poll->userAnswers->count() > 0) {
            session()->flash('warning', 'This poll contains user answers and cannot be edited!');
            return redirect()->back();
        }

        return view('admin.polls.form', ['poll' => $poll]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return Response
     */
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

    /**
     * @param $id
     *
     * @return Response
     */
    public function archive($id)
    {
        $poll = $this->pollRepo->findOrFail($id);
        $this->pollRepo->archive($poll);

        return redirect()->route('admin.poll.list');
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function delete($id)
    {
        $poll = $this->pollRepo->findOrFail($id);
        $this->pollRepo->delete($poll);

        return redirect()->route('admin.poll.list');
    }
}
