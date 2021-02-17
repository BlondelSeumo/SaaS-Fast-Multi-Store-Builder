<?php

namespace App\Http\Controllers\Profile;

use General, Location, Str, Theme;
use App\User;
use App\Model\Track;
use App\Model\Products;
use App\Model\Product_Reviews;
use App\Model\Product_Category;
use App\Model\Product_Orders;
use App\Model\Domains;
use App\Model\Option;
use App\Model\OptionValues;
use App\Model\Blog;
use App\Mail\GeneralMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Cart;

class ProfileController extends Controller{
  public $user;
  private $uid;
  private $template;
  public  $package;
  private $profile;
  function __construct(Request $request){
    $this->init($request);
  }

  private function init($request){
    $host = $_SERVER['HTTP_HOST'];
    $parse = parse_url(env('APP_URL'))['host'] ?? '';
    foreach (Domains::get() as $value) {
       if ($host == $value->host && $value->user !== null) {
        if ($user = User::where('id', $value->user)->first()) {
          request()->merge(['profile' => $user->username]);
          $this->profile = $user->username;
        }
       }
    }
    $this->profile = $request->profile;
    if (!$this->user = User::where('username', $this->profile)->first()) {
        abort(404);
    }
    $this->uid = $this->user->id;
    $uid = $this->uid;
    $this->domain();
    # init views 
    $this->initViews($request);
    $this->template = !empty(settings('user.default_template')) ? settings('user.default_template') : 'doveshop';
    if (!empty(user('extra.template', $uid))) {
      if (Theme::has(user('extra.template', $uid))) {
        $this->template = user('extra.template', $uid);
      }
    }
    Theme::set($this->template);
  }

    private function domain(){
        $domain = $this->user->domain;
        # If domain is main
        if ($domain == 'main') {
          $domain = env('APP_URL');
          # If Domain is not main and exists
        }elseif ($domain = Domains::where('id', $this->user->domain)->first()) {
          # If domain is in package
            $domain = $domain->scheme.$domain->host;
        }else{
          $domain = env('APP_URL');
        }
        $host     = parse_url($domain);
        $thishost = $_SERVER['HTTP_HOST'];

        if ($host['host'] == $thishost) {
          # Proceed with request
        }else{
          if (settings('user.domains_restrict')) {
          # Proceed with request
          }else{
            redirect("$domain")->send();
          }
        }
    }

  private function initViews($request){
    $general = new General();
    $package = $general->package($this->user);
    $productPaginate = Products::where('user', $this->user->id)->orderBy('position', 'ASC')->orderBy('id', 'DESC');
    $categories = Product_Category::where('user', $this->user->id)->get();
    $max_price   = Products::where('user', $this->user->id)->max('price');
    $min_price   = Products::where('user', $this->user->id)->min('price');
    $gateways   = getOtherResourceFile('store_gateways');
    if (license('license') !== 'Extended License') {
      $gateways = [
        "paypal" => [
          "name"     => "PayPal",
          "banner"   => "paypal.png"
        ],
        "bank" => [
          "name"     => "Bank",
          "banner"   => "banktransfer.png"
        ],
        "cash" => [
          "name"     => "Cash Payment",
          "banner"   => "cashpayment.png"
        ]
      ];
    }
    $socials    = getOtherResourceFile('socials');
    if ($request->get('min-price')) {
      $min_price = $request->get('min-price');
      $productPaginate->where('price', '>=', $min_price);
    }
    if ($request->get('max-price')) {
      $max_price = $request->get('max-price');
      $productPaginate->where('price', '<=', $max_price);
    }
    if (!empty($request->get('query'))) {
      $productPaginate = $productPaginate->where('title', 'LIKE','%'.$request->get('query').'%');
    }
    if (!empty($request->get('category'))) {
      $productPaginate = $productPaginate->whereJsonContains('categories', $request->get('category'))->paginate(10000);
    }else{
      $productPaginate = $productPaginate->paginate(8);
    }
    if (file_exists($sc = resource_path('custom/socials.php'))) {
        $sc = require $sc;
        if (is_array($sc)) {
            foreach ($sc as $key => $value) {
                $socials[$key] = $value;
            }
        }
    }
    $options = (object) ['socials' => $socials];
    View::share('options', $options);
    View::share('min_price', $min_price);
    View::share('max_price', $max_price);
    View::share('uid', $this->uid);
    View::share('package', $package);
    View::share('categories', $categories);
    View::share('productPaginate', $productPaginate);
    View::share('gateways', $gateways);
    View::composer('*', function($view){
        $view->with('user', $this->user);
    });
  }

  public function index(){
    # Track activity
    $this->track($this->user);
    return view('profile');
  }

  public function categories($profile = null){
    return view('pages.categories');
  }

  public function about($profile = null){

    return view('about');
  }

  public function blogs(){
    return view('blogs');
  }

  public function track($user, $dyid = Null, $type = 'profile'){
    $agent = new Agent();
    $general = new General();
    $ip = $general->getIP();
    $visitor_id = md5(microtime());
    session()->put('visitor', 1);
    $session  = session();
    if (empty($session->get('visitor_id'))) {
      session()->put('visitor_id', $visitor_id);
    }

    if (Track::where('visitor_id', $session->get('visitor_id'))->count() > 0 ) {
      $track = Track::where('visitor_id', $session->get('visitor_id'))->first();
          $values = array('count' => ($track->count + 1), 'date' => Carbon::now(settings('timezone')));
          Track::where('visitor_id', $session->get('visitor_id'))->update($values);
    }else{
          $values = array('user' => $user->id, 'visitor_id' => $session->get('visitor_id'), 'country' => (!empty(Location::get($general->getIP())->countryCode)) ? Location::get($general->getIP())->countryCode : Null, 'type' => $type, 'dyid' => $dyid, 'ip' => $general->getIP(), 'os' => $agent->platform(), 'browser' => $agent->browser(), 'count' => 1, 'referer' => url(request()->profile), 'date' => Carbon::now(settings('timezone')));
          Track::insert($values);
    }
  }


  public function checkout($profile = null, Request $request){
    $session = session();
    $session_cart = $session->get('cart_'.$this->user->username) ?? [];
    $cart = [];
    foreach ($session_cart as $key => $value) {
      $val = Products::where('id', $key)->where('user', $this->user->id)->first();
      $val->qty = $value['qty'];
      $cart[$key] = $val;
    }
    if (empty($cart)) {
      #return redirect($this->profile ?? '')->with('error', __('Cart empty'));
    }
    $newcart = new \App\Cart;
    $cart = $newcart->getAll($this->uid);
    return view('pages.checkout', ['cart' => $cart]);
  }

  public function add_to_cart(Request $request, $id){
    $session = $request->session();
    $id = $request->id;
    $product_id = $id;
    if (!$product = Products::where('id', $id)->where('user', $this->user->id)->first()) {
      abort(404);
    }
    $action = $request->action;
    $quantity = (!empty($request->quantity) ? $request->quantity : 1);
    if ($action == 'add') {
      $cart = $session->get('cart_' . $this->profile) ? $session->get('cart_' . $this->profile) : [];
      if (array_key_exists($product_id, $cart)) {
        $qty = $cart[$product_id]['qty'];
        $cart[$product_id]['qty'] = ($qty + $quantity);
      }else{
        $cart[$product_id] = [
          'id' => $id,
          'qty' => $quantity
        ];
      }
      $session->put('cart_' . $this->profile, $cart);
    }elseif ($action == 'remove') {
      $session->forget('cart_' . $this->profile . '.' . $product_id);
      return back()->with('success', 'Item removed');
    }elseif ($action == 'remove_all') {
      $session->forget('cart_' . $this->profile);
    }elseif ($action == 'quantity_change') {
      $cart = ($session->get('cart_' . $this->profile)) ? $session->get('cart_' . $this->profile) : [];
      if (array_key_exists($product_id, $cart)) {
          $cart[$product_id]['qty'] = $request->quantity;
      }else{
        $cart[$product_id] = [
          'id' => $id,
          'qty' => $request->quantity
        ];
      }
      $session->put('cart_' . $this->profile, $cart);
    }
    $return = ['status' => 'success', 'cart_count' => count(\Session::get('cart_'.$this->profile))];
    return $return;
  }


  public function single_blogs($id, Request $request){
      $id = $request->id;
      if (package('settings.blog', $this->uid)) {
          return Redirect::to($this->profile = '');
      }

      if (!$blog = Blog::where('id', $id)->where('user', $this->uid)->first()) {
          abort(404);
      }
      $blog_name = $blog->name;
      $blog_name = str_replace("{{title}}", $blog->name, $blog_name);
      $blog_note = $blog->note;
      $blog_note = str_replace("{{title}}", $blog_name, $blog_note);
      $this->track_blog($this->user, $request, $blog->id, "portfolio");
      return view('pages.single-blog', ['blog' => $blog, 'blog_note' => $blog_note, 'blog_title' => $blog_name]);
  }
    public function track_blog($user, $request, $dyid = Null, $type = 'profile'){
        $agent = new Agent();
        $general = new General();
        $visitor_id = md5(microtime());
        $request->session()->put('visitor', 1);
        $session  = $request->session();
        if (empty($session->get('visitor_id'))) {
            $request->session()->put('visitor_id', $visitor_id);
        }

        if (Track::where('visitor_id', $session->get('visitor_id'))->where('dyid', $dyid)->where('type', $type)->count() > 0 ) {
            $track = Track::where('visitor_id', $session->get('visitor_id'))->where('dyid', $dyid)->where('type', $type)->first();
            $values = array('count' => ($track->count + 1), 'date' => Carbon::now(settings('timezone')));
            Track::where('visitor_id', $session->get('visitor_id'))->update($values);
        }else{
            $values = array('user' => $user->id, 'visitor_id' => $session->get('visitor_id'), 'country' => (!empty(Location::get($general->getIP())->countryCode)) ? Location::get($general->getIP())->countryCode : Null, 'type' => $type, 'dyid' => $dyid, 'ip' => $this->getIp(), 'os' => $agent->platform(), 'browser' => $agent->browser(), 'count' => 1, 'date' => Carbon::now(settings('timezone')));
            Track::insert($values);
        }
        
    }

    public function getIp(){
        if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

            if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
                $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

                return trim(reset($ips));
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

        } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER['REMOTE_ADDR'];
        } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        return '';
    }
  public function single_product($id, Request $request){
   $id = $request->id;
   if (!$product = Products::where('id', $request->id)->where('user', $this->user->id)->first()) {
    abort(404);
   }
   #$options = Option::where('product', $id)->get();
   #$options_values = OptionValues::leftJoin('options', 'options.id', '=', 'option_values.option_id')
   #         ->select('option_values.*')
   #         ->groupBy('option_values.id')
   #         ->where('option_values.user', $this->uid)
   #         ->orderBy('order', 'ASC')
   #         ->orderBy('id', 'DESC')->get();

   $reviews = Product_Reviews::where('product_id', $id)->where('storeuser', $this->user->id)->count();
   return view('pages.single_product', ['product' => $product, 'reviews' => $reviews]);
  }


  public function reviews(Request $request){
   $id = $request->id;
   if (!$product = Products::where('id', $id)->where('user', $this->user->id)->first()) {
    abort(404);
   }
   $reviews = Product_Reviews::where('product_id', $id)->where('storeuser', $this->user->id)->orderBy('id', 'desc')->get();

   return view('pages.reviews', ['product' => $product, 'reviews' => $reviews]);
  }

  public function postReviews(Request $request){
   $id = $request->id;
   if (!$product = Products::where('id', $id)->where('user', $this->user->id)->first()) {
    abort(404);
   }
    $request->validate([
      'name' => 'required|min:2|string',
      'email' => 'required|email',
      'review' => 'required|string|min:2',
      'rating' => 'required',
    ]);
    $avatar = glob(media_path('avatars/').'*.{jpg,jpeg,png,gif,svg}', GLOB_BRACE);
    $avatar = $avatar[array_rand($avatar)];
    $avatar = basename($avatar);
    $array = ['name' => $request->name, 'email' => $request->email, 'review' => $request->review, 'avatar' => $avatar];
    $review = new Product_Reviews;
    $review->storeuser = $this->user->id;
    $review->product_id = $id;
    $review->rating = $request->rating;
    $review->review = $array;
    $review->save();

    return back()->with('success', 'Review posted');
  }

  public function orders($profile = null, Request $request){
    $session = $request->session();
    $GetOrderId = $request->get('order_id');
    if (empty($GetOrderId)) {
      return view('pages.set-order');
    }
    if (!$storeorder = DB::table('store_orders')->where('slug', $GetOrderId)->first()) {
      abort(404);
    }
    if ($order = Product_Orders::where('storeuser', $this->user->id)->where('id', $storeorder->order_id)->first()) {
      $products = [];
      foreach ($order->products as $key => $value) {
       $product = Products::where('id', $key)->first();
       if (!array_key_exists($key, $products)) {
          $products[$key] = [
           'qty'  => 0,
           'name'  => '',
           'price'  => '',
           'media'  => '',
           'options'  => '',
           'downloadables' => null,
          ];
       }
       $price = $value['price'];

       /**
       *
       * Use Product price
       * $price = !empty($product->salePrice) ? $product->salePrice : $product->price;
       *
       **/

       $products[$key]['qty'] = $value['qty'];
       $products[$key]['name'] = $product->title ?? $value['name'] ?? '';
       $products[$key]['price'] = $price;
       $products[$key]['media'] = $product->media ?? '';
       $products[$key]['options'] = $value['options'] ?? '';
       $products[$key]['downloadables'] = $product->files;
      }
    }else{
      abort(404);
    }
    return view('pages.view-orders', ['order' => $order, 'products' => $products]);
  }

  public function products($profile = null){

    return view('products');
  }


    public function insertordersinit($user, $orders, $gateway = ''){
      $cart = new Cart;
      $cart = $cart->getAll($user->id);
      $details = json_decode($orders['details']);
      $message = 'Order completed, thanks for purchasing';
      $products = [];

      foreach ($cart as $key => $value) {
          $id = $value->associatedModel->id;
          if (array_key_exists($id, $products)) {
            $products[$id] = [
              'qty'   => 0,
              'name'  => '',
              'price' => 0,
              'options' => '',
            ];
          }
          $products[$id]['qty'] = $value->quantity;
          $products[$id]['price'] = $value->price;
          $products[$id]['name'] = $value->name;
          $products[$id]['options'] = Cart::getOptionsAttr($value->attributes->options, 'name_string');

          $product = Products::find($id);

          if ($product->stock_management == 1 && $product->stock > 0) {
            $product->stock = ($product->stock - $value->quantity);
          }
          if ($product->stock < 1) {
            $product->stock_status = 0;
          }

          $product->save();
      }
      $products = json_encode($products);

      # Insert order
      $insert = ['storeuser' => $user->id, 'products' => $products, 'details' => $orders['details'], 'currency' => user('gateway.currency', $user->id), 'gateway' => $gateway, 'ref' => Str::random(10), 'price' => Cart::total($user->id), 'created_at' => Carbon::now(settings('timezone'))];

      $id = Product_Orders::insertGetId($insert);

      # Store orders
      $storeOrderId = DB::table('store_orders')->insertGetId(['slug' => Str::random(10), 'order_id' => $id, 'created_at' => Carbon::now(settings('timezone'))]);

      $storeOrderId = DB::table('store_orders')->where('id', $storeOrderId)->first();


      $email = (object) ['subject' => 'New Payment from '. $details->first_name ?? '', 'message' => '<p> <b>'. $details->first_name .'</b> Just paid for <b>'.count($cart).'</b> Products. <br> Head to your dashboard to view earnings and orders</p><br><a href="'. route('login') .'" style="background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;margin-top: 20px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 13px 50px; width: 100%">Login</a>'];
      try {
        Mail::to($user->email)->send(new GeneralMail($email));
      } catch (\Exception $e) {
        $message = 'Order completed and error sending email';
      }

      $email = (object) ['subject' => 'Thanks for purchasing', 'message' => '<p> You just purchased <b>'.count($cart).'</b> Products from our store. To view purchased orders, kindly click the button below </p><br><a href="'. route('user-profile-orders', ['profile' => $user->username, 'order_id' => $storeOrderId->slug]) .'" style="background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;margin-top: 20px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 13px 50px; width: 100%">View orders</a> <p style="margin-top: 20px; display: block">'. route('user-profile-orders', ['profile' => $user->username, 'order_id' => $storeOrderId->slug]) .'</p>'];


      try {
        Mail::to($details->email)->send(new GeneralMail($email));
      } catch (\Exception $e) {
        $message = 'Order completed and error sending email';
      }

      return ['response' => 'success', 'message' => $message, 'order_id' => $storeOrderId->slug];
    }
    public function postcheckout(Request $request){
      $request->validate([
        'gateway' => 'required',
      ]);
      $details = [
           'first_name'     => $request->first_name,
           'last_name'      => $request->last_name,
           'address'        => $request->address,
           'town_city'      => $request->town_city,
           'state'          => $request->state,
           'poster_code'    => $request->poster_code,
           'phone'          => $request->phone,
           'country'        => $request->country,
           'shipping'       => $request->shipping_location,
           'email'          => $request->email,
           'note'           => $request->note
      ];
      $details = json_encode($details);
      $gateways = getOtherResourceFile('store_gateways');
      if (!array_key_exists($request->gateway, $gateways)) {
        return back()->with('error', 'Gateway doesnt exists');
      }
      $shipping = $request->shipping_location;

      try {
         return redirect()->route('user-'.$request->gateway.'-create', ['profile' => $this->profile, 'shipping' => $shipping, 'details' => $details]);
      } catch (\Exception $e) {
        return back()->with('error', $e);
      }
    }

    public function success($profile){

      return view('pages.success');
    }
}