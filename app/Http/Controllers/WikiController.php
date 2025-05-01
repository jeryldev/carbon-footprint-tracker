<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WikiController extends Controller
{
    /**
     * Display the wiki/knowledge base main page.
     */
    public function index()
    {
        return view('wiki.index');
    }

    /**
     * Display a specific wiki topic.
     */
    public function show($topic)
    {
        return view('wiki.show', [
            'topic' => $topic
        ]);
    }
}
