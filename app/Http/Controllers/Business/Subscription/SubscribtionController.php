<?php

namespace App\Http\Controllers\Business\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Resources\Business\BusinessPackageResource;
use App\Models\BussinessPackage;
use App\Models\PacketOrder;
use App\Services\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Üyelik
 *
 */
class SubscribtionController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    /**
     * Abonelik Özeti
     * @return JsonResponse
     *
     */
    public function index()
    {
        //$business = $this->business;
        $terms = "<h2>Hello,</h2><p>When you’re done bundling, you should decide on the order of the topics your article. In most cases, you can decide to order thematically. For instance, if you want to discuss various aspects or angles of the main topic of your blog post. But you can also order your text chronologically or didactically.</p><p><br></p><blockquote>Buraya alıntı alanı gelecek</blockquote><p><br></p><p><br></p><p>In the above example we’re discussing, ordering topics thematically makes the most sense.</p><p>Than you,</p><p>Jerry</p>";
        $remainingDay = now()->diffInDays($this->business->packet_end_date);
        $package = $this->business->package;

        $monthlyPackages = BussinessPackage::where('type', 0)
            ->when(isset($package), function ($q){
                $q->where('price', '>', 0);
            })
            ->orderBy('price', 'asc')->get();

        $yearlyPackages = BussinessPackage::where('type', 1)
            ->when(isset($package), function ($q){
                $q->where('price', '>', 0);
            })
            ->orderBy('price', 'asc')->get();
        return view('business.subscription.index', compact('terms', 'remainingDay', 'package', 'monthlyPackages', 'yearlyPackages'));

    }
}
