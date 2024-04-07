<?php

namespace App\Http\Controllers\Business\SupportCenter;

use App\Http\Controllers\Controller;
use App\Models\BusinessFaq;
use App\Models\BusinessFaqCategory;
use App\Models\DocumentFiles;
use App\Models\DocumentFolder;
use App\Models\VideoTutorial;

class SupportOptionController extends Controller
{
    public function tutorials()
    {
        $videos = VideoTutorial::all();
        return view('business.support-center.tutorial.index', compact('videos'));
    }

    public function faq()
    {
        $faqCategories = BusinessFaqCategory::all();
        return view('business.support-center.faq.index', compact('faqCategories'));
    }

    public function document()
    {
        $folders = DocumentFolder::orderBy('order_number', 'asc')->get();
        return view('business.support-center.document.index', compact('folders'));
    }

    public function files(DocumentFolder $documentFolder)
    {
        $files = $documentFolder->files;
        return view('business.support-center.document.file.index', compact('files'));
    }
}
