<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemapContent = view('frontend.sitemap')->render();
        return Response::make($sitemapContent, 200, ['Content-Type' => 'application/xml']);
    }
}
