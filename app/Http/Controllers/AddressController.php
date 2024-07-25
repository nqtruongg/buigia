<?php

namespace App\Http\Controllers;

use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\Commune;
use App\Models\District;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    private $cart;
    private $city;
    private $district;
    private $commune;
    public function __construct(City $city, District $district, Commune $commune)
    {
        $this->city = $city;
        $this->district = $district;
        $this->commune = $commune;
    }
    public function getDistricts(Request $request)
    {
        $cityId=$request->cityId;
        $address=new AddressHelper();
        $data = $this->city->find($cityId)->districts()->orderby('name')->get();
        $districts=$address->districts($data,$cityId);
        return response()->json([
            "code" => 200,
            'data'=>$districts,
            "message" => "success"
        ], 200);
    }
    public function getCommunes(Request $request)
    {
        $districtId=$request->districtId;
   //     dd($districtId);
        $address=new AddressHelper();
        $data = $this->district->find($districtId)->communes()->orderby('name')->get();
       // $data=$this->district->find($districtId)->join('communes', 'districts.id', '=', 'communes.district_id')->get();
      // dd($data);
        $communes=$address->communes($data,$districtId);
     //   dd($communes);
        return response()->json([
            "code" => 200,
            'data'=>$communes,
            "message" => "success"
        ], 200);
    }
}
