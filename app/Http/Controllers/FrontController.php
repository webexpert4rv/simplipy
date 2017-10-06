<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignRequest;
use App\Product;
use App\SocialUser;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FrontController extends Controller
{
    //


    /**
     * Show the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        return view('cart');
    }

    /**
     * Show the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function product($id)
    {
        $product = Product::find($id);
        return view('product', compact('product'));
    }

    public function retailers()
    {
        return view('front.retailers');
    }

    public function influencers()
    {
        return view('front.influencers');
    }

    public function getFollowers($provider)
    {
        $social = SocialUser::where([
            'user_id' => \Auth::user()->id,
            'provider_name' => $provider
        ])->first();
        $count = 0;
        if ($social != null) {
            $count = User::getFollowerCount($provider, $social->provider_id);
        }

        return $count;
    }

    public function campaign($id, $slug)
    {
        $campaign_request = CampaignRequest::find($id);
        if ($campaign_request != null) {
            if ($campaign_request->isActive()) {
                return view('front.campaign', compact('campaign_request'));
            }
            $campaign = $campaign_request->campaign;
            if ($campaign_request->allSold()) {
                $error = "All units sold! Please click on following button to go to retailer's webpage.";
            }

            if (!$campaign_request->isValid()) {
                $error = "Campaign is over! Please click on following button to go to retailer's webpage.";
            }
            $retail_webpage = "";
            if ($campaign != null) {
                $retail_webpage = $campaign->product_retail_webpage;
            }
            return view('front.campaign', compact('error', 'retail_webpage', 'campaign_request'));
        }
        $error = "All units sold!";
        return view('front.campaign', compact('error'));
    }

}
