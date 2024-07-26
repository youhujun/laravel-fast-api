<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 14:53:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 16:23:54
 * @FilePath: \app\Service\Facade\Public\Map\TencentMapFacadeService.php
 */

namespace App\Service\Facade\Public\Map;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Common\CommonException;

/**
 * @see \App\Facade\Public\Map\TencentMapFacade
 */
class TencentMapFacadeService
{
   public function test()
   {
       echo "TencentMapFacadeService test";
   }

   /**
    * 通过H5获取位置信息
    */
   public function getLocationRegionByH5($validated)
   {
        $result = code(config('common_code.GetLocationRegionByH5TencentMapError'));

        if(!(isset($validated['latitude'])&& isset($validated['longitude'])))
        {
            throw new CommonException('GetLocationRegionByH5TencentMapParamError');
        }

        //维度
        $latitude = $validated['latitude'];
        //经度
        $longitude = $validated['longitude'];

        $key = trim(Cache::store('redis')->get('tencent.map.key'));

        if(!$key)
        {
            throw new CommonException('TencentMapNoKeyError');
        }

        $regionUrl = trim(Cache::store('redis')->get('tencent.map.api.regionUrl'));

        if(!$regionUrl)
        {
            throw new CommonException('TencentMapApiRegionUrlError');
        }

        $url = "{$regionUrl}?location={$latitude},{$longitude}&key={$key}";

        $httpGetObjectResult = json_decode(httpGet($url));

        //p( $httpGetObjectResult);die;

        /**
         * stdClass Object
            (
                [status] => 0
                [message] => query ok
                [request_id] => 1a17514f-c16b-438f-bdaa-4946431450bc
                [result] => stdClass Object
                    (
                        [location] => stdClass Object
                            (
                                [lat] => 37.54061
                                [lng] => 121.40011
                            )

                        [address] => 山东省烟台市芝罘区市府街63号
                        [formatted_addresses] => stdClass Object
                            (
                                [recommend] => 向阳烟台市芝罘区人民政府中兴楼饭庄(市府街北)
                                [rough] => 向阳烟台市芝罘区人民政府中兴楼饭庄(市府街北)
                            )

                        [address_component] => stdClass Object
                            (
                                [nation] => 中国
                                [province] => 山东省
                                [city] => 烟台市
                                [district] => 芝罘区
                                [street] => 市府街
                                [street_number] => 市府街63号
                            )

                        [ad_info] => stdClass Object
                            (
                                [nation_code] => 156
                                [adcode] => 370602
                                [phone_area_code] => 0535
                                [city_code] => 156370600
                                [name] => 中国,山东省,烟台市,芝罘区
                                [location] => stdClass Object
                                    (
                                        [lat] => 37.541312
                                        [lng] => 121.400303
                                    )

                                [nation] => 中国
                                [province] => 山东省
                                [city] => 烟台市
                                [district] => 芝罘区
                            )

                        [address_reference] => stdClass Object
                            (
                                [business_area] => stdClass Object
                                    (
                                        [id] => 8558298051031
                                        [title] => 向阳
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.535562
                                                [lng] => 121.39736
                                            )

                                        [_distance] => 0
                                        [_dir_desc] => 内
                                    )

                                [famous_area] => stdClass Object
                                    (
                                        [id] => 8558298051031
                                        [title] => 向阳
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.535562
                                                [lng] => 121.39736
                                            )

                                        [_distance] => 0
                                        [_dir_desc] => 内
                                    )

                                [crossroad] => stdClass Object
                                    (
                                        [id] => 5279133
                                        [title] => 胜利路/市府街(路口)
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.54067
                                                [lng] => 121.39831
                                            )

                                        [_distance] => 153.3
                                        [_dir_desc] => 东
                                    )

                                [town] => stdClass Object
                                    (
                                        [id] => 370602001
                                        [title] => 向阳街道
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.534313
                                                [lng] => 121.399845
                                            )

                                        [_distance] => 0
                                        [_dir_desc] => 内
                                    )

                                [street_number] => stdClass Object
                                    (
                                        [id] => 56612323734693544304590
                                        [title] => 市府街63号
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.5405
                                                [lng] => 121.40026
                                            )

                                        [_distance] => 18
                                    )

                                [street] => stdClass Object
                                    (
                                        [id] => 14677662124692694598
                                        [title] => 市府街
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.54027
                                                [lng] => 121.40167
                                            )

                                        [_distance] => 19.5
                                        [_dir_desc] => 北
                                    )

                                [landmark_l1] => stdClass Object
                                    (
                                        [id] => 16123012369974312590
                                        [title] => 烟台市芝罘区人民政府
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.541038
                                                [lng] => 121.400292
                                            )

                                        [_distance] => 0
                                        [_dir_desc] => 内
                                    )

                                [landmark_l2] => stdClass Object
                                    (
                                        [id] => 15456007395997063056
                                        [title] => 中兴楼饭庄
                                        [location] => stdClass Object
                                            (
                                                [lat] => 37.54061
                                                [lng] => 121.40011
                                            )

                                        [_distance] => 0
                                        [_dir_desc] =>
                                    )

                            )

                    )

            )
         */

        if($httpGetObjectResult->status != 0)
        {
            Log::debug(['$httpGetObjectResult:Error'=>$httpGetObjectResult]);

            throw new CommonException('GetLocationRegionByH5TencentMapError');
        }

        $dataResult = $httpGetObjectResult->result;

        return $dataResult;
   }
}
