<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class FormController extends Controller
{
    public function validateStep(Request $request)
    {
        $data = [];
        $fieldsToValidate = [];

        $fieldsToValidate['name'] = 'required';

        if($request->input('step') > 1){
            $fieldsToValidate['surname'] = 'required';
        }

        if($request->input('step') > 2){
            $fieldsToValidate['email'] = 'required|email';
        }

        $validator = Validator::make(
            $request->all(),
            $fieldsToValidate,
            [
                'name.required' => 'Field name is required',
                'surname.required' => 'Field surname is required',
                'email.required' => 'Field email is required',
                'email.email' => 'Field email must be a valid email address',
            ]
        );

        if ($validator->fails()) {
            $data['validation'] = $validator->messages();
            $data['step'] = $request->input('step');
        }
        else{
            $data['validation'] = [];
            $data['step'] = $request->input('step') + 1;
        }

        return response()->json($data);
    }
}
