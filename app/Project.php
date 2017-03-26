<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'title', 'location', 'time_start', 'time_finish', 'budget'
    ];

    public function user(){
        return $this->belongsTo("App\User")->select('id', 'fname', 'lname', 'dp');
    }

    public function houses(){
        return $this->hasMany("App\House");
    }

    public function cover(){
    	$houses = $this->houses()->get();
		$html = '<div id="projHouses" class="layout wrap">';
		$count = 0;
		$house_url = asset("storage/uploads/") . "/housesIsh";

		foreach ($houses as $house){
			if($count < 4){
				$img_url = "$house_url/thumbs/$house->image_url";
				$html .= '<div class="column-inner"style="background-color:'.$house->placeholder_color.';background-image: url('.$img_url.')"></div>';

				$count++;
			}else{
				break;
			}
		}

		if(count($houses) < 4){
			for($i = 0; $i < 4 - count($houses); $i++){
				$html .= "<div class='column-inner'></div>";
			}
		}
		
		$html.= '</div>';

		return $html;
    }
}
