<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Instagramusers as User;
use App\Instagramlocations as Location;
use App\Instagramphotos as Photo;
use App\Configurations as Configuration;

//To be moved to INSTAGRAM constants file
define('INSTAGRAM_CLIENT_ID', '0e64ff614da4421d97cae1e09e3d06dc');
define('INSTAGRAM_TAG_ENDPOINT_URL', 'https://api.instagram.com/v1/tags/');
define('INSTRAGRAM_MEDIA_TYPE_PHOTO', 'image');
define('INSTAGRAM_MEDIA_FETCH_COUNT', 33);
define('INSTAGRAM_MEDIA_FETCH_HEIGHT_LIMITATION', 640);
define('INSTAGRAM_CONFIGURATION_CODE_MIN_TAG_ID', 'instagram:curr_min_tag_id');

class FetchInstagramMedia extends Controller
{
  public function fecthByTag($tag)
  {
    $current_min_tag_id = Configuration::where('code', INSTAGRAM_CONFIGURATION_CODE_MIN_TAG_ID)->first();

    if(!isset($current_min_tag_id->value))
    {
      $min_tag_id_config = new Configuration();
      $min_tag_id_config->code = INSTAGRAM_CONFIGURATION_CODE_MIN_TAG_ID;
      $min_tag_id_config->value = 0;
      $min_tag_id_config->save();
      $min_tag_id = false;
    }
    else {
      $min_tag_id = $current_min_tag_id->value;
    }

    $url = INSTAGRAM_TAG_ENDPOINT_URL . "$tag/media/recent?client_id=" . INSTAGRAM_CLIENT_ID . '&count=' . INSTAGRAM_MEDIA_FETCH_COUNT . (!empty($min_tag_id) ? '&min_tag_id=' . $min_tag_id : '');

    $ch = curl_init();

    $options = array(
                      CURLOPT_URL => $url,
                      CURLOPT_CONNECTTIMEOUT => 30,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_SSL_VERIFYPEER => false
                    );

    // echo "<pre>";
    // var_dump($options); die();
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    $errors = curl_error($ch);

    curl_close($ch);

    if(empty($errors) && !empty($result))
    {
      $this->StoreMediaDataFromJson($result);
    }
    exit;
  }

  private function StoreMediaDataFromJson($json)
  {
    $object = @json_decode($json);

    // var_dump($object->data);

    if(json_last_error() == JSON_ERROR_NONE)
    {
      if(isset($object->data) && is_array($object->data) && !empty($object->data))
      {
        $current_min_tag_id = Configuration::where('code', INSTAGRAM_CONFIGURATION_CODE_MIN_TAG_ID)->first();

        if(isset($current_min_tag_id->value) && isset($object->pagination->min_tag_id))
        {
          $current_min_tag_id->value = $object->pagination->min_tag_id;
          $current_min_tag_id->save();
        }

        foreach($object->data as $key_data=>$data)
        {
          if(isset($data->type) && $data->type == INSTRAGRAM_MEDIA_TYPE_PHOTO)
          {
            // if ($data->images->standard_resolution->height < INSTAGRAM_MEDIA_FETCH_HEIGHT_LIMITATION)continue;
            //STORE LOCATION DATA IF NOT EXISTS
            if(isset($data->location) && !empty($data->location))
            {
              $location_id = $data->location->id;
              $location_exists = Location::find($location_id);
              if(empty($location_exists))
              {
                $location = new Location();
                $location->id = $location_id;
                $location->latitude = $data->location->latitude;
                $location->longitude = $data->location->longitude;
                $location->name = $data->location->name;
                $location->save();
                // var_dump($location); die();
              }
            }

            //STORE USER DATA IF NOT EXISTS
            if(isset($data->user) && !empty($data->user))
            {
              $user_id = $data->user->id;
              $user_exists = User::find($user_id);
              if(empty($user_exists))
              {
                $user = new User();
                $user->id = $user_id;
                $user->username = $data->user->username;
                $user->profile_picture = $data->user->profile_picture;
                $user->full_name = $data->user->full_name;
                $user->save();
                // var_dump($user); die();
              }
            }

            //STORE ACTUAL PHOTO DATA
            $photo_id = $data->id;
            $photo_exists = Photo::find($photo_id);
            if(empty($photo_exists) && (isset($user_id) && !empty($user_id)))
            {
              $photo = new Photo();
              $photo->id = $photo_id;
              $photo->instagramusers_id = $user_id;
              $photo->instagramlocations_id = (isset($location_id) ? $location_id : 0);
              $photo->text = (isset($data->caption->text) && !empty($data->caption->text) ? $data->caption->text : "");
              $photo->online_location = $data->images->standard_resolution->url;
              $photo->local_location = "";
              $photo->instagram_link = $data->link;
              $photo->instagram_create_date = (isset($data->created_time) && !empty($data->created_time) ? date("Y-m-d H:i:s", $data->created_time) : '0000-00-00 00:00:00');
              $photo->save();
              // var_dump($photo); die();
            }
          }
          else
          {
            continue;
          }
        }
      }
    }
  }
}
