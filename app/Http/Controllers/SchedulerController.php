<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Scheduler;

use Validator;

use \DateTime;

class SchedulerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $object = (object)[
            'success'       => false,
            'message'       => 'New event not added.',
            'csrf_token'    => csrf_token(),
            'toastHeader'   => '<i class="fas fa-times mr-2 text-danger"></i> Warning',
            'bgClass'       => 'bg-warning bg-gradient'
        ];

        $data = [
            'event'             => 'required',
            'daterangepicker'   => 'required',
            'days'              => 'required'
        ];

        $validator = Validator::make($request->all(), $data);

        if ($validator->passes()) {

            $store = $this->process($request);

            if (!empty($store)) {
                // save model here
                $save = Scheduler::insert($store); 

                if ($save) {
                    $object->success = true;
                    $object->bgClass = 'bg-success bg-success text-white';
                    $object->toastHeader = '<i class="fas fa-check mr-2"></i> Success';
                    $object->message = 'New event successfully added.';

                    return response()->json($object);
                }
            }

            $object->message = 'New event not added, please check date range';

            return response()->json($object);
        }

        $object->error = $validator->errors()->toArray();

        return response()->json($object);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function process($request)
    {
        $split = explode(' - ', $request->daterangepicker);

        $start = date('Y-m-d', strtotime(reset($split) . '-1 day'));
        $end = date('Y-m-d', strtotime(end($split)));

        $weeks = $request->days;

        $trigger = (!empty($weeks)) ? true : false;

        $daysCount = 0;
        
        $push = [];

        while ($trigger) {
            
            $daysCount++;

            $date = date('Y-m-d', strtotime($start.' +'.$daysCount.' day'));

            $days = new DateTime($date);

            $weekDays = $days->format('D');

            if (in_array($weekDays, $weeks)) {
                $push[$date] = $weekDays;
            }
            
            if ($date == $end) {
                break;
            }
        }

        // array container use for date basis
        $cont = [];

        $store = [];

        if (!empty($push)) {
            // we need to check if array count is greater than 1
            // we used to check this to prevent foreach loop for single array
            if (count($push) > 1) {
                foreach ($push as $k => $v) {

                    $save = [
                        'eventName'     => $request->event,
                        'eventStart'    => reset($cont),
                        'eventEnd'      => end($cont)
                    ];

                    if (empty($cont)) {
                        array_push($cont, $k);
                    } else {
                        $days = abs(strtotime(end($cont)) - strtotime($k));

                        $daysDiff = floor($days / (60 * 60 * 24));

                        if ($daysDiff > 1) {
                            array_push($store, $save);

                            // reset container
                            $cont = [];

                            // then push new date
                            // this is for single date
                            array_push($cont, $k);

                        } else {
                            array_push($cont, $k);
                        }

                        $key = array_keys($push);

                        // check for last date
                        if ($k == end($key)) {
                            $save['eventEnd'] = $k;
                            array_push($store, $save);
                        }
                    }
                }
            } else {

                $key = array_keys($push);

                $save = [
                    'eventName'     => 'test',
                    'eventStart'    => reset($key),
                    'eventEnd'      => reset($key)
                ];

                array_push($store, $save);
            }
        }

        return $store;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $results = Scheduler::all();

        $reponse = [];

        if (!$results->isEmpty()) {
            foreach ($results as $v) {
                $push = [
                    'title' => $v->eventName,
                    'start' => $v->eventStart,
                    'end'   => $v->eventEnd
                ];

                array_push($reponse, $push);
            }
        }

        return response()->json($reponse);
    }
}
