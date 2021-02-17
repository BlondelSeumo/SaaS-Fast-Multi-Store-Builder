<?php

namespace App\Http\Controllers\Dashboard;

use Linker, QrCode, Cart;
use App\User;
use App\Model\Products;
use App\Model\Product_Orders;
use App\Model\Settings;
use App\Model\Faq;
use App\Model\TrackLinks;
use App\Model\Payments;
use App\Model\Track;
use App\Model\Blog;
use Validator,Redirect,Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Mail\SendMailable;
use GladePay\GladePay;
use Carbon\Carbon;
use Herbert\EnvatoClient;
use App\Model\Domains;
use Herbert\Envato\Auth\Token as EnvatoToken;

class DashboardController extends Controller{

    function __construct(){
      if (settings('email_activation')) {
        $this->middleware('activeEmail');
      }
      $general = new \General();
      $general->cron($type = 'soft');

    }

    public function dashboard(){
        $user = Auth::user();
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $thisMonth = Carbon::now()->startOfMonth()->toDateString();
        $thisYear = Carbon::now()->startOfYear()->toDateString();

        # Sales chart
        $sales_chart = [];
        $sales_chart_fetch = Product_Orders::select(\DB::raw("*, DATE_FORMAT(`created_at`, '%Y-%m-%d') AS `formatted_date`"))->where('storeuser', $user->id)->where('created_at', '>=', $thisMonth)->get();

        foreach ($sales_chart_fetch as $key) {
         foreach ($key->products as $prices => $price) {
           $key->formatted_date = Carbon::parse($key->formatted_date)->toFormattedDateString();
           if(!array_key_exists($key->formatted_date, $sales_chart)) {
               $sales_chart[$key->formatted_date] = [
                   'sales'        => 0,
               ];
           }
           $prices = $price['price'];
           $sales_chart[$key->formatted_date]['sales'] += ($price['qty'] * $prices);
         }
        }
        asort($sales_chart);
        $sales_chart = get_chart_data($sales_chart);

        # Top products
        $orders = Product_Orders::where('storeuser', $user->id)->get();
        $topproducts = [];
        foreach ($orders as $order) {
           foreach ($order->products as $key => $value) {
            $product = Products::where('id', $key)->first();
            if (!array_key_exists($key, $topproducts)) {
               $topproducts[$key] = [
                'sold'  => 0,
                'earned' => 0,
                'name'  => '',
                'price'  => '',
                'media'  => '',
               ];
            }
            $price = $value['price'];

            /**
            *
            * Use Product price
            * $price = !empty($product->salePrice) ? $product->salePrice : $product->price;
            *
            **/

            $topproducts[$key]['sold'] += $value['qty'];
            $topproducts[$key]['name'] = $product->title ?? $value['name'] ?? '';
            $topproducts[$key]['price'] = $price;
            $topproducts[$key]['media'] = $product->media ?? '';
            $topproducts[$key]['earned'] += ($value['qty'] * $price);
           }
        }
        $topproducts = array_slice($topproducts, 0, 5);
        # Sales chart
        $sales = ['total' => 0, 'last_month' => 0, 'this_month' => 0, 'last_month_percent' => 0, 'total_orders' => 0, 'recent_orders' => Product_Orders::where('storeuser', $user->id)->orderBy('id', 'DESC')->limit(5)->get()];
        $last_month = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        # Total sales
        $orders = Product_Orders::where('storeuser', $user->id)->get();
        foreach ($orders as $order) {
           foreach ($order->products as $key => $value) {
            $price = $value['price'];
            /**
            *
            * Use Product price
            * $price = !empty($product->salePrice) ? $product->salePrice : $product->price;
            *
            **/
             $sales['total']  += ($value['qty'] * $price);
             $sales['total_orders'] += ($value['qty']);
           }
        }

        # last month sales
        $orders = Product_Orders::where('storeuser', $user->id)->where('created_at', '>=', $last_month)->where('created_at', '<=', $thisMonth)->get();
        foreach ($orders as $order) {
           foreach ($order->products as $key => $value) {
            $price = $value['price'];
             $sales['last_month']  += ($value['qty'] * $price);
           }
        }

        # This month sales
        $orders = Product_Orders::where('storeuser', $user->id)->where('created_at', '>=', $thisMonth)->get();
        foreach ($orders as $order) {
           foreach ($order->products as $key => $value) {
            $price = $value['price'];
             $sales['this_month']  += ($value['qty'] * $price);
           }
        }

        # Last month percentage
        try {
            $sales['last_month_percent'] = $this->calculatePercent($sales['last_month'], $sales['this_month']);
        } catch (\Exception $e) {
            $sales['last_month_percent'] = 0;
        }

        # Store Visits

        $visit_chart = Track::select(\DB::raw("`country`,`count`, YEAR(`date`) AS `year`"))->where('user', Auth()->user()->id)->get();

        $month_visits_all = Track::select(\DB::raw("*, MONTH(`date`) AS `month`, DATE_FORMAT(`date`, '%Y-%m-%d') AS `formatted_date`"))->where('user', $user->id)->where('date', '>=', $thisMonth)->get();
        $year = [];
        $month = [];
        $this_month_chart = [];
        foreach ($month_visits_all as $key) {
         if(!array_key_exists($key->month, $month)) {
             $month[$key->month] = [
                 'impression'        => 0,
                 'unique'            => 0,
             ];
         }
         $month[$key->month]['unique']++;
         $month[$key->month]['impression'] += $key->count;
         $key->formatted_date = Carbon::parse($key->formatted_date)->toFormattedDateString();

         if(!array_key_exists($key->formatted_date, $this_month_chart)) {
             $this_month_chart[$key->formatted_date] = [
                 'impression'        => 0,
                 'unique'            => 0,
             ];
         }
         $this_month_chart[$key->formatted_date]['unique']++;
         $this_month_chart[$key->formatted_date]['impression'] += $key->count;
        }
        foreach ($visit_chart as $key) {
         if(!array_key_exists($key->year, $year)) {
             $year[$key->year] = [
                 'impression'        => 0,
                 'unique'            => 0,
             ];
         }
         /* Distribute the data from the database key */
         $year[$key->year]['unique']++;
         $year[$key->year]['impression'] += $key->count;
        }
        $year = get_chart_data($year);
        $month = get_chart_data($month);
        $this_month_chart = get_chart_data($this_month_chart);
        $month = preg_replace('/[^0-9]/', '', $month);
        $year = preg_replace('/[^0-9]/', '', $year);

        # Qr Code
        QrCode::format('png')->size(500)->generate(url("$user->username"), media_path('user/qrcode/'.strtolower($user->username).'.png'));

        $options = (object) ['topproducts' => $topproducts, 'sales' => $sales, 'sales_chart' => $sales_chart, 'month' => $month, 'year' => $year, 'this_month_chart' => $this_month_chart];

        return view('dashboard.dashboard', ['options' => $options]);
    }

    private function calculatePercent($first_number, $last_number){
      if ($first_number >= $last_number) {
        $numbers = $last_number / $first_number;
        $updown = 'down';
      }
      if ($last_number >= $first_number) {
        $numbers = $first_number / $last_number;
        $updown = 'up';
      }
      $percent = (1 - $numbers) * 100;
      return ['percent' => $percent, 'updown' => $updown];
    }

    public function shipping(){

      return view('dashboard.shipping.all');
    }

    public function add_shipping(){
      $countries = countries();

      return view('dashboard.shipping.add', ['countries' => $countries]);
    }

    public function edit_shipping($slug){
        $countries = countries();
        $province = user('shipping.'.$slug);

        return view('dashboard.shipping.edit', ['countries' => $countries, 'province' => $province, 'slug' => $slug]);      
    }

    public function post_shipping(Request $request, $type){
      $user = Auth::user();
      if (!in_array($type, ['new', 'edit', 'delete'])) {
        abort(404);
      }
      $country = $request->country;
      $province = [];
      if (is_array($request->shipping)) {
        foreach ($request->shipping as $value) {
          $province[$value['province']] = ['type' => $value['type'], 'cost' => $value['cost']];
        }
      }
      if ($type == 'new') {
        $user_shipping = $user->shipping ?? [];
        $user_shipping[$country] = $province;
        $update = User::find($user->id);
        $update->shipping = $user_shipping;
        $user_shipping = json_encode($user_shipping);
        $update->save();
        return redirect()->route('user-shipping')->with(__('saved successfully'));
      }

      return ;
    }
    public function transactions_history(Payments $payments, Request $request){
        $user = Auth::user();
        $invoice_id = $request->get('invoice_id');

        if (!empty($invoice_id)) {
            if (!settings('business.enabled')) {
                abort(404);
            }
            if (!$invoice = $payments->where('id', $invoice_id)->first()) {
                abort(404);
            }

            return view('dashboard.payments.transaction-invoice', ['invoice' => $invoice]);
        }

        $allpayments = $payments->where('user', $user->id)->orderBy('id', 'DESC')->paginate(10);
        # Payments Chart
        $paymentschart = [];
        $results = $payments->select(\DB::raw("COUNT(*) as count, DATE_FORMAT(`date`, '%Y-%m-%d') AS `formatted_date`, TRUNCATE(SUM(`price`), 2) AS `amount`"))->where('user', $user->id)->groupBy('formatted_date')->get();

        foreach ($results as $value) {
            $value->formatted_date = Carbon::parse($value->formatted_date)->toFormattedDateString();
            $paymentschart[$value->formatted_date] = [
                'count' => $value->count,
                'amount' => $value->amount
            ];
        }

        $paymentschart = get_chart_data($paymentschart);
        
        return view('dashboard.payments.transactions-history', ['payments' => $allpayments, 'paymentschart' => $paymentschart]);
    }

    public function settings(){
      $user = Auth::user();
      subdomain_wildcard_creation(user('id'));
      $socials    = getOtherResourceFile('socials');
      $templates  = \Theme::all();
      $json = !empty(package('domains', user())) && is_array(json_decode(package('domains', user()), true)) ? json_decode(package('domains', user())) : [];
      $domains = [];
      $user_domains = Domains::where('user', $user->id)->where('status', 1)->get();
      foreach ($user_domains as $value) {
          $json[] = $value->id;
      }
      foreach($json as $value){
          if ($domain = Domains::where('id', $value)->where('status', 1)->first()) {
              $domains[$domain->id] = (object) ['domain' => $domain->host];
          }
      }
      if (file_exists($sc = resource_path('custom/socials.php'))) {
          $sc = require $sc;
          if (is_array($sc)) {
              foreach ($sc as $key => $value) {
                  $socials[$key] = $value;
              }
          }
      }

      return view('dashboard.settings', ['socials' => $socials, 'domains' => $domains, 'templates' => $templates]);
    }

    public function blog(Request $request){
        $user = Auth::user();
        if (!package('settings.blogs')) {
            return redirect()->route('user-dashboard')->with('info', __('You cant access that page'));
        }
        if ($request->get('remove-image') == true) {
            $blog = Blog::find($request->get('id'));
            if (!empty($blog->image)) {
                if(file_exists(public_path('media/user/blog/' . $blog->image))){
                    unlink(public_path('media/user/blog/' . $blog->image)); 
                }
            }

            return redirect()->route('user-blog')->with('success', __('Image removed successfully'));
        }
        $blogs = Blog::leftJoin('track', 'track.dyid', '=', 'blog.id')
            ->select('blog.*', DB::raw("count(track.dyid) AS track_portfolio"))
            ->groupBy('blog.id')->where('blog.user', $user->id)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        return view('dashboard.blog.blog', ['blogs' => $blogs]);
    }

    public function blog_delete($id){
        if (!Blog::where('id', $id)->exists()) {
            abort(404);
        }
        $blog = Blog::find($id);
        if (!empty($blog->image)) {
            if(file_exists(public_path('media/user/blog/' . $blog->image))){
                unlink(public_path('media/user/blog/' . $blog->image)); 
            }
        }
        $blog->delete();
        Track::where('dyid', $id)->delete();
        return redirect()->route('user-blog')->with('success', __('That blog was successfully removed'));
    }

    public function blog_sortable(Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['order'] = (int) $key['order'];
        $link = Blog::find($key['id']);
        $link->order = $key['order'];
        $link->save();
     }
    }

    public function post_blog(Request $request){
        $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);
        if (!empty($request->image)) {
          $request->validate([
              'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
          ]);
        }
        // Define request
        $name = $request->name;
        $note = $request->note;
        $slug = slugify($request->name);
        $user = Auth::user();
        $settings = ['media_url' => $request->media_url];
        $blogs = Blog::where('user', $user->id)->get();
        if (!isset($request->blog_id)) {
            if(package('settings.blogs_limits') != -1 && count($blogs) >= package('settings.blogs_limits')) {
                return back()->with('error', __("You've reached your package limit."));
            }
            $insert = new Blog;
            $insert->user = $user->id;
            $insert->name = $name;
            $insert->note = $note;
            $insert->slug = $slug;
            $insert->extra = $settings;
            $insert->save();
            if (!empty($request->image)) {
                $imageName = md5(microtime());
                $imageName = $imageName . '.' .$request->image->extension();
                $request->image->move(public_path('media/user/blog'), $imageName);
                $values = array('image' => $imageName);
                Blog::where('id', $insert->id)->update($values);
            }
          return redirect()->route('user-blog')->with('success', __('Blog posted'));
        }else{
            $blog = Blog::find($request->blog_id);
            if (!empty($request->image)) {
                $imageName = md5(microtime());
                $imageName = $imageName . '.' .$request->image->extension();
                if (!empty($blog->image)) {
                    if(file_exists(public_path('media/user/blog/' . $blog->image))){
                        unlink(public_path('media/user/blog/' . $blog->image)); 
                    }
                }
                $request->image->move(public_path('media/user/blog'), $imageName);
                $blog->image = $imageName;
           }
           $blog->name = $name;
           $blog->note = $note;
           $blog->extra = $settings;
           $blog->slug = $slug;
           $blog->save();
          return redirect()->route('user-blog')->with('success', __('Blog updated'));
        }
    }

    public function user_stats(Request $request, TrackLinks $track_links, Linker $linker){
        $user = Auth::user();
        $type = $request->get('type');
        $url = $request->get('url');
        $link = $request->get('link');
        $url_slug = $request->get('url_slug');
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $thisMonth = Carbon::now()->startOfMonth()->toDateString();
        if (!package('settings.statistics', $user)) {
            return redirect()->route('user-dashboard')->with('info', 'You cant access that page');
        }
        if ($type == 'links') {
            if (!empty($link)) {
                if (!$track_links->where('slug', $link)->exists()) {
                    abort(404);
                }
                $linksLogs = $track_links->select(\DB::raw("*, DATE_FORMAT(`created_at`, '%Y-%m-%d') AS `formatted_date`"))
                ->where('user', $user->id)
                ->where('slug', $link)
                ->get();

                $linksLogsFD = $track_links->select(\DB::raw("*, DATE_FORMAT(`created_at`, '%Y-%m-%d') AS `formatted_date`"))
                ->where('user', $user->id)
                ->where('created_at', '>=', $thisMonth)
                ->where('slug', $link)
                ->get();
                $data = ['os' => [], 'browser' => [], 'country' => [], 'slug' => []];
                $log = [];
                $logsFD = [];
                foreach ($linksLogsFD as $value) {
                    if(!array_key_exists($value->formatted_date, $logsFD)) {
                        $logsFD[$value->formatted_date] = [
                            'impression'        => 0,
                            'unique'            => 0,
                        ];
                    }
                    /* Distribute the data from the database key */
                    $logsFD[$value->formatted_date]['unique']++;
                    $logsFD[$value->formatted_date]['impression'] += $value->views;
                }
                foreach ($linksLogs as $value) {
                    if(!array_key_exists($value->slug, $log)) {
                        $log[$value->slug] = [
                            'impression'        => 0,
                            'unique'            => 0,
                        ];
                    }
                    /* Distribute the data from the database key */
                    $log[$value->slug]['unique']++;
                    $log[$value->slug]['impression'] += $value->views;
                    if(!array_key_exists($value->os, $data['os'])) {
                        $data['os'][$value->os ?? 'N/A'] = 1;
                    } else {
                        $data['os'][$value->os]++;
                    }

                    if(!array_key_exists($value->country, $data['country'])) {
                        $data['country'][$value->country ?? 'false'] = 1;
                    } else {
                        $data['country'][$value->country]++;
                    }

                    if(!array_key_exists($value->browser, $data['browser'])) {
                        $data['browser'][$value->browser ?? 'N/A'] = 1;
                    } else {
                        $data['browser'][$value->browser]++;
                    }

                    if(!array_key_exists($value->slug, $data['slug'])) {
                        $data['slug'][$value->slug ?? 'N/A'] = 1;
                    } else {
                        $data['slug'][$value->slug]++;
                    }
                }
                unset($data['country']['false']);
                unset($data['country']['']);
                $logsFD = get_chart_data($logsFD);
                $options = (object) ['data' => $data, 'logs' => $log, 'logsFD' => $logsFD];

                return view('dashboard.stats.singlelinks-stats', ['options' => $options]);
            }
            $linksLogs = $track_links->select(\DB::raw("*, DATE_FORMAT(`created_at`, '%Y-%m-%d') AS `formatted_date`"))->where('user', $user->id)->get();

            $getAll = $track_links
            ->leftJoin('linker', 'linker.slug', '=', 'track_links.slug')
            ->select('track_links.*', 'linker.url as link_url');
            $getAll2 = $track_links
            ->leftJoin('linker', 'linker.slug', '=', 'track_links.slug')
            ->select('track_links.*', 'linker.url as link_url')->where('track_links.user', $user->id);
            if (!empty($url)) {
              $getAll->where('linker.url','LIKE','%'.$url.'%');
            }
            if (!empty($url_slug)) {
              $getAll->where('track_links.slug','LIKE','%'.$url_slug.'%');
            }
            $getAll = $getAll->where('track_links.user', $user->id)
            ->groupBy('track_links.slug')
            ->orderBy('track_links.views', 'DESC');
            $data = ['os' => [], 'browser' => [], 'country' => [], 'slug' => []];
            $log = [];
            foreach ($linksLogs as $value) {
                if(!array_key_exists($value->slug, $log)) {
                    $log[$value->slug] = [
                        'impression'        => 0,
                        'unique'            => 0,
                    ];
                }
                /* Distribute the data from the database key */
                $log[$value->slug]['unique']++;
                $log[$value->slug]['impression'] += $value->views;
                if(!array_key_exists($value->os, $data['os'])) {
                    $data['os'][$value->os ?? 'N/A'] = 1;
                } else {
                    $data['os'][$value->os]++;
                }
                if(!array_key_exists($value->country, $data['country'])) {
                    $data['country'][$value->country ?? 'false'] = 1;
                } else {
                    $data['country'][$value->country]++;
                }
                if(!array_key_exists($value->browser, $data['browser'])) {
                    $data['browser'][$value->browser ?? 'N/A'] = 1;
                } else {
                    $data['browser'][$value->browser]++;
                }

                if(!array_key_exists($value->slug, $data['slug'])) {
                    $data['slug'][$value->slug ?? 'N/A'] = 1;
                } else {
                    $data['slug'][$value->slug]++;
                }
            }
            unset($data['country']['false']);
            unset($data['country']['']);
            $logs_chart = get_chart_data($log);
            $options = (object) ['getAll' => $getAll, 'getAll2' => $getAll2, 'data' => $data, 'logs' => $log, 'logs_chart' => $logs_chart];
            return view('dashboard.stats.links-stats', ['options' => $options]);
        }


        $visit_chart_date = Track::select(\DB::raw("DATE_FORMAT(`date`, '%Y-%m') AS `formatted_date`"))->where('user', Auth()->user()->id)->where('type', 'profile')->groupBy(\DB::raw("formatted_date"))->distinct()->get();
        $visit_chart_date_fetch = [];
        foreach ($visit_chart_date as $key => $value) {
            $visit_chart_date_fetch[] = date("F", strtotime($value->formatted_date));
        }

        $visit_chart = Track::select(\DB::raw("`country`,`os`,`browser`,`count`, DATE_FORMAT(`date`, '%Y-%m-%d') AS `formatted_date`"))->where('user', Auth()->user()->id)->where('type', 'profile')->get();

        $logs_chart = Track::select(\DB::raw("`count`, DATE_FORMAT(`date`, '%Y-%m-%d') AS `formatted_date`"))
        ->where('user', $user->id)
        ->where('type', 'profile')
        ->where('date', '>=', $thisMonth)
        ->get();

        $dataTrack = Track::where('user', Auth()->user()->id)->get()
                ->groupBy(function($val) {
                    return Carbon::parse($val->date)->format('m');
                });
        $total_visits = [];
        foreach ($dataTrack as $value) {
            $total_visits[] = count($value);
        }

        $total_visits_count = Track::select(\DB::raw("COUNT(*) as count"))->where('user', Auth()->user()->id)->where('type', 'profile')->where('date', '>=', $fromDate)->first();

        $logs_data = ['country' => [],'os' => [],'browser'  => []];
        $log = [];
        foreach ($logs_chart as $key) {
            if(!array_key_exists($key->formatted_date, $log)) {
                $log[$key->formatted_date] = [
                    'impression'        => 0,
                    'unique'            => 0,
                ];
            }
            /* Distribute the data from the database key */
            $log[$key->formatted_date]['unique']++;
            $log[$key->formatted_date]['impression'] += $key->count;
        }
        foreach ($visit_chart as $key) {
            if(!array_key_exists($key->country, $logs_data['country'])) {
                $logs_data['country'][$key->country ?? 'false'] = 1;
            } else {
                $logs_data['country'][$key->country]++;
            }

            if(!array_key_exists($key->os, $logs_data['os'])) {
                $logs_data['os'][$key->os ?? 'N/A'] = 1;
            } else {
                $logs_data['os'][$key->os]++;
            }

            if(!array_key_exists($key->browser, $logs_data['browser'])) {
                $logs_data['browser'][$key->browser ?? 'N/A'] = 1;
            } else {
                $logs_data['browser'][$key->browser]++;
            }
        }
        arsort($logs_data['browser']);
        arsort($logs_data['os']);
        arsort($logs_data['country']);
        unset($logs_data['country']['false']);
        unset($logs_data['country']['']);
        $logs_chart = get_chart_data($log);

        $countryPercent = [];
        $count = 0;
        foreach ($logs_data['country'] as $key => $value) {
            $count = ($count + $value);
        }
        foreach ($logs_data['country'] as $key => $value) {
            $countryPercent[$key] = [$value, round($value / ($count / 100),2)];
        }
        $products = Products::where('user', $user->id)->get();

        $total_visits_chart = ['total_visits' => $total_visits, 'visit_chart_date' => $visit_chart_date_fetch, 'total_visits_count' => $total_visits_count];
        $options = (object) ['countryPercent' => $countryPercent, 'logs_chart' => $logs_chart];
        return view('dashboard.stats.stats', ['total_visits' => $total_visits_chart, 'products' => $products, 'logs_data' => $logs_data, 'options' => $options]);
    }


    public function postSettings(Request $request){
        $username = $maybe_slug = slugify($request->username);
        $next = '_';
        $settings = [];
        while (User::where('username', '=', $username)->where('id', '!=', user('id'))->first()) {
            $username = "{$maybe_slug}{$next}";
            $next = $next . '_';
        }
        if (!empty($request->gateway_paypal_client_id) && !empty($request->gateway_paypal_secret_key)) {
            $request->merge(['gateway_paypal_status' => true]);
        }else{
            $request->merge(['gateway_paypal_status' => false]);
        }

        if (!empty($request->gateway_paystack_secret_key)) {
            $request->merge(['gateway_paystack_status' => true]);
        }else{
            $request->merge(['gateway_paystack_status' => false]);
        }

        if (!empty($request->gateway_bank_details)) {
            $request->merge(['gateway_bank_status' => true]);
        }else{
            $request->merge(['gateway_bank_status' => false]);
        }

        if (!empty($request->gateway_stripe_client) && !empty($request->gateway_stripe_secret)) {
            $request->merge(['gateway_stripe_status' => true]);
        }else{
            $request->merge(['gateway_stripe_status' => false]);
        }

        if (!empty($request->gateway_razor_key_id) && !empty($request->gateway_razor_secret_key)) {
            $request->merge(['gateway_razor_status' => true]);
        }else{
            $request->merge(['gateway_razor_status' => false]);
        }

        if (!empty($request->gateway_midtrans_client_key) && !empty($request->gateway_midtrans_server_key)) {
            $request->merge(['gateway_midtrans_status' => true]);
        }else{
            $request->merge(['gateway_midtrans_status' => false]);
        }

        if (!empty($request->gateway_mercadopago_access_token) && !empty($request->gateway_mercadopago_access_token)) {
            $request->merge(['gateway_mercadopago_status' => true]);
        }else{
            $request->merge(['gateway_mercadopago_status' => false]);
        }

        $request->gateway_cash_status = (bool) $request->gateway_cash_status;

        $settings_keys = ['name' => ['first_name', 'last_name'], 'address', 'email', 'domain', 'extra' => ['banner_url', 'shipping_types', 'custom_branding', 'tagline', 'google_analytics', 'facebook_pixel', 'template', 'about'], 'gateway' => ['currency', 'paypal_status', 'paypal_mode', 'paypal_client_id', 'paypal_secret_key', 'paystack_status', 'paystack_secret_key', 'bank_status', 'bank_details', 'stripe_status', 'stripe_client', 'stripe_secret', 'razor_status', 'razor_key_id', 'razor_secret_key', 'midtrans_mode', 'midtrans_status', 'cash_status', 'midtrans_client_key', 'midtrans_server_key', 'mercadopago_status', 'mercadopago_access_token']];
        if (session()->get('admin_overhead') && user('role') == 0) {
          $settings_keys[] = 'active';
          $settings_keys[] = 'verified';
          $settings_keys[] = 'package';
          $settings_keys[] = 'package_due';
        }
        if (!package('settings.domains', user())) {
            $request->domain = 'main';
            $_POST['domain'] = 'main';
        }

        foreach ($settings_keys as $key => $value) {
            if(is_array($value)) {
                $values_array = [];
                foreach ($value as $sub_key) {
                    $values_array[$sub_key] = $request->{$key . '_' . $sub_key};
                }
                $value = json_encode($values_array);
            } else {
                $key = $value;
                $value = $_POST[$key];
            }
            $value = [$key => $value];

            $settings[$key] = $value;
            User::where('id', user('id'))->update($value);
        }
        if (isset($request->theme_extra)) {
          foreach ($request->theme_extra as $key => $value) {
            $extra = json_decode($settings['extra']['extra'], true);
            $extra[$key] = $value;
            $extra = json_encode($extra);

            User::where('id', user('id'))->update(['extra' => $extra]);
          }
        }
        $socials = $request->socials;
        $update = User::find(user('id'));
        subdomain_wildcard_creation(user('id'));
        $media = is_array(user('media')) ? user('media') : [];

        if (!empty($socials)) {
            foreach ($socials as $key => $value) {
                $update->socials = $socials;
            }
        }
        if (!empty($request->avatar)) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            if (!empty(user('media.avatar'))) {
                if(file_exists(media_path('user/avatar/' . user('media.avatar')))){
                    unlink(media_path('user/avatar/' . user('media.avatar'))); 
                }
            }
            $imageName = md5(microtime());
            $imageName = $imageName . '.' .$request->avatar->extension();
            $request->avatar->move(media_path('user/avatar'), $imageName);
            $media['avatar'] = $imageName;
        }
        if (!empty($request->banner)) {
            $request->validate([
                'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            if (!empty(user('media.banner'))) {
                if(file_exists(media_path('user/banner/'.user('media.banner')))){
                    unlink(media_path('user/banner/' . user('media.banner'))); 
                }
            }
            $imageName = md5(microtime());
            $imageName = $imageName . '.' .$request->banner->extension();
            $request->banner->move(media_path('user/banner'), $imageName);
            $media['banner'] = $imageName;
        }
        if (!empty($request->password)) {
            $update->password = Hash::make($request->password);
        }
        $update->media = $media;
        $update->username = $username;
        $update->save();
        return back()->with('success', 'saved successfully');
    }

    public function domains(Domains $domains){
        $user = Auth::user();
        $allDomains = $domains->where('user', $user->id)->get();
        return view('dashboard.domains.domains', ['domains' => $allDomains]);
    }

    public function domains_post_get(Domains $domains, Request $request){
        $domain_id = $request->get('id');
        $domain = null;
        $user = Auth::user();
        $domains = Domains::where('user', $user->id)->get();
        if (empty($domain_id)) {
          if(package('settings.custom_domain_limit') != -1 && count($domains) >= package('settings.custom_domain_limit')) {
              return back()->with('error', __("You've reached your package limit."));
          }
        }
        if ($request->get('delete') == true) {
            $domains->find($request->get('id'))->delete();
            return back()->with('success', __('Deleted successfully'));
        }
        if (!empty($domain_id) && $domain = $domains->where('id', $domain_id)->where('user', $user->id)->first()) {
        }

        return view('dashboard.domains.post-domain', ['domain' => $domain]);
    }
    public function domains_post(Domains $domains, Request $request){
        if (!empty($this->code) && is_object($this->code) && $this->code->license !== 'Extended License') {
            #return back()->with('error', 'License needed or Extended license needed. Kindly visit admin - updates to update your license');
        }
        $parse_env_url = parse_url(env('APP_URL'))['host'];
        if ($request->host == $parse_env_url) {
            return back()->with('error', __('You cant add main domain'));
        }
        $request->validate([
            'scheme' => 'required',
        ]);
        if (!isset($request->domain_id)) {
            $request->validate([
                'host' => 'required|unique:domains',
            ]);
        }
        $requests['user'] = $request->user;
        $requests = $request->all();
        unset($requests['_token'], $requests['submit'], $requests['domain_id']);
        $requests['created_at'] = Carbon::now(settings('timezone'));
        if (isset($request->domain_id)) {
            $request->validate([
                'host' => 'required|unique:domains,host,'.$request->domain_id,
            ]);
            unset($requests['created_at']);
            $requests['updated_at'] = Carbon::now(settings('timezone'));
            $update = $domains->where('id', $request->domain_id)->update($requests);
            return back()->with('success', __('Domain updated successfully'));
        }
        $new = $domains->insert($requests);
        return redirect()->route('user-domains')->with('success', __('Domain created successfully'));
    }

    public function login_activity(){
        $activities = DB::table('users_logs')->where('user', Auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('dashboard.activities', ['activities' => $activities]);
    }

    public function back_to_free(Request $request){
        if (strtolower($request->free) !== 'free') {
            return back()->with('error', 'Type FREE');
        }
        $user = User::find(Auth()->user()->id);
        $user->package = 'free';
        $user->package_due = NULL;
        $user->save();
        return back()->with('success', 'Plan activated');
    }

    public function faq(){
        $faq = Faq::where('status', 1)->get();
        return view('dashboard.faq', ['faqs' => $faq]);    
    }

    public function deleteActivities(){
        $activities = DB::table('users_logs')->where('user', Auth()->user()->id)->delete();
        return back()->with('success', 'Deleted successfully');
    }

    public function delete_banner(){
        $user = Auth::user();
        if (!empty(user('media.banner', $user->id))) {
            if(file_exists(public_path('media/user/banner/' . user('media.banner', $user->id)))){
                unlink(public_path('media/user/banner/' . user('media.banner', $user->id))); 
                return redirect()->route('user-settings')->with('success', __('successfully removed your banner'));
            }
        }
        return redirect()->route('user-settings');
    }
}