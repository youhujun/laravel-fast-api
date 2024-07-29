<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-29 15:47:45
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-29 17:32:07
 * @FilePath: \app\Service\Facade\Common\Location\CalculateUserDistanceFacadeService.php
 */

namespace App\Service\Facade\Common\Location;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Common\CommonException;

use App\Models\User\User;
use App\Models\User\Log\UserLocationLog;

/**
 * @see \App\Facade\Common\Location\CalculateUserDistanceFacade
 */
class CalculateUserDistanceFacadeService
{
   public function test()
   {
       echo "CalculateUserDistanceFacadeService test";
   }

    /**
	 * 计算两个用户的距离
	 */
	public function getUserDistance(User $startUser ,User $endUser)
	{

		$startUserLocationObject = UserLocationLog::where('user_id',$startUser->id)->orderBy('created_time','desc')->first();

		['latitude'=>$start_latitude,'longitude'=>$start_longitude] = $startUserLocationObject->toArray();

		$start_latitude = number_format($start_latitude,5,'.',null);
		$start_longitude = number_format($start_longitude,5,'.',null);

		$endUserLocationObject = UserLocationLog::where('user_id',$endUser->id)->orderBy('created_time','desc')->first();

		['latitude'=>$end_latitude,'longitude'=>$end_longitude] = $endUserLocationObject->toArray();

		$end_latitude = number_format($end_latitude,5,'.',null);
		$end_longitude = number_format($end_longitude,5,'.',null);

		$distance = $this->calculateDistance($start_latitude,$start_longitude,$end_latitude,$end_longitude);

		return $distance;

	}

	/**
	 * 计算经纬度的距离
	 */
	protected function calculateDistance($start_latitude,$start_longitude,$end_latitude,$end_longitude)
	{
		
		// $lng1=117.27; //经度1

		$lng1 = $start_longitude; //经度1

		// $lat1=31.86; //纬度1

		$lat1 = $start_latitude; //纬度1

		//$lng2=120.19; //经度2

		$lng2 = $end_longitude; //经度2

		// $lat2 = 30.26; //纬度2

		$lat2 = $end_latitude; //纬度2

		$EARTH_RADIUS = 6378137; //地球半径

		$RAD = pi() / 180.0;

		$radLat1 = $lat1 * $RAD;

		$radLat2 = $lat2 * $RAD;

		$a = $radLat1 - $radLat2; // 两点纬度差

		$b = ($lng1 - $lng2) * $RAD; // 两点经度差

		$s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));

		$s = $s * $EARTH_RADIUS;

		//单位米 再除以 1000 就是 km
		$s = (round($s * 10000) / 10000) /1000;

		return number_format($s,2,'.', null);

	}

	
}
