<?php

namespace Database\Seeders\System\SystemConfig;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoiceConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voiceConfigData = [
			['admin_id' =>1,'voice_title'=>'实名认证提示','channle_name'=>'admin_real_auth_apply','channle_event'=>'RealAuthApply','note'=>'提示用户申请实名认证','voice_save_type'=>10,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],
		];

		DB::table('system_voice_config')->insert($voiceConfigData);
    }
}
