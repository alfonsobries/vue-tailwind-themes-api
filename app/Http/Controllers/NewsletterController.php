<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscribeRequest;
use App\Http\Requests\NewsletterUnsubscribeRequest;
use Spatie\Mailcoach\Models\EmailList;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterSubscribeRequest $request)
    {
        $emailList = EmailList::where(['name' => 'newsletter'])->first();

        return $emailList->subscribe($request->input('email'));
    }

    public function unsubscribe(NewsletterUnsubscribeRequest $request)
    {
        $emailList = EmailList::where(['name' => 'newsletter'])->first();

        return $emailList->unsubscribe($request->input('email'));
    }
}
