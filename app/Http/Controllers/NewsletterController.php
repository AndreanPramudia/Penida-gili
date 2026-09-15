<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeNewsletterRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(SubscribeNewsletterRequest $request): RedirectResponse
    {
        NewsletterSubscriber::query()->firstOrCreate(
            ['email' => strtolower($request->string('email')->value())],
            ['source' => $request->string('source', 'footer')->value()],
        );

        return back()->with('newsletter', 'Thanks! You are on the list.')->withFragment('newsletter');
    }
}
