<?php
/**
 * Created by PhpStorm.
 * Date: 5/16/2017
 * Time: 3:36 PM
 */

namespace App\Http\Controllers\Back;


use App\Base\BaseController;
use App\Models\Feedbacks;
use App\Traits\Indexable;
use App\Repositories\FeedBacksRepository;
class FeedbackController extends BaseController
{

    use Indexable;

    /**
     * Create a new FeedBackController instance.
     *
     * @param  \App\Repositories\FeedBacksRepository $repository
     */
    public function __construct(FeedBacksRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'feedbacks';
    }

    public function feedbackById()
    {
        $feed = Feedbacks::byId(request('id'))->first();
        if ( ! $feed) {
            return $this->failed('idea::general.record_does_not_exist');
        }

        return $this->successData($feed);
    }

    /*
     * @param : User Id
     * Description: The following method returns all feedback for a user By User Id
     */
    public function feedbackByUserId()
    {
        $feed = Feedbacks::byUserId(request('user_id'))->get();
        if ( ! $feed->count()) {
            return $this->failed('idea::general.record_does_not_exist');
        }

        return $this->successData($feed);
    }

    public function markAsRead()
    {
        $feedbackId = request('feedback_id');

        Feedbacks::byTarget($feedbackId)
            ->update(['read' => 1]);

        return $this->success();
    }

    /**
     * @param Feedbacks $feedback
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Feedbacks $feedback)
    {
        $feedback->delete();
        return response()->json();
    }
}