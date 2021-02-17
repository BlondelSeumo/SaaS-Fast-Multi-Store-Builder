<?php

use Carbon\Carbon;
use App\Model\Settings;
use Ausi\SlugGenerator\SlugGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Herbert\EnvatoClient;
use Herbert\Envato\Auth\Token as EnvatoToken;

if (!function_exists('hello')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function hello(){

        echo "Hello";
    }
}

if (!function_exists('subdomain_wildcard_creation')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function subdomain_wildcard_creation($user_id){
        if (!$user = \App\User::find($user_id)) {
           return false;
        }
        if (!env('APP_USER_WILDCARD')) {
            return false;
        }

        $app_url = parse_url(env('APP_URL'));
        $slugGenerator = new SlugGenerator;
        $username = $maybe_slug = slugify($user->username);
        $domain = $username .'.'. $app_url['host'];
        $next = '_';
        if (\App\Model\Domains::where('host', '=', $domain)->where('user', '!=', $user->id)->exists()) {
            $username = "{$maybe_slug}{$next}";
            $next = $next . '_';
        }
        $new_domain = $username .'.'. $app_url['host'];
        if (!$domain = \App\Model\Domains::where('user', $user->id)->where('wildcard', 1)->first()) {
            $new = new \App\Model\Domains;
            $new->user = $user->id;
            $new->scheme = $app_url['scheme'].'://';
            $new->wildcard = 1;
            $new->status = 1;
            $new->host = $new_domain;
            $new->save();

            $user->domain = $new->id;
            $user->save();
        }else{
          if ($domain = \App\Model\Domains::where('user', $user->id)->where('wildcard', 1)->first()) {
              $update = \App\Model\Domains::find($domain->id);
              $update->scheme = $app_url['scheme'].'://';
              $update->host = $new_domain;
              $update->save();
          }
        }

        return true;
    }
}
if (!function_exists('product_options_html')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function product_options_html($uid, $product_id){
        $html = '';
        foreach (product_options($uid, $product_id) as $item){
            $html .= '<div class="card my-4"><div class="card-header bdrs-15"><h5>'. $item->name .'</h5></div></div>';

            if ($item->type == 'dropdown') {
                $html .= '<select class="form-control dy-product-options form-select"';
                if ($item->is_required) {
                    $html .= ' required=""';
                }
                $html .= ' data-search="off" data-ui="lg" name="options['.$item->id.']">';
                foreach (product_options_values($item->id) as $val):
                    $html .= '<option value="'. $val->id .'">'. $val->label .' - '. Currency::symbol(user('gateway.currency', $uid)) . number_format($val->price) .'</option>';
                endforeach;
                $html .= '</select>';
            }elseif ($item->type == 'checkbox') {
                foreach (product_options_values($item->id) as $val):
                    $html .= '<div class="custom-control custom-control-alternative mr-3 custom-checkbox"><input class="custom-control-input dy-product-options"';
                    if ($item->is_required) {
                        $html .= ' required=""';
                    }
                    $html .= ' type="checkbox" name="options['.$item->id.'][]" value="'. $val->id .'" id="checkbox-'. $val->id .'"><label class="custom-control-label" for="checkbox-'.$val->id.'"><span class="text-muted">'. $val->label .' - '. Currency::symbol(user('gateway.currency', $uid)) . number_format($val->price) .'</span></label></div>';
                endforeach;
            }elseif ($item->type == 'radio') {
                foreach (product_options_values($item->id) as $val):
                    $html .= '<div class="custom-control custom-control-lg custom-radio mr-3"><input type="radio" id="radio-'.$val->id.'" name="options['.$item->id.'][]" value="'. $val->id .'" class="custom-control-input dy-product-options"';

                    if ($item->is_required) {
                        $html .= ' required=""';
                    }

                    $html .= '><label class="custom-control-label" for="radio-'.$val->id.'">'.$val->label.' -  '. Currency::symbol(user('gateway.currency', $uid)) . number_format($val->price) .'</label></div>';
                endforeach;
            }elseif ($item->type == 'multiple_select') {
                $html .= '<select class="form-control form-select dy-product-options"';
                if ($item->is_required) {
                    $html .= ' required=""';
                }
                $html .= ' data-search="off" data-ui="lg" multiple="" name="options['.$item->id.'][]">';
                foreach (product_options_values($item->id) as $val):
                    $html .= '<option value="'. $val->id .'">'. $val->label .' - '. Currency::symbol(user('gateway.currency', $uid)) . number_format($val->price) .'</option>';
                endforeach;
                $html .= '</select>';
            }
        }


        return $html;
    }
}

if (!function_exists('user_top_products')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function user_top_products($user, $offset = 0, $limit = 1){
        $orders = \App\Model\Product_Orders::where('storeuser', $user)->get();
        $topproducts = [];
        foreach ($orders as $order) {
           foreach ($order->products as $key => $value) {
            $product = \App\Model\Products::where('id', $key)->first();

            $topproducts[$key] = $product;
           }
        }
        $topproducts = array_slice($topproducts, $offset, $limit);

        return $topproducts;
    }
}

if (!function_exists('user_first_top_products')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function user_first_top_products($user){
        $orders = \App\Model\Product_Orders::where('storeuser', $user)->get();
        $topproducts = [];
        foreach ($orders as $order) {
           foreach ($order->products as $key => $value) {
            $product = \App\Model\Products::where('id', $key)->first();

            $topproducts[$key] = $product;
           }
        }
        $topproducts = array_slice($topproducts, 0, 1);

        return $topproducts;
    }
}

if (!function_exists('product_options')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function product_options($user, $product_id){
      $options = \App\Model\Option::where('product', $product_id)->where('user', $user)->get();
      return $options;
    }
}

if (!function_exists('product_options_values')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function product_options_values($option_id){
      $values = \App\Model\OptionValues::where('option_id', $option_id)->get();
      return $values;
    }
}

if (!function_exists('share_to_media')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function share_to_media($type, $name){
        $url = url()->current();

        if ($type == 'facebook') {
            $query = urldecode(http_build_query([
                'app_id' => env('FACEBOOK_APP_ID'),
                'href' => $url,
                'display' => 'page',
                'title' => urlencode($name)
            ]));

            return 'https://www.facebook.com/dialog/share?' . $query;
        }

        if ($type == 'twitter') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'text' => urlencode(\Str::limit($name, 120))
            ]));

            return 'https://twitter.com/intent/tweet?' . $query;
        }

        if ($type == 'whatsapp') {
            $query = urldecode(http_build_query([
                'text' => urlencode($name . ' ' . $url)
            ]));

            return 'https://wa.me/?' . $query;
        }

        if ($type == 'linkedin') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'summary' => urlencode($name)
            ]));

            return 'https://www.linkedin.com/shareArticle?mini=true&' . $query;
        }

        if ($type == 'pinterest') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'description' => urlencode($name)
            ]));

            return 'https://pinterest.com/pin/create/button/?media=&' . $query;
        }

        if ($type == 'google') {
            $query = urldecode(http_build_query([
                'url' => $url,
            ]));

            return 'https://plus.google.com/share?' . $query;
        }
    }
}

if (!function_exists('countries')) {

    function countries(){
      $countries = ["Worldwide", "Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

      return $countries;
    }
}

if (!function_exists('install_log')) {
    function install_log(){
        if (file_exists(storage_path('logs/install.log'))) {
            $logfile = storage_path('logs/install.log');
        }else{
            file_put_contents(storage_path('logs/install.log'), '"========================== INSTALLATION START ========================"' . PHP_EOL, FILE_APPEND);
            return false;
        }
        $args = func_get_args();
        $message = array_shift($args);

        if (is_array($message)) $message = implode(PHP_EOL, $message);

        $message = "[" . date("Y/m/d h:i:s", time()) . "] " . vsprintf($message, $args) . PHP_EOL;
        file_put_contents($logfile, $message, FILE_APPEND);
    }
}
if (!function_exists('varexport')) {
    function varexport($expression, $return=FALSE) {
        $export = var_export($expression, TRUE);
        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        if ((bool)$return) return $export; else echo $export;
    }
}
if (!function_exists('ecom_variable_update')) {
    function ecom_variable_update($data = array()) {
        $content = require base_path('config/ecom.php');
        $update_ecom = [];

        foreach ($data as $key => $value) {
            $content[$key] = $value;
        }
        $insert = "<?php \n return " . varexport($content, true) . ';';
        file_put_contents(base_path('config/ecom.php'), $insert);
    }
}
if (!function_exists('env_update')) {
    function env_update($data = array()){
        if(count($data) > 0){
            $env = file_get_contents(base_path() . '/.env');
            $env = explode("\n", $env);
            foreach((array)$data as $key => $value) {
                if($key == "_token") {
                    continue;
                }
                $notfound = true;
                foreach($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);
                    if($entry[0] == $key){
                        $env[$env_key] = $key . "=\"" . $value."\"";
                        $notfound = false;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
                if($notfound) {
                    $env[$env_key + 1] = "\n".$key . "=\"" . $value."\"";
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path('.env'), $env);
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('verify_license')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function verify_license($code, $clean = false){
      $token = new EnvatoToken('c4ScI4Zd0AxPqjkQq74xPigzfboMVDkt');
      $client = new EnvatoClient($token);
      $purchase_code = $code;
      $response = $client->user->sale(['code' => $purchase_code]);
      if (!$response->error && is_array($response->results)) {
          $results = $response->results;
          if (file_exists(storage_path('app/.code'))) {
              unlink(storage_path('app/.code'));
          }
          $env = [];
          $env["LICENSE_KEY"]  = $code;
          $env["LICENSE_NAME"] = $results['buyer'];
          $env["LICENSE_TYPE"] = $results['license'];
          env_update($env);
          unset($results['item'], $results['amount']);
          \Storage::put('.code', \Crypt::encryptString(json_encode($results)));
          ($clean ? install_log('License check success. Name on license "'.$results['buyer'].'". License type "'.$results['license'].'"') : '');

          return (object) ['status' => true, 'response' => 'Done'];
      }
      else {
        return (object) ['status' => false, 'response' => "The code produced an error:\n"];
      }

      return $results;
    }
}

if (!function_exists('license')) {
    function license($key = null){
        $code = null;
        if (file_exists(storage_path('app/.code'))) {
           try {
               $code = json_decode(Crypt::decryptString(Storage::get('.code')), true);
           } catch (\Exception $e) {
            $code = null;
           }
        }else{
            return false;
        }
        app('config')->set('license', $code);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('license'.$key);
    }
}

if (!function_exists('banner')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function banner($user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }elseif (!$user && Auth::check()) {
            $user = Auth::user();
        }else{
            return false;
        }
        
        return (!empty(user('media.banner', $user->id)) && file_exists(public_path('media/user/banner/' . user('media.banner', $user->id))) ? url('media/user/banner/' . user('media.banner', $user->id)) : user('extra.banner_url', $user->id));
    }
}


if (!function_exists('profile')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function profile($id){
      $user = \App\User::where('id', $id)->first();
      $domain = $user->domain;
      if (Schema::hasTable('domains')) {
          if ($domain == 'main') {
            $domain = env('APP_URL');
          }elseif ($domain = App\Model\Domains::where('id', $user->domain)->first()) {
            $domain = $domain->scheme.$domain->host;
          }else{
            $domain = env('APP_URL');
          }
      }
      $profile_url = $domain.'/'.$user->username;
      return $profile_url;
    }
}

if (!function_exists('productReviewImage')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function productReviewImage($id){
        $review = \App\Model\Product_Reviews::where('id', $id)->first();
        $avatar = $review->review->avatar ?? '';
        $default = url('media/default_avatar.png');
        $check = media_path('avatars/') . $avatar;
        $path = url('media/avatars/' . $avatar);
        return (file_exists($check)) ? $path : $default;
    }
}

if (!function_exists('has_gateway')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function has_gateway($gateway, $user){
        $gateways = getOtherResourceFile('store_gateways');
        $packageGateways = json_decode(package('gateways', $user)) ?? [];
        if (array_key_exists($gateway, $gateways)) {
            foreach ($packageGateways as $key => $value) {
                if ($gateway == $value) {
                   return true;
                }
            }

            return false;
        }else{
            return false;
        }
    }
}

if (!function_exists('package')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function package($key = null, $user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }
        if(Auth::check()){
            $user = Auth::user();
        }
        if ($user->package == 'free') {
            $package = settings('package_free');
        }elseif($user->package == 'trial'){
            $package = settings('package_trial');
        }else{
            if (!$package = \App\Model\Packages::where('id', $user->package)->first()->toArray()) {
                 $package = config('settings.package_free');
            }
        }
        $settings = !is_array($package['settings']) ? (array) $package['settings'] : $package['settings'];
        $price = !is_array($package['price']) ? (array) $package['price'] : $package['price'];
        app('config')->set('package', $package);
        app('config')->set('package.price', $price);
        app('config')->set('package.settings', $settings);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('package'.$key);
    }
}
if (!function_exists('nf')) {
    function nf($numbers, $decimal = 2){
        $return = number_format($numbers, $decimal);
        return $return;
    }
}

if (!function_exists('nr')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function nr($n, $precision = 1) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
}

if (!function_exists('get_chart_data')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function get_chart_data(Array $main_array){
            $results = [];
            foreach($main_array as $date_label => $data) {
                foreach($data as $label_key => $label_value) {
                    if(!isset($results[$label_key])) {
                        $results[$label_key] = [];
                    }
                    $results[$label_key][] = $label_value;
                }
            }
            foreach($results as $key => $value) {
                $results[$key] = '["' . implode('", "', $value) . '"]';
            }
            $results['labels'] = '["' . implode('", "', array_keys($main_array)) . '"]';
            return $results;
    }
}

if (!function_exists('slugify')) {
    function slugify($string, $delimiter = '_'){
        $slug = new SlugGenerator();
        return $slug->generate($string, ['delimiter' => $delimiter]);
    }
}

if (!function_exists('user')) {
    function user($key = null, $user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }
        if (Auth::check() && !$user) {
            $user = Auth::user();
        }elseif (!Auth::check() && !$user) {
            return redirect()->route('login');
        }
        app('config')->set('user', $user);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('user'.$key);
    }
}

if (!function_exists('full_name')) {
    function full_name($user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }
        if (Auth::check() && !$user) {
            $user = Auth::user();
        }
        $first_name = $user->name['first_name'] ?? '';
        $last_name = $user->name['last_name'] ?? '';
        $name = $first_name . ' ' . $last_name;
        return $name;
    }
}

if (!function_exists('settings')) {
    function settings($key = null){
       $getsettings = \App\Model\Settings::all()
       ->keyBy('key')
       ->transform(function ($setting) {
             $value = json_decode($setting->value, true);
             $value = (json_last_error() === JSON_ERROR_NONE) ? $value : $setting->value;
             return $value;
        })->toArray();
       app('config')->set('settings', $getsettings);
       $key = !empty($key) ? '.'.$key : null;
       return app('config')->get('settings'.$key);
    }
}

if (!function_exists('getOtherResourceFile')) {
    function getOtherResourceFile($file){
        return require base_path('resources') . "/others/" . $file . '.php';
    }
}

if (!function_exists('media_path')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function media_path($parm = ''){
    	if (!empty($parm)) {
    		$parm = '/'.$parm;
    	}
    	return public_path('media'.$parm);
    }
}

if (!function_exists('getfirstproductimg')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getfirstproductimg($id){
        if (!$product = \App\Model\Products::where('id', $id)->first()) {
            return url('media/empty-dark.png');
        }
        $media = implode(',', $product->media);
        $media = explode(',', $media);
        $default = url('media/empty-dark.png');
        $check = media_path('user/products/') . $media[0];
        $path = url('media/user/products/' . $media[0]);
        return (!empty($media[0]) && file_exists($check)) ? $path : $default;
    }
}

if (!function_exists('avatar')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function avatar($user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }elseif (!$user && Auth::check()) {
            $user = Auth::user();
        }else{
            return false;
        }
        $avatar = user('media.avatar', $user->id);
        $default = url('media/default_avatar.png');
        $check = media_path('user/avatar/') . $avatar;
        $path = url('media/user/avatar/' . $avatar);
        return (!empty($avatar) && file_exists($check)) ? $path : $default;
    }
}

if (!function_exists('getcategoryImage')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getcategoryImage($id){
    	$category = \App\Model\Product_Category::where('id', $id)->first();
	    $default = url('img/default_avatar.png');
	    $check = media_path('user/categories/') . $category->media;
	    $path = url('media/user/categories/' . $category->media);
	    return (file_exists($check)) ? $path : $default;
    }
}

if (!function_exists('profile_analytics')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function profile_analytics($user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }else{
            return false;
        }
        $return = [];
        if (package('settings.google_analytics', $user->id) && !empty($user->settings->google_analytics)):
        $return[] = '<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id='. $user->settings->google_analytics .'"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag("js", new Date());

            gtag("config", "'. $user->settings->google_analytics .'");
        </script>';
       endif;
       if (package('settings.facebook_pixel', $user->id) && !empty($user->settings->facebook_pixel)):
        $return[] = "<!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', ". $user->settings->facebook_pixel .");
            fbq('track', 'PageView');
        </script>
        <noscript><img height=\"1\" width=\"1\" style='display:none' src='https://www.facebook.com/tr?id=".$user->settings->facebook_pixel."&ev=PageView&noscript=1\"/></noscript>
        <!-- End Facebook Pixel Code -->";
       endif;

       return implode(' ', $return);
    }
}



if (!function_exists('profile_body_class')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function profile_body_classes($user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
        }else{
            return false;
        }
        $return = [];
        if (!empty($user->settings->showbuttombar) && $user->settings->showbuttombar) {
            $return[] = 'has-bottom-bar';
        }
        $return[] = 'profile';
        if (package('settings.custom_background', $user->id)) {
            if ($user->background_type == 'gradient') {
                $return[] = $user->background;
            }elseif ($user->background_type == 'default') {
                $return[] = 'default';
            }
        }else{
            $return[] = 'default';
        }

        if (!empty($user->settings->default_color) && $user->settings->default_color == 'dark') {
            $return[] = 'background-dark';
        }
       return implode(' ', $return);
    }
}

if (!function_exists('custom_code')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function custom_code(){
        $code = [];
        if (settings('custom_code.enabled')):
         $code[] = '<style>
             '. settings('custom_code.css') .'
         </style>';
        endif;
        if (settings('custom_code.enabled')):
        $code[] = '<script>
           '. settings('custom_code.js') .'
        </script>';
        endif;

        return implode(' ', $code);
    }
}

if (!function_exists('store_categories')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function store_categories($user, $limit = null, $paginate = false){
        $categories = App\Model\Product_Category::where('user', $user);
        if (!empty($limit)) {
            $categories->limit($limit);
        }
        if ($paginate) {
            $categories = $categories->paginate($limit);
        }else{
            $categories = $categories->get();
        }

        return $categories;
    }
}

if (!function_exists('store_blogs')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function store_blogs($user, $limit = null){
        $blogs = App\Model\Blog::where('user', $user)->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        if (!empty($limit)) {
            $blogs->limit($limit);
        }
        $blogs = $blogs->get();

        return $blogs;
    }
}

if (!function_exists('store_products')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function store_products($user, $limit = null, $paginate = false){
        $products = App\Model\Products::where('user', $user)->orderBy('position', 'ASC')->orderBy('id', 'DESC');
        if (!empty($limit)) {
            $products->limit($limit);
        }
        if (!$paginate) {
            $products = $products->get();
        }else{
            $products = $products->paginate($limit);
        }

        return $products;
    }
}
