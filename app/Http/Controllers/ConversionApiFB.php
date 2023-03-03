<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\Content;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\DeliveryCategory;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ConversionApiFB extends Controller
{
    
    public function geraid() {
        $data = openssl_random_pseudo_bytes(16);
    
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
      }

    public function Lead(){
//dd("lead");

        if(isset($_COOKIE['_fbc'])){
        $fbc = $_COOKIE['_fbc'];
        }
        if(isset($_COOKIE['_fbp'])){
        $fbp = $_COOKIE['_fbp'];
        }
        
        if (env('APP_DEBUG') == false){
            $tempo = time();
            $page = url()->current();
            $eventid = ConversionApiFB::geraid();

            $access_token = env('CONVERSIONS_API_ACCESS_TOKEN');
            $pixel_id = env('CONVERSIONS_API_PIXEL_ID');

            $api = Api::init(null, null, $access_token);
            $api->setLogger(new CurlLogger());

            $user_data = (new UserData())  
            //->setEmail((auth()->user()->email))
            ->setPhone((auth()->user()->cellphone))
            ->setLastName((auth()->user()->lastname))
            ->setFirstName((auth()->user()->name))/*
            ->setCities(array("08809a7d1404509f5ca572eea923bad7c334d16bf92bb4ffc1e576ef34572176"))
            ->setStates(array("0510eddd781102030eb8860671503a28e6a37f5346de429bdd47c0a37c77cc7d"))
            ->setCountryCodes(array("885036a0da3dff3c3e05bc79bf49382b12bc5098514ed57ce0875aba1aa2c40d"))*/
            ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
            ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
            ->setFbc($fbc)
            ->setFbp($fbp);

            $event = (new Event())
            ->setEventName("Lead")
            ->setEventTime($tempo)
            ->setUserData($user_data)
            //->setCustomData($custom_data)
            //->setActionSource("website")
            ->setEventSourceUrl($page)
            ->setEventId($eventid);
                
            $events = array();
            array_push($events, $event);

            if(env('CONVERSIONS_API_TEST') == true){
                $request = (new EventRequest($pixel_id))
                    ->setTestEventCode(env('CONVERSIONS_API_TEST_CODE'))
                    ->setEvents($events);
                }else{
                    $request = (new EventRequest($pixel_id))
                    ->setEvents($events);
                }

                $response = $request->execute();
            //dd($response);

            //header('Location: ' . $url, true, $permanent ? 301 : 302);

            unset($pixel);
            unset($token);
            unset($url);
            //exit();
            return $eventid;
        }
    }

    public function ViewContent(){
//dd('view');

        if(isset($_COOKIE['_fbc'])){
        $fbc = $_COOKIE['_fbc'];
        }
        if(isset($_COOKIE['_fbp'])){
        $fbp = $_COOKIE['_fbp'];
        }
        
        //Storage::put('event.txt', $fbc . " " . $fbp);
        //dd($fbc);

        if (env('APP_DEBUG') == false){
            $tempo = time();
            $page = url()->current();
            $eventid = ConversionApiFB::geraid();

            $access_token = env('CONVERSIONS_API_ACCESS_TOKEN');
            $pixel_id = env('CONVERSIONS_API_PIXEL_ID');
           

            $api = Api::init(null, null, $access_token);
            $api->setLogger(new CurlLogger());

            if (Auth::check()) {
                $user_data = (new UserData())  
                ->setEmail((auth()->user()->email))
                ->setPhone((auth()->user()->cellphone))
                ->setLastName((auth()->user()->lastname))
                ->setFirstName((auth()->user()->name))/*
                ->setCities(array("08809a7d1404509f5ca572eea923bad7c334d16bf92bb4ffc1e576ef34572176"))
                ->setStates(array("0510eddd781102030eb8860671503a28e6a37f5346de429bdd47c0a37c77cc7d"))
                ->setCountryCodes(array("885036a0da3dff3c3e05bc79bf49382b12bc5098514ed57ce0875aba1aa2c40d"))*/
                ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
                ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
                ->setFbc($fbc)
                ->setFbp($fbp);
            } else {
                $user_data = (new UserData())  
                ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
                ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
                ->setFbc($fbc)
                ->setFbp($fbp);
            }

            

            $event = (new Event())
            ->setEventName("ViewContent")
            ->setEventTime($tempo)
            ->setUserData($user_data)
            //->setCustomData($custom_data)
            //->setActionSource("website")
            ->setEventSourceUrl($page)
            ->setEventId($eventid);
                
            $events = array();
            array_push($events, $event);
            
            if(env('CONVERSIONS_API_TEST') == true){
            $request = (new EventRequest($pixel_id))
                ->setTestEventCode(env('CONVERSIONS_API_TEST_CODE'))
                ->setEvents($events);
            }else{
                $request = (new EventRequest($pixel_id))
                ->setEvents($events);
            }

            //dd($request);
            $response = $request->execute();
            //dd($response);

            //header('Location: ' . $url, true, $permanent ? 301 : 302);

            unset($pixel);
            unset($token);
            unset($url);
            //exit();
            
            return;
    }
}
}
