<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Lib\Intended;
use App\Models\Country;
use App\Models\Service;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\DeliveryMethod;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\CountryDeliveryMethod;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        $sendingCountries   = Country::active()->sending()->with('conversionRates')->get();
        $receivingCountries = Country::receivableCountries()->get();
        return view('Template::home', compact('pageTitle', 'sections', 'seoContents', 'seoImage', 'sendingCountries', 'receivingCountries'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::contact', compact('pageTitle', 'user', 'sections', 'seoContents', 'seoImage'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;
        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];
        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $count = Page::where('tempname', activeTemplate())->where('slug', 'blog')->count();
        $pageTitle = 'Blog';
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'blog')->first();
        $seoContents = $sections->seoContent;
        $seoImage = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        $blogs     = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate(9));
        return view('Template::blog', compact('pageTitle', 'sections', 'blogs', 'seoContents', 'seoImage'));
    }

    public function blogDetails($slug)
    {
        $blog = Frontend::where('tempname', activeTemplateName())->where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = 'Blog Details';
        $seoContents = $blog->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        $recentBlogs = Frontend::where('tempname', activeTemplateName())->where('data_keys', 'blog.element')->where('slug','!=', $slug)->take(8)->latest()->get();
        return view('Template::blog_details', compact('blog', 'pageTitle', 'seoContents', 'seoImage', 'recentBlogs'));
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }

    public function getServices(Request $request)
    {
        $services = [];
        if ($request->country_id && $request->delivery_method_id) {
            $countryDeliveryMethod = CountryDeliveryMethod::where('country_id', $request->country_id)->where('delivery_method_id', $request->delivery_method_id)->first();

            if ($countryDeliveryMethod) {
                $services = Service::where('country_delivery_method_id', $countryDeliveryMethod->id)->orderBy('name')->get();
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'services' => $services
            ]
        ]);
    }

    public function serviceForm(Request $request)
    {
        $service = Service::with('form')->find($request->service_id);
        if ($service) {
            $formData = $service->form->form_data;
            $class = 'mt-0';
            $html = view('components.viser-form', compact('formData', 'class'))->render();
            return response()->json([
                'html'    => $html,
                'success' => true
            ]);
        }
        return null;
    }

    public function currencyCalculator(Request $request)
    {
        if(!auth()->user()){
            Intended::identifyRoute();
            return to_route('user.login')->withInput();
        }

        $request->validate([
            'sending_amount'    => 'required|numeric|gt:0',
            'recipient_amount'  => 'required|numeric|gt:0',
            'sending_country'   => 'required|integer',
            'recipient_country' => 'required|integer',
            'delivery_method'   => 'nullable|integer',
        ]);

        Country::active()->sending()->findOrFail($request->sending_country);
        Country::active()->receiving()->findOrFail($request->recipient_country);
        if ($request->delivery_method) {
            DeliveryMethod::active()->findOrFail($request->delivery_method);
        }

        $send_money = [
            'sending_amount'    => $request->sending_amount,
            'recipient_amount'  => $request->recipient_amount,
            'sending_country'   => $request->sending_country,
            'recipient_country' => $request->recipient_country,
            'delivery_method'   => $request->delivery_method
        ];

        session()->put('send_money', $send_money);
        return to_route('user.send.money.now');
    }
}
