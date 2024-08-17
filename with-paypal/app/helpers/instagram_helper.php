<?php
if(!function_exists("Instagram_Loader")){
    function Instagram_Loader($username, $password){
        listIt(APPPATH. "libraries/InstagramAPI/");
        $i = new Instagram(false, false);
        $i->setUser($username, $password);
        return $i;
    }
}

if(!function_exists("Instagram_Login")){
    function Instagram_Login($username, $password){
        try {
            Delete(APPPATH."libraries/InstagramAPI/data/".$username);
            $i = Instagram_Loader($username, $password);
            $data = $i->login(true);
            return $i;
        }
        catch ( Exception $e ) {
            $error_arr = $e->getTrace();
            $txt  = $error_arr[0]['args'][0]->error_title;
            $type = $error_arr[0]['args'][0]->error_type;
            if($type == "checkpoint_logged_out"){
                $txt = "Please go to <a href='http://instagram.com/' target='_blank'>http://instagram.com/</a> to verify email and then login at here again";
            }
            return array(
                "txt"   => ($txt != "")?$txt:$type,
                "type"  => $type,
                "label" => "bg-red",
                "st"    => "error",
            );
        }
    }
}

if(!function_exists("Instagram_Post")){
    function Instagram_Post($data){
        $response = array();
        $i = Instagram_Loader($data->username, $data->password);
        if(!is_string($i)){
            switch ($data->category) {
                case 'post':
                    switch ($data->type) {
                        case 'photo':
                            try {
                                $response =$i->uploadPhoto($data->image, $data->message);
                            } catch (Exception $e){
                                $response = $e->getMessage();
                            }

                            break;
                        case 'story':
                            try {
                                $response =$i->uploadPhotoStory($data->image, $data->message);
                            } catch (Exception $e){
                                $response = $e->getMessage();
                            }

                            break;
                        case 'video':
                            $url = $data->image;
                            $id = getIdYoutube($data->image);
                            if(strlen($id) == 11){
                                parse_str(file_get_contents('http://www.youtube.com/get_video_info?video_id='.$id),$info);
                                if($info['status'] == "ok"){
                                    $streams = explode(',',$info['url_encoded_fmt_stream_map']);
                                    $type = "video/mp4"; 
                                    foreach($streams as $stream){ 
                                        parse_str($stream,$real_stream);
                                        $stype = $real_stream['type'];
                                        if(strpos($real_stream['type'],';') !== false){
                                            $tmp = explode(';',$real_stream['type']);
                                            $stype = $tmp[0]; 
                                            unset($tmp); 
                                        } 
                                        if($stype == $type && ($real_stream['quality'] == 'large' || $real_stream['quality'] == 'medium' || $real_stream['quality'] == 'small')){
                                            try {
                                                $response =$i->uploadVideo($real_stream['url'].'&signature='.@$real_stream['sig'], $data->message);
                                                if(isset($response->fullResponse)){
                                                    $response = $response->fullResponse;
                                                }
                                            } catch (Exception $e){
                                                $response = $e->getMessage();
                                            }
                                        }
                                    }
                                }else{
                                    $response = array(
                                        "status"  => "fail",
                                        "message" => strip_tags($info['reason'])
                                    );
                                }
                            }else{
                                if (strpos($url, 'facebook.com') != false) {
                                    $url = fbdownloadVideo($url);
                                }

                                try {
                                    $response =$i->uploadVideo($url, $data->message);
                                    if(isset($response->fullResponse)){
                                        $response = $response->fullResponse;
                                    }
                                } catch (Exception $e){
                                    $response = $e->getMessage();
                                }
                            }

                            break;
                    }

                    if(isset($response->status) && $response->status == "ok"){
                        $response = array(
                            "st"      => "success",
                            "id"      => $response->media->pk,
                            "code"    => $response->media->code,
                            "txt"     => l('Post successfully')
                        );
                    }
                    break;
            }

            if(is_string($response)){
                $response = array(
                    "st"      => "error",
                    "txt"     => $response
                );
            }
        }else{
            $response["message"] = "Upload faild, Please try again";
            $response = array(
                "status"  => "error",
                "message" => $response["message"]
            );
        }
        
        return $response;
        
    }

    function removeElementWithValue($array, $key, $value){
        $array = (array)$array;
         foreach($array as $subKey => $subArray){
            $subArray = (array)$subArray;
              if($subArray[$key] != $value){
                   unset($array[$subKey]);
              }
         }
         return $array;
    }
}
?>