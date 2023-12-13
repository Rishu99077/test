<?php
	namespace App\Export;
	use App\Models\Zones;
    
    use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromCollection;

	class ExportZone implements FromCollection {
        
		public function collection()
		{   
            $Zone     = @$_GET['Zone'];

            $Zones = Zones::select('zone_title')->where(['is_delete' => 0])->orderBy('id', 'desc');
           
            if(@$_GET['Zone']){
               $Zones = $Zones->where('zone_title','LIKE', '%'.$Zone.'%');
            }   
            
            $get_zones  =  $Zones->get();
            // dd($get_zones);
            return $get_zones;
		}

        public function headings() :array
        {   

            return [
                'id',
                'Zone',
            ];
        }


        
	}
?>
