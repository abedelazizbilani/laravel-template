<?php

namespace App\Http\Controllers\Api;

use App\Base\BaseController;
use App\Models\Feedbacks;
class FeedbackController extends BaseController
{
    /*
     * @param : User Id ,subject ,body
     * Description: The following method is to Add a Feedback by a user
     */
    public function add()
    {
        $feedback = new Feedbacks();
        $feedback->user_id = $this->user->id;
        $feedback->subject = $this->request->subject;
        $feedback->body = $this->request->body;

        $feedback->save();

        return array($feedback);
    }

    /*
     * @param : User Id
     * Description: The following method is to Delete a Feedback and remove the images attached
     */
    public function delete()
    {
        $feedback = Feedbacks::find(request("id"));

        if ($feedback->user_id != $this->user->id) {
            return $this->failed("general.permission_denied");
        }

        $feedback->delete();

        return $this->success();
    }

}
