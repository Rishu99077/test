<?php
	namespace App\Export;
	use App\Models\Locations;
    
    use Maatwebsite\Excel\Concerns\WithHeadings;
	use Maatwebsite\Excel\Concerns\FromCollection;

	class ExportLocation implements FromCollection {
        
		public function collection()
		{   
            $Location = @$_GET['Location'];
            $Zone     = @$_GET['Zone'];
            $Locations = Locations::select('locations.location_title', 'zones.zone_title')->orderBy('locations.id', 'desc')->where(['locations.is_delete' => 0])
            ->join("zones", 'locations.zone', '=', 'zones.id')->groupBy('locations.id');
            if(@$_GET['Location']){
                $Locations = $Locations->where('locations.location_title', 'LIKE', '%'.$Location.'%');                      
             }   
     
             if(@$_GET['Zone']){
                $Locations = $Locations->where('locations.zone',$Zone);
             } 
             $Locations  =  $Locations->get();
            return $Locations;
		}

        public function headings() :array
        {   

            return [
                'id',
                'Location',
                'Zone',
            ];
        }


        
	}
?>
