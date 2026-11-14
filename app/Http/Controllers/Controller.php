<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

abstract class Controller
{
    /**
     * Read and validate the ?q= search term used on the list pages.
     * Returns [term, errors]. A bad term becomes '' (show everything) and the
     * page shows the error, so a typo never gives a blank error page.
     *
     * @return array{0: string, 1: MessageBag|null}
     */
    protected function searchTerm(Request $request): array
    {
        $validator = Validator::make($request->query(), [
            'q' => 'nullable|string|max:100',
        ], [
            'q.string' => 'The search must be plain text.',
            'q.max' => 'The search can be at most :max characters long.',
        ]);

        if ($validator->fails()) {
            return ['', $validator->errors()];
        }

        return [trim((string) ($validator->validated()['q'] ?? '')), null];
    }
}
