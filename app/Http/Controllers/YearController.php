<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Year;
use App\Models\Klass;
use App\Models\Subject;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Year::paginate(5);
        return Inertia::render('Admin/Years',['years'=>$data]);
        //return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render(
            'Payments_spa/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'merchant_id' => ['required'],
        ])->validate();
        $request['notify_url']='https://abc.com';
        $request['return_url']='https://efg.com';
        $request['sign']='md5';

        Year::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'Article Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(),[
            'merchant_id'=>['required'],
            'merchantTid'=>['required'],
        ])->validate();
        if($request->has('id')){
            Year::find($request->input('id'))->update($request->all());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment=Year::find($id);
        if($payment){
            $payment->delete();
            return redirect()->back()
                ->with('message', 'Blog Delete Successfully');

        }
    }
    public function year($yearId){
        $data=Klass::where('year_id',$yearId)->get();
        return Inertia::render('Admin/Year_klasses',[
            'klasses'=>$data,
        ]);
    }
    public function subjects($yearId){
        $year=Year::find($yearId);
        $subjects=Subject::where('active',1)->get();
        $klasses=Klass::select('id as value','acronym as label')->where('year_id',$yearId)->get();
        $config=json_decode(Config::where('key','grades')->first()->value,true);
        return Inertia::render('Admin/Year_subjects',[
            'year'=>$year,
            'subjects'=>$subjects,
            'klasses'=>$klasses,
            'config'=>$config
        ]);
    }
}
