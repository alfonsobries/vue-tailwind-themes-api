<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use Spatie\Mailcoach\Models\EmailList;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterRequest $request)
    {
        $emailList = EmailList::firstOrCreate([
            'name' => 'Newsletter',
            'requires_confirmation' => true,
        ]);

        $emailList->subscribe($request->input('email'));
    }
}
