<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '547617549365-5ck2arnfgtgqu4jd8ef67171ogvhh36q.apps.googleusercontent.com';
$config['google']['client_secret']    = 'i263booCBDIj1R8pz6kob7mW';
$config['google']['redirect_uri']     = 'https://dev.infosparkles.com/sportsbooking/home/google_login';
$config['google']['application_name'] = 'sportspace';
$config['google']['api_key']          = 'AIzaSyCsnP2EtTXcUNhsawwRO5CFQRKozXoPYvQ';
$config['google']['scopes']           = array();